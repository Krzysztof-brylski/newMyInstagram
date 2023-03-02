<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\LikesService;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends Controller
{
    public function answer(Comment $comment,Request $request):JsonResponse{

        $data=$request->validate([
            'content'=>'string|required'
        ]);
        $comment->answerComment($data['content'], Auth::user() );
        return Response()->json('commented',201);
    }

    public function like( Post $post)
    {
        if((new LikesService())->like($post,Auth::user())){
            return Response()->json('liked',201);
        }

        return Response()->json('un liked',200);
    }

}
