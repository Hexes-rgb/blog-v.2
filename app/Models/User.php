<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
            ->withPivot('deleted_at')
            ->withTimestamps();
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'author_id', 'sub_id')
            ->withPivot('deleted_at')
            ->as('subscribers')
            ->withTimestamps()
            ->where('deleted_at', null);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'sub_id', 'author_id')
            ->withPivot('deleted_at')
            ->as('subscriptions')
            ->withTimestamps()
            ->where('deleted_at', null);
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

    public function scopeUnreadedPosts($query)
    {
        $query->selectRaw('
        users.id,
        users.name,
        (select count(*) from posts where posts.author_id in
            (select s2.author_id from subscriptions s2 where s2.sub_id = users.id and s2.deleted_at is null)
            and posts.deleted_at is null) -
        count(distinct views.post_id) as unreaded_posts
        ')
            ->join('subscriptions as s', function ($join) {
                $join->on('users.id', '=', 's.sub_id')
                    ->where('s.deleted_at', null);
            })
            ->join('users as u2', 's.author_id', '=', 'u2.id')
            ->join('posts', function ($join) {
                $join->on('u2.id', '=', 'posts.author_id')
                    ->where('posts.deleted_at', null);
            })
            ->join('views', function ($join) {
                $join->on('posts.id', '=', 'views.post_id')
                    ->on('users.id', '=', 'views.user_id');
            })
            ->groupBy('users.id', 'users.name')
            ->where('users.id', '=', Auth::id());
    }
}
