<div class="ms-3 d-flex flex-column align-items-stretch flex-shrink-0 bg-white border rounded overflow-hidden shadow-sm col" style="width: 380px;">
    <span class="fs-5 fw-semibold text-center">Unreaded posts({{ $unreaded_posts }})</span>
    <div class="list-group list-group-flush border-bottom scrollarea">
        @if($unreaded_posts == 0)
            {{ $message }}
        @endif
        @foreach($user->subscriptions as $author)
            @foreach ($author->posts as $post)
                @if($post->views->where('id', Auth::id())->isEmpty())
                    <div class="list-group-item py-3 lh-sm">
                        <a href="{{ route('post.show', $post->id) }}" aria-current="true">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <strong class="mb-1">{{ $post->title }}</strong>
                                <small>{{ \Carbon\Carbon::parse($post->created_at)->format('d.m.Y H:i:s') }}</small>
                            </div>
                            <div class="col-10 mb-1 small">
                                {{ Str::limit($post->content, 40) }}
                            </div>
                        </a>
                            <div class="col-10 mb-1 small">
                                <a href="{{ route('user.index', $author->id) }}" class="link link-primary">
                                    {{ $post->author->name }}
                                </a>
                            </div>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
  </div>
