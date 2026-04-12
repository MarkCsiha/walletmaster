@extends('layout')
@push('add-css')
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
@endpush
@section('content')
    <main class="container py-4 px-5">
        <section>
            <h1>Kiadás/bevétel hozzáadása</h1>
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
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">

                            <form action="/import" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" class="form-control rounded-pill" accept=".csv,.xlsx"
                                    required>
                                <button type="submit" class="btn btn-primary mt-2 animationBtn rounded-pill">Adatok
                                    importálása</button>
                            </form>
                            <form action="/add" method="post">
                                @csrf
                                <label class="form-label" for="osszeg">Összeg:</label>
                                <input class="form-control rounded-pill" type="number" name="osszeg" id="osszeg"
                                    value="{{ old('osszeg') }}">
                                @error('osszeg')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <label class="form-label mt-4" for="honnan">Hely:</label>
                                <input class="form-control rounded-pill" type="text" name="honnan" id="honnan"
                                    value="{{ old('honnan') }}">
                                @error('honnan')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="my-4">
                                    <label class="for-label mb-1" for="leiras">Leírás:</label>
                                    <textarea class="form-control border rounded-4" name="leiras" id="leiras" cols="10" rows="10"></textarea>
                                </div>
                                @error('leiras')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="my-4">
                                    <label class="form-label" for="datum">Dátum: </label>
                                    <input class="form-control rounded-pill" type="date" name="datum" id="datum"
                                        placeholder="éééé.hh.nn">
                                </div>
                                @error('datum')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="my-2">
                                    <label class="form-check-label" for="fix">Ez egy fix kiadás?</label>
                                    <select class="form-select rounded-pill" name="fix" id="fix">
                                        <option value="0">---</option>
                                        <option value="eves">Éves</option>
                                        <option value="feleves">Féléves</option>
                                        <option value="havi">Havi</option>
                                        <option value="nem">Nem</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <label class="for-label mb-2" for="tipus">Bevétel vagy kiadás?</label>
                                    <select class="form-select rounded-pill" name="tipus" id="tipus"
                                        data-old="{{ old('tipus') }}">
                                        <option value="0">---</option>
                                        <option value="kiadas" {{ old('tipus') == 'kiadas' ? 'selected' : '' }}>Kiadás
                                        </option>
                                        <option value="bevetel" {{ old('tipus') == 'bevetel' ? 'selected' : '' }}>Bevétel
                                        </option>
                                    </select>
                                </div>

                                <div class="mt-2">
                                    <label class="form-label mb-2" for="kategoria">Kategória</label>
                                    <select class="form-select rounded-pill" name="kategoria" id="kategoria"
                                        data-old="{{ old('kategoria') }}">
                                        <option value="0">Válasszon típust először</option>
                                    </select>
                                </div>

                                <button class="btn btn-dark mt-4 animationBtn rounded-pill" type="submit">Tranzakció
                                    hozzáadása</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
<script src="{{ asset('js/add.js') }}"></script>
