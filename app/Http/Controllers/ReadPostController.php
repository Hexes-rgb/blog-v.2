<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Comment;
use App\Libraries\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadPostController extends Controller
{
    public function readPost($post_id)
    {

        $post = Post::find($post_id);
        if (Auth::user()) {
            if (empty($post->views->where('id', Auth::user()->id)->first()->views->created_at)) {
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

    public function changeCommentStatus($post_id, $comment_id, $is_deleted)
    {
        $comment = Comment::where('id', $comment_id)->first();
        if ($is_deleted == 'false') {
            $comment->is_deleted = false;
        } else {
            $comment->is_deleted = true;
        }
        $comment->save();
        return redirect()->route('read-post', $post_id);
    }
}
