@extends('layout')

@push('belepes-css')
    <link rel="stylesheet" href="{{ asset('css/belepes.css') }}">
@endpush

@section('content')
    <main class="container pb-5">
        <div class="row justify-content-center pb-3">
            <div class="col-md-9 mb-3">
                @if(session('unsuccessful'))
                    <p class="mt-2 text-danger text-center" style="color: tomato">{{session('unsuccessful')}}</p>
                @endif
            </div>
                <h1 class="text-center py-3">Belépés</h1>
                <div class="card w-75 mx-auto">
                    <form class="card-body" action="/login" method="post">
                        @csrf
                        {{-- <label class="form-label mt-3" for="email">E-mail:</label>
                        <input class="form-control rounded-pill" @error('email') is-invalid @enderror type="text"
                            name="email" id="email"> --}}

                        <label class="form-label mt-3" for="loginData">E-mail cím vagy felhasználónév:</label>
                        <input class="form-control rounded-pill @error('loginData') is-invalid @enderror" type="text" name="loginData" id="loginData">

                        <label class="form-label mt-3" for="password">Jelszó:</label>
                        <input class="form-control rounded-pill" @error('password') is-invalid @enderror type="password"
                            name="password" id="password">
                        <div class="btn">
                            <button class="btn btn-primary mt-3" type="submit">Belépés</button>
                        </div>

                    </form>
                    <a href="forgot-password">Elfelejtette jelszavát?</a>

                    <div class="col-md-3">
                        <a href="{{ route('redirect.google') }}">Bejelentkezés Google-el</a>
                    </div>
                </div>
            </div>
    </main>
@endsection
