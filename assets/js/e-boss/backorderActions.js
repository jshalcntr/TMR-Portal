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
        
        // Reset form
        $("#updateEtaForm")[0].reset();
        $("#etaRecordId").val(id);
        $("#etaType").val(etaType);
        $("#confirmExtension").val(confirmExtension);
        
        // Set modal title
        $("#etaModalTitle").text("Update ETA");
        $("#etaSubmitBtn").text("Update ETA");
        
        // Get current ETA date from the button's data attribute and add 15 days
        let currentEtaDate = $(this).data("current-eta");
        if (currentEtaDate) {
            // Add 15 days to current ETA
            let currentDate = new Date(currentEtaDate);
            currentDate.setDate(currentDate.getDate() + 15);
            
            // Format as YYYY-MM-DD
            let newEtaDate = currentDate.toISOString().split('T')[0];
            $("#etaDate").val(newEtaDate);
        }
        
        $("#updateEtaModal").modal("show");
    });

    $("#updateEtaForm").submit(function (e) {
        e.preventDefault();
        
        $.ajax({
            url: "../../backend/e-boss/updateEta.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    let message = response.message || "ETA has been updated successfully.";
                    Swal.fire("Success!", message, "success");
                    $("#updateEtaModal").modal("hide");
                    $("#backordersRecordsTable").DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire("Error!", response.message || "Something went wrong.", "error");
                }
            },
            error: function() {
                Swal.fire("Error!", "Something went wrong.", "error");
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
