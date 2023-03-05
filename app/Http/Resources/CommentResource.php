<?php

namespace App\Http\Resources;

use App\Http\Controllers\CommentController;
use App\Models\Comment;
use App\Services\LikesService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array(
            'id'=>$this->id,
            'author'=> new AuthorResource($this->author),
            'content'=>$this->content,
            'likesCount'=>$this->likes_count,
            'liked' =>$this->when(
                (new LikesService())->isLiked($request->user(),$this->id,Comment::class),
                true,false),
            'answers'=> $this->when($this->Answers()->exists(),function (){
                return  CommentResource::collection($this->answers);
            }),
        );
    }
}
