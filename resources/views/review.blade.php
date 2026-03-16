@extends('layout')

@push('belepes-css')
    <link rel="stylesheet" href="{{ asset('css/belepes.css') }}">
@endpush

@section('content')
    <main class="container pb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 mb-3">
                @if (session('unsuccessful'))
                    <p class="text-danger text-center">{{ session('unsuccessful') }}</p>
                @endif
            </div>
            <h1 class="text-center py-3">Vélemény, ötlet írása</h1>
            <div class="card w-75 mx-auto">
                <form class="card-body" action="/review" method="post">
                    @csrf
                    <div class="my-4">
                        <label class="form-label-mt-3" for="typeSelect">Vélemény típusa:</p>
                        <select name="typeSelect" id="typeSelect" class="@error('typeSelect') is-invalid @enderror">
                            <option value="otlet">Ötlet</option>
                            <option value="hiba">Hiba</option>
                            <option value="tanacs">Tanács</option>
                            <option value="fejlesztes">Fejlesztési javaslat</option>
                            <option value="egyeb">Egyéb</option>
                        </select>
                        @error('typeSelect')
                            <p style="color: tomato" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="my-4">
                        <label class="form-label mt-3" for="reviewText">Vélemény leírása:</label>
                        <textarea class="form-control @error('reviewText') is-invalid @enderror" name="reviewText" id="reviewText"
                            cols="10" rows="10"></textarea>
                        @error('reviewText')
                            <p style="color: tomato" class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Vélemény küldése</button>
                </form>
            </div>
        </div>
    </main>
@endsection
