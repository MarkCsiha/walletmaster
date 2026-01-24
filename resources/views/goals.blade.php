@extends('layout')

@push('goals-css')
    <link rel="stylesheet" href="{{ asset('css/goals.css') }}">
@endpush

@section('content')
<main class="container pb-2">
    <h1 class="bi bi-bullseye p-3">Céljaim</h1>

    <div class="container">
        <div id="outerpanel">

            <div class="row align-items-start">
                <div class="col-sm">
                    <button type="button" class="goal-tab" data-target="goalsBody">
                        Célok
                    </button>

                    <div id="goalsBody" class="dbody-source d-none">
                        @foreach ($result as $cel)
                            <div class="card w-75" id="goalcard">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title">{{ $cel->cel_nev }}</h5>
                                        </div>
                                        <div class="col">
                                            <p class="card-text">{{ $cel->hatarido }}</p>
                                        </div>
                                    </div>

                                    <div class="w3-border">
                                        <div class="w3-green rounded-pill" style="height:24px;width:(({{$cel->osszeg}} / {{$cel->cel_osszeg}}) * 100)%"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <a class="btn btn-primary">Módosítás</a>
                                        </div>
                                        <div class="col">
                                            <a href="">
                                                @if ($cel->statusz == "aktív")
                                                    {{ $cel->statusz }}
                                                @elseif ($cel->statusz == "kész")
                                                    {{ $cel->statusz }} ✅
                                                @else
                                                    {{ $cel->statusz }} ❎
                                                @endif
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-sm text-end">
                    <button type="button" class="goal-tab" data-target="addBody">
                        Hozzáadás
                    </button>

                    <div id="addBody" class="dbody-source d-none">
                        <div class="card">
                            <div class="card-body">
                                <form action="/goals" method="post">
                                    @csrf

                                    <label class="form-label" for="nev">Cél neve:</label>
                                    <input class="form-control rounded-pill" type="text" name="nev" id="nev">
                                    @error('nev')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label class="form-label" for="cel_osszeg">Célösszeg:</label>
                                    <input class="form-control rounded-pill" type="number" name="cel_osszeg" id="cel_osszeg">
                                    @error('cel_osszeg')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label class="form-label" for="osszeg">Most mennyit tud rászánni:</label>
                                    <input class="form-control rounded-pill" type="number" name="osszeg" id="osszeg">
                                    @error('osszeg')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label class="form-label" for="hatarido">Határidő:</label>
                                    <input class="form-control rounded-pill" type="date" name="hatarido" id="hatarido">
                                    @error('hatarido')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <button class="btn btn-dark mt-4" type="submit">Létrehozás</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div id="centerPanel" class="center-panel d-none">
                        <div id="centerPanelInner" class="mt-3">
                            <div class="card">
                                <div class="card-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{asset('js/goals.js')}}"></script>
@endsection


{{--A módosítás gombra kattintva a megjeleneik egy új oldal ami a hozzáadáshoz hasonlít.
    Azzal bővül ki, hogy a statuszt lehet majd módosítani.
    Olyankor mentés után visszadob a goals-ra és módosítja az adatokat a módosítás dátuma megvátozik a mostani időre
    A csikot meg kell még csinálni.

--}}
