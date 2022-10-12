<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class ReadPostController extends Controller
{
    public function show(Request $request)
    {
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        $post_id = $request->input('post_id');
        $post = Post::where('id', '=', $post_id)->first();
        return view('read-post', ['post' => $post, 'tags' => $tags]);
    }
}
