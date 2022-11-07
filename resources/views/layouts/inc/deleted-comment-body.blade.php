<div class="comment-body">
    <div class="text-start d-flex">
        Unknowm user
    </div>
    <div class="text-start">
        Comment has been deleted
    </div>
    <div class="text-start">
        {{-- @if($comment->loadCount('comments')->comments_count > 0) --}}
            <button onclick="showHideComment({{ $comment->id }})" type="button" class="link-primary text-sm" >
        {{-- ({{ $comment->loadCount('comments')->comments_count }}) --}}
                hide/show
            </button>
        @auth
            {{-- <form method="POST" action="{{ route('comment.restore', ['comment_id' => $comment->id, 'post_id' => $comment->post->id]) }}">
                @csrf --}}
                {{-- <button type="submit" class="btn btn-outline-success">Restore comment</button> --}}
                <button type="button" post-id="{{ $comment->post->id }}" comment-id="{{ $comment->id }}" class="restoreComment ms-1 btn-link link-success">Restore comment</button>
                {{-- <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            </form> --}}
        <br>
        @endauth
    </div>
</div>
