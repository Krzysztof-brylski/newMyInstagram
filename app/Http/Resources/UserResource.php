<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->publicAccount or $this->id == $request->user()->id){
            return array(
                'id'=>$this->id,
                'name'=>$this->name,
                'username'=>$this->userName,
                'descirption'=>$this->description,
                'photo'=>$this->photo,
                'followersCount'=>$this->followersCount,
                'posts' => PostResource::collection($this->posts)
            );
        }
        return array(
           'error'=>'This account is private'
        );
    }
}
