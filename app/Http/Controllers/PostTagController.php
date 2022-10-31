<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class PostTagController extends Controller
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

    public function store(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);
        $tagName = $request->input('myTags');
        $tag = Tag::where('name', 'ILIKE', $tagName)->first();
        if (empty($tag)) {
            return response()->json(['success' => 'This tag does not exist']);
        } else {
            if ($post->tags->where('name', $tag->name)->isEmpty()) {
                $post->tags()->attach($tag);
                return response()->json(['success' => 'Tag added successfully']);
            } else {
                return response()->json(['success' => 'This tag has already been added']);
            }
        }
    }
}
