<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable=[
      'title',
      'content',
      'edited',
      'tagged',
    ];

    protected $withCount = ['Likes','Comments'];

    public function Author(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function Photos(){
        return $this->morphMany(Photos::class,'photoable');
    }

    public function Comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
    public function Likes(){
        return $this->morphMany(Likes::class,'likeable');
    }
}
