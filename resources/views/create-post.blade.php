@extends('layouts.app')

@section('title-block')
    Create publication
@endsection

@section('content')

<div class="container my-5">
    <main>
      <div class="row g-5">
        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3 text-3xl text-center">Fill in the relevant fields</h4>
          <form action="{{ route('create-post') }}" method="POST" enctype="multipart/form-data">
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
        </div>
        <div class="col-md-5 col-lg-4">
            @include('layouts/inc/tags-dropdown-menu')
        </div>
      </div>
    </main>
  </div>

@endsection

