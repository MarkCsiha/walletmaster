@extends('layout')

@push('account-css')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endpush

@section('content')
    <main class="container py-5">
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

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <h2 class="text-white mb-4 text-center">Felhasználói beállítások</h2>
                <div class="card mb-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="/account" method="post">
                            @csrf

                            <h4 class="text-white mb-4 text-center">Személyes adatok</h4>

                            <div class="mb-3">
                                <label for="firstName" class="form-label text-white">Vezetéknév:</label>
                                <input type="text" class="form-control rounded-pill" id="firstName" name="firstName"
                                    value="{{ Auth::user()->vez_nev }}">
                                @error('firstName')
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="lastName" class="form-label text-white">Keresztnév:</label>
                                <input type="text" class="form-control rounded-pill" id="lastName" name="lastName"
                                    value="{{ Auth::user()->ker_nev }}">
                                @error('lastName')
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label text-white">Email cím:</label>
                                <input type="email" class="form-control rounded-pill" id="email" name="email"
                                    value="{{ Auth::user()->email }}">
                                @error('email')
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label text-white">Felhasználónév:</label>
                                <input type="text" class="form-control rounded-pill" id="username" name="username"
                                    value="{{ Auth::user()->felhasznalonev }}">
                                @error('username')
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label text-white">Telefonszám:</label>
                                <input type="tel" class="form-control rounded-pill" id="phone" name="phone"
                                    value="{{ Auth::user()->telszam }}">
                            </div>

                            <button class="btn btn-primary animationBtn rounded-pill mt-3" type="submit" name="mentes"
                                value="mentes">
                                Változtatások mentése
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="/account" method="post">
                            @csrf

                            <h4 class="text-white mb-4 text-center">Jelszó megváltoztatása</h4>

                            <div class="mb-3">
                                <label for="currentpassword" class="form-label text-white">Jelenlegi jelszó:</label>
                                <input type="password"
                                    class="form-control @error('currentpassword') is-invalid @enderror rounded-pill"
                                    id="currentpassword" name="currentpassword">
                                @error('currentpassword')
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="newpassword" class="form-label text-white">Új jelszó:</label>
                                <input type="password"
                                    class="form-control @error('newpassword') is-invalid @enderror rounded-pill"
                                    id="newpassword" name="newpassword">
                                @error('newpassword')
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                                <i class="fa-solid fa-eye text-white mt-2" id="show-password"></i>
                            </div>

                            <div class="mb-3">
                                <label for="newpassword_confirmation" class="form-label text-white">Új jelszó
                                    megerősítése:</label>
                                <input type="password"
                                    class="form-control @error('newpassword_confirmation') is-invalid @enderror rounded-pill"
                                    name="newpassword_confirmation" id="newpassword_confirmation">
                                @error('newpassword_confirmation')
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary animationBtn rounded-pill mt-3" name="mentes"
                                value="mentes">
                                Jelszó változtatás mentése
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-4 p-md-5 text-center">
                        <h4 class="text-white mb-4 text-center">Fiókkezelés</h4>

                        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                            <form action="/logout" method="post" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-primary animationBtn rounded-pill">
                                    Kijelentkezés
                                </button>
                            </form>

                            <form action="{{ route('user.destroy', Auth::id()) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger animationBtnDel rounded-pill"
                                    onclick="return confirm('Biztosan törli felhasználói fiókját?')">
                                    Felhasználói fiók törlése
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
