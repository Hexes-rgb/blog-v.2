<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ContentRatingController extends Controller
{
    public function index()
    {
        return view('trends', [
            'posts' => Post::trends()->orderBy('rating', 'desc')->get(),
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get()
        ]);
    }

    public function search(Request $request)
    {
        $text = $request->input('text');
        $sort = $request->input('sort') ?? 'DESC';
        if ($text) {
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
                ->get();
        } else {
            $posts = Post::trends()
                ->orderBy('created_at', $sort)
                ->get();
        }
        return view('trends', [
            'posts' => $posts,
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get(),
            'text' => $text
        ]);
    }
}
