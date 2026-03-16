@extends('layout')

@push("belepes-css")
    <link rel="stylesheet" href="{{asset('css/belepes.css')}}">
@endpush

@section('content')
    <main class="container pb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 mb-3">
                @if(session('unsuccessful'))
                    <p class="text-danger text-center">{{session('unsuccessful')}}</p>
                @endif
            </div>
                <h1 class="text-center py-3">Belépés</h1>
                <div class="card w-75 mx-auto">
                    <form class="card-body" action="/twofactor" method="post">
                    @csrf
                        <label class="form-label mt-3" for="twoFactorCode">Emailben kapott 6 számjegyű kód:</label>
                        <input class="form-control @error('twoFactorCode') is-invalid @enderror" type="number" name="twoFactorCode" id="twoFactorCode">

                        <button class="btn btn-primary mt-3" type="submit">Belépés</button>
                    </form>
                </div>
                {{-- <div class="col-md-3">
                    <button><a href="{{ route('redirect.google') }}">Bejelentkezés Google-el</a></button>
                </div> --}}
        </div>
    </main>
@endsection
