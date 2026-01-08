@extends('layout')
@section('content')
    <main class="container pb-2">

        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">


                <div class="container">

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <h2 class="text-center">Pie Charts</h2>
                            <canvas id="pieChart" height="100"></canvas>
                        </div>

                        <div class="col-md-6">
                            <h2 class="text-center">Doughnut Charts</h2>
                            <canvas id="doughnutChart" height="100"></canvas>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <h2 class="text-center">Bar Charts</h2>
                            <canvas id="barChart" data-labels="@json($labels)" data-data="@json($data)"  height="100"></canvas>
                        </div>

                        <div class="col-md-6">
                            <h2 class="text-center">Line Charts</h2>
                            <canvas id="lineChart" height="100"></canvas>
                        </div>
                    </div>

                </div>


            </main>
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($labels) !!};
        const data = {!! json_encode($data) !!};

        const config = (type) => ({
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Költségek',
                    data: data,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#66BB6A', '#EF5350'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: type === 'pie' || type === 'doughnut' ? {} : {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('barChart'), config('bar'));
        // new Chart(document.getElementById('lineChart'), config('line'));
        // new Chart(document.getElementById('pieChart'), config('pie'));
        // new Chart(document.getElementById('doughnutChart'), config('doughnut'));
    </script>
@endsection
