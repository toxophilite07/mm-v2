document.addEventListener('DOMContentLoaded', () => {
    fetchMenstrualCycleData();
});

async function fetchMenstrualCycleData() {
    try {
        const response = await fetch('/admin/menstrual-cycle-prediction');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        console.log('Received data:', data);

        if (!Array.isArray(data)) {
            throw new Error('Expected array, but got: ' + typeof data);
        }

        displayStatusCounts(data);
        createMenstrualCycleChart(data);
    } catch (error) {
        console.error('Error fetching or processing data:', error);
        document.getElementById('statusCounts').innerText = 'Error loading data. Please try again later.';
    }
}

function displayStatusCounts(data) {
    const counts = data.reduce((acc, item) => {
        acc[item.status] = (acc[item.status] || 0) + 1;
        return acc;
    }, {});

    const countsHtml = Object.entries(counts)
        .map(([status, count]) => `<strong>${status}:</strong> ${count}`)
        .join(' | ');

    document.getElementById('statusCounts').innerHTML = countsHtml;
}

function createMenstrualCycleChart(data) {
    const ctx = document.getElementById('menstrualCycleChart').getContext('2d');
    const statusColors = {
        'On Period': 'rgba(255, 99, 132, 1)',
        'Pregnant': 'rgba(54, 162, 235, 1)',
        'Irregular': 'rgba(255, 206, 86, 1)',
        'Normal': 'rgba(75, 192, 192, 1)'
    };

    // Convert status to numeric value for the chart
    const statusValues = {
        'On Period': 1,
        'Pregnant': 0.75,
        'Irregular': 0.5,
        'Normal': 0.25
    };

    // Prepare datasets for the line chart
    const datasets = Object.keys(statusColors).map(status => ({
        label: status,
        data: data.map(item => ({
            x: `${item.month} ${item.year}`,
            y: statusValues[status]
        })),
        borderColor: statusColors[status],
        backgroundColor: 'rgba(0,0,0,0)',
        fill: false,
        tension: 0.3  // Adjusted to make the curve smoother
    }));

    new Chart(ctx, {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'category',
                    labels: data.map(item => `${item.month} ${item.year}`),
                    title: {
                        display: true,
                        text: 'Predicted Months'
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 1,
                    ticks: {
                        stepSize: 0.25,
                        callback: function(value) {
                            return Object.keys(statusValues).find(key => statusValues[key] === value) || '';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Status'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Menstrual Cycle Prediction'
                }
            }
        }
    });
}
