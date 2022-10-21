<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Libraries\Services;
use Illuminate\Support\Facades\Auth;

class ReadPostController extends Controller
{
    public function readPost($post_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        // dd($post->likes->last()->likes->created_at);
        // dd($post->postComments);
        // dd($post->postComments->where('comment_id', null)->first()->comments);
        if (Auth::user()) {
            if (empty($post->views->where('id', Auth::user()->id)->last()->name)) {
                $post->views()->attach(Auth::user());
                return view('read-post', ['post' => $post, 'tags' => Services::popularTags()]);
            }
            if (Carbon::now()->diffInHours($post->views->where('id', Auth::user()->id)->last()->views->created_at) > 3) {
                $post->views()->attach(Auth::user());
            }
            return view('read-post', ['post' => $post, 'tags' => Services::popularTags()]);
        } else {
            return view('read-post', ['post' => $post, 'tags' => Services::popularTags()]);
        }
    }
}
