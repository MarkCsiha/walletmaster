@extends('layout')

@push("regisztracio-css")
    <link rel="stylesheet" href="{{asset("css/regisztracio.css")}}">
@endpush

@section('content')
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('success'))
                    <p class="text text-success text-center">{{session("success")}}</p>
            @endif
        </div>
            <h1 class="text-center py-3">Regisztráció</h1>
            <div class="card w-75 mx-auto mb-3">
                <form class="card-body" action="/registration" method="post">
                    @csrf
                    <label class="form-label" for="firstName">Vezetéknév: </label>
                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old("firstName") }}">
                    @error('firstName')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label" for="lastName">Keresztnév:</label>
                    <input class="form-control @error('lastName') is-invalid @enderror" type="text" name="lastName" id="lastName" value="{{old('lastName')}}">
                    @error('lastName')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label" for="username">Felhasználónév: </label>
                    <input type="text" class="form-control @error('surname') is-invalid @enderror" name="username" value="{{ old("username") }}">
                    @error('username')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="email">Email cím:</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{old('email')}}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="phone">Telefonszám:</label>
                    <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" value="{{old('phone')}}">
                    @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="password" {{--id="password"--}}>Jelszó:</label>
                    <input onkeyup="check()" class="form-control rounded-pill @error('password') is-invalid @enderror" type="password" name="password" id="password">
                    <ul >
                        <li id="length">A jelszónak legalább 8 karakternek kell lennie!</li>
                        <li id="alph">A jelszónak betűt kell tartalmaznia!</li>
                        <li id="num">A jelszónak legalább egy számot kell tartalmaznia!</li>
                        <li id="lucase">A jelszónak kis- és nagybetűt is kell tartalmaznia!</li>
                        <li id="spec">A jelszónak legalább egy speciális karaktert kell tartalmaznia!</li>

                    </ul>
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="password_confirmation">Jelszó újra:</label>
                    <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation">
                    @error('password_confirmation')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <button class="btn btn-primary mt-3" type="submit">Regisztrál</button>
                    <p class="mt-2"><a href="/login">Van már fiókja?</a></p>
                </form>

                 <div class="col-md-3">
                    <button><a href="{{ route('redirect.google') }}">Regisztráció Google fiókkal</a></button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset("js/registration.js")}}"></script>
</main>
@endsection

{{--
    regisztrációnál sugó szöveg,
--}}
