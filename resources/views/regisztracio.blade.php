@extends('layout')

@push("regisztracio-css")
    <link rel="stylesheet" href="{{asset("css/regisztracio.css")}}">
@endpush

@section('content')
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('siker'))
                    <p class="text text-success text-center">{{session("siker")}}</p>
            @endif
            <h1 class="text-center py-3">Regisztráció</h1>
            <div class="card w-75 mx-auto mb-3">
                <form class="card-body" action="/regisztracio" method="post">
                    @csrf
                    <label class="form-label" for="vez_nev">Vezetéknév: </label>
                    <input type="text" class="form-control rounded-pill" @error('vez_nev') is-invalid @enderror" name="vez_nev" value="{{ old("vez_nev") }}">
                    @error('vez_nev')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label" for="ker_nev">Keresztnév:</label>
                    <input class="form-control rounded-pill" @error('ker_nev') is-invalid @enderror" type="text" name="ker_nev" id="ker_nev" value="{{old('ker_nev')}}">
                    @error('ker_nev')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label" for="felhasznalonev">Felhasználónev: </label>
                    <input type="text" class="form-control rounded-pill" @error('felhasznalonev') is-invalid @enderror" name="felhasznalonev" value="{{ old("felhasznalonev") }}">
                    @error('felhasznalonev')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="email">Email cím:</label>
                    <input class="form-control rounded-pill" @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{old('email')}}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="telszam">Telefonszam:</label>
                    <input class="form-control rounded-pill" @error('telszam') is-invalid @enderror" type="text" name="telszam" id="telszam" value="{{old('telszam')}}">
                    @error('telszam')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="password">Jelszó:</label>
                    <input class="form-control rounded-pill" @error('password') is-invalid @enderror" type="password" name="password" id="password">
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="password_confirmation">Jelszó mégegyszer:</label>
                    <input class="form-control rounded-pill" @error('password') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation">
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <button class="btn btn-primary mt-3" type="submit">Regisztrál</button>
                    <p class="mt-2"><a href="/belepes">Van már fiókja?</a></p>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
