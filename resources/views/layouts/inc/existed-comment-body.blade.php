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
                <button type="button" comment-id="{{ $comment->id }}" class="deleteComment ms-1 btn-link link-danger">Delete comment</button>
                {{-- <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            </form> --}}
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
$(document).ready(function(){

$('.answerFormButton').off().on('click', function(){
    $('.answerFormButton').off().parent().submit(function(event){
        event.preventDefault();
        var url = $(this).attr('action');
        var form = $(this)
        var comment = $(form).parent().parent().parent()
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
                // alert(response.success)
                // $('.answers').append(response.data)
                // $('.answers').replaceWith(response.data);
                $(form).trigger("reset");
                $(comment).next().next().removeClass('d-none')
                $(comment).next().next().addClass('d-block')
                $(comment).next().next().append(response.data)

            },
            error: function(response) {
            }
        });
    })

});

$('.deleteComment').off().on('click', function(event){
    let comment_id = $(this).attr('comment-id')
    let comment_body = $(this).parent().parent()
    // let post_id = $(this).attr('post-id')
    let url = "{{ route('comment.delete', ['post_id' => $comment->post->id, 'comment_id' => $comment->id]) }}"
    let data = {
        // "post_id": post_id,
        "comment_id": comment_id
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url,
        method: 'delete',
        data,
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
</script>
