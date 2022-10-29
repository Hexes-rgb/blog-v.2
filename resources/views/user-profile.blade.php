@extends('layouts.app')

@section('title-block')
    User Profile
@endsection

@section('content')
    @auth
        @if(Auth::id() != $user->id)
            <div class="container p-4 mt-5 border rounded overflow-hidden shadow-sm">
                <div class="row">
                    @include('layouts/inc/user-profile-sidebar')
                    <div class="col">
                        <img src="{{ url('public/appImages/avatar.png') }}" class="float-end" height="200px" width="200px">
                    </div>
                    <div class="text-end">
                        @if (Auth::user()->subscriptions->where('id', $user->id)->isEmpty())
                        <form method="POST" action="{{ route('subscription.store', $user->id) }}" class="text-end">
                            @csrf
                            <input type="hidden" name="author_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-outline-primary">Subscribe</button>
                        </form>
                        @elseif(Auth::user()->subscriptions->find($user->id)->subscriptions->deleted_at != null)
                        <form method="POST" action="{{ route('subscription.restore', $user->id) }}" class="text-end">
                            @csrf
                            <input type="hidden" name="author_id" value="{{ $user->id}}">
                            <button type="submit" class="btn btn-outline-success">Restore subscription</button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('subscription.delete', $user->id) }}" class="text-end">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="author_id" value="{{ $user->id}}">
                            <button type="submit" class="btn btn-outline-danger">Delete subscription</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="container p-4 mt-5 border rounded overflow-hidden shadow-sm">
                <div class="row">
                    @include('layouts/inc/user-profile-sidebar')
                    @include('layouts.inc.subscriptions')
                    <div class="col">
                        <img src="{{ url('public/appImages/avatar.png') }}" class="float-end" height="200px" width="200px">
                    </div>
                    <div class="text-end">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="link-danger me-5">Log out</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth
    @guest
        <div class="container p-4 mt-5 border rounded overflow-hidden shadow-sm">
            <div class="row">
                @include('layouts/inc/user-profile-sidebar')
                <div class="col">
                    <img src="{{ url('public/appImages/avatar.png') }}" class="float-end" height="200px" width="200px">
                </div>
                {{-- <div class="text-end">
                    @if (Auth::user()->subscriptions->where('id', $user->id)->isEmpty())
                        <a href="{{ route('subscription.create', $user->id) }}" class="link-primary">
                            Subscribe
                        </a>
                    @elseif(Auth::user()->subscriptions->find($user->id)->subscriptions->deleted_at != null)
                        <a href="{{ route('subscription.restore', $user->id) }}" class="link-primary">
                            Subscribe
                        </a>
                    @else
                        <a href="{{ route('subscription.delete', $user->id) }}" class="link-danger">
                            Unsubscribe
                        </a>
                    @endif
                </div> --}}
            </div>
        </div>
    @endguest
@endsection
