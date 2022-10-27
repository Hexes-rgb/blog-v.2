<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ContentRatingController extends Controller
{
    public function trends()
    {
        return view('trends', ['posts' => Post::trends()->get(), 'tags' => Tag::popular()->get()]);
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
                ->get();
        } else {
            $posts = Post::trends()->get();
        }
        if ($sort == 'DESC') {
            return view('trends', ['posts' => $posts, 'tags' => Tag::popular()->get(), 'text' => $text]);
        } else {
            return view('trends', ['posts' => $posts, 'tags' => Tag::popular()->get(), 'text' => $text]);
        }
    }
}
