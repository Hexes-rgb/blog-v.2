@extends('layouts.app')

@section('title-block')
    User Profile
@endsection

@section('content')
<div class="container p-4 mt-5 border rounded overflow-hidden shadow-sm">
@include('layouts/inc/user-profile-sidebar')
@if($isSubscribed)
<a href="{{ route('unsubscribe', $user->id) }}" class="link-danger">Unsubscribe</a>
@else
<a href="{{ route('subscribe', $user->id) }}" class="link-primary">Subscribe</a>
@endif
</div>
@endsection
