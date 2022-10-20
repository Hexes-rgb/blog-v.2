<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Libraries\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadPostController extends Controller
{
    public function readPost($post_id)
    {
        $all_tags = Tag::all();
        $tags = array();
        foreach ($all_tags as $tag) {
            if (!empty($tag->posts[0])) {
                array_push($tags, $tag);
            }
        }
        $post = Post::where('id', '=', $post_id)->first();
        $now = Carbon::now();
        dd($post->views);
        dd($now->diffInMinutes($post->views->where('id', Auth::user()->id)->first()->pivot->created_at));
        if ($now->diffInSeconds($post->views->where('id', Auth::user()->id)->last()->created_at) > 10) {
            $post->views()->attach(Auth::user());
        }
        return view('read-post', ['post' => $post, 'tags' => Services::popularTags()]);
    }
}
