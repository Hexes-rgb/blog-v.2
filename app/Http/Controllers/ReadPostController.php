<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadPostController extends Controller
{
    public function readPost($post_id)
    {

        $post = Post::find($post_id);
        if (Auth::user()) {
            if ($post->views->where('id', Auth::id())->isEmpty()) {
                $post->views()->attach(Auth::user());
                return view('read-post', ['post' => $post, 'tags' => Tag::popular()->get()]);
            }
            if (Carbon::now()->diffInHours($post->views->where('id', Auth::id())->last()->views->created_at) > 3) {
                $post->views()->attach(Auth::user());
            }
            return view('read-post', ['post' => $post, 'tags' => Tag::popular()->get()]);
        } else {
            return view('read-post', ['post' => $post, 'tags' => Tag::popular()->get()]);
        }
    }

    public function changeLikeVisibility($post_id)
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

    public function createComment(Request $request)
    {
        $post_id = $request->input('post_id');
        $comment_id = $request->input('comment_id') ?? null;
        $text = $request->input('text');
        Comment::create([
            'post_id' => $post_id,
            'user_id' => Auth::user()->id,
            'comment_id' => $comment_id,
            'text' => $text,
        ]);
        return redirect()->route('read-post', $post_id);
    }

    public function changeCommentVisibility($post_id, $comment_id)
    {
        $comment = Comment::withTrashed()->find($comment_id);
        if ($comment->trashed()) {
            $comment->restore();
        } else {
            $comment->delete();
        }
        return redirect()->route('read-post', $post_id);
    }
}
