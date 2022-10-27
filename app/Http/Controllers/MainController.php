<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Libraries\Services;
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
        if ($sort == 'DESC') {
            return view('main', ['posts' => $posts->sortByDesc('created_at'), 'tags' => Tag::popular()->get(), 'text' => $text]);
        } else {
            return view('main', ['posts' => $posts->sortBy('created_at'), 'tags' => Tag::popular()->get(), 'text' => $text]);
        }
    }
    public function filterByTag($tag_id)
    {
        if ($tag_id) {
            $posts = Post::whereHas('tags', function (Builder $query) use ($tag_id) {
                $query->where('id', $tag_id);
            })->get();
        } else {
            $posts = Post::all();
        }
        $text = Tag::where('id', $tag_id)->first()->name;
        return view('main', ['tags' => Services::popularTags(), 'posts' => $posts->sortByDesc('created_at'), 'text' => $text]);
    }
    public function index()
    {
        $posts = Post::all();
        return view('main', ['posts' => $posts->sortByDesc('created_at'), 'tags' => Tag::popular()->get()]);
    }
}
