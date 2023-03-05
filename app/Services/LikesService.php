<?php

namespace App\Services;

use App\Models\Likes;
use App\Models\User;

class LikesService
{
    public function like($resource, User $user): bool
    {
        $like = Likes::where('user_id',$user->id)->where('likeable_id',$resource->id)
            ->where('likeable_type',get_class($resource))->first();
        if($like != null){
            $like->disLike();
            return false;
        }

        $like = new Likes();
        $like->like($user,$resource);
        return true;
    }

    public function isLiked(User $user, $resourceId,$resourceType ){
        $like = Likes::where('user_id',$user->id)->where('likeable_id',$resourceId)
            ->where('likeable_type',$resourceType)->first();
        return ($like != null);
    }


}
