@extends('layout')

@push('forgot-css')
    <link rel="stylesheet" href="{{ asset('css/forgotpass.css') }}">
@endpush

@section('content')
    <div class="container py-5">
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
        <h2 class="mb-4">Új jelszó igénylése</h2>
        <form action="/forgot-password" method="post">
            @csrf
            <hr class="w-50 mx-auto">

            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Új jelszó igénylése</h4>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email címe:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror rounded-pill"
                            id="email" name="email">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="btn">
                        <button type="submit" class="btn btn-primary btn-lg animationBtn" name="mentes" id="mentes"
                            value="mentes">Új jelszó igénylése
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
