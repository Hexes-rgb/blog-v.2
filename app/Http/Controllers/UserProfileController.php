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
        $user = User::where('id', Auth::user()->id)->first();
        return view('user-profile', ['tags' => Tag::popular()->get(), 'user' => $user]);
    }

    public function showAnotherUserProfile($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        if (Auth::user()->subscriptions->where('id', $user_id)->isNotEmpty()) {
            if (Auth::user()->subscriptions->find($user_id)->subscriptions->deleted_at == null) {
                $isSubscribed = true;
            } else {
                $isSubscribed = false;
            }
        } else {
            $isSubscribed = false;
        }
        return view('another-user-profile', ['tags' => Tag::popular()->get(), 'user' => $user, 'isSubscribed' => $isSubscribed]);
    }

    public function changeSubscribeVisibility($author_id)
    {
        $author = User::find($author_id);
        $user = User::find(Auth::id());
        if ($user->subscriptions->where('id', $author_id)->isEmpty()) {
            $user->subscriptions()->attach($author);
        } else {
            if ($user->subscriptions->find($author_id)->subscriptions->deleted_at == null) {
                $user->subscriptions->find($author_id)->subscriptions->deleted_at = Carbon::now();
            } else {
                $user->subscriptions->find($author_id)->subscriptions->deleted_at = null;
            }
            $user->subscriptions->find($author_id)->subscriptions->save();
        }
        return redirect()->route('another-user-profile', $author_id);
    }
}
