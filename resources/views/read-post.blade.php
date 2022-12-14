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
            <img src="{{ url('public/postsImages/'.$post->image) }}" class="rounded mx-auto img-thumbnail mh-50 mw-50 h-50 w-50" alt="Responsive image">
        </div>
    @endif
    <div class="text-start mt-3">
        <p class="fs-3">{{ $post->content }}</p>
    </div>
    <div class="text-start mt-3">
        <div class="text-start mt-3 text-muted">
            @if(Auth::check() and (Auth::id() == $post->author->id))
                <p class="fs-5">
                    Author: <a href="{{ route('user-profile') }}" >
                        {{ $post->author->name }}
                    </a>
                </p>
            @else
                <p class="fs-5">Author: <a href="{{ route('another-user-profile', $post->author->id) }}" >{{ $post->author->name }}</a></p>
            @endif
        </div>
        <div class="text-start mt-3 row">
            <p class="fs-5 col-4 text-muted">Created at: {{ \Carbon\Carbon::parse($post->created_at)->format('d.m.Y H:i:s') }}</p>
            <p class="fs-5 col-4 text-muted">Updated at: {{ \Carbon\Carbon::parse($post->updated_at)->format('d.m.Y H:i:s') }}</p>
            @auth
                @if(Auth::check() and (Auth::id() == $post->author->id))
                    <p class="fs-5 col-4 text-end text-primary"><a href="{{ route('edit-post', $post->id) }}">Edit this post</a></p>
                @else
                    @if(Auth::user()->likedPosts->where('id', $post->id)->isEmpty() or $post->likes->find(Auth::id())->likes->deleted_at != null)
                    <p class="fs-5 col-4 text-end text-primary">
                        <a href="{{ route('change-like-visibility', ['post_id' => $post->id]) }}">
                        Like this post
                        </a>
                    </p>
                    @else
                        <p class="fs-5 col-4 text-end text-danger">
                            <a href="{{ route('change-like-visibility', ['post_id' => $post->id]) }}">Remove your like
                            </a>
                        </p>
                    @endif
                @endif
            @endauth
        </div>
        <div class="post-info-block justify-content-end">
            <div class="view-block-read">
                <div>
                    <img id="view-icon" src="{{ url('public/appImages/view.png') }}">
                </div>
                <div class="text-primary fs-5">
                    {{ $post->loadCount('views')->views_count }}
                </div>
            </div>
            <div class="like-block-read">
                <div>
                    <img id="like-icon" src="{{ url('public/appImages/heart.png') }}">
                </div>
                <div class="fs-5 like-color">
                    {{ $post->loadCount(['likes' => function($query){
                        $query->where('deleted_at', null);
                    }])->likes_count }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.inc.comments-block')

@endsection

