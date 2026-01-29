import { Chart } from 'chart.js/auto';

(async function() {

    new barChart(
         document.getElementById('barChart'),
         {
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
        }
    ) 

        new Chart(document.getElementById('barChart'), config('bar'));
    
})();
