<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function showUserProfile()
    {
        $user = User::find(Auth::id());
        if ($user->subscriptions->isNotEmpty()) {
            return view('user-profile', [
                'tags' => Tag::popular()->get(), 'user' => $user,
                'unreaded_posts' => User::unreadedPosts()->first()->unreaded_posts, 'message' => 'No new posts'
            ]);
        } else {
            return view('user-profile', [
                'tags' => Tag::popular()->get(), 'user' => $user,
                'unreaded_posts' => 0, 'message' => 'You don\'t have any subscriptions.'
            ]);
        }
    }

    public function showAnotherUserProfile($user_id)
    {
        $user = User::find($user_id);
        return view('another-user-profile', ['tags' => Tag::popular()->get(), 'user' => $user]);
    }

    public function createSubscription($author_id)
    {
        $author = User::find($author_id);
        $user = User::find(Auth::id());
        $user->subscriptions()->attach($author);
        return redirect()->route('another-user-profile', $author_id);
    }

    public function deleteSubscription($author_id)
    {
        $user = User::find(Auth::id());
        $user->subscriptions->find($author_id)->subscriptions->deleted_at = Carbon::now();
        $user->subscriptions->find($author_id)->subscriptions->save();
        return redirect()->route('another-user-profile', $author_id);
    }

    public function restoreSubscription($author_id)
    {
        $user = User::find(Auth::id());
        $user->subscriptions->find($author_id)->subscriptions->deleted_at = null;
        $user->subscriptions->find($author_id)->subscriptions->save();
        return redirect()->route('another-user-profile', $author_id);
    }
}
