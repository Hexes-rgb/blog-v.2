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

    public function createLike($post_id)
    {
        $post = Post::withTrashed()->find($post_id);
        $post->likes()->attach(Auth::user());
        return redirect()->route('read-post', $post_id);
    }

    public function deleteLike($post_id)
    {
        $post = Post::withTrashed()->find($post_id);
        $post->likes->where('id', Auth::id())->last()->likes->deleted_at = Carbon::now();
        $post->likes->find(Auth::id())->likes->save();
        return redirect()->route('read-post', $post_id);
    }

    public function restoreLike($post_id)
    {
        $post = Post::withTrashed()->find($post_id);
        $post->likes->where('id', Auth::id())->last()->likes->deleted_at = null;
        $post->likes->find(Auth::id())->likes->save();
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

    public function deleteComment($post_id, $comment_id)
    {
        $comment = Comment::withTrashed()->find($comment_id);
        $comment->delete();
        return redirect()->route('read-post', $post_id);
    }

    public function restoreComment($post_id, $comment_id)
    {
        $comment = Comment::withTrashed()->find($comment_id);
        $comment->restore();
        return redirect()->route('read-post', $post_id);
    }
}
