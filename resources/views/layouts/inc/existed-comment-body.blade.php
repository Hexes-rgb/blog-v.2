<div class="comment-body">
    <div class="text-start d-flex">
        @if($comment->author->id == $comment->post->author->id and !$comment->trashed())
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
    </div>
    <div class="text-start">
        {{-- @if($comment->loadCount('comments')->comments_count > 0) --}}
            <button onclick="showHideComment({{ $comment->id }})" type="button" class="link-primary text-sm" >
                {{-- ({{ $comment->loadCount('comments')->comments_count }}) --}}
                hide/show
            </button>
        {{-- @endif --}}
        @auth
            <button onclick="showCommentForm({{ $comment->id }})" type="button" class="link-primary text-sm" >Reply</button>
            {{-- <form method="POST" action="{{ route('comment.delete', ['comment_id' => $comment->id, 'post_id' => $comment->post->id]) }}">
                @csrf
                @method('delete') --}}
                {{-- <button type="submit" class="btn btn-outline-danger">Delete comment</button> --}}
                <button type="button" post-id="{{ $comment->post->id }}" comment-id="{{ $comment->id }}" class="deleteComment ms-1 btn-link link-danger">Delete comment</button>
                {{-- <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            </form> --}}
        <br>
            <div class="ms-2 d-none" id="comment-form{{ $comment->id }}">
                <form class="answerForm" method="POST" action="{{ route('comment.store') }}">
                    @csrf
                    <div class="alert alert-danger" id="comment" style="display:none"></div>
                    <input class="form-control @error('text') is-invalid @enderror" type="text" name="text" autocomplete="off">
                    <button type="submit" class="btn btn-outline-primary">Send</button>
                    @error('text')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                </form>
            </div>
        @endauth
    </div>
</div>
