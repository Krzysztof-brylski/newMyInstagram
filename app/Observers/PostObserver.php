<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function comment(Post $post):void{
        Cache::forget('comments');
        Cache::put('comments',Comment::all(),(60*60*24));
    }
}
