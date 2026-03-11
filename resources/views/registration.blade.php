@extends('layout')

@push("regisztracio-css")
    <link rel="stylesheet" href="{{asset("css/regisztracio.css")}}">
@endpush

@section('content')
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('siker'))
                    <p class="text text-success text-center">{{session("siker")}}</p>
            @endif
            <h1 class="text-center py-3">Regisztráció</h1>
            <div class="card w-75 mx-auto mb-3">
                <form class="card-body" action="/registration" method="post">
                    @csrf
<<<<<<< Updated upstream
                    <label class="form-label mt-3" for="firstName" id="firstName">Vezetéknév: </label>
=======
                    <label class="form-label" for="firstName"><span style="color: tomato">*</span>Vezetéknév: </label>
>>>>>>> Stashed changes
                    <input type="text" class="form-control rounded-pill @error('firstName') is-invalid @enderror" name="firstName" value="{{ old("firstName") }}">
                    @error('firstName')
                        <p style="color: tomato">{{ $message }}</p>
                    @enderror

<<<<<<< Updated upstream
                    <label class="form-label mt-3" for="lastName" id="lastName">Keresztnév:</label>
=======
                    <label class="form-label" for="lastName"><span style="color: tomato">*</span>Keresztnév:</label>
>>>>>>> Stashed changes
                    <input class="form-control rounded-pill @error('lastName') is-invalid @enderror" type="text" name="lastName" id="lastName" value="{{old('lastName')}}">
                    @error('lastName')
                        <p style="color: tomato">{{ $message }}</p>
                    @enderror

<<<<<<< Updated upstream
                    <label class="form-label mt-3" for="username" id="username">Felhasználónev: </label>
                    <input type="text" class="form-control rounded-pill @error('username') is-invalid @enderror" name="username" value="{{ old("username") }}">
=======
                    <label class="form-label" for="username"><span style="color: tomato">*</span>Felhasználónév: </label>
                    <input type="text" class="form-control rounded-pill @error('surname') is-invalid @enderror" name="username" value="{{ old("username") }}">
>>>>>>> Stashed changes
                    @error('username')
                        <p style="color: tomato">{{ $message }}</p>
                    @enderror

<<<<<<< Updated upstream
                    <label class="form-label mt-3" for="email" id="email">Email cím:</label>
=======
                    <label class="form-label mt-3" for="email"><span style="color: tomato">*</span>Email cím:</label>
>>>>>>> Stashed changes
                    <input class="form-control rounded-pill @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{old('email')}}">
                    @error('email')
                        <p style="color: tomato">{{ $message }}</p>
                    @enderror

<<<<<<< Updated upstream
                    <label class="form-label mt-3" for="telszam" id="telszam">Telefonszam:</label>
=======
                    <label class="form-label mt-3" for="phone">Telefonszám:</label>
>>>>>>> Stashed changes
                    <input class="form-control rounded-pill @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" value="{{old('phone')}}">
                    @error('phone')
                        <p style="color: tomato">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="password"><span style="color: tomato">*</span>Jelszó:</label>
                    <input onkeyup="check()" class="form-control rounded-pill @error('password') is-invalid @enderror" type="password" name="password" id="password">
                    <ul >
                        <li id="length">A jelszónak legalább 8 karakternek kell lennie!</li>
                        <li id="alph">A jelszónak betűt kell tartalmaznia!</li>
                        <li id="num">A jelszónak legalább egy számot kell tartalmaznia!</li>
                        <li id="lucase">A jelszónak kis- és nagybetűt is kell tartalmaznia!</li>
                        <li id="spec">A jelszónak legalább egy speciális karaktert kell tartalmaznia!</li>

                    </ul>
                    @error('password')
                        <p style="color: tomato">{{ $message }}</p>
                    @enderror

<<<<<<< Updated upstream
                    <label class="form-label mt-3" for="password_confirmation" id="password_confirmation">Jelszó mégegyszer:</label>
                    <input class="form-control rounded-pill @error('password') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation">
=======
                    <label class="form-label mt-3" for="password_confirmation"><span style="color: tomato">*</span>Jelszó újra:</label>
                    <input class="form-control rounded-pill @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation">
>>>>>>> Stashed changes
                    @error('password_confirmation')
                        <p style="color: tomato">{{ $message }}</p>
                    @enderror

                    <button class="btn btn-primary mt-3" type="submit">Regisztrálok</button>
                    <p class="mt-2"><a href="/login">Van már fiókja?</a></p>
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset("js/registration.js")}}"></script>
</main>
@endsection

{{--
    regisztrációnál sugó szöveg,
--}}
