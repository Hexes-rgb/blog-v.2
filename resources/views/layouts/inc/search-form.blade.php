<div class="input-group">
    @if(!empty($text))
        <input type="text" autocomplete="off" value="{{ $text }}" name="search" id="search" class="form-control rounded" aria-label="Search"
            aria-describedby="search-addon">
    @else
        <input type="text" autocomplete="off" name="search" id="search" class="form-control rounded" aria-label="Search"
                aria-describedby="search-addon">
    @endif
    {{-- <button type="submit" class=" btn btn-outline-primary rounded">Apply</button> --}}
    <select class="ms-3 form-select text-grey overflow-hidden rounded" id="sort"  name="sort">
        <option class="d-inline ms-3" value="DESC">Descending by creation date</option>
        <option class="d-inline ms-3" value="ASC">Ascending by creation date</option>
    </select>
</div>
