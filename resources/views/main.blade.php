@extends('layouts.app')

@section('title-block')
    Main page
@endsection

@section('content')
    <section class="w-100 p-4 pb-4 d-flex justify-content-center align-items-center flex-column">
        <div>
            <form action="{{ route('main-search') }}" method="POST">
                @csrf
                <div class="input-group">
                    @if(!empty($text))
                    <input type="text" autocomplete="off" value="{{ $text }}" name="text" class="form-control rounded" aria-label="Search"
                        aria-describedby="search-addon">
                    @else
                    <input type="text" autocomplete="off" name="text" class="form-control rounded" aria-label="Search"
                         aria-describedby="search-addon">
                    @endif
                        {{-- Объединить в одну функцию, параметр поиска добавить в select --}}
                    <button type="submit" class="btn btn-outline-primary">Apply</button>
                    {{-- <a href="{{ route('sort-by-asc') }}" class="ms-3 text-decoration-none link-primary">Sort by ASC</a>
                    <a href="{{ route('sort-by-desc') }}" class="ms-3 text-decoration-none link-primary">Sort by DESC</a> --}}
                    <select class="form-select text-grey border-white overflow-hidden" size="2" aria-label="size 2 select example" name="sort">
                       <option class="d-inline ms-3" value="DESC">DESC</option>
                       <option class="d-inline ms-3" value="ASC">ASC</option>
                    </select>
                </div>
            </form>
        </div>
    </section>

    <div class="container">
        <div class="row mb-2">
            @foreach ($posts as $post)
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
                <div class="col-6 gy-5">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-100 position-relative">
                        <div class="col-12 p-4 d-flex flex-column position-static mh-50">
                            <strong class="d-inline-block mb-2 text-center">
                                @foreach ($post->tags as $tag)
                                    <a href="{{ route('main-filter-by-tag', $tag->id) }}"
                                        class="text-decoration-none link-primary">{{ $tag->name }}</a>
                                @endforeach
                            </strong>
                            <h3 class="text-3xl"><a href="{{ route('read-post', $post->id) }}">{{ Str::limit($post->title, 100) }}</a></h3>
                            <div class="mb-1 text-muted">Created at: {{ $post->created_at }}</div>
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
                                Updated at: {{ $post->updated_at }}
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
                            <p>
                                {{ $post->loadCount('likes')->likes_count }}
                            </p>
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
                            <img src="{{ url('public/Image/'.$post->image) }}" class="img-thumbnail w-100 h-100" alt="Responsive image">

                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
