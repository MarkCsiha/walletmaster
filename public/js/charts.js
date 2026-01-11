//nullá teszi az eddigi chartot -> szükséges az új chart rendereléséhez
let chart=null;
let delayed;

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
            animation: {
                onComplete: () => {
                    //csak akkor történik animáció ha oszlop diagramról van szó, kördiagramnál nem

                    if (type == "bar") {
                        delayed = true;
                        }
                    },
                delay: (context) => {
        //csak akkor történik animáció ha oszlop diagramról van szó, kördiagramnál nem
                    if (type == "bar") {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default') {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    }
                },
    },
            responsive: true,
            plugins: {
                legend: {
                        //eltűnteti a címet
                        //https://stackoverflow.com/questions/56846339/how-to-remove-title-color-box-in-chart-js
                    display: type != "bar"
                    },
                tooltip: {
                    callbacks: {
                            //https://www.geeksforgeeks.org/javascript/how-to-add-percentage-and-value-datalabels-in-pie-chart-in-chartjs/
                            //százalékszámítás
                        label: (context) => {
                            if (type == "doughnut") {
                                const value = context.parsed;
                                let percentage = (value / context.chart._metasets[context.datasetIndex].total * 100).toFixed(2);
                                return percentage  + "% |\n" + value + " Ft";
                            }
                            else if (type == "bar") {
                                return data;
                            }
                        }
                    }
                }
            }

                        //https://stackoverflow.com/questions/56846339/how-to-remove-title-color-box-in-chart-js
                                                    //https://www.geeksforgeeks.org/javascript/how-to-add-percentage-and-value-datalabels-in-pie-chart-in-chartjs/
                                                                            //eltűnteti a címet
                                                                                                        //százalékszámítás
        },
            //megmondja hogy torta és kördiagram esetén nullán keződjön
            plugins: [ChartDataLabels],
            scales: type === 'pie' || type === 'doughnut' ? {} : {
                y: {
                    beginAtZero: true
            },
        }
    });

//az új chartot generálja le, és törli az előzőt, így van szabad hely a myChart változóban az új diagramnak
function render(type) {
    const ctx = document.getElementById("myChart");

    if (chart) {
        chart.destroy()
    };
    chart = new Chart(ctx, config(type));
}

// gombra nyomást követően megjelenik az adott diagram
document.getElementById("bar").addEventListener("click", function () {
    render("bar");
});

document.getElementById("doughnut").addEventListener("click", function () {
    render("doughnut");
});
