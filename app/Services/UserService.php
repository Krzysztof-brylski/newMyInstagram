<?php

namespace App\Services;

use App\Http\Resources\AuthorResource;
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

        $result = DB::table('follows')->where('user_id',$followedUser->id )
            ->where('follower_id',$followingUser->id)->exists();
        if($result){
            DB::table('follows')->where('user_id',$followedUser->id )
                ->where('follower_id',$followingUser->id)->delete();
            return false;
        }
        $followedUser->Followers()->attach(
            $followingUser->id
        );
        return true;
    }


    public function suggestedUsers(User $user){

        $suggestionsId=array();

        $follows = $user->follows()->withCount('Follows')->limit(10)
            ->where('publicAccount','=',1)
            ->get()->sortBy('follows_count');

        $followers= $user->followers()->withCount('Followers')->limit(10)
            ->where('publicAccount','=',1)
            ->get()->sortBy('followers_count');

        $bestUsers = User::with('Followers')->withCount('Followers')
            ->where('publicAccount','=',1)->orderBy('followers_count', 'desc')
            ->limit(10)->get();

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
        return User::whereIn('id',$suggestionsId)->withCount('Followers')->get();
    }

    public function search(string $name)
    {   
        if($name==""){
            return [];
        }

        $result = User::where('name','LIKE',"$name%")
            ->orWhere('userName','LIKE',"$name%")->get();
        return $result;
    }
}
