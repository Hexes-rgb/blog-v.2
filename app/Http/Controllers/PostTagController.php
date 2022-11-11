<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostTagController extends Controller
{
    public function destroy(Request $request)
    {
        $tag_id = $request->input('tag_id');
        $post_id = $request->input('post_id');
        $post = Post::findOrFail($post_id);
        $tag = Tag::findOrFail($tag_id);
        $post->tags()->detach($tag);
        $post = Post::findOrFail($post_id);
        // return redirect()->route('post.edit', $post->id);
        return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render()]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);
        $validator = Validator::make($request->all(), [
            'tag' => 'required|max:255|min:2',
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render(), 'errors' => $validator->errors()->all()]);
        }
        $validated = $validator->validated();
        $tagName = $validated['tag'];
        $tag = Tag::where('name', 'ILIKE', $tagName)->first();
        if (empty($tag)) {
            // return response()->json(['error' => 'This tag does not exist']);
            return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render(), 'errors' => ['errors' => 'This tag does not exist']]);
        } else {
            if ($post->tags->where('name', $tag->name)->isEmpty()) {
                $post->tags()->attach($tag);
                $post = Post::find($post_id);
                return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render()]);
                // $tagsList = view('layouts.inc.add-tag-form', ['post' => $post])->render();
                // return view('layouts.inc.add-tag-form', ['post' => $post])->render();
                // return $tagsList;
            } else {
                // return response()->json(['error' => 'This tag has already been added']);
                return response()->json(['data' => view('layouts.inc.add-tag-form', ['post' => $post])->render(), 'errors' => ['errors' => 'This tag has already been added']]);
            }
        }
    }
}
