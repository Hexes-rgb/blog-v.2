@section('header')

<header class="d-flex bg-white sticky-top flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="col-md-3">
      <h1>
        <a href="/" class="nav-link link-dark">
            Blog
        </a>
    </h1>
    </div>
    <div class="col-md-6">
      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        @foreach($tags as $tag)
            <li>
                <a href="/?tag_id={{ $tag->id }}"  class="nav-link px-2 link-primary">
                    {{ $tag->name }}
                </a>
            </li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-3 gx-5 text-end">
    </div>
</header>
