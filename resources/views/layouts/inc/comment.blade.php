
<div class="m-3 p-2 border rounded overflow-hidden shadow-sm comment">
    @if(!$comment->trashed())
        @include('layouts.inc.existed-comment-body')
    @else
        @include('layouts.inc.deleted-comment-body')
    @endif
    {{-- <div class="comment-body">
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
                    @if($comment->trashed())
                        Unknowm user
                    @else
                        {{ $comment->author->name }}
                    @endif
                </div>
            @endif
        </div>
        <div class="text-start">
            @if($comment->trashed())
                Comment has been deleted
            @else
                {{ $comment->text}}
            @endif
        </div>
        <div class="text-start">
            @if($comment->loadCount('comments')->comments_count > 0)
                <button onclick="showHideComment({{ $comment->id }})" type="button" class="link-primary text-sm" >
                    ({{ $comment->loadCount('comments')->comments_count }})
                    hide/show
                </button>
            @endif
            @auth
                @if(!$comment->trashed())
                    <button onclick="showCommentForm({{ $comment->id }})" type="button" class="link-primary text-sm" >Reply</button>
                @endif

            @if($comment->author->id == Auth::id() and !$comment->trashed())
                <form method="POST" action="{{ route('comment.delete', ['comment_id' => $comment->id, 'post_id' => $comment->post->id]) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-danger">Delete comment</button>
                    <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                </form>
            @elseif($comment->author->id == Auth::id() and $comment->trashed())
                <form method="POST" action="{{ route('comment.restore', ['comment_id' => $comment->id, 'post_id' => $comment->post->id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-success">Restore comment</button>
                    <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                </form>
            @else
            @endif
            <br>
                <div class="ms-2 d-none" id="comment-form{{ $comment->id }}">
                    <form method="POST" action="{{ route('comment.store') }}">
                        @csrf
                        <input class="form-control @error('text') is-invalid @enderror" type="text" name="text" autocomplete="off">
                        <button type="submit" class="btn btn-outline-primary answerFormButton">Send</button>
                        @error('text')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                    </form>
                </div>
            @endauth
        </div>
    </div> --}}
    <div id="answers{{ $comment->id }}" class="d-none answers">
        @each('layouts/inc/comment', $comment->comments->sortBy('created_at'), 'comment', 'layouts/inc/no-comments')
    </div>
</div>
