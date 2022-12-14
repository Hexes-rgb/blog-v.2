<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white border rounded overflow-hidden shadow-sm col" style="width: 380px;">
    <span class="fs-5 fw-semibold text-center">All my posts ({{ count($user->posts) }})</span>
    <div class="list-group list-group-flush border-bottom scrollarea">
        @foreach ($user->posts as $post)
            @if ($post->author->id != Auth::id())
                <a href="{{ route('read-post', $post->id) }}" class="list-group-item py-3 lh-sm" aria-current="true">
                    <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">{{ $post->title }}</strong>
                        <small>{{ \Carbon\Carbon::parse($post->created_at)->format('d.m.Y') }}</small>
                    </div>
                    <div class="col-10 mb-1 small">{{ Str::limit($post->content, 40) }}</div>
                </a>
            @else
                <a href="{{ route('edit-post', $post->id) }}" class="list-group-item py-3 lh-sm" aria-current="true">
                    <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">{{ $post->title }}</strong>
                        <small>{{ \Carbon\Carbon::parse($post->created_at)->format('d.m.Y H:i:s') }}</small>
                    </div>
                    <div class="col-10 mb-1 small">
                        {{ Str::limit($post->content, 40) }}
                    </div>
                </a>
            @endif
        @endforeach
    </div>
  </div>
