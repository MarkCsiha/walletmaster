@extends('layout')

@push("belepes-css")
    <link rel="stylesheet" href="{{asset('css/belepes.css')}}">
@endpush

@section('content')
    <main class="container pb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 mb-3">
                @if(session('unsuccessful'))
                    <p class="text-danger text-center">{{session('unsuccessful')}}</p>
                @endif
            </div>
                <h1 class="text-center py-3">Vélemény, ötlet írása</h1>
                <div class="card w-75 mx-auto">
                    <form class="card-body" action="/review" method="post">
                    @csrf
                        <select name="typeSelect" id="typeSelect">
                            <option value="idea">Ötlet</option>
                            <option value="error">Hiba</option>
                            <option value="advice">Tanács</option>
                            <option value="development">Fejlesztési javaslat</option>
                            <option value="other">Egyéb</option>
                        </select>
                        <label class="form-label mt-3" for="reviewText">Vélemény leírása:</label>
                        <input class="form-control @error('reviewText') is-invalid @enderror" type="textarea" name="reviewText" id="reviewText">

                        <button class="btn btn-primary mt-3" type="submit">Vélemény küldése</button>
                    </form>
                </div>
        </div>
    </main>
@endsection
