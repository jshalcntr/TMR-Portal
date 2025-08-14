Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = thousands_sep || ',',
        dec = dec_point || '.',
        s = '',
        toFixedFix = function (n, prec) {
            return (Math.round(n * Math.pow(10, prec)) / Math.pow(10, prec)).toString();
        };
    s = (prec ? toFixedFix(n, prec) : Math.round(n).toString()).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = (s[1] || '') + '0'.repeat(prec - s[1].length);
    }
    return s.join(dec);
}

$(document).ready(function () {
    let lineChartInstance = null;
    let pieChartInstance = null;

    const lineCtx = $("#ticketAreaChart");
    const pieCtx = document.getElementById('ticketPieChart').getContext('2d');

    function renderLineChart(labels, data) {
        if (lineChartInstance) lineChartInstance.destroy();

        lineChartInstance = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Closed Tickets (Daily)",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: data,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
                scales: {
                    xAxes: [{ gridLines: { display: false }, ticks: { maxTicksLimit: 31 } }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: value => number_format(value)
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
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
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    }

    function renderPieChart(labels, data) {
        if (pieChartInstance) pieChartInstance.destroy();

        pieChartInstance = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Closed Tickets',
                    data: data,
                    backgroundColor: [
                        'rgba(78, 115, 223, 0.7)', 'rgba(28, 200, 138, 0.7)', 'rgba(54, 185, 204, 0.7)',
                        'rgba(246, 194, 62, 0.7)', 'rgba(231, 74, 59, 0.7)', 'rgba(133, 135, 150, 0.7)',
                        'rgba(93, 123, 247, 0.7)', 'rgba(255, 99, 132, 0.7)', 'rgba(102, 102, 255, 0.7)',
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
                    legend: { display: true, position: 'top' },
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

    function fetchLineChartData(startDate = '', endDate = '') {
        $.ajax({
            url: '../../../backend/admin/ticketing-system/fetch_closed_tickets.php',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const labels = response.data.map(item => {
                        const dateObj = new Date(item.date);
                        return dateObj.toLocaleDateString('en-US', { month: 'short', day: '2-digit' });
                    });
                    const data = response.data.map(item => item.ticket_count);
                    renderLineChart(labels, data);
                } else {
                    console.error("Line chart: No data found");
                }
            },
            error: function (xhr, status, error) {
                console.error('Line chart error:', error);
            }
        });
    }

    function fetchPieChartData(startDate = '', endDate = '') {
        $.ajax({
            url: '../../../backend/admin/ticketing-system/fetch_tickets_by_department.php',
            method: 'GET',
            data: { start_date: startDate, end_date: endDate },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const labels = response.data.map(item => item.department);
                    const data = response.data.map(item => item.ticket_count);
                    renderPieChart(labels, data);
                } else {
                    console.error("Pie chart: No data found");
                }
            },
            error: function (xhr, status, error) {
                console.error('Pie chart error:', error);
            }
        });
    }

    function applyDateFilter() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        if (!startDate || !endDate) {
            alert("Please select both start and end dates.");
            return;
        }

        fetchLineChartData(startDate, endDate);
        fetchPieChartData(startDate, endDate);
    }

    $('#filterBtn').on('click', applyDateFilter);

    // Auto-load current month by default
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    $('#startDate').val(firstDay.toISOString().split('T')[0]);
    $('#endDate').val(lastDay.toISOString().split('T')[0]);

    fetchLineChartData($('#startDate').val(), $('#endDate').val());
    fetchPieChartData($('#startDate').val(), $('#endDate').val());
});
