@extends('layout')

@push("belepes-css")
    <link rel="stylesheet" href="{{asset('css/belepes.css')}}">
@endpush

@section('content')
    <main class="container pb-5">
        <div class="row justify-content-center pb-3">
            <div class="col-md-9 mb-3">
<<<<<<< Updated upstream
                @if(session('kudarc'))
                    <p class="text-danger text-center">{{session('kudarc')}}</p>
=======
                @if(session('unsuccessful'))
                    <p class="mt-2 text-danger text-center" style="color: tomato">{{session('unsuccessful')}}</p>
>>>>>>> Stashed changes
                @endif
                <h1 class="text-center py-3">Belépés</h1>
                <div class="card w-75 mx-auto">
                    <form class="card-body" action="/login" method="post">
                    @csrf
                        <label class="form-label mt-3" for="email">E-mail:</label>
                        <input class="form-control rounded-pill" @error('email') is-invalid @enderror type="text" name="email" id="email">

                        <label class="form-label mt-3" for="password">Jelszó:</label>
                        <input class="form-control rounded-pill" @error('password') is-invalid @enderror type="password" name="password" id="password">

                        <button class="btn btn-primary mt-3" type="submit">Belépés</button>

                    </form>
<<<<<<< Updated upstream
=======
                    <a href="forgot-password">Elfelejtette jelszavát?</a>

                <div class="col-md-3">
                    <a href="{{ route('redirect.google') }}">Bejelentkezés Google-el</a>
>>>>>>> Stashed changes
                </div>
            </div>
        </div>
    </main>
@endsection
