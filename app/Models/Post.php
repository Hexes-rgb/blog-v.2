<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['author_id', 'title', 'content', 'image'];
    protected $appends = ['rating'];

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
            ->withPivot('deleted_at')
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
        return $this->hasMany(Comment::class, 'post_id', 'id')
            ->withTrashed();
    }



    public function scopeTrends($query)
    {
        $query->selectRaw('
        *,
        (select count(*) from likes where likes.post_id = posts.id and likes.deleted_at is null and localtimestamp - likes.created_at < interval \'3 days\') +
        (select count(*) from views where views.post_id = posts.id and localtimestamp - views.created_at < interval \'3 days\') +
        (select count(distinct comments.user_id) from comments where comments.post_id = posts.id and comments.deleted_at is null and localtimestamp - comments.created_at < interval \'3 days\') as rating
    ');
    }

    public function getRatingAttribute()
    {
        return $this->attributes['rating'];
    }

    public function setRatingAttribute($value)
    {
        $this->attributes['rating'] = $value;
    }
}
