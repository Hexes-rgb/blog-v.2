<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Libraries\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // $posts = Post::withCount('likes')->get()->sortBy('likes');
        $posts = DB::table('posts')
            ->selectRaw(
                'posts.*,
                (select count(*) from likes where likes.post_id = posts.id) + (select count(*) from "views" where "views".post_id = posts.id) as rating'
            )
            ->where('posts.is_deleted', '=',  false)
            ->get();

        dd($posts);
        return view('trends', ['posts' => $posts, 'tags' => Services::popularTags()]);
    }
}
