<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    public function Likeable(){
        return $this->morphTo();
    }
    public function Author(){
        return $this->belongsTo(User::class,'user_id');
    }

}



