@extends('layout')

@push("goals-css")
    <link rel="stylesheet" href="{{asset('css/goals.css')}}">
@endpush

@section('content')
<main class="container py-4 px-5">
    <section>
        <h1 class="bi bi-bullseye p-3"> Cél módosítása</h1>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <form action="/goalsmod/{{$result->cel_id}}" method="post">
                        @csrf
                            <label class="form-label" for="nev">Cél neve:</label>
                            <input class="form-control rounded-pill" type="text" name="nev" id="nev" value="{{$result->cel_nev}}">
                            @error('nev')
                                <p style="color: tomato" class="text-danger">{{ $message }}</p>
                            @enderror

                            <label class="form-label" for="cel_osszeg">Célösszeg:</label>
                            <input class="form-control rounded-pill" type="number" name="cel_osszeg" id="cel_osszeg" value="{{$result->cel_osszeg}}">
                            @error('cel_osszeg')
                                <p style="color: tomato" class="text-danger">{{ $message }}</p>
                            @enderror

                            <label class="form-label" for="osszeg">Most mennyit tud rászánni:</label>
                            <input class="form-control rounded-pill" type="number" name="osszeg" id="osszeg" value="{{$result->budzse}}">
                            @error('osszeg')
                                <p style="color: tomato" class="text-danger">{{ $message }}</p>
                            @enderror

                            <label class="form-label" for="hatarido">Határidő:</label>
                            <input class="form-control rounded-pill" type="date" name="hatarido" id="hatarido" value="{{$result->hatarido}}">
                            @error('hatarido')
                                <p style="color: tomato" class="text-danger">{{ $message }}</p>
                            @enderror

                            <label class="form-label" for="statusz">Cél státusza:</label>
                            <select class="form-control rounded-pill" name="statusz" id="statusz">
                                <option value="aktív">Aktív</option>
                                <option value="kész">Teljesítve</option>
                                <option value="törölve">Törölve</option>
                            </select>
                            @error('hatarido')
                                <p style="color: tomato" class="text-danger">{{ $message }}</p>
                            @enderror

                            <button class="btn btn-dark mt-4" type="submit" id="animationBtn">Módosítás</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
{{-- <script src="{{asset('js/add.js')}}"></script> --}}
