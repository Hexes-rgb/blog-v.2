<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
