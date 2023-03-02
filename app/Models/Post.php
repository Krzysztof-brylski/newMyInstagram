<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $fillable=[
      'title',
      'content',
      'edited',
      'tagged',
    ];
    protected $with=['Photos'];
    protected $withCount = ['Likes','Comments'];
    protected $observables = ['comment'];

    public function comment(string $content, User $user){
        $comment = new Comment();
        $comment->content=$content;
        $comment->Author()->associate($user);
        $this->Comments()->save($comment);
        $this->fireModelEvent('comment', false);
    }


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
