<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class UserController extends Controller
{

    /**
     * showing specified user
     * @param User $user
     * @return UserResource
     */
    public function show(User $user){

        return new UserResource($user->with('Posts')->first());

    }


    /**
     * generate response with list of follows for currently loged-in users
     * @param User $user
     * @return AnonymousResourceCollection
     */
    public function follows(User $user){

        return AuthorResource::collection(
            $user->with('Follows')->get()
        );
    }


    /**
     * generate response with list of followers for currently loged-in users
     * @param User $user
     * @return AnonymousResourceCollection
     */
    public function followers(User $user){

        return AuthorResource::collection(
            $user->with('Followers')->get()
        );
    }



    /**
     * following or canceling follow to specyfied user
     * @param User $user
     * @return JsonResponse
     */
    public function follow(User $user):JsonResponse{
        if((new UserService())->follow($user, Auth::user() )){
            return Response()->json("followed",201);
        }
        return Response()->json("follow canceled",200);
    }





}
