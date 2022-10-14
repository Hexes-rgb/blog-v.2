<div class="dropdown-menu d-block position-static pt-0 mx-0 rounded-3 shadow overflow-hidden w-280px">
    <form class="p-2 mb-2 bg-light border-bottom">
        <input type="search" class="form-control tags input.autocomplete" autocomplete="on" placeholder="Type to find...">
    </form>
    <ul id="tags-dropdown-menu" class="list-unstyled mb-0 d-none">
        @if(empty($post))
        {{-- @foreach ($tags as $tag)
        <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
            <span class="d-inline-block bg-primary rounded-circle p-1"></span>
            {{ $tag->name }}
                </a></li>
            <input type="hidden" class="tag" name="tag_id" value="{{ $tag->id }}">
        @endforeach --}}
        @else
        @foreach ($post->tags as $tag)
            <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                    <span class="d-inline-block bg-primary rounded-circle p-1"></span>
                    {{ $tag->name }}
                </a></li>
            <input type="hidden" class="tag" name="tag_id" value="{{ $tag->id }}">
        @endforeach
        @endif
    </ul>
</div>

<script>
    let dropMenu = false
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('tags')) {
            dropMenu = !dropMenu
        }
        if (dropMenu) {
            document.getElementById('tags-dropdown-menu').className = 'd-block'
        } else {
            document.getElementById('tags-dropdown-menu').className = 'd-none'
        }
    })
    getTags();
    async function getTags() {
        try{
            let url = 'http://127.0.0.1:8000/api';
            let response = await fetch(url);
            let json = await response.json();
        } catch {
            alert('Ошибка, данные не получены.')
        }
    }
</script>
