<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array(
            'author'=>$this->whenLoaded('Author',new AuthorResource($this->author)),
            'photos'=>$this->whenLoaded('Photos',$this->photos),
            'comments_count'=>$this->comments_count,
            'likes_count'=>$this->like_count,
            'title'=>$this->title,
            'content'=>$this->content,
            'edited' =>  $this->edited,
            'tags' => $this->whenNotNull($this->tagged,
                 $this->tagged
            ),


        );
    }
}
