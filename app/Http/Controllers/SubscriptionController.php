<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $author_id = $request->input('author_id');
        $author = User::find($author_id);
        $user = User::find(Auth::id());
        $user->subscriptions()->attach($author);
        return redirect()->route('user.index', $author_id);
    }

    public function destroy(Request $request)
    {
        $author_id = $request->input('author_id');
        $user = User::find(Auth::id());
        $user->subscriptions->find($author_id)->subscriptions->deleted_at = Carbon::now();
        $user->subscriptions->find($author_id)->subscriptions->save();
        return redirect()->route('user.index', $author_id);
    }

    public function restore(Request $request)
    {
        $author_id = $request->input('author_id');
        $user = User::find(Auth::id());
        $user->subscriptions->find($author_id)->subscriptions->deleted_at = null;
        $user->subscriptions->find($author_id)->subscriptions->save();
        return redirect()->route('user.index', $author_id);
    }
}
