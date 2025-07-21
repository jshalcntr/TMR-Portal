// Set new default font family and font color to mimic Bootstrap's default styling
// (Chart.defaults.global.defaultFontFamily = "Nunito"),
//   '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
// Chart.defaults.global.defaultFontColor = "#858796";

// Pie Chart Example
var democtx = document.getElementById("myPieChart");
var myPieChart = new Chart(democtx, {
  type: "doughnut",
  data: {
    labels: ["Direct", "Referral", "Social", "SAMPLE"],
    datasets: [
      {
        data: [55, 30, 15, 40],
        backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc", "#C7DCA7"],
        hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf", "#C7DCA7"],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      },
    ],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: "#dddfeb",
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false,
    },
    cutoutPercentage: 80,
  },
});
