<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable=['content'];

    protected $with=[
        'Author:id,userName,photo->src',
        'Answer'
    ];

    public function Chat(){
        return $this->belongsTo(Chat::class);
    }
    public function Author(){
        return $this->belongsTo(User::class,'author_id');
    }

    public function Answer(){
        return $this->belongsTo(Message::class,'answer_id');
    }

}
