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
            <div class="col-6 gy-3">
                @auth
                    @if($post->author->id == Auth::id())
                        <div class="row g-0 border border-success border-2 rounded overflow-hidden flex-md-row mb-4 shadow-sm h-100 position-relative">
                    @elseif(Auth::user()->subscriptions->where('id', $post->author->id)->isNotEmpty())
                        @if($post->author->id == Auth::user()->subscriptions->find($post->author->id)->id and Auth::user()->subscriptions->find($post->author->id)->subscriptions->deleted_at == null)
                            <div class="row g-0 border border-primary border-2 rounded overflow-hidden flex-md-row mb-4 shadow-sm h-100 position-relative">
                        @else
                            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-100 position-relative">
                        @endif
                    @else
                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-100 position-relative">
                    @endif
                @endauth
                @guest
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-100 position-relative">
                @endguest
                    <div class="col-12 p-4 d-flex flex-column position-static mh-50">
                        <div class="row">
                            <div class="col post-info-block">
                                <div class="like-block-main">
                                    <div>
                                        <img id="like-icon" src="{{ url('public/appImages/heart.png') }}">
                                    </div>
                                    <div class="like-color fs-5">
                                        {{ $post->loadCount(['likes' => function($query){
                                            $query->where('deleted_at', null);
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
                        <h3 class="text-3xl">
                            <a href="{{ route('read-post', $post->id) }}">
                                {{ Str::limit($post->title, 100) }}
                            </a>
                        </h3>
                        <div class="mb-1 text-muted">
                            Created at: {{ \Carbon\Carbon::parse($post->created_at)->format('d.m.Y H:m:s')  }}
                        </div>
                        <p class="text-base">
                            {{Str::limit($post->content, 100)}}
                        </p>
                        @if(!empty(Auth::id()) and (Auth::id() == $post->author->id))
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
                    </div>
                    @if($post->image)
                        <div class="col-12 d-none d-lg-block mh-50 mw-100">
                            <img src="{{ url('public/postsImages/'.$post->image) }}" class="img-thumbnail w-100 h-100" alt="Responsive image">
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
