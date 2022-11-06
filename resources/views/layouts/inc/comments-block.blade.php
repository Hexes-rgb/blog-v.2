<div class="p-4 mt-4 container border rounded overflow-hidden shadow-sm">
    <p class="fs-2">({{ count($post->postComments) }}) Commentaries:</p>
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
        <form method="POST" action="{{ route('comment.store') }}">
            @csrf
            <input type="text" name="text" autocomplete="off" class="form-control @error('text') is-invalid @enderror" >
            <button type="submit" class="btn btn-outline-primary commentFormButton">Send</button>
            <input type="hidden" name="post_id" value="{{ $post->id }}">
        </form>
        @error('text')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    @endauth

    <div id="answers-" class="ms-2 mb-2">
        @if($post->postComments->isNotEmpty())
            @each('layouts/inc/comment', $post->postComments->where('comment_id', null), 'comment', 'layouts/inc/no-comments')
        @endif
    </div>
</div>

<script>

$(document).ready(function(){

    // var form = '.create-comment-form';

    $('.commentFormButton').off().on('click', function(){
        $('.commentFormButton').off().parent().submit(function(event){
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
                    $(form).trigger("reset");
                    $(form).parent().children().next().next().append(response.data)
                },
                error: function(response) {
                }
            });
        })

    });

});
</script>
