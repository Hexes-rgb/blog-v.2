
<div class="m-3 p-2 border rounded overflow-hidden shadow-sm comment">
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
        <br>
        @if($comment->loadCount('comments')->comments_count > 0)
            <button onclick="showHideComment({{ $comment->id }})" type="button" class="link-primary text-sm" >({{ $comment->loadCount('comments')->comments_count }})hide/show</button>
        @endif
        @auth
            @if(!$comment->trashed())
                <button onclick="showCommentForm({{ $comment->id }})" type="button" class="link-primary text-sm" >Reply</button>
            @endif

        @if($comment->author->id == Auth::id() and !$comment->trashed())
            {{-- <a href="{{ route('comment.delete', ['comment_id' => $comment->id, 'post_id' => $comment->post->id]) }}" class="link-danger">x</a> --}}
            <form method="POST" action="{{ route('comment.delete', ['comment_id' => $comment->id, 'post_id' => $comment->post->id]) }}">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-outline-danger">Delete comment</button>
                <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            </form>
        @elseif($comment->author->id == Auth::id() and $comment->trashed())
            {{-- <a href="{{ route('comment.restore', ['comment_id' => $comment->id, 'post_id' => $comment->post->id]) }}" class="link-success">Restore</a> --}}
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
                    <button id="commentFormButton{{ $comment->id }}" type="button" class="btn btn-outline-primary">Send</button>
                    @error('text')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
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
$(document).ready(function(){

    // var form = '#answer';

    $('#commentFormButton68').on('click', function(){
        console.log(123);
        $('#commentFormButton-').parent().submit(function(event){
            event.preventDefault();
            var url = $(this).attr('action');

            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(response)
                {
                    alert(response.success)
                    // $(form).trigger("reset");
                },
                error: function(response) {
                }
            });
        })

    });

});
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
