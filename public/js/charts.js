        // const labels = {!! json_encode($labels) !!};
        // const data = {!! json_encode($data) !!};

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
                        //eltűnteti a címet
                        //https://stackoverflow.com/questions/56846339/how-to-remove-title-color-box-in-chart-js
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            //https://www.geeksforgeeks.org/javascript/how-to-add-percentage-and-value-datalabels-in-pie-chart-in-chartjs/
                            //százalékszámítás
                            label: (context) => {
                            const value = context.parsed;
                            let percentage = (value / context.chart._metasets[context.datasetIndex].total * 100).toFixed(2) + "% |";
                            return percentage + "\n" + value;
                            }
                    }
                }
            }
        },
                plugins: [ChartDataLabels],
                scales: type === 'pie' || type === 'doughnut' ? {} : {
                    y: {
                        beginAtZero: true
                    }
                }
                
            }
        );

        new Chart(document.getElementById('barChart'), config('bar'));
        // new Chart(document.getElementById('lineChart'), config('line'));
        new Chart(document.getElementById('pieChart'), config('pie'));
        // new Chart(document.getElementById('doughnutChart'), config('doughnut'));