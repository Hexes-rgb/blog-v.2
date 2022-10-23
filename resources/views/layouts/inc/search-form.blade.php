<div class="input-group">
    @if(!empty($text))
    <input type="text" autocomplete="off" value="{{ $text }}" name="text" class="form-control rounded" aria-label="Search"
        aria-describedby="search-addon">
    @else
    <input type="text" autocomplete="off" name="text" class="form-control rounded" aria-label="Search"
            aria-describedby="search-addon">
    @endif
    <button type="submit" class="btn btn-outline-primary">Apply</button>
    <select class="form-select text-grey border-white overflow-hidden" size="2" aria-label="size 2 select example" name="sort">
        <option class="d-inline ms-3" value="DESC">DESC</option>
        <option class="d-inline ms-3" value="ASC">ASC</option>
    </select>
</div>
