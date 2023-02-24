<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends Controller
{
    public function answer(Comment $comment,Request $request):JsonResponse{

        $data=$request->validate([
            'content'=>'string|required'
        ]);
        $answer = new Comment();
        $answer->content=$data['content'];
        $answer->Author()->associate(Auth::user());
        $comment->Answers()->save($answer);

        return Response()->json('commented',201);
    }
}
