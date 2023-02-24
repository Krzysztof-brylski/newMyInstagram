<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function register(RegisterRequest $request): JsonResponse{
        $data=$request->validated();

        $user = User::create([
            'name'=>$data['name'],
            'userName'=>$data['userName'],
            'email'=>$data['email'],
            'description'=>$data['description'],
            'publicAccount'=>$data['publicAccount'],
            'password'=>Hash::make($data['password']),
        ]);
        if(isset($data['photo'])){
            $user->Photo()->create([
                'src'=>Storage::put('Photos',$data['photo'])
            ]);
        }

        $token = $user->createToken('token-name')->plainTextToken;
        return Response()->json(['token'=>$token],201);
    }

    public function login(LoginRequest $request): JsonResponse{
        $data=$request->validated();
        $user = User::where('email',$data['email'])->first();

        if(!Hash::check($data['password'],$user->password)){
            return Response()->json('access deny',403);
        }

        $token = $user->createToken('token-name')->plainTextToken;
        return Response()->json(['token'=>$token],200);
    }

    public function logout(Request $request): JsonResponse{
        $request->user()->currentAccessToken()->delete();
        return Response()->json('logout',200);

    }

}
