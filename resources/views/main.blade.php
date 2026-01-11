@extends('layout')
@section('content')
    <main class="container pb-2">

        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <div class="chartBtn">
                <div class="chart_types">
                    <button id="bar">Oszlopdiagram</button>
                    <button id="doughnut">Tortadiagram</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <form action="/main" method="post">
                        @csrf
                        <button id="spentIncome" name="spentIncome">Költés - kiadás diagram</button>
                    </form>
                    <form action="/main" method="post">
                        @csrf
                        <button id="categories" name="categories">Kategóriák diagram</button>
                    </form>
                    <form action="/main" method="post">
                        <select name="chartChange" id="chartChange">
                            <option value="spentIncome">Költség - kiadás diagram</option>
                            <option value="categories"></option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="chart">
                <canvas id="myChart"></canvas>
            </div>
                {{-- <div class="container">

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
                            <canvas id="barChart"  height="100"></canvas>
                        </div>

                        <div class="col-md-6">
                            <h2 class="text-center">Line Charts</h2>
                            <canvas id="lineChart" height="100"></canvas>
                        </div>
                    </div>
                    {{-- <form class="card-body" action="/main" method="post">
                        @csrf
                        <select name="chooseDataFilter" id="chooseDataFilter">
                            <option value="incomeSpentDiff">Bevétel - kiadás</option>
                            <option value="categoryFilter">Kategóriák szerinti lebontás</option>



                        </select>
                    </form>
                </div> --}}


            </main>
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        const labels = {!! json_encode($labels) !!};
        const data = {!! json_encode($data) !!};

        // const config = (type) => ({
        //     type: type,
        //     data: {
        //         labels: labels,
        //         datasets: [{
        //             label: 'Költségek',
        //             data: data,
        //             backgroundColor: [
        //                 '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
        //                 '#9966FF', '#FF9F40', '#66BB6A', '#EF5350'
        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 //eltűnteti a címet
        //                 //https://stackoverflow.com/questions/56846339/how-to-remove-title-color-box-in-chart-js
        //                 display: false,
        //             },
        //             tooltip: {
        //                 callbacks: {
        //                     //https://www.geeksforgeeks.org/javascript/how-to-add-percentage-and-value-datalabels-in-pie-chart-in-chartjs/
        //                     //százalékszámítás
        //                     label: (context) => {
        //                     const value = context.parsed;
        //                     let percentage = (value / context.chart._metasets[context.datasetIndex].total * 100).toFixed(2) + "% |";
        //                     return percentage + "\n" + value;
        //                     }
        //             }
        //         }
        //     }
        // },
        //         plugins: [ChartDataLabels],
        //         scales: type === 'pie' || type === 'doughnut' ? {} : {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }

        //     }
        // );

        // new Chart(document.getElementById('barChart'), config('bar'));
        // // new Chart(document.getElementById('lineChart'), config('line'));
        // new Chart(document.getElementById('pieChart'), config('pie'));
        // new Chart(document.getElementById('doughnutChart'), config('doughnut'));
    </script>
@endsection
