
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
        @if($comment->loadCount('comments')->comments_count > 0)
        <button onclick="showHideComment({{ $comment->id }})" type="button" class="link-primary text-sm" >({{ $comment->loadCount('comments')->comments_count }})hide/show</button>
        @endif
        <button onclick="showCommentForm({{ $comment->id }})" type="button" class="link-primary text-sm" >Reply</button>
        @if($comment->author->id == Auth::user()->id and empty($comment->comments->first()->text))
        <a href="{{ route('delete-comment', ['comment_id' => $comment->id, 'post_id' => $comment->post->id]) }}" class="link-danger">x</a>
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