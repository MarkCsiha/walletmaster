@extends('layout')

@push('reset-css')
    <link rel="stylesheet" href="{{ asset('css/resetpass.css') }}">
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success text-success text-center w-50 py-1 mx-auto mt-3">
            <i class="bi bi-check-circle-fill">
                {{ session('success') }}
            </i>
        </div>
    @elseif (session('unsuccessful'))
        <div class="alert alert-danger text-danger text-center w-50 py-1 mx-auto mt-3">
            <i class="bi bi-exclamation-triangle-fill">
                {{ session('unsuccessful') }}
            </i>
        </div>
    @endif

    <main class="container py-5 mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-body p-4 p-md-5 text-center">

                        <h2 class="text-white mb-4">Jelszó megváltoztatása</h2>

                        <form method="POST" action="/reset-password">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div>
                                <label for="email" hidden>Email</label>
                                <input id="email" type="email" name="email"
                                    value="{{ old('email', $email ?? request('email')) }}" required autofocus hidden>
                                @error('email')
                                    <div>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-2">
                                <label for="password" class="text-white">Új jelszó:</label>
                                <input id="password" type="password" name="password"
                                    class="form-control rounded-pill mt-2" required>
                                @error('password')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label for="password_confirmation" class="text-white">Jelszó újra:</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    class="form-control rounded-pill mt-2" required>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary animationBtn rounded-pill">
                                    Jelszó megváltoztatása
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
