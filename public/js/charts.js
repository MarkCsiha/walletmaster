//nullá teszi az eddigi chartot -> szükséges az új chart rendereléséhez
let chart = null;
let delayed = false;

const config = (type) => {
    return {
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
        animation: {
            //animáció forrás: https://www.chartjs.org/docs/latest/samples/animations/delay.html
            onComplete: () => {
            //csak akkor történik animáció ha oszlop diagramról van szó, kördiagramnál nem
                if (type === "bar") {
                    delayed = true;
                }
            },
            delay: (context) => {
                //csak akkor történik animáció ha oszlop diagramról van szó, kördiagramnál nem
                 if (type === "bar") {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    }
        }
    },
    plugins: {
        legend: {
        //eltűnteti a címet
        //https://stackoverflow.com/questions/56846339/how-to-remove-title-color-box-in-chart-js
        display: type !== "bar"
        },
        tooltip: {
          callbacks: {
            label: (context) => {
              if (type === "doughnut") {
                //https://www.geeksforgeeks.org/javascript/how-to-add-percentage-and-value-datalabels-in-pie-chart-in-chartjs/
                //százalékszámítás
                //frissített, verzióhoz helyes számítás
                const value = context.parsed;
                const total = context.chart._metasets?.[context.datasetIndex]?.total;
                //képlet
                let percentage = total ? ((value / total) * 100).toFixed(2) : "0.00";
                return `${percentage}% | ${value} Ft`;
              }

              if (type === "bar") {
                return `${context.parsed.y} Ft`;
              }

              return `${context.formattedValue} Ft`;
            }
          }
        }
      },

    //megmondja hogy torta és kördiagram esetén nullán keződjön
      scales: (type === "pie" || type === "doughnut") ? {} : {
        y: { beginAtZero: true }
      }
    },
    plugins: [ChartDataLabels]
  };
}

//az új chartot generálja le, és törli az előzőt, így van szabad hely a myChart változóban az új diagramnak

function render(type) {
  //kérdéses, ha nem működik írd át a nevet canvas-ra!
  const ctx = document.getElementById("myChart");

  if (chart) chart.destroy();
  delayed = false;

  chart = new Chart(ctx, config(type));
}

//enélkül nem fog elindulni
document.addEventListener("DOMContentLoaded", () => {
  render("bar");
});
