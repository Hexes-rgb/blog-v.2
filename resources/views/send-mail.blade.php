@extends('layouts.app')

@section('title-block')
    Email
@endsection

@section('content')
    <div class="text-center d-flex justify-content-center">
        <div class="mt-3 mail-form border rounded">
            <form action="{{ route('mail.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h1 class="h3 mb-3 fw-normal">Send email</h1>
                <div class="m-1 form-floating">
                    <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                    <label for="email">Email address</label>
                </div>
                <div class="m-1 form-floating">
                    <input name="message" type="text" class="form-control" id="text" placeholder="text">
                    <label for="text">Text</label>
                </div>
                <input name="files[]" type="file" multiple>
                <button class="btn btn-lg btn-outline-primary" type="submit">Send</button>
                <p class="mt-2 mb-3 text-muted">© 2017–2022</p>
            </form>
        </div>
    </div>

{{-- <script>
    $(document).ready(function(){

        $(document).on('submit', '#mailForm', function(event){
            event.preventDefault();
            data = {
                'email': $('#email').val(),
                'message': $('#text').val()
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/mail",
                method:'post',
                data,
                success:function(response)
                {
                    alert(response.success);
                }
            })
        })


    });
</script> --}}
@endsection
