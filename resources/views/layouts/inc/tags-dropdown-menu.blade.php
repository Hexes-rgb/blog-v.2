<div class="dropdown-menu d-block position-static pt-0 mx-0 rounded-3 shadow overflow-hidden w-280px">
    <form class="p-2 mb-2 bg-light border-bottom">
      <input type="search" class="form-control tags" autocomplete="false" placeholder="Type to filter...">
    </form>
    <ul id="tags-dropdown-menu" class="list-unstyled mb-0 d-none">
        @foreach ($tags as $tag)
        <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
            <span class="d-inline-block bg-primary rounded-circle p-1"></span>
            {{ $tag->name }}
          </a></li>
        @endforeach
    </ul>
  </div>

  <script>
        document.addEventListener('click', function(e){
            if(e.target.classList.contains('tags')){
                document.getElementById('tags-dropdown-menu').className = 'd-block'
            }else{
                document.getElementById('tags-dropdown-menu').className = 'd-none'
            }
        })
  </script>
