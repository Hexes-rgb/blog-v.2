@extends('layouts.app')

@section('title-block')
    Read post
@endsection

@section('content')

<div class="p-4 mt-4 container border rounded overflow-hidden shadow-sm readPost">
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
            <p class="fs-5">
                Author: <a href="{{ route('user.index', $post->author->id) }}" >
                    {{ $post->author->name }}
                </a>
            </p>
        </div>
        <div class="text-start mt-3 row">
            <p class="fs-5 col-4 text-muted">Created at: {{ \Carbon\Carbon::parse($post->created_at)->format('d.m.Y H:i:s') }}</p>
            <p class="fs-5 col-4 text-muted">Updated at: {{ \Carbon\Carbon::parse($post->updated_at)->format('d.m.Y H:i:s') }}</p>
            @include('layouts.inc.post-like-actions')
        </div>
        <div class="d-flex justify-content-start">
            {{-- <button type="button" post-id="{{ $post->id }}" id="exportPost">
                <img id="xlsx-icon" src="{{ url('public/appImages/export-excel.png') }}">
            </button> --}}
            <a href="{{ route('post.export', $post->id) }}">
                <img id="xlsx-icon" src="{{ url('public/appImages/export-excel.png') }}">
            </a>
        </div>
        {{-- <div class="post-info-block justify-content-end">
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
        </div> --}}
    </div>
</div>

@include('layouts.inc.comments-block')

{{-- <script>
$(document).ready(function(){
    $(document).on('click', '#exportPost', function(){
        let post_id = $(this).attr('post-id');
        // let data = {
        //     'post_id': post_id,
        // }
        let url = `${post_id}/export`;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: 'get'
            success:function(response)
            {
                $(comment_body).replaceWith(response.data);
            },
            error: function(response) {
                $(comment_body).replaceWith(response.data);
            }
        });
    });
});
</script> --}}
@endsection

