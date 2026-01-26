// Külön fájl a spentIncome chart-hoz
if (document.getElementById("spentIncomeChart")) {
    let spentIncomeChart = null;
    let spentIncomeDelayed = false;

    const configSpentIncome = {
        type: 'bar',
        data: {
            labels: ['Kiadás', 'Bevétel'], // vagy labels változó
            datasets: [{
                label: 'Kiadás - Bevétel',
                data: data, // vagy adott adatok
                backgroundColor: ['#FF6384', '#36A2EB'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            animation: {
                onComplete: () => {
                    spentIncomeDelayed = true;
                },
                delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default' && !spentIncomeDelayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                }
            },
            indexAxis: 'y',
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Bevételek és Kiadások'
                },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            return `${context.parsed.x} Ft`;
                        }
                    }
                }
            },
            scales: {
                x: { beginAtZero: true }
            }
        }
    };

    // SpentIncome chart inicializálása
    const spentIncomeCtx = document.getElementById("spentIncomeChart");
    spentIncomeChart = new Chart(spentIncomeCtx, configSpentIncome);

    // Ha van toggle gomb, akkor azt is kezeljük
    const spentIncomeToggleBtn = document.getElementById("btnToggleSpentIncome");
    if (spentIncomeToggleBtn) {
        spentIncomeToggleBtn.addEventListener("click", () => {
            // Itt lehetne valami váltást csinálni, de horizontal bar chart esetén
            // talán nem érdemes doughnut-ra váltani
            console.log("SpentIncome chart toggle");
        });
    }
}
