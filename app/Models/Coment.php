<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coment extends Model
{
    use HasFactory;

    protected $fillable = [
        "content",
        "user_id",
        "post_id",
    ] ;

    public function user(){
        return $this->belongsToMany(User::class);
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
