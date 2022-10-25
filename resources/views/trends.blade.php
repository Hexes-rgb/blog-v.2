@extends('layouts.app')

@section('title-block')
    Trends
@endsection

@section('content')
<section class="w-100 p-4 pb-1 d-flex justify-content-center align-items-center flex-column">
    <div>
        <form action="{{ route('trends-search') }}" method="POST">
            @csrf
            @include('layouts.inc.search-form')
        </form>
    </div>
</section>

<div class="container">
    <div class="row mb-2">
        @foreach ($posts->where('is_deleted', false) as $post)
            <!-- <div class="col-md-6"></div> -->
            {{-- <div class="text-center">
<div class="row col-md-12 g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
        <strong class="d-inline-block mb-2 text-success">
            @foreach ($post->tags as $tag)
             <a href="{{ route('main-filter-by-tag', $tag->id ) }}" class="text-decoration-none link-primary">{{ $tag->name }}</a>
             @endforeach
        </strong>
        <h3 class="text-3xl"><a href="{{ route('edit-post', $post->id) }}">{{ $post->title }}</a></h3>
        <div class="mb-1 text-muted">Created at: {{ $post->created_at }}</div>
        <p class="text-base">{{ $post->content }}</p>
        <div class="mb-1 text-muted">{{ $post->author->name }}</div>
        <div class="mb-1 text-muted">Updated at: {{ $post->updated_at }}</div>
        </div>
    </div>
</div> --}}
            <div class="col-6 gy-3">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-100 position-relative">
                    <div class="col-12 p-4 d-flex flex-column position-static mh-50">
                        <div class="row">
                            <div class="col post-info-block">
                            <div class="like-block-main">
                                <div>
                                <img id="like-icon" src="{{ url('public/appImages/heart.png') }}">
                                </div>
                                <div class="like-color fs-5">
                                {{ $post->loadCount(['likes' => function($query){
                                    $query->where('is_deleted', false);
                                }])->likes_count }}
                                </div>
                            </div>
                            <div class="view-block-main">
                                <div>
                                <img id="view-icon" src="{{ url('public/appImages/view.png') }}">
                                </div>
                                <div class="text-primary fs-5">
                                {{ $post->loadCount('views')->views_count }}
                                </div>
                            </div>
                            <div class="text-success fs-5 ms-4">
                                Rating: {{ $post->rating }}
                            </div>
                            </div>
                        <strong class="d-inline-block mb-2 text-end col">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('main-filter-by-tag', $tag->id) }}"
                                    class="text-decoration-none link-primary">{{ $tag->name }}</a>
                            @endforeach
                        </strong>
                        </div>
                        <h3 class="text-3xl"><a href="{{ route('read-post', $post->id) }}">{{ Str::limit($post->title, 100) }}</a></h3>
                        <div class="mb-1 text-muted">Created at: {{ \Carbon\Carbon::parse($post->created_at)->format('d.m.Y H:m:s')  }}</div>
                        <p class="text-base">{{Str::limit($post->content, 100)}}</p>
                        @if(!empty(Auth::user()->id) and (Auth::user()->id == $post->author->id))
                        <div class="mb-1 text-muted">
                            Author: <a href="{{ route('user-profile') }}" >{{ $post->author->name }}</a>
                        </div>
                        @else
                        <div class="mb-1 text-muted">
                            Author: <a href="{{ route('another-user-profile', $post->author->id) }}" >{{ $post->author->name }}</a>
                        </div>
                        @endif
                        <div class="mb-1 text-muted">
                            Updated at: {{ \Carbon\Carbon::parse($post->updated_at)->format('d.m.Y H:m:s')  }}
                        </div>
                        {{-- @if(!empty(Auth::user()->id) and (Auth::user()->id != $post->author->id))
                        @if(empty(Auth::user()->likedPosts->where('id', $post->id)->first()->title))
                        <p class="fs-5 col-4 text-start text-primary">
                            <a href="{{ route('like-post', ['post_id' => $post->id, 'route' => '']) }}">Like this post</a>
                        </p>
                        @else
                        <p class="fs-5 col-4 text-start text-danger">
                            <a href="{{ route('remove-like', ['post_id' => $post->id]) }}">Remove your like</a>
                        </p>
                        @endif
                        @endif --}}
                    </div>
                    @if($post->image)
                    <div class="col-12 d-none d-lg-block mh-50 mw-100">
                        {{-- <svg class="bd-placeholder-img h-100" width="300" height="250" xmlns="http://www.w3.org/2000/svg"
                            role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                            focusable="false">
                            <title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%"
                                y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg> --}}
                        <img src="{{ url('public/postsImages/'.$post->image) }}" class="img-thumbnail w-100 h-100" alt="Responsive image">

                    </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
