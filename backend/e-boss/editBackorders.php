<?php
require('../dbconn.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "SELECT * FROM backorders_tbl WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_assoc();

    if ($record) {
?>
        <form id="editRecordForm">
            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">RO Number</label>
                        <input type="text" class="form-control" name="ro_number" value="<?php echo htmlspecialchars($record['ro_number']); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" value="<?php echo htmlspecialchars($record['customer_name']); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Order No</label>
                        <input type="text" class="form-control" name="order_no" value="<?php echo htmlspecialchars($record['order_no']); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Source</label>
                        <input type="text" class="form-control" name="source" value="<?php echo htmlspecialchars($record['source']); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Part Number</label>
                        <input type="text" class="form-control" name="part_number" value="<?php echo htmlspecialchars($record['part_number']); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Part Name</label>
                        <input type="text" class="form-control" name="part_name" value="<?php echo htmlspecialchars($record['part_name']); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="qty" value="<?php echo htmlspecialchars($record['qty']); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">BO Price</label>
                        <input type="number" step="0.01" class="form-control" name="bo_price" value="<?php echo htmlspecialchars($record['bo_price']); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select name="order_status" class="form-select">
                            <option value="Pending" <?php if ($record['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Delivered" <?php if ($record['order_status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                            <option value="Cancelled" <?php if ($record['order_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Order Type</label>
                        <input type="text" class="form-control" name="order_type" value="<?php echo htmlspecialchars($record['order_type']); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Service Type</label>
                        <input type="text" class="form-control" name="service_type" value="<?php echo htmlspecialchars($record['service_type']); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Service Estimator</label>
                        <input type="text" class="form-control" name="service_estimator" value="<?php echo htmlspecialchars($record['service_estimator']); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Unit/Model</label>
                        <input type="text" class="form-control" name="unit_model" value="<?php echo htmlspecialchars($record['unit_model']); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Plate No</label>
                        <input type="text" class="form-control" name="plate_no" value="<?php echo htmlspecialchars($record['plate_no']); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Unit Status</label>
                        <input type="text" class="form-control" name="unit_status" value="<?php echo htmlspecialchars($record['unit_status']); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">1st ETA</label>
                        <input type="date" class="form-control" name="eta_1" value="<?php echo $record['eta_1']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">2nd ETA</label>
                        <input type="date" class="form-control" name="eta_2" value="<?php echo $record['eta_2']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">3rd ETA</label>
                        <input type="date" class="form-control" name="eta_3" value="<?php echo $record['eta_3']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Order Date</label>
                        <input type="date" class="form-control" name="order_date" value="<?php echo $record['order_date']; ?>">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" name="remarks" rows="3"><?php echo htmlspecialchars($record['remarks']); ?></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>

        <script>
            $("#editRecordForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "../../backend/e-boss/updateBackorders.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire("Updated!", response.message, "success");
                            $("#editModal").modal("hide");
                            $("#backordersRecordsTable").DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "An error occurred while updating the record.", "error");
                    }
                });
            });
        </script>
<?php
    } else {
        echo "<p class='text-danger'>Record not found.</p>";
    }
}
?>