@extends('layouts.app')

@section('title-block')
    User Profile
@endsection

@section('content')

@foreach ($userPosts as $post)
    <p class="text-center">
        <a href="{{ route('read-post', $post->id) }}" class="link-primary">{{ $post->title }}</a>
    </p>
@endforeach

@endsection
