<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index($user_id)
    {
        $user = User::find($user_id);
        dd($user->subscriptions);
        if (Auth::id() != null and Auth::id() == $user->id) {
            if ($user->subscriptions->isNotEmpty()) {
                return view('user-profile', [
                    'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get(),
                    'user' => $user,
                    'unreaded_posts' => User::unreadedPosts()->first()->unreaded_posts, 'message' => 'No new posts'
                ]);
            } else {
                return view('user-profile', [
                    'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get(),
                    'user' => $user,
                    'unreaded_posts' => 0, 'message' => 'You don\'t have any subscriptions.'
                ]);
            }
        } else {
            return view('user-profile', [
                'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get(),
                'user' => $user
            ]);
        }
    }
}
