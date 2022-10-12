@extends('layouts.app')

@section('title-block')
    Редактор публикации
@endsection

@section('content')

<div class="container my-5">
    <main>
      <div class="row g-5 justify-content-center">

        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3 text-3xl text-center">Fill in the relevant fields</h4>
          <form action="{{ route('edit-post') }}" method="POST">
                 @csrf
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="title" class="form-label">Title</label>
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="text" class="form-control" name="title" id="title" value="{{ $post->title }}">
                <div class="invalid-feedback">
                  Valid title is required.
                </div>
              </div>
{{--
              <div class="col-sm-6">
                <label for="lastName" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div> --}}
{{--
              <div class="col-12">
                <label for="username" class="form-label">Username</label>
                <div class="input-group has-validation">
                  <span class="input-group-text">@</span>
                  <input type="text" class="form-control" id="username" placeholder="Username" required="">
                <div class="invalid-feedback">
                    Your username is required.
                  </div>
                </div>
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                <input type="email" class="form-control" id="email" placeholder="you@example.com">
                <div class="invalid-feedback">
                  Please enter a valid email address for shipping updates.
                </div>
              </div> --}}

              <div class="col-12">
                <label for="content" class="form-label">Text</label>
                <textarea class="form-control" name="content" id="content" placeholder="Type your text here...">{{ $post->content }}</textarea>
                <div class="invalid-feedback">
                  Please enter your text here.
                </div>
              </div>
            </div>

            <hr class="my-4">
            <button class="btn btn-outline-primary" type="submit">Create post</button>
            <a href="{{ route('delete-post') }}?post_id={{ $post->id }}" class="link-danger">Delete this post</a>
          </form>
        </div>
      </div>
    </main>
  </div>

@endsection

