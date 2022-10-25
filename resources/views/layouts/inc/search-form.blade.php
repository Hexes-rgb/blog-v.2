<div class="input-group">
    @if(!empty($text))
    <input type="text" autocomplete="off" value="{{ $text }}" name="text" class="form-control rounded" aria-label="Search"
        aria-describedby="search-addon">
    @else
    <input type="text" autocomplete="off" name="text" class="form-control rounded" aria-label="Search"
            aria-describedby="search-addon">
    @endif
    <button type="submit" class="btn btn-outline-primary">Apply</button>
    <select class="ms-3 form-select text-grey overflow-hidden rounded"  name="sort">
        <option class="d-inline ms-3" value="DESC">DESC</option>
        <option class="d-inline ms-3" value="ASC">ASC</option>
    </select>
</div>
