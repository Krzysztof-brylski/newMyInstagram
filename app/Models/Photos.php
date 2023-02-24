<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $fillable=[
        'src'
    ];

    public function Photoable(){
        return $this->morphTo();
    }


    use HasFactory;
}
