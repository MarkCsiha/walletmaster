@extends('layout')

@push("belepes-css")
    <link rel="stylesheet" href="{{asset('css/belepes.css')}}">
@endpush

@section('content')
    <main class="container pb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 mb-3">
                @if(session('kudarc'))
                    <p class="text-danger text-center">{{session('kudarc')}}</p>
                @endif
                <h1 class="text-center py-3">Belépés</h1>
                <div class="card w-75 mx-auto">
                    <form class="card-body" action="/login" method="post">
                    @csrf
                        <label class="form-label mt-3" for="email">E-mail:</label>
                        <input class="form-control rounded-pill" @error('email') is-invalid @enderror type="text" name="email" id="email">

                        <label class="form-label mt-3" for="password">Jelszó:</label>
                        <input class="form-control rounded-pill" @error('password') is-invalid @enderror type="password" name="password" id="password">

                        <button class="btn btn-primary mt-3" type="submit">Belépés</button>

                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
