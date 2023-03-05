<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LikeResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Likes;
use App\Models\Post;
use App\Models\User;
use App\Services\LikesService;
use App\Services\PostService;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request):JsonResponse
    {
        $data=$request->validated();
        (new PostService())->create($data);
        return Response()->json('created',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post->with(['Author','Photos','Comments'])->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data=$request->validated();

        (new PostService())->update($data,$post);
        return Response()->json('created',200);
    }

    /**
     * comment the specified post.
     */
    public function comment(Request $request, Post $post)
    {
        $data=$request->validate([
            'content'=>'string|required'
        ]);
        $post->comment($data['content'], Auth::user());
        return Response()->json('commented',201);
    }

    public function like(Post $post)
    {
        if((new LikesService())->like($post,Auth::user())){
            return Response()->json('liked',201);
        }

        return Response()->json('disliked',200);
    }

    public function showComments(Post $post){
        if(!Cache::has('comments')){
            Cache::put('comments',Comment::all(),(60*60*24));
        }
        return CommentResource::collection(
            Cache::get('comments')->filter(function ($element) use ($post){
                return $element->commentable_id == $post->id;
            })
        );
    }
    public function showLikes(Post $post){
        if(!Cache::has('likes')){
            Cache::put('likes',Likes::all(),(60*60*24));
        }
        return LikeResource::collection(
            Cache::get('likes')->filter(function ($element) use ($post){
                return $element->likeable_id == $post->id and $element->likeable_type == 'App\Models\Post';
            })
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return Response()->json('deleted',200);
    }

    public function suggestedPost(){
        $suggestionsId = array();

        if(!Cache::has('suggested_post')){
            $suggestionsId = (new PostService())->suggestedPosts(Auth::user());
            Cache::put('suggested_post',$suggestionsId,600);
        }

        if(empty(Cache::get('suggested_post')) or empty($suggestionsId)){
            $suggestionsId = (new PostService())->suggestedPosts(Auth::user());
            Cache::put('suggested_post',$suggestionsId,600);
        }
        $suggestionsId = Cache::get('suggested_post');
        return PostResource::collection(
          Post::whereIn('user_id',$suggestionsId)->with(['Author'])->get(),
        );

    }


}
