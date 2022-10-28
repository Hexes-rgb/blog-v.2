<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
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
        return redirect()->route('post.show', $post_id);
    }

    public function destroy($post_id, $comment_id)
    {
        $comment = Comment::withTrashed()->find($comment_id);
        $comment->delete();
        return redirect()->route('post.show', $post_id);
    }

    public function restore($post_id, $comment_id)
    {
        $comment = Comment::withTrashed()->find($comment_id);
        $comment->restore();
        return redirect()->route('post.show', $post_id);
    }
}
