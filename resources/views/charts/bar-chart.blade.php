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

            <canvas id="myChart" width="800" height="400"></canvas>
        </div>
    </div>
</div>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        const labels = {!! json_encode($labels) !!};
        const data = {!! json_encode($data) !!};
    </script>

@endsection
