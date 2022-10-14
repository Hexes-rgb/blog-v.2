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
        $data = json_encode(Tag::all());
        return response()->json($data, 200);
    }

    public function showCreatePostForm()
    {
        return view('create-post', ['tags' => Services::popularTags()]);
    }
    public function showUpdatePostForm($post_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        return view('edit-post', ['tags' => Services::popularTags(), 'post' => $post]);
    }
    public function updatePost(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::where('id', '=', $post_id)->first();
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        return redirect()->route('edit-post', $post_id);
        // return view('edit-post', ['tags' => Services::tags(), 'post' => $post]);
    }
    public function createPost(Request $request)
    {
        Post::create([
            'author_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        $post = Post::where('author_id', '=', Auth::user()->id)
            ->where('title', '=', $request->input('title'))
            ->where('content', '=', $request->input('content'))->first();
        return redirect()->route('edit-post', $post->id);
        // return view('create-post', ['tags' => Services::tags()]);
    }
    public function deletePost($post_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        $post->delete();
        return redirect()->route('main-index');
        // return view('main', ['posts' => Post::all()->sortByDesc('created_at'), 'tags' => Services::tags()]);
    }
}
