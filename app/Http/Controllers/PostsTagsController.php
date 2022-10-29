<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsTagsController extends Controller
{
    public function destroy(Request $request)
    {
        $tag_id = $request->input('tag_id');
        $post_id = $request->input('post_id');
        $post = Post::where('id', '=', $post_id)->first();
        $tag = Tag::where('id', '=', $tag_id)->first();
        $post->tags()->detach($tag);
        return redirect()->route('post.edit', $post->id);
    }
}
