<?php

namespace App\Services;

use App\Models\Likes;
use App\Models\User;

class LikesService
{
    public function like($resource, User $user): bool
    {
        $like = Likes::where('user_id',$user)->first();
        if($like->exist){
            $like->delete();
            return true;
        }
        $like = new Likes();
        $like->Author()->associate($user);
        $resource->Likes()->save($like);
        return true;
    }
}
