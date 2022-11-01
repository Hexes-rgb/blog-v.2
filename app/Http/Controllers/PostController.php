<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function sendTagsJson()
    {
        $tags = array();
        foreach (Tag::all() as $tag) {
            array_push($tags, $tag->name);
        }
        $data = json_encode(array('allTags' => $tags));
        return response()->json($data);
    }

    public function show($post_id)
    {
        $post = Post::find($post_id);
        if (Auth::user()) {
            if ($post->views->where('id', Auth::id())->isEmpty()) {
                $post->views()->attach(Auth::user());
            }
            $post = Post::find($post_id);
            if (Carbon::now()->diffInHours($post->views->where('id', Auth::id())->last()->views->created_at) > 3) {
                $post->views()->attach(Auth::user());
            }
        }
        return view('read-post', [
            'post' => $post,
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get()
        ]);
    }

    public function edit($post_id)
    {

        $post = Post::where('id', '=', $post_id)->withTrashed()->get()->first();
        return view('post-redactor', ['tags' => Tag::popular()->get(), 'post' => $post]);
    }

    public function create()
    {
        return view('post-redactor', ['tags' => Tag::popular()->get()]);
    }

    public function update(Request $request)
    {
        $post_id = $request->input('post_id');
        $image = $request->file('image');
        $post = Post::where('id', '=', $post_id)->first();
        if ($image) {
            $post->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'image' => date('YmdHi') . $image->getClientOriginalName(),
            ]);
            $image->move(public_path('public/postsImages'), date('YmdHi') . $image->getClientOriginalName());
        } else {
            $post->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);
        }
        return redirect()->route('post.edit', $post_id);
    }

    public function store(Request $request)
    {
        $image = $request->file('image');
        if (!empty($image)) {
            $post = Post::create([
                'author_id' => Auth::id(),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'image' => date('YmdHi') . $image->getClientOriginalName(),
            ]);
            $image->move(public_path('public/postsImages'), date('YmdHi') . $image->getClientOriginalName());
        } else {
            $post = Post::create([
                'author_id' => Auth::id(),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);
        }
        return redirect()->route('post.edit', $post->id);
    }

    public function destroy(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);
        $post->delete();
        return redirect()->route('post.edit', $post->id);
    }

    public function restore(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::withTrashed()->find($post_id);
        $post->restore();
        return redirect()->route('post.edit', $post->id);
    }
}
