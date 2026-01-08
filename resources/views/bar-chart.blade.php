@extends("layout")
@section("content")
<div class="container">
    <div class="card">
        <div class="card-body">
            <x-filters></x-filters>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <canvas id="barChart" width="800" height="400"></canvas>
        </div>
    </div>
</div>
@endsection