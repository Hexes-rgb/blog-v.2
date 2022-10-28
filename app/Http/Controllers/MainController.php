<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class MainController extends Controller
{
    public function search(Request $request)
    {
        $sort = $request->input('sort') ?? "DESC";
        $text = $request->input('text');
        if ($text) {
            $posts = Post::where('title', 'ILIKE', '%' . $text . '%')
                ->orWhereHas('tags', function (Builder $query) use ($text) {
                    $query->where('name', 'ILIKE', '%' . $text . '%');
                })
                ->orWhereHas('author', function (Builder $query) use ($text) {
                    $query->where('name', 'ILIKE', '%' . $text . '%');
                })->get();
        } else {
            $posts = Post::all();
        }
        return view('main', [
            'posts' => $posts->sortByDesc('created_at'),
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get(),
            'text' => $text
        ]);
    }
    public function filter($tag_id)
    {
        if ($tag_id) {
            $posts = Post::whereHas('tags', function (Builder $query) use ($tag_id) {
                $query->where('id', $tag_id);
            })->get();
        } else {
            $posts = Post::all();
        }
        $text = Tag::find($tag_id)->name;
        return view('main', [
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get(),
            'posts' => $posts->sortByDesc('created_at'),
            'text' => $text
        ]);
    }
    public function index()
    {
        $posts = Post::all();
        return view('main', [
            'posts' => $posts->sortByDesc('created_at'),
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get()
        ]);
    }
}
