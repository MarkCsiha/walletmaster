@extends('layout')

@push('belepes-css')
    <link rel="stylesheet" href="{{ asset('css/belepes.css') }}">
@endpush

@section('content')
    <main class="container pb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 mb-3">
                @if (session('success'))
            <div class="alert alert-success text-success text-center w-50 py-1 mx-auto mt-3">
                        <i class="bi bi-check-circle-fill">
                            {{ session('success') }}
                        </i>
                    </div>
                @elseif (session('unsuccessful'))
            <div class="alert alert-success text-success text-center w-50 py-1 mx-auto mt-3">
                        <i class="bi bi-exclamation-triangle-fill">
                            {{ session('unsuccessful') }}
                        </i>
                    </div>
                @endif
            </div>
            <h1 class="text-center py-3">Vélemény, ötlet írása</h1>
            <div class="card w-75 mx-auto">
                <form class="card-body" action="/review" method="post">
                    @csrf
                    <div class="my-4">
                        <label class="form-label-mt-3" for="typeSelect">Vélemény típusa:</p>
                            <select name="typeSelect" id="typeSelect" class="@error('typeSelect') is-invalid @enderror rounded-pill">
                                <option value="otlet">Ötlet</option>
                                <option value="hiba">Hiba</option>
                                <option value="tanacs">Tanács</option>
                                <option value="fejlesztes">Fejlesztési javaslat</option>
                                <option value="egyeb">Egyéb</option>
                            </select>
                            @error('typeSelect')
                                <p style="color: #FDEBE7">{{ $message }}</p>
                            @enderror
                    </div>
                    <div class="my-4">
                        <label class="form-label mt-3" for="reviewText">Vélemény leírása:</label>
                        <textarea class="form-control @error('reviewText') is-invalid @enderror border rounded-4" name="reviewText" id="reviewText"
                            cols="10" rows="10"></textarea>
                        @error('reviewText')
                            <p style="color: #FDEBE7">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="btn btn-primary mt-3 animationBtn rounded-pill" type="submit">Vélemény küldése</button>
                </form>
            </div>
        </div>
    </main>
@endsection
