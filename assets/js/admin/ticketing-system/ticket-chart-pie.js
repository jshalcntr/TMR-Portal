// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

$(document).ready(function () {
    let chartInstance;

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

    function fetchAndRenderChartData() {
        $.ajax({
            url: '../../../backend/admin/ticketing-system/fetch_tickets_by_department.php',
            method: 'GET',
            success: function (response) {
                if (response.status === 'success') {
                    const labels = response.data.map(item => item.department);
                    const data = response.data.map(item => item.ticket_count);
                    renderChart(labels, data);
                } else {
                    console.error('Error:', response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    // Initial chart render
    fetchAndRenderChartData();

    // Refresh every 60 seconds
    setInterval(fetchAndRenderChartData, 60000);
});
