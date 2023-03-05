<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    protected $observables = ['like'];

    public function Likeable(){
        return $this->morphTo();
    }
    public function Author(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function disLike(){

        $this->fireModelEvent('liked', false);
        $this->delete();
    }
    public function like(User $user, $resource ){
        $this->Author()->associate($user);
        $resource->Likes()->save($this);
        $this->fireModelEvent('liked', false);
        $this->save();
    }

}



