@extends('layout')
@section('content')
    <main class="container pb-2">
        <div class="row">
            <div class="col-md-9">
                @if (session('siker'))
                    <p class="text text-success text-center">{{session("siker")}}</p>
                @endif
                <h1 class="text-center py-3">Főoldal</h1>
            </div>
        </div>
    </main>
@endsection
