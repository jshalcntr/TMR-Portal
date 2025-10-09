$(document).ready(function () {

    // ===== View Button =====
    $(document).on("click", ".viewBtn", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "../../backend/e-boss/viewBackorders.php",
            type: "POST",
            data: { id: id },

            success: function (response) {
                $("#viewDetailsContainer").html(response);
                $("#printViewBtn").show();
                $("#viewModal").modal("show");
            }
        });
    });

    // ===== Print View Button =====
    $(document).on("click", "#printViewBtn", function () {
        let printContent = $("#viewDetailsContainer").html();
        let printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Backorder Details - Print</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
                    <style>
                        @media print {
                            .btn { display: none !important; }
                            .modal-footer { display: none !important; }
                        }
                        .card { margin-bottom: 1rem; }
                        .badge { font-size: 0.75em; }
                    </style>
                </head>
                <body>
                    <div class="container-fluid">
                        <h2 class="text-center mb-4"><i class="fas fa-file-alt"></i> Backorder Details</h2>
                        ${printContent}
                    </div>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    });

    // ===== Edit Button =====
    $(document).on("click", ".editBtn", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "../../backend/e-boss/editBackorders.php",
            type: "POST",
            data: { id: id },
            success: function (response) {
                $("#editFormContainer").html(response);
                $("#editModal").modal("show");
            }
        });
    });

    // ===== Update ETA Button =====
    $(document).on("click", ".updateEtaBtn", function () {
        let id = $(this).data("id");
        let etaType = $(this).data("eta-type") || "eta_1";
        let confirmExtension = $(this).data("confirm-extension") || false;
        let $btn = $(this);

        // Reset form
        $("#updateEtaForm")[0].reset();
        $("#etaRecordId").val(id);
        $("#etaType").val(etaType);
        $("#confirmExtension").val(confirmExtension);

        // Set modal title based on ETA type
        let etaTypeText = etaType.replace('_', ' ').toUpperCase();
        $("#etaModalTitle").text(`Update ${etaTypeText}`);
        $("#etaSubmitBtn").text("Update ETA");

        // Get current ETA date from the button's data attribute
        let currentEtaDate = $(this).data("current-eta");
        if (currentEtaDate) {
            // Add 15 days to current ETA
            let currentDate = new Date(currentEtaDate);
            let suggestedDate = new Date(currentDate);
            suggestedDate.setDate(currentDate.getDate() + 15);

            // Format as YYYY-MM-DD
            let newEtaDate = suggestedDate.toISOString().split('T')[0];
            $("#etaDate").val(newEtaDate);

            // Show current and suggested dates
            $("#currentEtaInfo").html(`
                <div class="alert alert-info">
                    <strong>Current ETA:</strong> ${currentDate.toLocaleDateString()}<br>
                    <strong>Suggested New ETA:</strong> ${suggestedDate.toLocaleDateString()} (+ 15 days)<br>
                    <small>You can modify the date if needed, maximum 90 days from today.</small>
                </div>
            `);
        }

        // Set max date (90 days from today)
        let maxDate = new Date();
        maxDate.setDate(maxDate.getDate() + 90);
        $("#etaDate").attr('max', maxDate.toISOString().split('T')[0]);

        // Show modal
        $("#updateEtaModal").modal("show");
    });

    $("#updateEtaForm").submit(function (e) {
        e.preventDefault();

        // Disable submit button and show loading state
        let $submitBtn = $("#etaSubmitBtn");
        let originalText = $submitBtn.text();
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: "../../backend/e-boss/updateEta.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    let message = response.message || "ETA has been updated successfully.";
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $("#updateEtaModal").modal("hide");
                        $("#backordersRecordsTable").DataTable().ajax.reload(null, false);
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message || "Something went wrong.",
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function (xhr) {
                let errorMessage = "Something went wrong.";
                try {
                    let response = JSON.parse(xhr.responseText);
                    errorMessage = response.message || errorMessage;
                } catch (e) { }

                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: errorMessage,
                    confirmButtonColor: '#d33'
                });
            },
            complete: function () {
                // Re-enable submit button
                $submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // ===== Delete Button =====
    $(document).on("click", ".deleteBtn", function () {
        let id = $(this).data("id");
        Swal.fire({
            title: "Are you sure?",
            text: "This record will be deleted permanently.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../backend/e-boss/deleteBackorders.php",
                    type: "POST",
                    data: { id: id },
                    success: function (response) {
                        Swal.fire("Deleted!", "The record has been deleted.", "success");
                        $("#backordersRecordsTable").DataTable().ajax.reload(null, false);
                    }
                });
            }
        });
    });

    // Reject / Cancel
    $(document).on("click", ".rejectBtn", function () {
        let id = $(this).data("id");

        Swal.fire({
            title: "Reject / Cancel",
            text: "Please provide a reason for cancellation:",
            input: "text",
            inputPlaceholder: "Enter reason...",
            inputAttributes: {
                required: "true"
            },
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Submit",
            cancelButtonText: "Cancel",
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage("Reason is required!");
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let reason = result.value;

                $.post("../../backend/e-boss/cancelBackorders.php", { id: id, reason: reason }, function (resp) {
                    if (resp === "success") {
                        Swal.fire("Cancelled!", "Record marked as Cancelled.", "success");
                        $("#backordersRecordsTable").DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    }
                });
            }
        });
    });


    // Delivered
    $(document).on("click", ".deliveredBtn", function () {
        let id = $(this).data("id");

        Swal.fire({
            title: "Mark as Delivered?",
            text: "This record will be marked as Delivered.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, delivered!",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("../../backend/e-boss/deliverBackorders.php", { id: id }, function (resp) {
                    if (resp === "success") {
                        Swal.fire("Delivered!", "Record marked as Delivered.", "success");
                        $("#backordersRecordsTable").DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    }
                });
            }
        });
    });

});
