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
        $post = Post::find($post_id);
        $tag = Tag::find($tag_id);
        $post->tags()->detach($tag);
        $post = Post::find($post_id);
        // return redirect()->route('post.edit', $post->id);
        return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render()]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);
        $validated = $request->validate([
            'tag' => 'required|max:100|min:2',
        ]);
        $tagName = $validated['tag'];
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
