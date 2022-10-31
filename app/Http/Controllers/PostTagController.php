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
            // return response()->json(['success' => 'This tag does not exist']);
            return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render()]);
        } else {
            if ($post->tags->where('name', $tag->name)->isEmpty()) {
                $post->tags()->attach($tag);
                $post = Post::find($post_id);
                return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render()]);
                // $tagsList = view('layouts.inc.add-tag-form', ['post' => $post])->render();
                // return view('layouts.inc.add-tag-form', ['post' => $post])->render();
                // return $tagsList;
            } else {
                // return response()->json(['success' => 'This tag has already been added']);
                return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render()]);
            }
        }
    }
}
