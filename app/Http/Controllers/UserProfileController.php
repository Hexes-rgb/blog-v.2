<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Libraries\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function showUserProfile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('user-profile', ['tags' => Services::popularTags(), 'user' => $user]);
    }

    public function showAnotherUserProfile($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        if (!empty(Auth::user()->subscriptions->where('id', $user_id)->first()->name)) {
            $isSubscribed = true;
        } else {
            $isSubscribed = false;
        }
        return view('another-user-profile', ['tags' => Services::popularTags(), 'user' => $user, 'isSubscribed' => $isSubscribed]);
    }

    public function subscribe($author_id)
    {
        $author = User::where('id', $author_id)->first();
        $user = User::where('id', Auth::user()->id)->first();
        $user->subscriptions()->attach($author);
        return redirect()->route('another-user-profile', $author_id);
    }

    public function unSubscribe($author_id)
    {
        $author = User::where('id', $author_id)->first();
        $user = User::where('id', Auth::user()->id)->first();
        $user->subscriptions()->detach($author);
        return redirect()->route('another-user-profile', $author_id);
    }
}
