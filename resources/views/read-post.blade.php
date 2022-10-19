@extends('layouts.app')

@section('title-block')
    Read post
@endsection

@section('content')

<div class="p-4 mt-4 container border rounded overflow-hidden shadow-sm">
    <div class="text-center">
        <h3 class="fs-1">{{ $post->title }}</h3>
    </div>
    @if(!empty($post->image))
    <div>
        <img src="{{ url('public/Image/'.$post->image) }}" class="rounded mx-auto img-thumbnail mh-50 mw-50 h-50 w-50" alt="Responsive image">
    </div>
    @endif
    <div class="text-start mt-3">
        <p class="fs-3">{{ $post->content }}</p>
    </div>
    <div class="text-start mt-3">
        <div class="text-start mt-3 text-muted">
            @if(!empty(Auth::user()->id) and (Auth::user()->id == $post->author->id))
            <p class="fs-5">Author: <a href="{{ route('user-profile') }}" >{{ $post->author->name }}</a></p>
            @else
            <p class="fs-5">Author: <a href="{{ route('another-user-profile', $post->author->id) }}" >{{ $post->author->name }}</a></p>
            @endif
        </div>
        <div class="text-start mt-3 row">
            <p class="fs-5 col-4 text-muted">Created at: {{ $post->created_at }}</p>
            <p class="fs-5 col-4 text-muted">Updated at: {{ $post->updated }}</p>
            @if(!empty(Auth::user()->id) and (Auth::user()->id == $post->author->id))
            <p class="fs-5 col-4 text-end text-primary"><a href="{{ route('edit-post', $post->id) }}">Edit this post</a></p>
            @else
            @if(empty(Auth::user()->likedPosts->where('id', $post->id)->first()->title))
            <p class="fs-5 col-4 text-end text-primary"><a href="{{ route('like-post', ['post_id' => $post->id]) }}">Like this post</a></p>
            <p>{{ $post->loadCount('likes')->likes_count }}</p>
            @else
            <p class="fs-5 col-4 text-end text-danger"><a href="{{ route('remove-like', ['post_id' => $post->id]) }}">Remove your like</a></p>
            <p>{{ $post->loadCount('likes')->likes_count }}</p>
            @endif
            @endif
        </div>
    </div>
</div>

@endsection

