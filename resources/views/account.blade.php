@extends('layout')
@push('account-css')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endpush
@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success text-success text-center w-50 py-1 mx-auto mt-3">
                <i class="bi bi-check-circle-fill">
                    {{ session('success') }}
                </i>
            </div>
        @elseif (session('unchanged'))
            <div class="alert alert-primary text-primary text-center w-50 py-1 mx-auto mt-3">
                <i class="bi bi-dash-circle-fill">
                    {{ session('unchanged') }}
                </i>
            </div>
        @elseif (session('unsuccessful'))
            <div class="alert alert-danger text-danger text-center w-50 py-1 mx-auto mt-3">
                <i class="bi bi-exclamation-triangle-fill">
                    {{ session('unsuccessful') }}
                </i>
            </div>
        @endif
        <h2 class="mb-4">Felhasználói beállítások</h2>
        <div class="container">
            <form action="/account" method="post">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>Személyes adatok</h4>
                        <div class="mb-3">
                            <label for="firstName" class="form-label">Vezetéknév: </label>
                            <input type="text" class="form-control rounded-pill" id="firstName" name="firstName"
                                value="{{ Auth::user()->vez_nev }}">
                            @error('firstName')
                                <p style="color: #FDEBE7">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Keresztnév: </label>
                            <input type="text" class="form-control rounded-pill" id="lastName" name="lastName"
                                value="{{ Auth::user()->ker_nev }}">
                            @error('lastName')
                                <p style="color: #FDEBE7">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email cím: </label>
                            <input type="email" class="form-control rounded-pill" id="email" name="email"
                                value="{{ Auth::user()->email }}">
                            @error('email')
                                <p style="color: #FDEBE7">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Felhasználónév: </label>
                            <input type="text" class="form-control rounded-pill" id="username" name="username"
                                value="{{ Auth::user()->felhasznalonev }}">
                            @error('username')
                                <p style="color: #FDEBE7">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefonszám: </label>
                            <input type="tel" class="form-control rounded-pill" id="phone" name="phone"
                                value="{{ Auth::user()->telszam }}">
                        </div>

                        <button class="btn btn-primary animationBtn rounded-pill" type="submit" name="mentes" value="mentes">Változtatások mentése</button>
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
                            <input type="password" class="form-control @error('currentpassword') is-invalid @enderror rounded-pill"
                                id="currentpassword" name="currentpassword">
                            @error('currentpassword')
                                <p style="color: #FDEBE7">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newpassword" class="form-label">Új jelszó: </label>
                            <input type="password" class="form-control @error('newpassword') is-invalid @enderror rounded-pill"
                                id="newpassword" name="newpassword">
                            @error('newpassword')
                                <p style="color: #FDEBE7">{{ $message }}</p>
                            @enderror
                            <i class="fa-solid fa-eye" id="show-password"></i>
                        </div>
                        <div class="mb-3">
                            <label for="newpassword_confirmation" class="form-label">Új jelszó megerősítése: </label>
                            <input type="password"
                                class="form-control @error('newpassword_confirmation') is-invalid @enderror rounded-pill"
                                name="newpassword_confirmation" id="newpassword_confirmation">
                            @error('newpassword_confirmation')
                                <p style="color: #FDEBE7">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary animationBtn rounded-pill" name="mentes" value="mentes">Jelszó változtatás mentése</button>
                    </div>
                </div>
            </form>

            <hr class="w-50 mx-auto">

            <div class="row-mb-4">
                <div class="col-mb-6">
                    <form action="logout" method="post">
                        <button type="button" class="btn btn-primary mb-2 animationBtn rounded-pill">
                            <a href="/logout" id="animationA">Kijelentkezés</a>
                        </button>
                    </form>
                </div>
                <div class="col-mb-6">
                    <form action="{{ route('user.destroy', Auth::id()) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger animationBtnDel rounded-pill"
                            onclick="return confirm('Biztosan törli felhasználói fiókját?')">Felhasználói fiók törlése</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
