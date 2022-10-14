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
        <input type="text" autocomplete="off" name="text" class="form-control rounded" aria-label="Search" aria-describedby="search-addon">
        <button type="submit" class="btn btn-outline-primary">Search</button>
      </div>
        </form>
    </div>
</section>

<div class="container">
@foreach($posts as $post)
<!-- <div class="col-md-6"></div> -->
<div class="text-center">
    <div class="row col-md-12 g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-success">
                @foreach($post->tags as $tag)
                 <a href="{{ route('main-filter-by-tag', $tag->id ) }}" class="text-decoration-none link-primary">{{ $tag->name }}</a>
                 @endforeach
            </strong>
            <h3 class="text-3xl"><a href="{{ route('edit-post', $post->id) }}">{{ $post->title }}</a></h3>
            <div class="mb-1 text-muted">{{ $post->created_at }}</div>
            <p class="text-base">{{ $post->content }}</p>
            <div class="mb-1 text-muted">{{ $post->author->name }}</div>
            </div>
        </div>
</div>
@endforeach
</div>

@endsection
