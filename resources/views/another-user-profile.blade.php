@extends('layouts.app')

@section('title-block')
    User Profile
@endsection

@section('content')
    <div class="container p-4 mt-5 border rounded overflow-hidden shadow-sm">
        <div class="row">
            @include('layouts/inc/user-profile-sidebar')
            <div class="col">
                <img src="{{ url('public/appImages/avatar.png') }}" class="float-end" height="200px" width="200px">
            </div>
            <div class="text-end">
                @auth
                    @if (Auth::user()->subscriptions->where('id', $user->id)->isEmpty())
                        <a href="{{ route('create-subscription', $user->id) }}" class="link-primary">
                            Subscribe
                        </a>
                    @elseif(Auth::user()->subscriptions->find($user->id)->subscriptions->deleted_at != null)
                        <a href="{{ route('restore-subscription', $user->id) }}" class="link-primary">
                            Subscribe
                        </a>
                    @else
                        <a href="{{ route('delete-subscription', $user->id) }}" class="link-danger">
                            Unsubscribe
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection
