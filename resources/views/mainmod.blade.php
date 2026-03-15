@extends('layout')

@push("add-css")
    <link rel="stylesheet" href="{{asset("css/add.css")}}">
@endpush

@section('content')
<main class="container py-4 px-5">
    <section>
        <h1>
            @if($result->tipus == 0)
                Kiadás
            @else
                Bevétel
            @endif módosítása
        </h1>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <form action="/mainmod/{{$result->szamla_id}}" method="post">
                        @csrf
                            <label class="for-label" for="osszeg">Összeg:</label>
                            <input class="form-control rounded-pill" type="number" name="osszeg" id="osszeg" value="{{$result->osszeg}}">
                            @error('osszeg')
                                <p style="color: tomato" class="text-danger">{{$message}}</p>
                            @enderror

                            <label class="form-label mt-4" for="honnan">Hely:</label>
                            <input class="form-control rounded-pill" type="text" name="honnan" id="honnan" value="{{$result->honnan}}">
                            @error('honnan')
                                <p style="color: tomato" class="text-danger">{{$message}}</p>
                            @enderror

                            <div class="my-4">
                                <p><label class="for-label mb-1" for="leiras">Leírás:</label></p>
                                <textarea class="form-control" name="leiras" id="lairas" cols="10" rows="10">{{$result->leiras}}</textarea>
                            </div>
                            @error('leiras')
                                <p style="color: tomato" class="text-danger">{{$message}}</p>
                            @enderror

                            <div class="my-4">
                                <label class="form-label" for="datum">Dátum: </label>
                                <input class="form-control rounded-pill" type="date" name="datum" id="datum" value="{{substr($result->datum, 0, 10) }}">
                            </div>
                            @error('datum')
                                <p style="color: tomato" class="text-danger">{{$message}}</p>
                            @enderror

                            {{-- Megnézni hogyan lehet a kiválasztottat hozzáadni --}}
                            <div class="my-2">
                                <label class="form-check-label" for="fix">Ez egy fix kiadás?</label>
                                <select class="form-select  rounded-pill" name="fix" id="fix">
                                    @if ($result->fix == "nem")
                                        <option value="nem">Nem</option>
                                        <option value="havi">Havi</option>
                                        <option value="feleves">Féléves</option>
                                        <option value="eves">Éves</option>
                                    @elseif ($result->fix == "havi")
                                        <option value="havi">Havi</option>
                                        <option value="feleves">Féléves</option>
                                        <option value="eves">Éves</option>
                                        <option value="nem">Nem</option>
                                    @elseif ($result->fix == "feleves")
                                        <option value="feleves">Féléves</option>
                                        <option value="havi">Havi</option>
                                        <option value="eves">Éves</option>
                                        <option value="nem">Nem</option>
                                    @elseif ($result->fix == "eves")
                                        <option value="eves">Éves</option>
                                        <option value="feleves">Féléves</option>
                                        <option value="havi">Havi</option>
                                        <option value="nem">Nem</option>
                                    @else
                                        <option value="0">---</option>
                                        <option value="nem">Nem</option>
                                        <option value="havi">Havi</option>
                                        <option value="feleves">Féléves</option>
                                        <option value="eves">Éves</option>
                                    @endif
                                </select>
                            </div>

                            {{-- Itt is a régi option legyen --}}
                            <div class="mt-4">
                                <label class="for-label mb-2" for="tipus">Bevétel vagy kiadás?</label>
                                <select class="form-select rounded-pill" name="tipus" id="tipus" data-old="{{ old('tipus') }}">
                                    @if ($result->tipus == 0)
                                        <option value="kiadas"  {{ old('tipus')=='kiadas' ? 'selected' : '' }}>Kiadás</option>
                                        <option value="bevetel" {{ old('tipus')=='bevetel' ? 'selected' : '' }}>Bevétel</option>
                                    @else
                                        <option value="bevetel" {{ old('tipus')=='bevetel' ? 'selected' : '' }}>Bevétel</option>
                                        <option value="kiadas"  {{ old('tipus')=='kiadas' ? 'selected' : '' }}>Kiadás</option>
                                    @endif
                                    {{-- <option value="0">---</option> --}}
                                </select>
                            </div>

                            <div class="mt-2">
                                <label class="form-label mb-2" for="kategoria">Kategória</label>
                                <select class="form-select rounded-pill" name="kategoria" id="kategoria" data-old="{{ old('kategoria') }}">
                                    <option value="{{$result->kategoria}}">{{$result->kategoria}}</option>
                                    @if ($result->tipus == 0)
                                        <option value="Élelmiszer">Élelmiszer</option>
                                        <option value="Háztartás">Háztartás</option>
                                        <option value="Elektronika">Elektronika</option>
                                        <option value="Lakhatás">Lakhatás</option>
                                        <option value="Hitel">Hitel</option>
                                        <option value="Ruházat">Ruházat</option>
                                        <option value="Gyógyszer">Gyógyszer</option>
                                        <option value="Edzés">Edzés</option>
                                        <option value="Autó">Autó</option>
                                        <option value="Tanulmányok">Tanulmányo</option>
                                        <option value="Utazás">Utazás</option>
                                        <option value="Szórakozás">Szórakozás</option>
                                        <option value="Egyéb">Egyéb</option>
                                    @else
                                        <option value="Fizetés">Fizetés</option>
                                        <option value="Befektetés">Befektetés</option>
                                        <option value="Részvény">Részvény</option>
                                        <option value="Járandósság">Járandósság</option>
                                        <option value="Egyéb">Egyéb</option>
                                    @endif
                                </select>
                            </div>
                            <div class="btn">
                                <button class="btn btn-dark mt-4" type="submit">Módosítás</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
{{-- <script src="{{asset('js/add.js')}}"></script> --}}
