<?php

namespace App\Http\Controllers;

use App\Libraries\Services;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostRedactorController extends Controller
{
    public function showCreatePostForm()
    {
        return view('create-post', ['tags' => Services::tags()]);
    }
    public function showUpdatePostForm($post_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        return view('edit-post', ['tags' => Services::tags(), 'post' => $post]);
    }
    public function updatePost(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::where('id', '=', $post_id)->first();
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        return view('edit-post', ['tags' => Services::tags(), 'post' => $post]);
    }
    public function createPost(Request $request)
    {
        Post::create([
            'author_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        return view('create-post', ['tags' => Services::tags()]);
    }
    public function deletePost($post_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        $post->delete();
        return view('main', ['posts' => Post::all(), 'tags' => Services::tags()]);
    }
}
