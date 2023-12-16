document.addEventListener("DOMContentLoaded", function () {
    let selectedSalesMonth = 0;
    let selectedMoneyMonth = 0;

    let salesLabels;
    let salesMonths;
    let moneyLabels;
    let moneyMonths;

    let salesChart;
    let moneyChart;

    function fetchData(url, callback) {
        fetch(url)
            .then(response => response.json())
            .then(data => callback(data))
            .catch(error => console.error('Error fetching data:', error));
    }

    function updateSalesChart() {
        salesChart.data.labels = salesLabels;
        salesChart.data.datasets[0].label = (selectedSalesMonth === 0 ? 'Sales 2023' : 'Sales ' + salesLabels[selectedSalesMonth - 1] + ' - 2023');
        salesChart.data.datasets[0].data = salesMonths[selectedSalesMonth - 1];
        salesChart.update();
    }

    function updateMoneyChart() {
        moneyChart.data.labels = moneyLabels;
        moneyChart.data.datasets[0].label = (selectedMoneyMonth === 0 ? 'Money 2023' : 'Money ' + moneyLabels[selectedMoneyMonth - 1] + ' - 2023');
        moneyChart.data.datasets[0].data = moneyMonths[selectedMoneyMonth - 1];
        moneyChart.update();
    }

    function handleSalesMonthSelection() {
        const dropdown = document.getElementById('salesMonth');
        selectedSalesMonth = parseInt(dropdown.value);

        if (selectedSalesMonth === 0) {
            // If 'Year' is selected, fetch default labels and months for sales
            fetchData('/api/sales/default', data => {
                salesLabels = data.labels;
                salesMonths = data.months;
                updateSalesChart();
            });
        }
    }

    function handleMoneyMonthSelection() {
        const dropdown = document.getElementById('moneyMonth');
        selectedMoneyMonth = parseInt(dropdown.value);

        if (selectedMoneyMonth === 0) {
            // If 'Year' is selected, fetch default labels and months for money
            fetchData('/api/money/default', data => {
                moneyLabels = data.labels;
                moneyMonths = data.months;
                updateMoneyChart();
            });
        }
    }

    // Initialize Sales Chart
    const salesCtx = document.getElementById('salesChart');
    salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Sales 2023',
                data: [],
                borderWidth: 1,
                borderColor: '#bb2302',
                backgroundColor: '#bb2302',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Initialize Money Chart
    const moneyCtx = document.getElementById('moneyChart');
    moneyChart = new Chart(moneyCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Money 2023',
                data: [],
                borderWidth: 1,
                borderColor: '#79cf75',
                backgroundColor: '#79cf75',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('salesMonth').addEventListener('change', handleSalesMonthSelection);
    document.getElementById('moneyMonth').addEventListener('change', handleMoneyMonthSelection);
});
