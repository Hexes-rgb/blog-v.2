<strong>Hello, here while you were gone, new cool posts on our blog came out.</strong>
@foreach ($posts as $post)
<div class="mt-2">
    <a href="{{ route('post.show', $post->id) }}">
        {{$post->title}}
    </a>
</div>
@endforeach
