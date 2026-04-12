@extends('layout')

@push('goals-css')
    <link rel="stylesheet" href="{{ asset('css/goals.css') }}">
@endpush

@section('content')
    <main class="container py-5">
        <h1 class="bi bi-bullseye p-3"> Céljaim</h1>

        <div class="container">
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
            <div id="outerpanel">

                <div class="row align-items-start justify-content-center">
                    <div class="col">
                        <button type="button" class="goal-tab animationBtn rounded-pill" onclick="change('goals')">
                            Célok
                        </button>

                        <div id="goalsBody" class="d-none">
                            @foreach ($result as $cel)
                                <div class="card mb-3" id="goalcard">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-white">{{ $cel->cel_nev }}</h5>
                                            </div>
                                            <div class="col">
                                                <p class="card-text text-white">Határidő: {{ $cel->hatarido }}</p>
                                            </div>
                                        </div>
                                        @if ($cel->statusz == "teljesítve")
                                            <div class="progress" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar w-"
                                                style="width:100%; background: greenyellow;">
                                            </div>
                                        </div>
                                        @else
                                            <div class="progress" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar w-"
                                                    style="width:{{ ($cel->budzse / $cel->cel_osszeg) * 100 }}%; background: greenyellow;">
                                                </div>
                                            </div>
                                        @endif


                                        <div class="row">
                                            <div class="col">
                                                <a class="btn btn-primary mt-4 animationBtn rounded-pill"
                                                    href="/goalsmod/{{ $cel->cel_id }}">Módosítás</a>
                                            </div>
                                            <div class="col mt-4">
                                                <p class="text-white">
                                                    @if ($cel->cel_osszeg <= $cel->budzse)
                                                        Teljesítve <span
                                                            class="bi bi-check-square-fill text-success"></span>
                                                    @elseif ($cel->statusz == 'aktív')
                                                        Aktív <span class=""></span>
                                                    @elseif ($cel->statusz == 'teljesítve')
                                                        Teljesítve <span
                                                            class="bi bi-check-square-fill goalTick"></span>
                                                    @else
                                                        Törölve <span class="bi bi-x-circle-fill text-danger"></span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col text-end">
                        <button type="button" class="goal-tab animationBtn rounded-pill" onclick="change('add')">
                            Hozzáadás
                        </button>

                        <div id="addBody" class="d-none">
                            <div class="card">
                                <div class="card-body">
                                    <form action="/goals" method="post">
                                        @csrf

                                        <label class="form-label" for="nev"><span style="color: tomato">*</span>Cél
                                            neve:</label>
                                        <input class="form-control rounded-pill" type="text" name="nev"
                                            id="nev">
                                        @error('nev')
                                            <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                        @enderror

                                        <label class="form-label" for="cel_osszeg"><span
                                                style="color: tomato">*</span>Célösszeg:</label>
                                        <input class="form-control rounded-pill" type="number" name="cel_osszeg"
                                            id="cel_osszeg">
                                        @error('cel_osszeg')
                                            <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                        @enderror

                                        <label class="form-label" for="osszeg"><span style="color: tomato">*</span>Most
                                            mennyit tud rászánni:</label>
                                        <input class="form-control rounded-pill" type="number" name="osszeg"
                                            id="osszeg">
                                        @error('osszeg')
                                            <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                        @enderror

                                        <label class="form-label" for="hatarido"><span
                                                style="color: tomato">*</span>Határidő:</label>
                                        <input class="form-control rounded-pill" type="date" name="hatarido"
                                            id="hatarido">
                                        @error('hatarido')
                                            <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <div class="btn">
                                            <button class="btn btn-dark mt-4 animationBtn rounded-pill"
                                                type="submit">Létrehozás</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <div id="centerPanel" class="d-none">
                            <div id="centerPanelInner">
                                <div class="card-body" id="cont"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/goals.js') }}"></script>
@endsection
