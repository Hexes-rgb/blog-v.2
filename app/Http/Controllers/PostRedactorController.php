<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Libraries\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostRedactorController extends Controller
{
    public function sendTagsJson()
    {
        $tags = array();
        foreach (Tag::all() as $tag) {
            array_push($tags, $tag->name);
        }
        $data = json_encode(array('allTags' => $tags));
        return response()->json($data);
    }

    public function showCreatePostForm()
    {
        return view('create-post', ['tags' => Services::popularTags()]);
    }
    public function showUpdatePostForm($post_id)
    {
        $post = Post::where('id', '=', $post_id)->withTrashed()->get()->first();
        return view('edit-post', ['tags' => Services::popularTags(), 'post' => $post]);
    }
    public function updatePost(Request $request)
    {
        $post_id = $request->input('post_id');
        $image = $request->file('image');
        $post = Post::where('id', '=', $post_id)->first();
        if ($image) {
            $post->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'image' => date('YmdHi') . $image->getClientOriginalName(),
            ]);
            $image->move(public_path('public/postsImages'), date('YmdHi') . $image->getClientOriginalName());
        } else {
            $post->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);
        }
        return redirect()->route('edit-post', $post_id);
    }
    public function addTag(Request $request)
    {
        $post_id = $request->input('post_id') ?? 'no-post';
        if ($post_id == 'no-post') {
            $title = $request->input('title') ?? 'Example title';
            $content = $request->input('content') ?? 'Example content';
            $post = Post::create([
                'author_id' => Auth::user()->id,
                'title' => $title,
                'content' => $content,
            ]);
        } else {
            $post = Post::where('id', '=', $post_id)->first();
        }
        $tagName = $request->input('myTags');
        if (Tag::where('name', 'ILIKE', $tagName)->get()->isNotEmpty()) {
            $tagName = Tag::where('name', 'ILIKE', $tagName)->first()->name;
        }
        if (Tag::where('name', 'ILIKE', $tagName)->get()->isEmpty()) {
            Tag::create([
                'name' => $tagName,
            ]);
            $tag = Tag::where('name', 'ILIKE', $tagName)->first();
            $post->tags()->attach($tag);
        } elseif ($post->tags->where('name', $tagName)->isEmpty()) {
            $tag = Tag::where('name', 'ILIKE', $tagName)->first();
            $post->tags()->attach($tag);
        } else {
            return redirect()->route('edit-post', $post->id);
        }
        return redirect()->route('edit-post', $post->id);
    }
    public function removeTag($post_id, $tag_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        $tag = Tag::where('id', '=', $tag_id)->first();
        $post->tags()->detach($tag);
        return redirect()->route('edit-post', $post->id);
    }
    public function createPost(Request $request)
    {
        $image = $request->file('image');
        if (!empty($image)) {
            $post = Post::create([
                'author_id' => Auth::user()->id,
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'image' => date('YmdHi') . $image->getClientOriginalName(),
            ]);
            $image->move(public_path('public/postsImages'), date('YmdHi') . $image->getClientOriginalName());
        } else {
            $post = Post::create([
                'author_id' => Auth::user()->id,
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);
        }
        return redirect()->route('edit-post', $post->id);
    }
    public function changePostStatus($post_id)
    {
        $post = Post::withTrashed()->find($post_id);
        if ($post->trashed()) {
            $post->restore();
        } else {
            $post->delete();
        }
        return redirect()->route('edit-post', $post->id);
    }

    // public function deletePost($post_id)
    // {
    //     $post = Post::find($post_id);
    //     $post->tags()->detach();
    //     $post->delete();
    //     return redirect()->route('main-index', ['posts' => Post::all()->sortByDesc('created_at'), 'tags' => Services::popularTags()]);
    // }
}
