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
    const ctx = $("#ticketAreaChart");

    function fetchChartData() {
        $.ajax({
            url: '../../../backend/admin/ticketing-system/fetch_closed_tickets.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const chartData = response.data;
                    const labels = [];
                    const ticketCounts = [];

                    $.each(chartData, function (index, item) {
                        // Format date as "Apr 01", "Apr 02", etc.
                        const dateObj = new Date(item.date);
                        const options = { month: 'short', day: '2-digit' };
                        const label = dateObj.toLocaleDateString('en-US', options);
                        labels.push(label);
                        ticketCounts.push(item.ticket_count);
                    });

                    renderChart(ctx, labels, ticketCounts);
                } else {
                    console.error("No data found");
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching chart data:', error);
            }
        });
    }

    function renderChart(ctx, labels, data) {
        new Chart(ctx, {
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
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 31
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function (value) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
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

    fetchChartData();
});
