<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{

    public function create(array $data):void
    {
        $post=Post::create([
            'title'=>$data['title'],
            'content'=>$data['content'],
            'tagged'=> (!array_key_exists('tagged',$data) ? null : $data['tagged']),
        ]);
        foreach($data['images'] as $image){
            $post->Photos()->create([
                'src'=>Storage::put('Photos',$image),
            ]);
        }
        $post->Author()->associate(Auth::user());
        $post->save();
    }

    public function update($data, Post $post)
    {
        !array_key_exists('title',$data) ? $post->title = $data['title'] : null;
        !array_key_exists('content',$data) ? $post->content = $data['content']: null;
        !array_key_exists('tagged',$data) ? $post->tagged = $data['tagged']: null;
        if(array_key_exists('images',$data)){
            foreach($data['images'] as $image){
                $post->Photos()->create([
                    'src'=>Storage::put('Photos',$image),
                ]);
            }
        }

        $post->edited=true;
        $post->save();
    }



    public function suggestedPosts(User $user){
        $suggestionsId=array();

        $follows = $user->follows()->withCount('Follows')
            ->where('publicAccount','=',1)
            ->get()->sortBy('follows_count');

        $followers= $user->followers()->withCount('Followers')
            ->where('publicAccount','=',1)
            ->get()->sortBy('followers_count');

        $bestUsers = User::with('Followers')->withCount('Followers')
            ->where('publicAccount','=',1)
            ->orderBy('followers_count', 'desc')->get();

        $followers->each(function ($element) use(&$suggestionsId) {
            if(!in_array($element->id,$suggestionsId)){
                $suggestionsId[]=$element->id;
            }

        });
        $follows->each(function ($element) use(&$suggestionsId){
            if(!in_array($element->id,$suggestionsId)){
                $suggestionsId[]=$element->id;
            }
        });
        $bestUsers->each(function ($element) use(&$suggestionsId){
            if(!in_array($element->id,$suggestionsId)){
                $suggestionsId[]=$element->id;
            }
        });
        return $suggestionsId;


    }


}
