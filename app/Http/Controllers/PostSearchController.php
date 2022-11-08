<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PostSearchController extends Controller
{
    public function search(Request $request)
    {
        $sort = $request->input('sort') ?? "DESC";
        $text = $request->input('query');
        if ($text != '') {
            $posts = Post::trends()
                ->where(function (Builder $query) use ($text) {
                    $query->where('title', 'ILIKE', '%' . $text . '%')
                        ->orWhereHas('tags', function (Builder $query) use ($text) {
                            $query->where('name', 'ILIKE', '%' . $text . '%');
                        })
                        ->orWhereHas('author', function (Builder $query) use ($text) {
                            $query->where('name', 'ILIKE', '%' . $text . '%');
                        });
                })
                ->orderBy('created_at', $sort)
                ->paginate(4);
        } else {
            $posts = Post::trends()
                ->orderBy('created_at', $sort)
                ->paginate(4);
        }
        // return view('main', [
        //     'posts' => $posts,
        //     'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get(),
        //     'text' => $text
        // ]);
        return response()->json(['data' => view('layouts.inc.main-content', ['posts' => $posts])->render()]);
    }
    public function filter($tag_id)
    {
        if ($tag_id) {
            $posts = Post::trends()
                ->whereHas('tags', function (Builder $query) use ($tag_id) {
                    $query->where('id', $tag_id);
                })
                ->orderBy('rating', 'desc')
                ->paginate(4);
        } else {
            $posts = Post::trends()->orderBy('rating', 'desc')->paginate(4);
        }
        $text = Tag::find($tag_id)->name;
        return view('main', [
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get(),
            'posts' => $posts,
            'text' => $text
        ]);
    }
}
