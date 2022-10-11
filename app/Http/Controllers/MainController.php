<?php

namespace App\Http\Controllers;

use PhpParser\Node\Name;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();
        if ($request->input('tag_id')) {
            $tag_id = $request->input('tag_id');
            $posts = Post::whereHas('tags', function (Builder $query) use ($tag_id) {
                $query->where('id', '=', $tag_id);
            })->get();
        } else {
            $posts = Post::all();
        }
        if ($request->input('text')) {
            $text = $request->input('text');
            $posts = Post::where('title', 'ILIKE', '%' . $text . '%')
                ->orWhereHas('tags', function (Builder $query) use ($text) {
                    $query->where('name', 'ILIKE', '%' . $text . '%');
                })->get();
        }
        return view('main', ['posts' => $posts, 'tags' => $tags]);
    }
}
