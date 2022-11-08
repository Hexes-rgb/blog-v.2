@extends('layouts.app')

@section('title-block')
    Main page
@endsection

@section('content')
    <section class="w-100 p-4 pb-1 d-flex justify-content-center align-items-center flex-column">
        <div>
            @include('layouts.inc.search-form')
        </div>
        @include('layouts.inc.main-content')
    </section>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />

<script>
    $(document).ready(function(){
        let timeout
        function fetch_data(page, sort, query){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/search?page="+page+"&sort="+sort+"&query="+query,
                method:'get',
                success:function(response)
                {
                    $('#content').replaceWith(response.data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                let query = $('#search').val();

                let page = $('#hidden_page').val();
                let sort = $('#sort').val();
                fetch_data(page, sort, query);
            }, 400);
        });

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);

            let query = $('#search').val();
            let sort = $('#sort').val();
            $('li').removeClass('active');
                $(this).parent().addClass('active');
            fetch_data(page, sort, query);
        });

        $(document).on('change','#sort', function(event){
            let sort = $(this).val();

            let query = $('#search').val();
            let page = $('#hidden_page').val();
            fetch_data(page, sort, query);
        })
    });
</script>
@endsection
