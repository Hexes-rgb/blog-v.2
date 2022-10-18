@extends('layouts.app')

@section('title-block')
    Read post
@endsection

@section('content')

<p>{{ $post->title }}</p>

@endsection

