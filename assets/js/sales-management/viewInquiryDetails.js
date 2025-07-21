$(document).ready(function () {
  $("#viewInquiryModal").on("show.bs.modal", function (e) {
    const button = $(e.relatedTarget);
    const inquiryId = button.data("customer-id");
    const customerId = $(this).data("customer-id");
    $.ajax({
      type: "GET",
      url: "../../backend/sales-management/getInquiryDetails.php",
      data: { id: inquiryId },
      success: function (response) {
        console.log("Response:", response);
        if (response.status === "internal-error") {
          Swal.fire({
            title: "Error!",
            text: response.message,
            icon: "error",
            confirmButtonColor: "var(--bs-danger)",
          });
          return;
        }
        const data = response.data;
        $("#customerFirstName_view").val(data.customer_firstname || "");
        $("#customerMiddleName_view").val(data.customer_middlename || "");
        $("#customerLastName_view").val(data.customer_lastname || "");
        $("#province_view").val(data.province || "");
        $("#municipality_view").val(data.municipality || "");
        $("#street_view").val(data.home_address || "");
        $("#contactNumber_view").val(data.contact_number || "");
        $("#gender_view").val(data.gender || "");
        $("#maritalStatus_view").val(data.marital_status || "");
        $("#birthday_view").val(data.birthday || "");
        $("#occupation_view").val(data.occupation || "");
        $("#businessName_view").val(data.business_name || "");
        $("#businessAddress_view").val(data.business_address || "");
        $("#businessCategory_view").val(data.business_category || "");
        $("#income_view").val(data.income || "");
        $("#prospectType_hot_view").val(data.prospect_type || "");
        $("#prospectType_warm_view").val(data.prospect_type || "");
        $("#prospectType_cold_view").val(data.prospect_type || "");
        $("#inquiryDate_view").val(data.inquiry_date || "");
        $("#inquirySource_view").val(data.inquiry_source || "");
        $("#inquirySourceType_view").val(data.inquiry_source_type || "");
        $("#mallDisplay_view").val(data.mall || "");
        $("#buyerType_view").val(data.buyer_type || "");
        $("#unitInquired_view").val(data.unit_inquired || "");
        $("#transactionType_view").val(data.transaction || "");
        $("#hasApplication_view").val(data.has_application || "");
        $("#hasReservation_view").val(data.has_reservation || "");
        $("#reservationDate_view").val(data.reservation_date || "");
        $("#applicationDate_view").val(data.appointment_date || "");
        $("#id_view").val(data.customer_id || "");
      },
      error: function (xhr, status, error) {
        console.error(error);
        Swal.fire({
          title: "Error!",
          text: "Failed to fetch data. Please try again.",
          icon: "error",
          confirmButtonColor: "var(--bs-danger)",
        });
      },
    });
  });

  $(document).on("click", ".viewInquiryDetailsBtn", function () {
    $("#viewInquiryModal").modal("hide");
    $("#viewInquiryModalDetails").modal("show");
  });

  $("#viewInquiryModalDetails").on("hidden.bs.modal", function () {
    $("#viewInquiryModal").modal("show");
  });
});