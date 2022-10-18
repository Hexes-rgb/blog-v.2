@extends('layouts.app')

@section('title-block')
    My Profile
@endsection

@section('content')

@foreach ($userPosts as $post)
    <p clas = "text-center">
        <a href="{{ route('edit-post', $post->id) }}" class="link-primary">{{ $post->title }}</a>
    </p>
@endforeach

@endsection
