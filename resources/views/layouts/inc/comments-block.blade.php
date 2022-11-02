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
            <button type="submit" class="btn btn-outline-primary">Send</button>
            <input type="hidden" name="post_id" value="{{ $post->id }}">
        </form>
        @error('text')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    @endauth

    <div class="ms-2 mb-2">
        @if($post->postComments->isNotEmpty())
            @each('layouts/inc/comment', $post->postComments->where('comment_id', null), 'comment', 'layouts/inc/no-comments')
        @endif
    </div>
</div>
