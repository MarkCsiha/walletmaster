{{-- @extends('layout')
@section('content')
    <main class="container pb-2">
        <h1 class="text-center py-3">Fiókbeállítások</h1>
            <h2 class="text-center py-3">{{ Auth::user()->vez_nev.' '.Auth::user()->ker_nev }} </h2>

            <p class="text-center">
                <a href="/kijelentkezes" class="text-decoration-none">Kijelentkezés</a>
            </p>
    </main>
@endsection --}}


@extends('layout')
@push('account-css')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endpush
@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Felhasználói beállítások</h2>
        <div class="container">
            @if (session('success'))
                <p class="text-success text-center">{{ session('success') }}</p>
            @else
                <p class="text-danger text-center">{{ session('unsuccessful') }}</p>
        </div>
        @endif
        <form action="/account" method="post">
            @csrf
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Személyes adatok</h4>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Vezetéknév: </label>
                        <input type="text" class="form-control" id="firstName" name="firstName"
                            value="{{ Auth::user()->vez_nev }}">
                        @error('firstName')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Keresztnév: </label>
                        <input type="text" class="form-control" id="lastName" name="lastName"
                            value="{{ Auth::user()->ker_nev }}">
                        @error('lastName')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email cím: </label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', Auth::user()->email) }}">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Felhasználónév: </label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ Auth::user()->felhasznalonev }}">
                        @error('username')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefonszám: </label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            value="{{ Auth::user()->telszam }}">
                    </div>

                    <div class="mb-3">
                        <input type="checkbox" name="twoFactorCheck">
                        <label>Két faktoros hitelesítés bekapcsolása</label>
                    </div>

                    <button class="btn btn-primary" type="submit" name="mentes" value="mentes">Mentés</button>
                </div>
            </div>
        </form>

        <hr class="w-50 mx-auto">

        <form action="/account" method="post">
            @csrf
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Jelszó megváltoztatása</h4>
                    <div class="mb-3">
                        <label for="currentpassword" class="form-label">Jelenlegi jelszó: </label>
                        <input type="password" class="form-control @error('currentpassword') is-invalid @enderror"
                            id="currentpassword" name="currentpassword">
                        @error('currentpassword')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="newpassword" class="form-label">Új jelszó: </label>
                        <input type="password" class="form-control @error('newpassword') is-invalid @enderror"
                            id="newpassword" name="newpassword">
                        @error('newpassword')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <i class="fa-solid fa-eye" id="show-password"></i>
                    </div>
                    <div class="mb-3">
                        <label for="newpassword_confirmation" class="form-label">Új jelszó megerősítése: </label>
                        <input type="password" class="form-control @error('newpassword_confirmation') is-invalid @enderror"
                            name="newpassword_confirmation" id="newpassword_confirmation">
                        @error('newpassword_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <i class="bi bi-eye" id="show-password"></i>
                    </div>

                    <button type="submit" class="btn btn-primary" name="mentes" value="mentes">Mentés</button>
                </div>
            </div>
        </form>

        <hr class="w-50 mx-auto">

        <div class="row-mb-4">
            <div class="col-mb-6">
                <form action="" method="post">
                    <button type="button" class="btn btn-primary mb-2">
                        <a href="/logout">Kijelentkezés</a>
                    </button>
                </form>
            </div>
            {{--  https://laracasts.com/discuss/channels/laravel/laravel-confirm-delete-in-an-alert-in-my-view --}}
            <div class="col-mb-6">
                <form action="{{ route('user.destroy', Auth::id()) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Biztosan törli felhasználói fiókját?')">Törlés</button>
                </form>
            </div>
        </div>
    </div>
@endsection
