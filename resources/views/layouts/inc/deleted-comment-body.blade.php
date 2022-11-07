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
                <button type="button" comment-id="{{ $comment->id }}" class="restoreComment ms-1 btn-link link-success">Restore comment</button>
                {{-- <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            </form> --}}
        <br>
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

// var form = '#answer';


$('.restoreComment').off().on('click', function(event){
    let comment_id = $(this).attr('comment-id')
    let comment_body = $(this).parent().parent()
    // let post_id = $(this).attr('post-id')
    let url = "{{ route('comment.restore', ['post_id' => $comment->post->id, 'comment_id' => $comment->id]) }}"
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
        method: 'post',
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
