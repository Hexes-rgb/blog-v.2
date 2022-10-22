
<div class="m-3 p-2 border rounded overflow-hidden shadow-sm">
    <div class="text-start d-flex">
        @if($comment->author->id == $comment->post->author->id)
        <div>
        {{ $comment->author->name }}
        </div>
        <div class="ms-2 text-sm text-primary">
            Author
        </div>
        @else
        <div>
        {{ $comment->author->name }}
        </div>
        @endif
    </div>
    <div class="text-start">
        {{ $comment->text}}
        <br>
        @auth
            <form method="POST" action="{{ route('create-comment') }}">
                @csrf
                <input type="text" name="text" autocomplete="off">
                <button type="submit" class="btn btn-outline-primary">Send</button>
                <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            </form>
        @endauth
        {{-- <button id="{{ $comment->id }}" type="button" class="link-primary text-sm" >Reply</button> --}}
    </div>
    <div class="d-block">
    @each('layouts/inc/comment', $comment->comments, 'comment', 'layouts/inc/no-comments')
    </div>
</div>
