<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;

class PostsTagsController extends Controller
{
    public function destroy($post_id, $tag_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        $tag = Tag::where('id', '=', $tag_id)->first();
        $post->tags()->detach($tag);
        return redirect()->route('post.edit', $post->id);
    }
}
