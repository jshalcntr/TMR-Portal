$(document).ready(function () {
    const ctx = $("#avgResolutionChart");
    let avgChart = null;

    // Render chart
    function renderAvgChart(labels, values, readable) {
        if (avgChart) {
            avgChart.destroy();
        }

        avgChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Avg Resolution Time (hrs)",
                    data: values,
                    borderColor: "rgba(28, 200, 138, 1)",
                    backgroundColor: "rgba(28, 200, 138, 0.05)",
                    pointBackgroundColor: "rgba(28, 200, 138, 1)",
                    pointBorderColor: "rgba(28, 200, 138, 1)",
                    pointRadius: 3,
                    pointHoverRadius: 4,
                    lineTension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleFontColor: "#6e707e",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: "index",
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return "Avg Time: " + readable[tooltipItem.index];
                        }
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            callback: function (value) {
                                return value.toFixed(1) + "h"; // show hours with 1 decimal
                            }
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
                legend: {
                    display: false
                }
            }
        });
    }

    // Fetch data
    function fetchAvgResolution(startDate = '', endDate = '') {
        $.ajax({
            url: '../../../backend/s-admin/ticketing-system/fetch_avg_resolution.php',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const labels = [];
                    const values = [];
                    const readable = [];

                    $.each(response.data, function (index, item) {
                        const dateObj = new Date(item.date);
                        const label = dateObj.toLocaleDateString('en-US', { month: 'short', day: '2-digit' });

                        labels.push(label);
                        values.push(item.avg_seconds / 3600); // convert seconds to hours
                        readable.push(item.avg_time); // keep HH:MM:SS for tooltips
                    });

                    renderAvgChart(labels, values, readable);
                } else {
                    console.error("No data found for avg resolution");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching avg resolution:", error);
            }
        });
    }

    // Filter button
    $('#filterBtn').on('click', function () {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        if (!startDate || !endDate) {
            alert("Please select both start and end dates.");
            return;
        }

        fetchAvgResolution(startDate, endDate);
    });

    // Load default (current month)
    const today = new Date();
    const start = new Date(today.getFullYear(), today.getMonth(), 1);
    const end = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    $('#startDate').val(start.toISOString().split('T')[0]);
    $('#endDate').val(end.toISOString().split('T')[0]);

    fetchAvgResolution($('#startDate').val(), $('#endDate').val());

    // Auto-refresh every 1 min
    setInterval(function () {
        fetchAvgResolution($('#startDate').val(), $('#endDate').val());
    }, 60000);
});
