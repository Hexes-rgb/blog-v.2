<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostRedactorController extends Controller
{
    public function show_create_post_form()
    {
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        return view('create-post', ['tags' => $tags]);
    }
    public function show_update_post_form(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::where('id', '=', $post_id)->first();
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        return view('edit-post', ['tags' => $tags, 'post' => $post]);
    }
    public function update_post(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::where('id', '=', $post_id)->first();
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        return view('edit-post', ['tags' => $tags, 'post' => $post]);
    }
    public function create_post(Request $request)
    {
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        Post::create([
            'author_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        return view('create-post', ['tags' => $tags]);
    }
    public function delete_post(Request $request)
    {
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        $post_id = $request->input('post_id');
        $post = Post::where('id', '=', $post_id)->first();
        $post->delete();
        return view('main', ['posts' => Post::all(), 'tags' => $tags]);
    }
}
