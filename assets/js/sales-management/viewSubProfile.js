$(document).ready(function () {
  $(document).on("click", ".viewSubProfileModal", function (e) {
    e.preventDefault();
    // console.log("HELLO");
    const subProfileId = $(this).data("sub-profile-id");

    $.ajax({
      type: "GET",
      url: "../../backend/sales-management/getSubProfile.php",
      data: { subProfileId },
      success: function (response) {
        if (response.status === "internal-error") {
          Swal.fire({
            title: "Error!",
            text: response.message,
            icon: "error",
            confirmButtonColor: "var(--bs-danger)",
          });
          return;
        }
        const data = response.data[0];
        // Populate all fields, adjust IDs to your modal inputs
        $("#clientFirstName_view").val(data.client_first_name || "");
        $("#clientMiddleName_view").val(data.client_middle_name || "");
        $("#clientLastName_view").val(data.client_last_name || "");
        $("#csNumber_view").val(data.conduction_sticker_number || "");
        $("#inquiryDate_view").val(data.inquiry_date || "");
        $("#phone_view").val(data.phone || "");
        $("#birthDate_view").val(data.birth_date || "");
        $("#gender_view").val(data.gender || "");
        $("#maritalStatus_view").val(data.marital_status || "");
        $("#jobLevel_view").val(data.job_level || "");
        $("#workNature_view").val(data.work_nature || "");
        $("#profession_view").val(data.profession_source || "");
        $("#businessNature_view").val(data.business_nature_source || "");
        $("#jobDemo_view").val(data.job_demo_source || "");
        $("#businessSize_view").val(data.business_size_source || "");
        $("#tamarawRelease_view").val(data.tamaraw_release || "");
        $("#householdIncome_view").val(data.household_income || "");
        $("#salesSource_view").val(data.sales_source || "");
        $("#referralSource_view").val(data.referral_source || "");
        $("#repeatClient_view").val(data.repeat_client_source || "");
        $("#mallDisplay_view").val(data.mall_display_source || "");
        $("#releaseManner_view").val(data.manner_of_release || "");
        $("#releaseDate_view").val(data.release_date || "");
        $("#releaseMode_view").val(data.mode_of_release || "");
        $("#reservationMode_view").val(data.reservation_mode || "");
        $("#far_view").val(data.far || "");
        $("#customerPreference_view").val(data.customer_preference || "");
        $("#tintShade_view").val(data.tint_shade || "");

        // Show modal
        const modal = new bootstrap.Modal(
          document.getElementById("viewSubProfilingModal")
        );
        modal.show();
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
});
