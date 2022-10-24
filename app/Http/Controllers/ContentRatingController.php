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

    public function changeLikeStatus($post_id)
    {
        $post = Post::find($post_id);
        if ($post->likes->where('id', Auth::user()->id)->last()->likes->is_deleted == true) {
            $post->likes->where('id', Auth::user()->id)->last()->likes->is_deleted = false;
        } else {
            $post->likes->where('id', Auth::user()->id)->last()->likes->is_deleted = true;
        }
        $post->likes->where('id', Auth::user()->id)->last()->likes->save();
        return redirect()->route('read-post', $post_id);
    }

    public function trends()
    {
        // $posts = Post::withCount('likes')->get()->sortBy('likes');
        // $posts = DB::table('posts')
        //     ->selectRaw(
        //         "posts.*,
        //         (select count(*) from likes where likes.post_id = posts.id and likes.is_deleted = false and localtimestamp - likes.created_at < interval '3 days') +
        //         (select count(*) from views where views.post_id = posts.id and localtimestamp - views.created_at < interval '3 days') as rating"
        //     )
        //     ->where('posts.is_deleted', '=',  false)
        //     ->orderBy('rating', 'asc')
        //     ->get();


        // $posts = Post::withCount([
        //     'likes' => function ($query) {
        //         $query->where('likes.is_deleted', false)
        //             ->where('likes.created_at', '>', Carbon::now()->subDay(3));
        //     },
        //     'views' => function ($query) {
        //         $query->where('views.created_at', '>', Carbon::now()->subDay(3));
        //     }
        // ])
        //     ->where('posts.is_deleted', false)
        //     ->get();

        // $posts = Post::with(['likes', 'views'])
        //     ->select()
        //     ->addSelect(DB::raw("
        //         post.id
        //         (select count(*) as likes_count from likes where likes.is_deleted = false and localtimestamp - likes.created_at < interval '3 days') +
        //         (select count(*) as views_count from views where localtimestamp - views.created_at < interval '3 days') as rating
        //         "))
        //     ->get();

        // $posts = Post::with(['likes', 'views'])
        //     ->select(
        //         'posts.*,
        //         (select count(*) from likes where likes.post_id = posts.id and likes.is_deleted = false and localtimestamp - likes.created_at < interval \'3 days\') +
        //         (select count(*) from views where views.post_id = posts.id and localtimestamp - views.created_at < interval \'3 days\') as rating'
        //     )
        //     ->get();

        $posts = Post::withCount(['likes', 'views'])
            ->select(
                'posts.*'
            )
            ->get();
        dd($posts);
        return view('trends', ['posts' => $posts, 'tags' => Services::popularTags()]);
    }
}
