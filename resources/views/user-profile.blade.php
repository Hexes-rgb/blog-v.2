@extends('layouts.app')

@section('title-block')
    My Profile
@endsection

@section('content')
<div class="container p-4 mt-5 border rounded overflow-hidden shadow-sm">
    <div class="row">
        @include('layouts/inc/user-profile-sidebar')
        @include('layouts.inc.subscriptions')
        <div class="col">
            <img src="{{ url('public/appImages/avatar.png') }}" class="float-end" height="200px" width="200px">
        </div>
        <div class="text-end">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="link-danger me-5">Log out</button>
            </form>
        </div>
    </div>
</div>
@endsection
