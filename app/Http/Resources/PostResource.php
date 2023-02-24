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
            'Author'=>$this->whenLoaded('Author',new AuthorResource($this->author)),
            'Photos'=>$this->whenLoaded('Photos',$this->photos),
            'Comments'=>CommentResource::collection($this->comments),

            'title'=>$this->title,
            'content'=>$this->content,
            'edited' =>  $this->edited,
            'tags' => $this->whenNotNull($this->tagged,
                 $this->tagged
            ),


        );
    }
}
