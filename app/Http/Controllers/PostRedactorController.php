<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Libraries\Services;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostRedactorController extends Controller
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

    public function showCreatePostForm()
    {
        return view('create-post', ['tags' => Services::popularTags()]);
    }
    public function showUpdatePostForm($post_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        return view('edit-post', ['tags' => Services::popularTags(), 'post' => $post]);
    }
    public function updatePost(Request $request)
    {
        $post_id = $request->input('post_id');
        $image = $request->file('image');
        $post = Post::where('id', '=', $post_id)->first();
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => date('YmdHi') . $image->getClientOriginalName(),
        ]);
        $image->move(public_path('public/Image'), date('YmdHi') . $image->getClientOriginalName());
        return redirect()->route('edit-post', $post_id);
        // return view('edit-post', ['tags' => Services::tags(), 'post' => $post]);
    }
    public function addTag(Request $request)
    {
        $post_id = $request->input('post_id');
        if ($post_id == 'no-post') {
            if (!empty($request->input('title')) and !empty($request->input('content'))) {
                $post = Post::create([
                    'author_id' => Auth::user()->id,
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                ]);
            } elseif (!empty($request->input('title')) and empty($request->input('content'))) {
                $post = Post::create([
                    'author_id' => Auth::user()->id,
                    'title' => $request->input('title'),
                    'content' => 'Example content',
                ]);
            } elseif (empty($request->input('title')) and !empty($request->input('content'))) {
                $post = Post::create([
                    'author_id' => Auth::user()->id,
                    'title' => 'Example title',
                    'content' => $request->input('content'),
                ]);
            } else {
                $post = Post::create([
                    'author_id' => Auth::user()->id,
                    'title' => 'Example title',
                    'content' => 'Example content',
                ]);
            }
        } else {
            $post = Post::where('id', '=', $post_id)->first();
        }
        $tagName = $request->input('myTags');
        if (!empty(Tag::where('name', 'ILIKE', $tagName)->first()->name)) {
            $tagName = Tag::where('name', 'ILIKE', $tagName)->first()->name;
        }
        if (empty(Tag::where('name', 'ILIKE', $tagName)->first()->name)) {
            Tag::create([
                'name' => $tagName,
            ]);
            $tag = Tag::where('name', 'ILIKE', $tagName)->first();
            $post->tags()->attach($tag);
        } elseif (empty($post->tags->where('name', 'ILIKE', $tagName)->first()->name)) {
            $tag = Tag::where('name', 'ILIKE', $tagName)->first();
            $post->tags()->attach($tag);
        } else {
            return redirect()->route('edit-post', $post->id);
        }
        return redirect()->route('edit-post', $post->id);
    }
    public function removeTag($post_id, $tag_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        $tag = Tag::where('id', '=', $tag_id)->first();
        $post->tags()->detach($tag);
        return redirect()->route('edit-post', $post->id);
    }
    public function createPost(Request $request)
    {
        Post::create([
            'author_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $request->file('image'),
        ]);
        $post = Post::where('author_id', '=', Auth::user()->id)
            ->where('title', '=', $request->input('title'))
            ->where('content', '=', $request->input('content'))->first();
        return redirect()->route('edit-post', $post->id);
        // return view('create-post', ['tags' => Services::tags()]);
    }
    public function deletePost($post_id)
    {
        $post = Post::where('id', '=', $post_id)->first();
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('main-index');
        // return view('main', ['posts' => Post::all()->sortByDesc('created_at'), 'tags' => Services::tags()]);
    }
}
