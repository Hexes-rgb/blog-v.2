<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::withTrashed()->find($post_id);
        $post->likes()->attach(Auth::user());
        // return redirect()->route('post.show', $post_id);
        return response()->json(['data' => view('layouts.inc.post-like-actions', ['post' => $post])->render()]);
    }

    public function destroy(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::withTrashed()->findOrFail($post_id);
        $post->likes->where('id', Auth::id())->last()->likes->deleted_at = Carbon::now();
        $post->likes->find(Auth::id())->likes->save();
        // return redirect()->route('post.show', $post_id);
        return response()->json(['data' => view('layouts.inc.post-like-actions', ['post' => $post])->render()]);
    }

    public function restore(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::withTrashed()->findOrFail($post_id);
        $post->likes->where('id', Auth::id())->last()->likes->deleted_at = null;
        $post->likes->find(Auth::id())->likes->save();
        // return redirect()->route('post.show', $post_id);
        return response()->json(['data' => view('layouts.inc.post-like-actions', ['post' => $post])->render()]);
    }
}
