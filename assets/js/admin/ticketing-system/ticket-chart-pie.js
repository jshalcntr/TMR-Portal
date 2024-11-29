// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

$(document).ready(function () {
    function renderChart(labels, data) {
        const ctx = document.getElementById('ticketPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Department names
                datasets: [{
                    label: 'Closed Tickets',
                    data: data, // Ticket counts
                    backgroundColor: 'rgba(78, 115, 223, 0.5)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Tickets'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Departments'
                        }
                    }
                }
            }
        });
    }

    // Fetch data from the backend and populate the chart
    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_tickets_by_department.php', // Path to the PHP script
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
});