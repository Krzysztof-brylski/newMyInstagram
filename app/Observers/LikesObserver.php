<?php

namespace App\Observers;

use App\Models\Likes;
use Illuminate\Support\Facades\Cache;

class LikesObserver
{
    public function like(Likes $likes):void{
        Cache::forget('likes');
        Cache::put('likes',Likes::all(),(60*60*24));
    }
}
