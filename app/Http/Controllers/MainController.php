<?php

namespace App\Http\Controllers;

use App\Libraries\Services;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class MainController extends Controller
{

    public function search(Request $request)
    {
        $text = $request->input('text');
        if ($text) {
            $posts = Post::where('title', 'ILIKE', '%' . $text . '%')
                ->orWhereHas('tags', function (Builder $query) use ($text) {
                    $query->where('name', 'ILIKE', '%' . $text . '%');
                })->get()
                ->sortByDesc('created_at');
        } else {
            $posts = Post::all()
                ->sortByDesc('created_at');
        }
        return view('main', ['posts' => $posts, 'tags' => Services::tags()]);
    }
    public function filterByTag($tag_id)
    {
        if ($tag_id) {
            $posts = Post::whereHas('tags', function (Builder $query) use ($tag_id) {
                $query->where('id', '=', $tag_id);
            })->get()
                ->sortByDesc('created_at');
        } else {
            $posts = Post::all();
        }
        return view('main', ['tags' => Services::tags(), 'posts' => $posts]);
    }
    public function index()
    {
        $posts = Post::all()
            ->sortByDesc('created_at');
        return view('main', ['posts' => $posts, 'tags' => Services::tags()]);
    }
}
