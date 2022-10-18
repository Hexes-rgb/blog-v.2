<?php

namespace App\Http\Controllers;

use App\Libraries\Services;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class ReadPostController extends Controller
{
    public function readPost($post_id)
    {
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        $post = Post::where('id', '=', $post_id)->first();
        return view('read-post', ['post' => $post, 'tags' => Services::popularTags()]);
    }
}
