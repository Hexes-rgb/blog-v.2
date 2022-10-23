<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Libraries\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentRatingController extends Controller
{
    public function like($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        $post->likes()->attach(Auth::user());
        return redirect()->route('read-post', $post_id);
    }

    public function removeLike($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        $post->likes->where('id', Auth::user()->id)->last()->likes->is_deleted = true;
        $post->likes->where('id', Auth::user()->id)->last()->likes->save();
        return redirect()->route('read-post', $post_id);
    }

    public function trends()
    {
        $posts = Post::withCount('likes')->get()->sortBy('likes');
        return view('trends', ['posts' => $posts, 'tags' => Services::popularTags()]);
    }
}
