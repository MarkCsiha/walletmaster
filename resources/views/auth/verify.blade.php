@extends('layout')
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
