<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function register(RegisterRequest $request): JsonResponse{
        $data=$request->validated();

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'publicAccount'=>$data['publicAccount'],
            'password'=>Hash::make($data['password']),
        ]);
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
