<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentsObserver
{
    public function answerComment(Comment $comment):void{
        Cache::forget('comments');
        Cache::put('comments',Comment::all(),(60*60*24));
    }
}
