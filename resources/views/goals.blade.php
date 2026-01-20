@extends('layout')
@section('content')

@push('goals-css')
    <link rel="stylesheet" href="{{asset('css/goals.css')}}">
@endpush

<main class="container pb-2">
    <h1 class="bi bi-bullseye">Céljaim</h1>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <details>
                        <summary>Célok</summary>
                        @foreach ($result as $cel)
                            <div class="card w-75">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title">{{$cel->cel_nev}}</h5>
                                    </div>

                                    <div class="col">
                                        <p class="card-text">{{$cel->hatarido}}</p>
                                    </div>
                                </div>

                                    <p class="card-text">Ide jön a csík, kék vagy zöld színnel lesz kitöltve</p>

                                <div class="row">
                                    <div class="col">
                                        <a class="btn btn-primary">Módosítás</a>
                                    </div>

                                    <div class="col">
                                        <a href="">
                                            @if ($cel->statusz == "aktív")
                                                {{$cel->statusz}}
                                            @else
                                                @if ($cel->statusz == "kész")
                                                    {{$cel->statusz}} ✅
                                                @else
                                                    {{$cel->statusz}} ❎
                                                @endif
                                            @endif
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </details>
                </div>


                <div class="col-sm">
                    <details>
                        <summary>Cél hozzáadása</summary>
                        <div class="card">
                            <div class="card-body">
                                <form action="/goals" method="post">
                                @csrf
                                    <label class="form-label" for="nev">Cél neve:</label>
                                    <input class="form-control" type="text" name="nev" id="nev">
                                    @error('nev')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror

                                    <label class="form-label" for="cel_osszeg">Célösszeg:</label>
                                    <input class="form-control" type="number" name="cel_osszeg" id="cel_osszeg">
                                    @error('cel_osszeg')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror

                                    <label class="form-label" for="osszeg">Most mennyit tud rászánni:</label>
                                    <input class="form-control" type="number" name="osszeg" id="osszeg">
                                    @error('osszeg')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror

                                    <label class="form-label" for="hatarido">Határidő:</label>
                                    <input class="form-control" type="date" name="hatarido" id="hatarido">
                                    @error('hatarido')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror

                                    <button class="btn btn-dark mt-4" type="submit">Létrehozás</button>
                                </form>
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </main>
@endsection
