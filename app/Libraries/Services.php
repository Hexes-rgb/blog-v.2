<?php

namespace App\Libraries;

use App\Models\Tag;

class Services
{
    public static function popularTags()
    {
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        return $tags;
    }
}
