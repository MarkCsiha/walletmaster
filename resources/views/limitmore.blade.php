@extends('layout')

@push("add-css")
    <link rel="stylesheet" href="{{ asset('css/limit.css') }}">
@endpush

@section('content')
<main class="container py-4 px-5">
    <section>
        <h1>
            @if($result_szamla->tipus == 0)
                Kiadás
            @else
                Bevétel
            @endif módosítása
        </h1>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <form action="/limitmore/{{$result_fix->fix_id}}" method="get">
                        @csrf
                            <p></p>

                            <button class="btn btn-dark mt-4 animationBtn" type="submit">Vissza az oldalra</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
{{-- <script src="{{asset('js/add.js')}}"></script> --}}
