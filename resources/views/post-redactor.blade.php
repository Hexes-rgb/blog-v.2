@extends('layouts.app')

@section('title-block')
    Publication redactor
@endsection

@section('content')
    <div class="container my-5">
        <main class="position-relative">
            <div class="row g-5">
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3 text-3xl text-center">Fill in the relevant fields</h4>
                    @if(isset($post))
                        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="text" class="form-control" name="title" id="title"
                                        value="{{ $post->title }}">
                                    <div class="invalid-feedback">
                                        Valid title is required.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="content" class="form-label">Text</label>
                                    <textarea class="form-control" name="content" id="content" placeholder="Type your text here...">{{ $post->content }}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter your text here.
                                    </div>
                                </div>
                            </div>
                            @include('layouts/inc/add-image')
                            @if($post->image)
                                <img class="mt-5 img-thumbnail" src="{{ url('public/postsImages/'.$post->image) }}" style="height: 200px; width: 300px;">
                            @endif
                            <hr class="my-4">
                            <button class="btn btn-outline-primary" type="submit">Update post</button>
                            @if (!$post->trashed())
                                <button type="button" data-bs-toggle="modal" data-bs-target="#delete-modal" class="link-danger ms-3 delete-post">Delete this post</button>
                            @else
                                <a href="{{ route('post.restore', ['post_id' => $post->id]) }}" class="link-success ms-3">Restore deleted post</a>
                            @endif
                        </form>
                        @include('layouts/inc/delete-post-modal')
                    @else
                        <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" value="Example title" name="title" id="title">
                                    <div class="invalid-feedback">
                                        Valid title is required.
                                    </div>
                                </div>
                            <div class="col-12">
                                    <label for="content" class="form-label">Text</label>
                                    <textarea class="form-control" name="content" id="content" placeholder="Type your text here..." required="">Example content</textarea>
                                    <div class="invalid-feedback">
                                        Please enter your text here.
                                    </div>
                            </div>
                            </div>
                            @include('layouts/inc/add-image')
                            <hr class="my-4">
                            <button class="btn btn-outline-primary" type="submit">Create post</button>
                        </form>
                    @endif
                </div>
                <div id='tags' class="col-md-5 col-lg-4">
                    @include('layouts/inc/tags-dropdown-menu')
                </div>
            </div>
        </main>
    </div>
@endsection
