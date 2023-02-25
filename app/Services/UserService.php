<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * checking if follow exist in many-to-many relation
     * if exists then cancel follow => return False
     * else save follow => return True
     * @param User $followedUser
     * @param User $followingUser
     * @return bool
     */
    public function follow(User $followedUser,User $followingUser):bool{
        $result = DB::table('followers')->where('user_id',$followedUser->id )
            ->where('follower_id',$followingUser->id)->exists();
        if($result){
            DB::table('followers')->where('user_id',$followedUser->id )
                ->where('follower_id',$followingUser->id)->delete();
            return false;
        }
        $followedUser->Followers()->attach(
            $followingUser->id
        );
        $followingUser->Follows()->attach(
            $followedUser->id
        );
        return true;
    }
}
