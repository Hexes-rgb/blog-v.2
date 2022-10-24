
<div class="m-3 p-2 border rounded overflow-hidden shadow-sm">
    <div class="text-start d-flex">
        @if($comment->author->id == $comment->post->author->id and $comment->is_deleted == false)
        <div>
        {{ $comment->author->name }}
        </div>
        <div class="ms-2 text-sm text-primary">
            Author
        </div>
        @else
        <div>
        @if($comment->is_deleted == true)
            Unknowm user
        @else
        {{ $comment->author->name }}
        @endif
        </div>
        @endif
    </div>
    <div class="text-start">
        @if($comment->is_deleted == true)
        Comment has been deleted
        @else
        {{ $comment->text}}
        @endif
        <br>
        @if($comment->loadCount('comments')->comments_count > 0)
        <button onclick="showHideComment({{ $comment->id }})" type="button" class="link-primary text-sm" >({{ $comment->loadCount('comments')->comments_count }})hide/show</button>
        @endif
        @auth
        @if($comment->is_deleted == false)
        <button onclick="showCommentForm({{ $comment->id }})" type="button" class="link-primary text-sm" >Reply</button>
        @endif
        @endauth
        @if($comment->author->id == Auth::user()->id and $comment->is_deleted == false)
        <a href="{{ route('change-comment-status', ['comment_id' => $comment->id, 'post_id' => $comment->post->id, 'is_deleted' => 'true']) }}" class="link-danger">x</a>
        @elseif($comment->author->id == Auth::user()->id and $comment->is_deleted == true)
        <a href="{{ route('change-comment-status', ['comment_id' => $comment->id, 'post_id' => $comment->post->id, 'is_deleted' => 'false']) }}" class="link-success">Restore</a>
        @else
        @endif
        <br>
        @auth
        <div class="ms-2 d-none" id="comment-form{{ $comment->id }}">
            <form method="POST" action="{{ route('create-comment') }}">
                @csrf
                <input class="" type="text" name="text" autocomplete="off">
                <button type="submit" class="btn btn-outline-primary">Send</button>
                <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            </form>
        </div>
        @endauth
    </div>
    <div id="answers{{ $comment->id }}" class="d-none">
    @each('layouts/inc/comment', $comment->comments, 'comment', 'layouts/inc/no-comments')
    </div>
</div>

<script>
function showHideComment(id){
    if(document.getElementById('answers' + id).className == "d-none"){
    document.getElementById('answers' + id).className="d-block";
    } else {
        document.getElementById('answers' + id).className="d-none";
    }
}

function showCommentForm(id){
    if(document.getElementById('comment-form' + id).className == "d-none"){
    document.getElementById('comment-form' + id).className="d-block";
    } else {
        document.getElementById('comment-form' + id).className="d-none";
    }
}
</script>
