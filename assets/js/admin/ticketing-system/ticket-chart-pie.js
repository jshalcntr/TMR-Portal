// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Custom function to show a modal instead of alert()
function showModal(message) {
    document.getElementById('alertMessage').innerText = message;
    document.getElementById('alertModal').classList.remove('d-none');
}

// Hide the modal when the OK button is clicked
document.getElementById('closeModalBtn').addEventListener('click', function () {
    document.getElementById('alertModal').classList.add('d-none');
});

document.addEventListener('DOMContentLoaded', function () {
    let chartInstance;

    // Function to render or update the Chart.js instance
    function renderChart(labels, data) {
        const ctx = document.getElementById('ticketPieChart').getContext('2d');

        // Destroy existing chart instance if it exists
        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Closed Tickets',
                    data: data,
                    backgroundColor: [
                        'rgba(78, 115, 223, 0.7)',
                        'rgba(28, 200, 138, 0.7)',
                        'rgba(54, 185, 204, 0.7)',
                        'rgba(246, 194, 62, 0.7)',
                        'rgba(231, 74, 59, 0.7)',
                        'rgba(133, 135, 150, 0.7)',
                        'rgba(93, 123, 247, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(102, 102, 255, 0.7)',
                        'rgba(153, 204, 255, 0.7)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return `${tooltipItem.label}: ${tooltipItem.raw}`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Function to fetch chart data from the PHP backend
    async function fetchAndRenderChartData(startDate = '', endDate = '') {
        try {
            const response = await fetch(`../../../backend/admin/ticketing-system/fetch_tickets_by_department.php?start_date=${startDate}&end_date=${endDate}`);
            const result = await response.json();

            if (result.status === 'success') {
                const labels = result.data.map(item => item.department);
                const data = result.data.map(item => item.ticket_count);
                renderChart(labels, data);
            } else {
                console.error("No data found");
            }
        } catch (error) {
            console.error('Error fetching chart data:', error);
        }
    }

    // Event listener for the filter button
    document.getElementById('filterBtn').addEventListener('click', function () {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (!startDate || !endDate) {
            showModal("Please select both start and end dates.");
            return;
        }

        fetchAndRenderChartData(startDate, endDate);
    });

    // Initial data load on page load
    fetchAndRenderChartData();

    // Auto-refresh chart every 1 minute (60,000 ms)
    setInterval(function () {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        fetchAndRenderChartData(startDate, endDate);
    }, 60000);
});
