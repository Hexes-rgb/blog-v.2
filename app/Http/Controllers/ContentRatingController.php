<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Libraries\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ContentRatingController extends Controller
{
    public function changeLikeStatus($post_id)
    {
        $post = Post::withTrashed()->find($post_id);
        if ($post->likes->where('id', Auth::id())->isEmpty()) {
            $post->likes()->attach(Auth::user());
        } else {
            if ($post->likes->where('id', Auth::id())->last()->likes->deleted_at != null) {
                $post->likes->where('id', Auth::id())->last()->likes->deleted_at = null;
            } else {
                $post->likes->where('id', Auth::id())->last()->likes->deleted_at = Carbon::now();
            }
            $post->likes->find(Auth::id())->likes->save();
        }
        return redirect()->route('read-post', $post_id);
    }

    public function trends()
    {
        $posts = Post::selectRaw('
            *,
            (select count(*) from likes where likes.post_id = posts.id and likes.deleted_at is null and localtimestamp - likes.created_at < interval \'3 days\') +
            (select count(*) from views where views.post_id = posts.id and localtimestamp - views.created_at < interval \'3 days\') +
            (select count(distinct comments.user_id) from comments where comments.post_id = posts.id and comments.deleted_at is null and localtimestamp - comments.created_at < interval \'3 days\') as rating
        ')
            ->orderBy('rating', 'desc')
            ->get();
        return view('trends', ['posts' => $posts, 'tags' => Services::popularTags()]);
    }

    public function search(Request $request)
    {
        $text = $request->input('text');
        $sort = $request->input('sort') ?? 'DESC';
        if ($text) {
            $posts = Post::selectRaw('
            *,
            (select count(*) from likes where likes.post_id = posts.id and likes.deleted_at is null and localtimestamp - likes.created_at < interval \'3 days\') +
            (select count(*) from views where views.post_id = posts.id and localtimestamp - views.created_at < interval \'3 days\') +
            (select count(distinct comments.user_id) from comments where comments.post_id is posts.id and comments.deleted_at = null and localtimestamp - comments.created_at < interval \'3 days\') as rating
        ')
                ->where(function (Builder $query) use ($text) {
                    $query->where('title', 'ILIKE', '%' . $text . '%')
                        ->orWhereHas('tags', function (Builder $query) use ($text) {
                            $query->where('name', 'ILIKE', '%' . $text . '%');
                        })
                        ->orWhereHas('author', function (Builder $query) use ($text) {
                            $query->where('name', 'ILIKE', '%' . $text . '%');
                        });
                })
                ->orderBy('rating', 'desc')
                ->get();
        } else {
            $posts = Post::selectRaw('
            *,
            (select count(*) from likes where likes.post_id = posts.id and likes.deleted_at is null and localtimestamp - likes.created_at < interval \'3 days\') +
            (select count(*) from views where views.post_id = posts.id and localtimestamp - views.created_at < interval \'3 days\') +
            (select count(distinct comments.user_id) from comments where comments.post_id = posts.id and comments.deleted_at is null and localtimestamp - comments.created_at < interval \'3 days\') as rating
        ')
                ->orderBy('rating', 'desc')
                ->get();
        }
        if ($sort == 'DESC') {
            return view('trends', ['posts' => $posts, 'tags' => Services::popularTags(), 'text' => $text]);
        } else {
            return view('trends', ['posts' => $posts, 'tags' => Services::popularTags(), 'text' => $text]);
        }
    }
}
