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
        return view('user-profile', ['tags' => Services::popularTags(), 'userPosts' => Auth::user()->posts]);
    }

    public function showAnotherUserProfile($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        return view('another-user-profile', ['tags' => Services::popularTags(), 'userPosts' => $user->posts]);
    }
}
