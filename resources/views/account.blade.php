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
                </div>
                {{-- <div class="col-md-6">
                <h4>Profile Picture</h4>
                <div class="mb-3">
                    <img src="/api/placeholder/150/150" alt="Profile Picture" class="img-thumbnail mb-2">
                    <input class="form-control" type="file" id="profilePicture">
                </div>
            </div> --}}
                {{-- <button type="button" class="btn btn-secondary btn-lg">Visszavonás</button> --}}
                <button type="submit" class="btn btn-primary btn-lg" name="mentes" value="mentes">Mentés</button>
            </div>
        </form>

        <form action="/account" method="post">
            @csrf
            {{-- <div class="row mb-4">
            <div class="col-md-6">
                <h4>Email Preferences</h4>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="newsletterCheck" checked>
                    <label class="form-check-label" for="newsletterCheck">Receive newsletter</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="promotionsCheck"> --}}
            {{-- <label class="form-check-label" for="promotionsCheck">Receive promotional emails</label>
                </div>
            </div>
            <div class="col-md-6">
                <h4>Account Settings</h4>
                <div class="mb-3">
                    <label for="language" class="form-label">Preferred Language</label>
                    <select class="form-select" id="language">
                            <option value="en">English</option>
                            <option value="es">Español</option>
                            <option value="fr">Français</option>
                            <option value="de">Deutsch</option>
                        </select>
                </div>
                <div class="mb-3">
                    <label for="timezone" class="form-label">Time Zone</label>
                    <select class="form-select" id="timezone">
                            <option value="UTC-8">Pacific Time (PT)</option>
                            <option value="UTC-5">Eastern Time (ET)</option>
                            <option value="UTC+0">Coordinated Universal Time (UTC)</option>
                            <option value="UTC+1">Central European Time (CET)</option>
                        </select>
                </div>
            </div>
        </div> --}}

            <hr class="w-50 mx-auto">

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
                </div>
                {{-- <div class="col-md-6">
                <h4>Privacy Settings</h4>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="profileVisibilityCheck" checked>
                    <label class="form-check-label" for="profileVisibilityCheck">Make profile visible to others</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="activityTrackingCheck" checked>
                    <label class="form-check-label" for="activityTrackingCheck">Allow activity tracking for personalized experience</label>
                </div>
            </div> --}}
        </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    {{-- <button type="button" class="btn btn-secondary btn-lg">Visszavonás</button> --}}
                    <button type="submit" class="btn btn-primary btn-lg" name="mentes" value="mentes">Mentés</button>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary btn-lg mb-3"><a
                            href="/logout">Kijelentkezés</a></button>
                </div>
        </form>
        {{-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            {{-- <button type="button" class="btn btn-secondary btn-lg">Visszavonás</button> --}}
        {{-- <form action="{{ route('delete.account') }}" method="post">
            {{-- <button type="submit" class="btn btn-primary btn-lg" name="accountDelete" id="accountDelete" value="accountDelete">Felhasználó fiók törlése</button>
        </form> --}}
        {{-- </div> --}}
        {{--  https://laracasts.com/discuss/channels/laravel/laravel-confirm-delete-in-an-alert-in-my-view --}}
        <form action="{{ route('user.destroy', Auth::id()) }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Biztosan törli felhasználói fiókját?')">Törlés</button>
        </form>
    </div>
@endsection
