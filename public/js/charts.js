// const { helpers } = Chart;

// let width, height;
// const cache = new Map();

// function createRadialGradient3(context, c1, c2, c3) {
//   const chartArea = context.chart.chartArea;
//   if (!chartArea) return;

//   const chartWidth = chartArea.right - chartArea.left;
//   const chartHeight = chartArea.bottom - chartArea.top;
//   if (width !== chartWidth || height !== chartHeight) cache.clear();

//   let gradient = cache.get(c1 + c2 + c3);
//   if (!gradient) {
//     width = chartWidth;
//     height = chartHeight;

//     const centerX = (chartArea.left + chartArea.right) / 2;
//     const centerY = (chartArea.top + chartArea.bottom) / 2;
//     const r = Math.min(chartWidth / 2, chartHeight / 2);

//     const ctx = context.chart.ctx;
//     gradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, r);
//     gradient.addColorStop(0, c1);
//     gradient.addColorStop(0.5, c2);
//     gradient.addColorStop(1, c3);
//     cache.set(c1 + c2 + c3, gradient);
//   }
//   return gradient;
// }

// const baseColors = [
//   "#60A5FA", "#34D399", "#FBBF24", "#F87171",
//   "#A78BFA", "#22D3EE", "#FB7185", "#93C5FD",
//   "#4ADE80", "#FCA5A5"
// ];
// function gradientBg(ctx) {
//   let c = baseColors[ctx.dataIndex] ?? '#999';
//   if (ctx.active) c = helpers.getHoverColor(c);

//   const mid   = helpers.color(c).desaturate(0.2).darken(0.2).rgbString();
//   const start = helpers.color(c).lighten(0.2).rotate(270).rgbString();
//   const end   = helpers.color(c).lighten(0.1).rgbString();

//   return createRadialGradient3(ctx, start, mid, end);
// }




//nullá teszi az eddigi chartot -> szükséges az új chart rendereléséhez
let chart = null;
let delayed = false;
let currentType = "bar";
const config = (type) => {
    return {
        type: type,
        data: {
        labels: labels,
        //ha az isComparison igaz (azaz ha az a select option van kiválasztva), akkor a címek 'Te' és 'Átlag'-ok lesznek, az adatok pedig a userData és a compData
        datasets: isComparison ? [
            {
                data: userData,
                label: "Ön"
            },
            {
                data: compData,
                label: "Átlag"
            }
        ] : isSpentIncome ? [
            {
                data: spent,
                label: "Költség"
            },
            {
                data: income,
                label: "Bevétel"
            }
        ] : isMonthly ? [{
            label: "Költségek",
            data: data,
            backgroundColor:
            [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                '#FF9F40', '#66BB6A', '#EF5350'
            ],

            //https://www.chartjs.org/docs/latest/api/interfaces/ArcHoverOptions.html
            //ha az egeret ráviszi a user az oszlop/körszelet széle fehér lesz
            hoverBorderColor: 'white',
            //https://www.chartjs.org/docs/latest/api/interfaces/BorderOptions.html
            borderWidth: 2
        }] : [{
            label: "Költségek",
            data: data,
            backgroundColor:
            [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                '#FF9F40', '#66BB6A', '#EF5350'
            ],

            //https://www.chartjs.org/docs/latest/api/interfaces/ArcHoverOptions.html
            //ha az egeret ráviszi a user az oszlop/körszelet széle fehér lesz
            hoverBorderColor: 'white',
            //https://www.chartjs.org/docs/latest/api/interfaces/BorderOptions.html
            borderWidth: 2
    }]
    },
    options: {
        //rakd majd egybe a kettő scales-t + színek változtatása
        scales: (type === "pie" || type === "doughnut") ? {} : {
      x: {
        stacked: isComparison || isSpentIncome,
        ticks: { color: "#ffffff" }
      },
      y: {
        stacked: isComparison || isSpentIncome,
        beginAtZero: true
      }
    },
        responsive: true,
        animation: {
            //animáció forrás: https://www.chartjs.org/docs/latest/samples/animations/delay.html
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
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    }
        }
    },
    plugins: {
        datalabels: {
            display: false
        },
        legend: {
        //eltűnteti a címet
        //https://stackoverflow.com/questions/56846339/how-to-remove-title-color-box-in-chart-js
            display: type !== "bar",
            display: isComparison ? true : isSpentIncome ? true : false,
        },
        tooltip: {
          callbacks: {
            label: (context) => {
              if (type === "doughnut" || type === "pie") {
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
        y: {
            beginAtZero: true,
         }
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
    // induláskor a select aktuális értékével rajzol
    const select = document.getElementById("chartType");
    currentType = select.value;
    render(currentType);

    // váltáskor újrarajzol
    select.addEventListener("change", (e) => {
        currentType = e.target.value;
        render(currentType);
    });
});

