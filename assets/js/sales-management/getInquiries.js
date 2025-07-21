$(document).ready(function () {
  $("#prospectTypesTable").DataTable({
    ajax: {
      url: "../../backend/sales-management/getInquiries.php",
      type: "GET",
      dataSrc: "data",
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        console.log("Status:", status);
        console.log("Response Text:", xhr.responseText);
      },
    },
    columns: [
      { data: "customerFirstName" },
      { data: "inquiryDate" },
      { data: "inquirySource" },
      { data: "contactNumber" },
      { data: "gender" },
      { data: "maritalStatus" },
      { data: "birthday" },
      {
        data: "id",
        render: function (data) {
          return `
              <i class="fas fa-circle-info fa-lg text-primary viewInquiryDetailsBtn"
                  role="button"
                  data-bs-toggle="modal"
                  data-bs-target="#viewInquiryModal"
                  data-inquiry-id="${data}"></i>`;
        },
      },
    ],
    destroy: true,
    processing: true,
  });
});
