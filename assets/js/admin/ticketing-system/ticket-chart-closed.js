// Set default font properties for Chart.js
Chart.defaults.global.defaultFontFamily = 'Inter', 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Helper function to format numbers with commas
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };

    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

// Custom function to show a modal instead of alert()
function showModal(message) {
    document.getElementById('alertMessage').innerText = message;
    document.getElementById('alertModal').classList.remove('hidden');
}

// Hide the modal when the OK button is clicked
document.getElementById('closeModalBtn').addEventListener('click', function () {
    document.getElementById('alertModal').classList.add('hidden');
});

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById("closedTicketsChart");
    let chartInstance = null;

    // Function to render or update the Chart.js instance
    function renderChart(labels, data) {
        // Destroy existing chart to avoid re-rendering issues
        if (chartInstance) {
            chartInstance.destroy();
        }

        // Find the element to display the total count
        const totalTicketsElement = document.getElementById("totalClosedTickets");
        const totalCount = data.reduce((sum, current) => sum + current, 0);

        // Update the content of the element
        totalTicketsElement.innerText = number_format(totalCount);
    }

    // Function to fetch chart data from the PHP backend
    async function fetchChartData(startDate = '', endDate = '') {
        try {
            const response = await fetch(`../../../backend/admin/ticketing-system/month_closed_tickets.php?start_date=${startDate}&end_date=${endDate}`);
            const result = await response.json();

            if (result.status === 'success') {
                const chartData = result.data;
                const labels = chartData.map(item => {
                    const dateObj = new Date(item.date + 'T12:00:00Z'); // Add time and 'Z' to avoid timezone issues
                    const options = { month: 'short', day: '2-digit' };
                    return dateObj.toLocaleDateString('en-US', options);
                });
                const ticketCounts = chartData.map(item => item.ticket_count);
                renderChart(labels, ticketCounts);
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

        fetchChartData(startDate, endDate);
    });

    // Initial data load on page load
    // The PHP backend now defaults to all tickets if no dates are provided.
    fetchChartData();

    // Auto-refresh data every 1 minute (60,000 ms)
    setInterval(function () {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        fetchChartData(startDate, endDate);
    }, 60000);
});


$(document).ready(function () {
    const ctx = $("#topSubjectsChart");
    let chartInstance = null;

    function getRandomColor() {
        const r = Math.floor(Math.random() * 255);
        const g = Math.floor(Math.random() * 255);
        const b = Math.floor(Math.random() * 255);
        return `rgba(${r}, ${g}, ${b}, 0.8)`; // Semi-transparent
    }

    function renderChart(labels, data) {
        if (chartInstance) {
            chartInstance.destroy();
        }

        // Generate random colors for each bar
        const colors = labels.map(() => getRandomColor());

        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Top 5 Ticket Subjects",
                    backgroundColor: colors,
                    borderColor: colors.map(c => c.replace("0.8", "1")), // full opacity border
                    borderWidth: 1,
                    data: data,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: { left: 10, right: 25, top: 25, bottom: 0 }
                },
                scales: {
                    xAxes: [{
                        gridLines: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: 5 }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            callback: function (value) { return value; }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }]
                },
                legend: { display: false },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: true,
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            return "Tickets: " + tooltipItem.yLabel;
                        }
                    }
                }
            }
        });
    }

    function fetchTopSubjects(startDate = '', endDate = '') {
        $.ajax({
            url: '../../../backend/admin/ticketing-system/fetch_top_subjects.php',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const labels = [];
                    const counts = [];
                    response.data.forEach(item => {
                        labels.push(item.ticket_subject);
                        counts.push(item.subject_count);
                    });
                    renderChart(labels, counts);
                } else {
                    console.error("No data found");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching top subjects:", error);
            }
        });
    }

    // Hook to filter button (same as your other charts)
    $('#filterBtn').on('click', function () {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        if (!startDate || !endDate) {
            alert("Please select both start and end dates.");
            return;
        }

        fetchTopSubjects(startDate, endDate);
    });

    // Load default (this month)
    const today = new Date();
    const start = new Date(today.getFullYear(), today.getMonth(), 1);
    const end = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    $('#startDate').val(start.toISOString().split('T')[0]);
    $('#endDate').val(end.toISOString().split('T')[0]);

    fetchTopSubjects($('#startDate').val(), $('#endDate').val());
});


$(document).ready(function () {
    function fetchAvgResponse(startDate = '', endDate = '') {
        $.ajax({
            url: '../../../backend/admin/ticketing-system/fetch_avg_response.php',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $("#avgResponseText").text(response.average_response_time);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching avg response:", error);
            }
        });

    }

    // Hook to filter button
    $('#filterBtn').on('click', function () {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        if (!startDate || !endDate) {
            alert("Please select both start and end dates.");
            return;
        }

        fetchAvgResponse(startDate, endDate);
    });

    // Load default (this month)
    const today = new Date();
    const start = new Date(today.getFullYear(), today.getMonth(), 1);
    const end = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    $('#startDate').val(start.toISOString().split('T')[0]);
    $('#endDate').val(end.toISOString().split('T')[0]);

    fetchAvgResponse($('#startDate').val(), $('#endDate').val());
});
