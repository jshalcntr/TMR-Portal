<div class="modal fade" id="addBackorderModal" tabindex="-1" aria-labelledby="addBackorderLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addBackorderLabel">Add Backorder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBackorderForm" method="post">
                <div class="modal-body row g-3">

                    <!-- COMMON FIELDS -->
                    <div class="col-md-4">
                        <label class="form-label">RO Number</label>
                        <input type="text" class="form-control" name="ro_number" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Order Date</label>
                        <input type="date" class="form-control" name="order_date" required max="<?= date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Order No</label>
                        <input type="text" class="form-control" name="order_no" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Source</label>
                        <input type="text" class="form-control" name="source" required>
                    </div>
                    <!-- DYNAMIC PARTS FIELDS -->
                    <div class="col-12">
                        <label class="form-label fw-bold">Parts</label>
                        <div id="parts-wrapper">
                            <div class="row g-2 mb-2 part-row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="part_number[]" placeholder="Part Number" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="part_name[]" placeholder="Part Name" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" name="qty[]" placeholder="Qty" required>
                                </div>
                                <div class="col-md-3 d-flex">
                                    <input type="number" step="0.01" class="form-control" name="bo_price[]" placeholder="BO Price" required>
                                    <button type="button" class="btn btn-outline-secondary btn-sm ms-2 removePartRow" style="display:none;"><i class="fa fa-trash fa-sm"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr class="short-line hidden-xs">
                        <button type="button" class="btn btn-sm btn-outline-secondary float-end" id="addPartRow">+</button>
                    </div>


                    <!-- OTHER FIELDS -->
                    <div class="col-md-3">
                        <label class="form-label">1st ETA</label>
                        <input type="date" class="form-control" name="eta_1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label d-block">Order Type</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="order_type" id="order_type_counter" value="Counter" required>
                            <label class="form-check-label" for="order_type_counter">Counter</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="order_type" id="order_type_accessories" value="Accessories">
                            <label class="form-check-label" for="order_type_accessories">Accessories</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="order_type" id="order_type_chemical" value="Chemical">
                            <label class="form-check-label" for="order_type_chemical">Chemical</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="order_type" id="order_type_soq" value="S.O.Q.">
                            <label class="form-check-label" for="order_type_soq">S.O.Q.</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="service_type" class="form-label">Service Type</label>
                        <select class="form-select" name="service_type" id="service_type" required>
                            <option value="">-- Select Service Type --</option>
                            <option value="SERVICE BP">SERVICE BP</option>
                            <option value="SERVICE GJ">SERVICE GJ</option>
                            <option value="SERVICE WARRANTY">SERVICE WARRANTY</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">SA / SE</label>
                        <select class="form-control" name="service_estimator" id="service_estimator" required>
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unit/Model</label>
                        <input type="text" class="form-control" name="unit_model">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Plate No</label>
                        <input type="text" class="form-control" name="plate_no">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Remarks</label>
                        <input type="text" class="form-control" name="remarks">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="UNIT IN">UNIT IN</option>
                            <option value="UNIT OUT">UNIT OUT</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>