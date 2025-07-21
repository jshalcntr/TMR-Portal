$(document).ready(function () {
  $("#subProfilingFormBtn").on("click", function () {
    $("#createSubprofilingForm")[0].reset();
  });
  // ! Hidden input fields for Work Nature
  $("#workNature").on("change", function () {
    const workNature = $(this).val();

    if (workNature === "profession") {
      if ($("#professionRow").hasClass("d-none")) {
        $("#professionRow").removeClass("d-none");
        $("#profession").prop("required", true);
        // $("#jobDemo").prop("required", false);
      }
      if ($("#jobDemoRow").hasClass("d-none")) {
        $("#jobDemoRow").removeClass("d-none");
        $("#jobDemo").prop("required", true);
      }
      if (!$("#businessNatureRow").hasClass("d-none")) {
        $("#businessNatureRow").addClass("d-none");
        $("#jobDemoRow").addClass("d-none");
        $("businessSizeRow").addClass("d-none");
        $("#businessNatureRow").prop("required", false);
        $("#jobDemo").prop("required", false);
        $("#businessSize").prop("required", false);
      }
    } else if (workNature === "businessNature") {
      if ($("#businessNatureRow").hasClass("d-none")) {
        $("#businessNatureRow").removeClass("d-none");
        $("#jobDemoRow").removeClass("d-none");
        $("#businessSizeRow").removeClass("d-none");
        $("#businessSizeRow").prop("required", true);
        $("#jobDemo").prop("required", true);
        $("#businessSize").prop("required", true);
      }
      if (!$("#professionRow").hasClass("d-none")) {
        $("#professionRow").addClass("d-none");
        $("#profession").prop("required", false);
      }
    } else if (workNature === "both") {
      if ($("#professionRow").hasClass("d-none")) {
        $("#professionRow").removeClass("d-none");
        $("#profession").prop("required", true);
      }
      if ($("#businessNatureRow").hasClass("d-none")) {
        $("#businessNatureRow").removeClass("d-none");
        $("#jobDemoRow").removeClass("d-none");
        $("#businessSizeRow").removeClass("required", true);
        $("#businessSizeRow").prop("required", true);
        $("#jobDemo").prop("required", true);
      }
    } else if (workNature === "notApp") {
      if (!$("#businessNatureRow").hasClass("d-none")) {
        $("#businessNatureRow").addClass("d-none");
        $("#jobDemoRow").addClass("d-none");
        $("#businessNatureRow").prop("required", false);
        $("#businessSizeRow").prop("required", false);
        $("#jobDemo").prop("required", false);
      }
      if (!$("#professionRow").hasClass("d-none")) {
        $("#professionRow").addClass("d-none");
        $("#profession").prop("required", false);
      }
    }
  });

  // ! Hidden input fields for Source of Sales
  $("#salesSource").on("change", function () {
    const salesSource = $(this).val();

    if (salesSource === "referral") {
      if ($("#referralRow").hasClass("d-none")) {
        $("#referralRow").removeClass("d-none");
        $("#referralSource").prop("required", true);
      }
      if (!$("#repeatClientRow").hasClass("d-none")) {
        $("#repeatClientRow").addClass("d-none");
        $("#repeatClient").prop("required", false);
      }
      if (!$("#mallDisplayRow").hasClass("d-none")) {
        $("#mallDisplayRow").addClass("d-none");
        $("#mallDisplay").prop("required", false);
      }
    } else if (salesSource === "repeat_client") {
      if ($("#repeatClientRow").hasClass("d-none")) {
        $("#repeatClientRow").removeClass("d-none");
        $("#repeatClient").prop("required", true);
      }
      if (!$("#referralRow").hasClass("d-none")) {
        $("#referralRow").addClass("d-none");
        $("#referralSource").prop("required", false);
      }
      if (!$("#mallDisplayRow").hasClass("d-none")) {
        $("#mallDisplayRow").addClass("d-none");
        $("#mallDisplay").prop("required", false);
      }
    } else if (salesSource === "mall_display") {
      if ($("#mallDisplayRow").hasClass("d-none")) {
        $("#mallDisplayRow").removeClass("d-none");
        $("#mallDisplay").prop("required", true);
      }
      if (!$("#referralRow").hasClass("d-none")) {
        $("#referralRow").addClass("d-none");
        $("#referralSource").prop("required", false);
      }
      if (!$("#repeatClientRow").hasClass("d-none")) {
        $("#repeatClientRow").addClass("d-none");
        $("#repeatClient").prop("required", false);
      }
    } else {
      if (!$("#referralRow").hasClass("d-none")) {
        $("#referralRow").addClass("d-none");
        $("#referralSource").prop("required", false);
      }
      if (!$("#repeatClientRow").hasClass("d-none")) {
        $("#repeatClientRow").addClass("d-none");
        $("#repeatClient").prop("required", false);
      }
      if (!$("#mallDisplayRow").hasClass("d-none")) {
        $("#mallDisplayRow").addClass("d-none");
        $("#mallDisplay").prop("required", false);
      }
    }
  });

  let createSubprofilingValidationTimeout;
  $("#createSubprofilingForm").on("submit", function (e) {
    e.preventDefault();

    if (!this.checkValidity()) {
      e.stopPropagation();
    } else {
      console.log("Goods");
      Swal.fire({
        title: "Create Sub Profile?",
        text: "Are you sure you want to add this sub profile?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "var(--bs-success)",
        cancelButtonColor: "var(--bs-danger)",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = $(this).serialize();
          $.ajax({
            type: "POST",
            url: "../../backend/sales-management/createProfilingForm.php",
            data: formData,
            success: function (response) {
              if (response.status === "success") {
                Swal.fire({
                  title: "Success!",
                  text: `${response.message}`,
                  icon: "success",
                  confirmButtonColor: "var(--bs-success)",
                }).then(() => {
                  setTimeout(() => {
                    subProfileTable.ajax.reload();
                    $("#createSubProfilingModal").modal("hide");
                  }, 150);
                });
              } else if (response.status === "internal-error") {
                Swal.fire({
                  title: "Error!",
                  text: `${response.message}`,
                  icon: "error",
                  confirmButtonColor: "var(--bs-danger)",
                });
              }
            },
            error: function (xhr, status, error) {
              console.log(xhr.responseText);
              console.log(status);
              console.log(error);
              Swal.fire({
                title: "Error!",
                text: "An internal error occurred. Please contact MIS.",
                icon: "error",
                confirmButtonColor: "var(--bs-danger)",
              });
            },
          });
        }
      });
    }
    $(this).addClass("was-validated");
    createSubprofilingValidationTimeout = setTimeout(() => {
      $(this).removeClass("was-validated");
    }, 3000);
  });
});
