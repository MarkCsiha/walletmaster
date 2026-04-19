@extends('layout')

@push('forgot-css')
    <link rel="stylesheet" href="{{ asset('css/forgotpass.css') }}">
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

                        <h2 class="text-white mb-4">Új jelszó igénylése</h2>

                        <form action="/forgot-password" method="post">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label text-white">Email címe:</label>
                                <input type="text"
                                    class="form-control @error('email') is-invalid @enderror rounded-pill mt-2"
                                    id="email" name="email">
                                @error('email')
                                    <p style="color: #FDEBE7" class="mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary animationBtn rounded-pill" name="mentes"
                                    id="mentes" value="mentes">
                                    Új jelszó igénylése
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
