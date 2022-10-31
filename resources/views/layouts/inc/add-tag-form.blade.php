<div class="dropdown-menu d-block position-static pt-0 mx-0 rounded-3 shadow overflow-hidden w-280px">
    <form method="POST" class="p-2 mb-2 bg-light border-bottom" action="{{ route('post_tag.store', $post->id) }}" enctype="multipart/form-data" id="add-tag-form">
        @csrf
        <div class="autocomplete">
            <div class="row">
                <div class="col-8">
                    <input type="text" autocomplete="off" class="form-control tags" id="myInput" name="myTags"
                        placeholder="Type to find..." required>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-outline-primary">Add tag</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        {{-- <input type="hidden" id="hiddenTitle" name="title" value="">
        <input type="hidden" id="hiddenContent" name="content" value=""> --}}
    </form>
    <ul id="tags-dropdown-menu" class="list-unstyled mb-0 d-block">
        @if(isset($post))
            @foreach ($post->tags as $tag)
                <li>
                    <div class="dropdown-item d-flex align-items-center gap-2 py-2">
                        <span class="d-inline-block bg-primary rounded-circle p-1"></span>
                        {{ $tag->name }}
                        {{-- <a href="{{ route('post_tag.delete', ['post_id' => $post->id, 'tag_id' => $tag->id]) }}">
                            <span class="d-inline-block text-3xl text-danger p-1">-</span>
                        </a> --}}
                        <form action="{{ route('post_tag.delete', ['post_id' => $post->id, 'tag_id' => $tag->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="ms-1 btn-link link-danger">Remove Tag</button>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="tag_id" value="{{ $tag->id }}">
                        </form>
                    </div>
                </li>
                <input type="hidden" class="tag" name="tag_id" value="{{ $tag->id }}">
            @endforeach
        @endif
    </ul>
</div>

<script>

$(document).ready(function(){

    var form = '#add-tag-form';

    $(form).on('submit', function(event){
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
                $(form).trigger("reset");
                alert(response.success)

            },
            error: function(response) {
                $(form).trigger("reset");
                alert(response.error)
            }
        });
    });

});
</script>
