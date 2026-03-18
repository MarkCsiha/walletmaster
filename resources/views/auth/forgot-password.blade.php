@extends('layout')

@push('forgot-css')
    <link rel="stylesheet" href="{{ asset('css/forgotpass.css') }}">
@endpush

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Új jelszó igénylése</h2>
        <div class="container">
            @if (session('success'))
                <p class="text-success text-center">{{ session('success') }}</p>
            @else
                <p class="text-danger text-center">{{ session('success') }}</p>
            @endif
        </div>
        <form action="/forgot-password" method="post">
            @csrf
            <hr class="w-50 mx-auto">

            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Új jelszó igénylése</h4>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email címe:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="btn">
                        <button type="submit" class="btn btn-primary btn-lg" name="mentes" id="mentes"
                            value="mentes">Új jelszó igénylése
                        </button>
                    </div>
                    <div class="container py-5">
                        <h2 class="mb-4">Új jelszó igénylése</h2>
                        <div class="container">
                            @if (session('success'))
                                <p class="text-success text-center">{{ session('success') }}</p>
                            @else
                                <p class="text-danger text-center">{{ session('unsuccessful') }}</p>
                        </div>
                        @endif
                        <form action="/forgot-password" method="post">
                            @csrf
                            <hr class="w-50 mx-auto">

                    </div>
                </div>
        </form>
    </div>
@endsection
