let chart = null;
let delayed = false;
let currentType = "bar";
const config = (type) => {
    return {
        type: type,
        data: {
            labels: labels,
            datasets: isComparison ? [
                {
                    data: userData,
                    label: "Ön",
                },
                {
                    data: compData,
                    label: "Átlag",
                }
            ] : isSpentIncome ? [
                {
                    data: spent,
                    label: "Költség",
                },
                {
                    data: income,
                    label: "Bevétel",
                }
            ] : isMonthly ? [{
                label: "Költségek",
                data: data,
                backgroundColor:
                    [
                        '#6C63FF',
                        '#4D96FF',
                        '#00C2A8',
                        '#FFD166',
                        '#FF7B54',
                        '#EF476F',
                        '#7B2CBF',
                        '#2EC4B6',
                        '#90BE6D',
                        '#577590',
                        '#F94144',
                        '#F3722C',
                        '#43AA8B',
                        '#277DA1',
                        '#F9C74F',
                        '#9D4EDD',
                        '#F15BB5',
                        '#00BBF9',
                        '#00F5D4',
                        '#B5179E',
                        '#4895EF',
                        '#560BAD',
                        '#ADB5BD'
                    ],
            }] : [{
                label: "Költségek",
                data: data,
                backgroundColor:
                    [
                        '#6C63FF',
                        '#6C63FF',
                        '#4D96FF',
                        '#00C2A8',
                        '#FFD166',
                        '#FF7B54',
                        '#EF476F',
                        '#7B2CBF',
                        '#2EC4B6',
                        '#90BE6D',
                        '#577590',
                        '#F94144',
                        '#F3722C',
                        '#43AA8B',
                        '#277DA1',
                        '#F9C74F',
                        '#9D4EDD',
                        '#F15BB5',
                        '#00BBF9',
                        '#00F5D4',
                        '#B5179E',
                        '#4895EF',
                        '#560BAD',
                        '#ADB5BD'
                    ],

            }]
        },
        options: {
            hoverBorderColor: 'white',
            borderWidth: 2,
            scales: (type === "pie" || type === "doughnut") ? {} : {
                x: {
                    stacked: isComparison || isSpentIncome,
                    ticks: { color: "#ffffff" }
                },
                y: {
                    stacked: isComparison || isSpentIncome,
                    beginAtZero: true,
                    ticks: {
                        color: "#ffffff"
                    }
                }
            },
            responsive: true,
            animation: {
                onComplete: () => {
                    if (type == "bar") {
                        delayed = true;
                    }
                },
                delay: (context) => {
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
                    display: isComparison || isSpentIncome || type == "pie" || type == "doughnut" ? true : false,
                    labels: {
                        color: "white"
                    }
                },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            if (type === "doughnut" || type === "pie") {
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

            scales: (type === "pie" || type === "doughnut") ? {} : {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: "#ffffff"
                    }
                },
                x: {
                    ticks: {
                        color: "#ffffff"
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    };
}

function render(type) {
    const ctx = document.getElementById("myChart");

    if (chart) chart.destroy();
    delayed = false;

    chart = new Chart(ctx, config(type));
}

document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById("chartType");
    currentType = select.value;
    render(currentType);

    select.addEventListener("change", (e) => {
        currentType = e.target.value;
        render(currentType);
    });
});

