<div id="read-post-action" class="col-4 d-flex justify-content-end">
    @auth
    @if(Auth::check() and (Auth::id() == $post->author->id))
        <p class="fs-5 col-4 text-end text-primary"><a href="{{ route('post.edit', $post->id) }}">Edit this post</a></p>
    @else
        @if(Auth::user()->likedPosts->where('id', $post->id)->isEmpty())
            <p class="fs-5 col-4 text-end text-primary">
                {{-- <form method="POST" action="{{ route('like.store', $post->id) }}" class="text-end">
                    @csrf --}}
                    {{-- <input type="hidden" name="post_id" value="{{ $post->id }}"> --}}
                    <div class="like-block-read">
                        <div>
                            <button type="button" post-id="{{ $post->id }}" class="like">
                                <img id="like-icon" src="{{ url('public/appImages/no-like.png') }}">
                            </button>
                        </div>
                        <div class="fs-5 text-muted">
                            {{ $post->loadCount(['likes' => function($query){
                                $query->where('deleted_at', null);
                            }])->likes_count }}
                        </div>
                    </div>
                {{-- </form> --}}
            </p>
        @elseif($post->likes->find(Auth::id())->likes->deleted_at != null)
            <p class="fs-5 col-4 text-end text-primary">
                {{-- <form method="POST" action="{{ route('like.restore', $post->id) }}" class="text-end">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}"> --}}
                    <div class="like-block-read">
                        <div>
                            <button type="button" post-id="{{ $post->id }}" class="restoreLike">
                                <img id="like-icon" src="{{ url('public/appImages/no-like.png') }}">
                            </button>
                        </div>
                        <div class="fs-5 text-muted">
                            {{ $post->loadCount(['likes' => function($query){
                                $query->where('deleted_at', null);
                            }])->likes_count }}
                        </div>
                    </div>
                {{-- </form> --}}
            </p>
        @else
            <p class="fs-5 col-4 text-end">
                {{-- <form method="POST" action="{{ route('like.delete', $post->id) }}" class="text-end">
                    @csrf
                    @method('delete') --}}
                    {{-- <input type="hidden" name="post_id" value="{{ $post->id }}"> --}}
                    <div class="like-block-read">
                        <div>
                            <button type="button" post-id="{{ $post->id }}" class="removeLike">
                                <img id="like-icon" src="{{ url('public/appImages/heart.png') }}">
                            </button>
                        </div>
                        <div class="fs-5 like-color">
                            {{ $post->loadCount(['likes' => function($query){
                                $query->where('deleted_at', null);
                            }])->likes_count }}
                        </div>
                    </div>
                {{-- </form> --}}
            </p>
        @endif
    @endif
    @endauth
    <div class="ms-1 post-info-block justify-content-end">
        <div class="view-block-read">
            <div>
                <img id="view-icon" src="{{ url('public/appImages/view.png') }}">
            </div>
            <div class="text-primary fs-5">
                {{ $post->loadCount('views')->views_count }}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('.removeLike').on('click', function(event){
            let post_id = $(this).attr('post-id')
            let url = "{{ route('like.delete', $post->id) }}"
            let data = {
                "post_id": post_id
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
                    // alert(response.success)
                    $('#read-post-action').replaceWith(response.data);
                },
                error: function(response) {
                    // alert(response.success)
                    $('#read-post-action').replaceWith(response.data);
                }
            });
        });

        $('.restoreLike').on('click', function(event){
            let post_id = $(this).attr('post-id')
            let url = "{{ route('like.restore', $post->id) }}"
            let data = {
                "post_id": post_id
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
                    // alert(response.success)
                    $('#read-post-action').replaceWith(response.data);
                },
                error: function(response) {
                    // alert(response.success)
                    $('#read-post-action').replaceWith(response.data);
                }
            });
        });

        $('.like').on('click', function(event){
            let post_id = $(this).attr('post-id')
            let url = "{{ route('like.store', $post->id) }}"
            let data = {
                "post_id": post_id
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
                    // alert(response.success)
                    $('#read-post-action').replaceWith(response.data);
                },
                error: function(response) {
                    // alert(response.success)
                    $('#read-post-action').replaceWith(response.data);
                }
            });
        });

    });
</script>
