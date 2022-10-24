<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')
            ->as('likedPosts')
            ->withTimestamps()
            ->withPivot('is_deleted');
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'author_id', 'sub_id')
            ->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'sub_id', 'author_id')
            ->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    public function viewedPosts()
    {
        return $this->belongsToMany(Post::class, 'views', 'user_id', 'post_id')
            ->as('viewedPosts')
            ->withTimestamps();
    }

    public function userComments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
}
