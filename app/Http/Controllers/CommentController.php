<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validated();
        $post_id = $request->input('post_id');
        $comment_id = $request->input('comment_id') ?? null;
        Comment::create([
            'post_id' => $post_id,
            'user_id' => Auth::id(),
            'comment_id' => $comment_id,
            'text' => $validated['text'],
        ]);
        return redirect()->route('post.show', $post_id);
    }

    public function destroy(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $post_id = $request->input('post_id');
        $comment = Comment::withTrashed()->findOrFail($comment_id);
        $comment->delete();
        return redirect()->route('post.show', $post_id);
    }

    public function restore(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $post_id = $request->input('post_id');
        $comment = Comment::withTrashed()->findOrFail($comment_id);
        $comment->restore();
        return redirect()->route('post.show', $post_id);
    }
}
