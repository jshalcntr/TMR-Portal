document.addEventListener("DOMContentLoaded", function () {
  //Gender Chart
  var genderCtx = document.getElementById("genderChart");
  var genderChart = new Chart(genderCtx, {
    type: "doughnut",
    data: {
      labels: ["Male", "Female", "LGBT+"],
      datasets: [
        {
          data: [0, 0, 0],
          backgroundColor: ["#527eac", "#ff8d92", "#57e4cc"],
          hoverBackgroundColor: ["#456990", "#ef767a", "#49beaa"],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      cutoutPercentage: 50,
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
        display: true,
        position: "bottom",
        labels: {
          fontColor: "#858796",
          boxWidth: 20,
          padding: 10,
        },
      },
    },
  });

  fetch("../../backend/sales-management/getGenderDemo.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const counts = data.gender_counts;
        // console.log(counts);
        const updatedData = [
          counts.gender_male || 0,
          counts.gender_female || 0,
          counts.gender_lgbt || 0,
        ];
        genderChart.data.datasets[0].data = updatedData;
        genderChart.update();
      } else {
        console.error("Failed to load gender data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching gender data:", error);
    });

  // Source of Inquiry Chart
  var sourceCtx = document.getElementById("sourceInquiryChart");
  var sourceChart = new Chart(sourceCtx, {
    type: "doughnut",
    data: {
      labels: ["Online", "Face to Face"],
      datasets: [
        {
          data: [0, 0],
          backgroundColor: ["#ff7d4c", "#f7d38f"],
          hoverBackgroundColor: ["#FE5D26", "#F2C078"],
          hoverBorderColor: "#FFFFFF",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      cutoutPercentage: 50,
      centertext: 2,
      tooltips: {
        backgroundColor: "rgb(255, 255, 255)",
        bodyFontColor: "#858796",
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: true,
        position: "bottom",
        labels: {
          boxWidth: 20,
          padding: 15,
          fontColor: "#858796",
          fontSize: 14,
        },
      },
      // cutoutPercentage: 75,
      // centertext: 2,
    },
  });

  fetch("../../backend/sales-management/getSourceofInquiryDemo.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const counts = data.source_counts;
        const updatedData = [counts.online || 0, counts.face_to_face || 0];
        sourceChart.data.datasets[0].data = updatedData;
        sourceChart.update();
      } else {
        console.error("Failed to load source data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching source data:", error);
    });

  // Market Area Chart
  var marketCtx = document.getElementById("marketAreaChart");
  var marketChart = new Chart(marketCtx, {
    type: "doughnut",
    data: {
      labels: ["PMA", "OPMA"],
      datasets: [
        {
          data: [0, 0],
          backgroundColor: ["#345995", "#EF476F"],
          hoverBackgroundColor: ["#345995", "#ef476f"],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      cutoutPercentage: 50,
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
        display: true,
        position: "bottom",
        labels: {
          boxWidth: 20,
          padding: 15,
          fontColor: "#858796",
          fontSize: 14,
        },
      },
    },
  });

  fetch("../../backend/sales-management/getMarketAreaDemo.php")
    .then((response) => response.json())
    .then((data) => {
      // console.log("Market Area API Response:", data);
      if (data.status === "success" && data.market_area_counts) {
        const counts = data.market_area_counts;
        const updatedData = [Number(counts.PMA) || 0, Number(counts.OPMA) || 0];

        marketChart.data.datasets[0].data = updatedData;
        marketChart.update();
      } else {
        console.error(
          "Failed to load market area data:",
          data.message || "Invalid response structure"
        );
      }
    })
    .catch((error) => {
      console.error("Error fetching market area data:", error);
    });

  // Buyer Type Chart
  var buyerCtx = document.getElementById("buyerTypeChart");
  var buyerChart = new Chart(buyerCtx, {
    type: "doughnut",
    data: {
      labels: ["First-time", "Additional", "Replacement"],
      datasets: [
        {
          data: [0, 0, 0],
          backgroundColor: ["#1cc88a", "#f6c23e", "#36b9cc"],
          hoverBackgroundColor: ["#17a673", "#dda20a", "#2c9faf"],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      cutoutPercentage: 50,
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
        display: true,
        position: "bottom",
        labels: {
          boxWidth: 20,
          padding: 15,
          fontColor: "#858796",
          fontSize: 14,
        },
      },
    },
  });

  fetch("../../backend/sales-management/getBuyerTypeDemo.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const counts = data.buyer_type_counts;

        const labelMap = {
          first_time: "First-Time",
          additional: "Additional",
          replacement: "Replacement",
        };

        const orderedKeys = ["first_time", "additional", "replacement"];
        const updatedLabels = orderedKeys.map((key) => labelMap[key]);
        const updatedData = orderedKeys.map((key) =>
          counts[key] !== undefined
            ? counts[key] === 0
              ? 0.00001
              : counts[key]
            : 0.00001
        );

        if (buyerChart && buyerChart.data) {
          buyerChart.data.labels = updatedLabels;
          buyerChart.data.datasets[0].data = updatedData;
          buyerChart.update();
        } else {
          console.error("buyerChart is not initialized or missing .data");
        }
      } else {
        console.error("Failed to load buyer type data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching buyer type data:", error);
    });

  // Age Group Chart
  var ageCtx = document.getElementById("ageChart");
  var ageChart = new Chart(ageCtx, {
    type: "doughnut",
    data: {
      labels: ["20-below", "21-30", "31-40", "41-50", "51-above"],
      datasets: [
        {
          data: [0, 0, 0, 0, 0],
          backgroundColor: [
            "#F6C23E",
            "#1CC88A",
            "#FF7D4C",
            "#57E4CC",
            "#FF8D92",
          ],
          hoverBackgroundColor: [
            "#DDA20A",
            "#17A673",
            "#FE5D26",
            "#49BEAA",
            "#EF767A",
          ],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      cutoutPercentage: 50,
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
        display: true,
        position: "bottom",
        labels: {
          boxWidth: 20,
          padding: 15,
          fontColor: "#858796",
          fontSize: 14,
        },
      },
    },
  });

  fetch("../../backend/sales-management/getAgeDemo.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const counts = data.age_bracket_counts;
        const updatedData = [
          counts.age_20_and_below || 0,
          counts.age_21_30 || 0,
          counts.age_31_40 || 0,
          counts.age_41_50 || 0,
          counts.age_51_and_above || 0,
        ];
        ageChart.data.datasets[0].data = updatedData;
        ageChart.update();
      } else {
        console.error("Failed to load age data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching age data:", error);
    });
});
