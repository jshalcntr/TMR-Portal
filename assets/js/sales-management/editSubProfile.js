$(document).ready(function () {
  $(document).on("click", ".viewSubProfileModal", function (e) {
    e.preventDefault();
    console.log("Hi");
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

        console.log("document ready");
        $("#editSubprofilingForm")
          .find("input, select, textarea")
          .not("[type=hidden]")
          .prop("disabled", true);

        $("#editActionsRow").addClass("d-none");
        $("#viewActionsRow").removeClass("d-none");

        $("#editSubprofilingForm").data("subProfileId", subProfileId);
      },
      error: function () {
        Swal.fire({
          title: "Error!",
          text: "Failed to fetch data. Please try again.",
          icon: "error",
          confirmButtonColor: "var(--bs-danger)",
        });
      },
    });

    $(document).on("click", "#editButton", function () {
      $("#editSubprofilingForm")
        .find("input, select, textarea")
        .not("[type=hidden]")
        .prop("disabled", false);

      $("#viewActionsRow").addClass("d-none");
      $("#editActionsRow").removeClass("d-none");
    });

    $(document).on("click", "#cancelButton", function () {
      $("#editSubprofilingForm")
        .find("input, select, textarea")
        .not("[type=hidden]")
        .prop("disabled", true);

      $("#editActionsRow").addClass("d-none");
      $("#viewActionsRow").removeClass("d-none");
    });
  });

  $("#editButton").on("click", function () {
    $("#clientFirstName_view").prop(
      "disabled",
      !$("#clientFirstName_view").prop("disabled")
    );
    $("#clientMiddleName_view").prop(
      "disabled",
      !$("#clientMiddleName_view").prop("disabled")
    );
    $("#clientLastName_view").prop(
      "disabled",
      !$("#clientLastName_view").prop("disabled")
    );
    $("#inquiryDate_view").prop(
      "disabled",
      !$("#inquiryDate_view").prop("disabled")
    );
    $("#phone_view").prop("disabled", !$("#phone_view").prop("disabled"));
    $("#birthDate_view").prop(
      "disabled",
      !$("#birthDate_view").prop("disabled")
    );
    $("#gender_view").prop("disabled", !$("#gender_view").prop("disabled"));
    $("#maritalStatus_view").prop(
      "disabled",
      !$("#maritalStatus_view").prop("disabled")
    );
    $("#jobLevel_view").prop("disabled", !$("#jobLevel_view").prop("disabled"));
    $("#workNature_view").prop(
      "disabled",
      !$("#workNature_view").prop("disabled")
    );
    $("#profession_view").prop(
      "disabled",
      !$("#profession_view").prop("disabled")
    );
    $("#businessNature_view").prop(
      "disabled",
      !$("#businessNature_view").prop("disabled")
    );
    $("#tamarawRelease_view").prop(
      "disabled",
      !$("#tamarawRelease_view").prop("disabled")
    );
    $("#householdIncome_view").prop(
      "disabled",
      !$("#householdIncome_view").prop("disabled")
    );
    $("#salesSource_view").prop(
      "disabled",
      !$("#salesSource_view").prop("disabled")
    );
    $("#referralSource_view").prop(
      "disabled",
      !$("#referralSource_view").prop("disabled")
    );
    $("#repeatClient_view").prop(
      "disabled",
      !$("#repeatClient_view").prop("disabled")
    );

    $("#mallDisplay_view").prop(
      "disabled",
      !$("#mallDisplay_view").prop("disabled")
    );
    $("#releaseManner_view").prop(
      "disabled",
      !$("#releaseManner_view").prop("disabled")
    );
    $("#releaseDate_view").prop(
      "disabled",
      !$("#releaseDate_view").prop("disabled")
    );
    $("#releaseMode_view").prop(
      "disabled",
      !$("#releaseMode_view").prop("disabled")
    );
    $("#reservationMode_view").prop(
      "disabled",
      !$("#reservationMode_view").prop("disabled")
    );
    $("#far_view").prop("disabled", !$("#far_view").prop("disabled"));
    $("#customerPreference_view").prop(
      "disabled",
      !$("#customerPreference_view").prop("disabled")
    );
    $("#tintShade_view").prop(
      "disabled",
      !$("#tintShade_view").prop("disabled")
    );
  });

  $(document).on("click", "#cancelButton", function () {
    console.log("hi helloo");
    $("#editSubprofilingForm")
      .find("input, select, textarea")
      .not("[type=hidden]")
      .prop("disabled", true);

    $("#editActionsRow").addClass("d-none");
    $("#viewActionsRow").removeClass("d-none");
  });

  let editSubprofilingTimeout;
  $("#editSubprofilingForm").on("submit", function (e) {
    e.preventDefault();

    if (editSubprofilingTimeout) {
      $("#editSubprofilingForm").removeClass("was-validated");
    }

    if (!this.checkValidity()) {
      // form.reportValidity();

      // $("#createSubprofilingForm")
      //   .find("input, select, textarea")
      //   .not("[type-hidden]")
      //   .prop("disabled", true);
      // return;
      e.stopPropagation();
    } else {
      const formData = $(this).serialize();

      Swal.fire({
        title: "Save changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "Cancel",
      }).then((result) => {
        // console.log(formData);
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../../backend/sales-management/editSubProfile.php",
            data: formData,
            success: function (response) {
              if (response.status === "success") {
                Swal.fire({
                  title: "Success!",
                  text: response.message,
                  icon: "success",
                  confirmButtonColor: "var(--bs-success)",
                });

                $("#editSubprofilingForm")
                  .find("input, select, textarea")
                  .not("[type=hidden]")
                  .prop("disabled", true);

                const form = $("#editSubprofilingForm")[0];

                $("#editActionsRow").addClass("d-none");
                $("#viewActionsRow").removeClass("d-none");
              } else {
                Swal.fire({
                  title: "Error!",
                  text: response.message,
                  icon: "error",
                  confirmButtonColor: "var(--bs-danger)",
                });
              }
            },
            error: function () {
              Swal.fire({
                title: "Error!",
                text: "Failed to save changes. Please try again.",
                icon: "error",
                confirmButtonColor: "var(--bs-danger)",
              });
            },
          });
        }
      });
    }
    $(this).addClass("was-validated");
    addToGroupValidationTimeout = setTimeout(function () {
      $("#editSubprofilingForm").removeClass("was-validated");
    }, 5000);

    $(document).on("submit", "#editSubprofilingForm", function (e) {
      console.log("Form submit triggered");
    });
  });

  $(document).ready(function () {
    $("#editButton").on("click", function () {
      $(this).hide();
      $("#saveButton, #cancelButton").show();
    });

    $("#cancelButton").on("click", function () {
      $("#editButton").show();
      $("#saveButton, #cancelButton").hide();
    });

    $("#saveButton").on("click", function () {
      $("#editButton").show();
      $("#saveButton, #cancelButton").hide();
    });

    $("#saveButton, #cancelButton").hide();
  });
});
