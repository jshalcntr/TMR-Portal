$(document).ready(function () {
    // Add new part row
    $("#addPartRow").on("click", function () {
        let newRow = `
            <div class="row g-2 mb-2 part-row">
                <div class="col-md-3"><input type="text" class="form-control" name="part_number[]" placeholder="Part Number" required></div>
                <div class="col-md-3"><input type="text" class="form-control" name="part_name[]" placeholder="Part Name" required></div>
                <div class="col-md-3"><input type="number" class="form-control" name="qty[]" placeholder="Qty" required></div>
                <div class="col-md-3 d-flex">
                    <input type="number" step="0.01" class="form-control" name="bo_price[]" placeholder="BO Price" required>
                    <button type="button" class="btn btn-outline-secondary btn-sm ms-2 removePartRow"><i class="fa fa-trash fa-sm"></i></button>
                </div>
            </div>`;
        $("#parts-wrapper").append(newRow);
        toggleRemoveButtons();
    });

    // Remove part row
    $(document).on("click", ".removePartRow", function () {
        $(this).closest(".part-row").remove();
        toggleRemoveButtons();
    });

    // Ensure only extra rows have remove button visible
    function toggleRemoveButtons() {
        let rows = $("#parts-wrapper .part-row");
        rows.find(".removePartRow").hide();
        if (rows.length > 1) {
            rows.find(".removePartRow").show();
        }
    }

    // Submit form
    $("#addBackorderForm").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "../../backend/e-boss/addBackorders.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $("#addBackorderModal").modal("hide");
                    $("#addBackorderForm")[0].reset();
                    // Reset parts wrapper to one row only
                    $("#parts-wrapper").html($("#parts-wrapper .part-row").first().prop("outerHTML"));
                    toggleRemoveButtons();
                    $('#backordersRecordsTable').DataTable().ajax.reload();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message
                    });
                }
            }
        });
    });

    // Run on load
    toggleRemoveButtons();
});
