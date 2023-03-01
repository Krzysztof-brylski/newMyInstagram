<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table="chat";


    public function Messages(){
        return $this->hasMany(Message::class,'chat_id');
    }

    // always currently auth user
    public function UserOne(){
        return $this->belongsTo(User::class,'user_one');
    }

    // other user
    public function UserTwo(){
        return $this->belongsTo(User::class,'user_two');
    }
}
