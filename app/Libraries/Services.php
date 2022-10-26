<?php

namespace App\Libraries;

use App\Models\Tag;

class Services
{
    public static function removeEmptyTags()
    {
        $allTags = Tag::all();
        foreach ($allTags as $tag) {
            if ($tag->posts()->withTrashed()->get()->isEmpty()) {
                $tag->delete();
            }
        }
    }

    public static function popularTags()
    {
        Services::removeEmptyTags();
        $tags = Tag::selectRaw('
        tags.id,
        tags.name,
        count(posts.id) as post_count
        ')
            ->join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
            ->join('posts', 'post_tag.post_id', '=', 'posts.id')
            ->groupBy('tags.id', 'tags.name')
            ->orderBy('post_count', 'desc')
            ->get();

        return $tags->slice(0, 4);
    }
}
