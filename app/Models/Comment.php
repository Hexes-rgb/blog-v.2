<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'comment_id',
        'text',
    ];
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
}
