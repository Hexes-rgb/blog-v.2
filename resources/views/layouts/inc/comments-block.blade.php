<div class="p-4 mt-4 container border rounded overflow-hidden shadow-sm comments">
    <p class="fs-2">
        {{-- ({{ count($post->postComments) }}) --}}
        Commentaries:</p>
        {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}
        @auth
        <form class="commentForm" method="POST" action="{{ route('comment.store') }}">
            @csrf
            <div class="alert alert-danger" id="comments-block" style="display:none"></div>
            <input type="text" name="text" autocomplete="off" class="form-control @error('text') is-invalid @enderror" >
            <button type="submit" class="btn btn-outline-primary">Send</button>
            <input type="hidden" name="post_id" value="{{ $post->id }}">
        </form>
        @error('text')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    @endauth

    <div class="ms-2 mb-2 answers">
        @if($post->postComments->isNotEmpty())
            @each('layouts/inc/comment', $post->postComments->where('comment_id', null)->sortBy('created_at'), 'comment', 'layouts/inc/no-comments')
        @endif
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
    $('.comments').on('click', '.restoreComment', function(event){
        let comment_id = $(this).attr('comment-id')
        let comment_body = $(this).parent().parent()
        let post_id = $(this).attr('post-id')
        // let url = "{{ route('comment.restore', ['post_id' => $post->id, 'comment_id' => 0]) }}"
        let url = `/post/${post_id}/read/comment/${comment_id}/restore`
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
    // var form = '.create-comment-form';
    $('.comments').on('click', '.deleteComment', function(event){
        let comment_id = $(this).attr('comment-id')
        let comment_body = $(this).parent().parent()
        let post_id = $(this).attr('post-id')
        // let url = "{{ route('comment.delete', ['post_id' => $post->id, 'comment_id' => 0]) }}"
        let url = `/post/${post_id}/read/comment/${comment_id}`
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
    $('.comments').on('submit', '.commentForm', function(event){
        event.preventDefault();
        var url = $(this).attr('action');
        var form = $(this)
        // var comment = $(form).parent().parent().parent()

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
                // $(form).trigger("reset");
                jQuery('#comments-block').empty();
                jQuery('#comments-block').hide();
                jQuery.each(response.errors, function(key, value){
                        jQuery('#comments-block').show();
                        jQuery('#comments-block').append('<p>'+value+'</p>');
                    });
                $(form).trigger("reset");
                $(form).parent().children().next('.answers').append(response.data)
            },
            error: function(response) {
            }
        });
    })


    $('.comments').on('submit', '.answerForm', function(event){
        event.preventDefault();
        var url = $(this).attr('action');
        var form = $(this)
        var comment = $(form).closest('.comment-body')
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
                $(form).children('.alert').empty();
                $(form).children('.alert').hide();
                jQuery.each(response.errors, function(key, value){
                    $(form).children('.alert').show();
                    $(form).children('.alert').append('<p>'+value+'</p>');
                });
                // alert(response.success)
                // $('.answers').append(response.data)
                // $('.answers').replaceWith(response.data);
                $(form).trigger("reset");
                $(comment).next('.answers').removeClass('d-none')
                $(comment).next('.answers').addClass('d-block')
                $(comment).next('.answers').append(response.data)

            },
            error: function(response) {
            }
        });
    })

});
</script>
