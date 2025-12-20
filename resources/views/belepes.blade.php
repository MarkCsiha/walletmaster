@extends('layout')
@section('content')
<main class="container pb-2">
    <div class="row">
        <div class="col-md-9">
            <h1 class="text-center py-3">Regisztráció</h1>
            <div class="card w-75 mx-auto">
                <form class="card-body" action="/regisztracio" method="post">
                    @csrf
                    <label class="form-label" for="nev">Név:</label>
                    <input class="form-control @error('nev') is-invalid @enderror" type="text" name="nev" id="nev" value="{{old('nev')}}">
                    @error('nev')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="email">E-mail:</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{old('email')}}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label class="form-label mt-3" for="password">Jelszó:</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password">
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    
                    <label class="form-label mt-3" for="password_confirmation">Jelszó mégegyszer:</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation">
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <button class="btn btn-primary mt-3" type="submit">Regisztrál</button>
                </form>
            </div>
        </div>
@endsection