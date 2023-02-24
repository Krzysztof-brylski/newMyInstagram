<?php

namespace App\Http\Resources;

use App\Http\Controllers\CommentController;
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
            'author'=> new AuthorResource($this->author),
            'content'=>$this->content,

            'answers'=> $this->when($this->Answers()->exists(),function (){
                return  CommentResource::collection($this->answers);
            }),
        );
    }
}
