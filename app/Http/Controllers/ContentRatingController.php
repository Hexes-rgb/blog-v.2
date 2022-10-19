<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        $post->likes()->detach(Auth::user());
        return redirect()->route('read-post', $post_id);
    }
}
