<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
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

    public function comment($data, Post $post)
    {
        $comment = new Comment();
        $comment->content=$data['content'];
        $comment->Author()->associate(Auth::user());

        $post->Comments()->save($comment);

    }
}
