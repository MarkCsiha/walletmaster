@extends('layout')

@push("verify-css")
    <link rel="stylesheet" href="{{asset("css/verify.css")}}">
@endpush

@section('content')
{{-- https://github.com/ERaufi/LaravelProjects/blob/main/routes/web.php --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            <p>Új hitelesítő e-mail elküldve!</p>
                        </div>
                    @endif
                    {{-- Kéri a felhasználót, hogy hagyja jóvá az email címet --}}
                    <p>Kérjük, hagyja jóvá a regisztrációt az e-mail címére kapott linkre kattintva!</p>
                    <p>Ha nem kapta meg a hitelesítő levelet: </p>
                    {{-- Ha az újraküldés linkre kattint a felhasználó akkor új emailt kap --}}
                    <div class="col-md-3">
                            <p>Rossz email címet adott meg?</p>
                            <form class="d-inline" method="POST" action="/auth/verify">
                                @csrf
                                <input type="hidden" name="action" value="update_email">

                                <label class="form-label mt-3" for="email">Új email cím:</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{old('email')}}">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Email cím változtatása</button>.
                            </form>
                        </div>
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Kattintson ide az új link kéréséhez!</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
