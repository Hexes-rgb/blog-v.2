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
                @if ($isSubscribed)
                    <a href="{{ route('change-subscribe-status', $user->id) }}" class="link-danger">
                        Unsubscribe
                    </a>
                @else
                    <a href="{{ route('change-subscribe-status', $user->id) }}" class="link-primary">
                        Subscribe
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
