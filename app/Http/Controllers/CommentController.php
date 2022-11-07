<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // $validated = $request->validated();
        $validator = Validator::make($request->all(), [
            'text' => 'required|max:255|min:2',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $validated = $validator->validated();
        $post_id = $request->input('post_id');
        $comment_id = $request->input('comment_id') ?? null;
        // $post = Post::findOrFail($post_id);
        $comment = Comment::create([
            'post_id' => $post_id,
            'user_id' => Auth::id(),
            'comment_id' => $comment_id,
            'text' => $validated['text'],
        ]);
        // return redirect()->route('post.show', $post_id);
        return response()->json(['data' => view('layouts.inc.comment', ['comment' => $comment])->render()]);
    }

    public function destroy(Request $request)
    {
        $comment_id = $request->input('comment_id');
        // $post_id = $request->input('post_id');
        $comment = Comment::withTrashed()->findOrFail($comment_id);
        $comment->delete();
        // return redirect()->route('post.show', $post_id);
        return response()->json(['data' => view('layouts.inc.deleted-comment-body', ['comment' => $comment])->render()]);
    }

    public function restore(Request $request)
    {
        $comment_id = $request->input('comment_id');
        // $post_id = $request->input('post_id');
        $comment = Comment::withTrashed()->findOrFail($comment_id);
        $comment->restore();
        // return redirect()->route('post.show', $post_id);
        return response()->json(['data' => view('layouts.inc.existed-comment-body', ['comment' => $comment])->render()]);
    }
}
