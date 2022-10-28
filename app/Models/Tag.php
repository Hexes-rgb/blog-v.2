<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }



    public function scopePopular($query)
    {
        $query->selectRaw('
        tags.id,
        tags.name,
        count(posts.id) as posts_count
        ')
            ->join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
            ->join('posts', function ($join) {
                $join->on('post_tag.post_id', '=', 'posts.id')
                    ->where('posts.deleted_at', null);
            })
            ->groupBy('tags.id', 'tags.name');
    }
}
