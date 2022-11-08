<div id="content" class="container">
    <div class="mt-2 d-flex justify-content-center">
        <div class="pagination-links">
            {{-- {{ $posts->appends(request()->only('text', 'sort'))->links() }} --}}
            {{ $posts->links() }}
        </div>
    </div>
    <div class="row mb-2">
        @foreach ($posts as $post)
            @include('layouts.inc.post-card')
        @endforeach
    </div>
</div>
