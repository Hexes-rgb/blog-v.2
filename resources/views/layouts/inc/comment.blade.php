
<div class="m-3 p-2 border rounded overflow-hidden">
    <div class="text-start">
        {{ $comment->author->name }}
    </div>
    <div class="text-start">
        {{ $comment->text}}
    </div>
    <button type="button" class="btn" onclick="document.getElementById('2').className='d-none' ">
        hide
    </button>
    <div class="d-block" id="2">
    @each('layouts/inc/comment', $comment->comments, 'comment', 'layouts/inc/no-comments')
    </div>
</div>
