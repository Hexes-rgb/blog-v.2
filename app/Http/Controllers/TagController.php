<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    // public function store(Request $request)
    // {
    //     // findOr or findOrCreate or firstOrNew
    //     $post_id = $request->input('post_id') ?? false;
    //     if (!$post_id) {
    //         $title = $request->input('title') ?? 'Example title';
    //         $content = $request->input('content') ?? 'Example content';
    //         $post = Post::create([
    //             'author_id' => Auth::user()->id,
    //             'title' => $title,
    //             'content' => $content,
    //         ]);
    //     } else {
    //         $post = Post::find($post_id);
    //     }
    //     $tagName = $request->input('myTags');
    //     if (Tag::where('name', 'ILIKE', $tagName)->get()->isNotEmpty()) {
    //         $tagName = Tag::where('name', 'ILIKE', $tagName)->first()->name;
    //     }
    //     if (Tag::where('name', 'ILIKE', $tagName)->get()->isEmpty()) {
    //         Tag::create([
    //             'name' => $tagName,
    //         ]);
    //         $tag = Tag::where('name', 'ILIKE', $tagName)->first();
    //         $post->tags()->attach($tag);
    //     } elseif ($post->tags->where('name', $tagName)->isEmpty()) {
    //         $tag = Tag::where('name', 'ILIKE', $tagName)->first();
    //         $post->tags()->attach($tag);
    //     } else {
    //         return redirect()->route('post.edit', $post->id);
    //     }
    //     return redirect()->route('post.edit', $post->id);
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tag' => 'required|max:100|min:2',
        ]);
        $tagName = $validated['tag'];
        $tag = Tag::where('name', 'ILIKE', $tagName)->first();
        if (empty($tag)) {
            Tag::create([
                'name' => $tagName,
            ]);
            return response()->json(['success' => 'New tag is successfully created.']);
        } else {
            return response()->json(['success' => 'This tag has already exist']);
        }
    }
}
