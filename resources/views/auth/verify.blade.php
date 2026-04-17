@extends('layout')

@push('verify-css')
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endpush

@section('content')
    {{-- https://github.com/ERaufi/LaravelProjects/blob/main/routes/web.php --}}
    <main class="container pt-3 pb-5">
        <section>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
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
                            {{-- Kéri a felhasználót, hogy hagyja jóvá az email címet --}}
                            <p>Kérjük, hagyja jóvá a regisztrációt az e-mail címére kapott linkre kattintva!</p>
                            <p>Ha nem kapta meg a hitelesítő levelet: </p>
                            <div class="col-md-3">
                                <p>Rossz email címet adott meg?</p>
                                <form class="d-inline" method="POST" action="/auth/verify">
                                    @csrf
                                    <input type="hidden" name="action" value="update_email" class="rounded-pill">

                                    <label class="form-label mt-3" for="email">Új email cím:</label>
                                    <input class="form-control rounded-pill @error('email') is-invalid @enderror" type="text"
                                        name="email" id="email" value="{{ old('email') }}">
                                    @error('email')
                                        <p style="color: #FDEBE7">{{ $message }}</p>
                                    @enderror
                                    <button type="submit" class="btn btn-primary animationBtn rounded-pill mt-3">Email cím
                                        változtatása</button>.
                                </form>
                            </div>
                            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary animationBtn rounded-pill">Kattintson ide az
                                    új
                                    link kéréséhez!</button>.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
