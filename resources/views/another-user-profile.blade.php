@extends('layouts.app')

@section('title-block')
    User Profile
@endsection

@section('content')

@foreach ($user->posts as $post)
    <p class="text-center">
        <a href="{{ route('read-post', $post->id) }}" class="link-primary">{{ $post->title }}</a>
    </p>
@endforeach
<a href="{{ route('subscribe', $user->id) }}" class="link-primary">Subscribe</a>
@endsection
