<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['author_id', 'title', 'content', 'image'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')
            ->as('likes')
            ->withTimestamps();
    }

    public function views()
    {
        return $this->belongsToMany(User::class, 'views', 'post_id', 'user_id')
            ->as('views')
            ->withTimestamps();
    }

    public function postComments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
