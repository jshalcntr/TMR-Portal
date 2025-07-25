<div class="modal fade" id="repairItemModal" tabindex="-1" aria-labelledby="repairItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="repairItemModalLabel">Repair Item</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body p-lg-4 container">
                <div class="row">
                    <div class="col-5 d-none" id="noRepairColumn">
                        <form id="repairItemForm" class="needs-validation" novalidate autocomplete="off">
                            <h3>Add To Repair</h3>
                            <div class="mb-2 form-group">
                                <label for="repairDescription" class="col-form-label">Repair Description</label>
                                <input type="text" name="repairDescription" id="repairDescription" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please Input Repair Description</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="gatepassNumber" class="col-form-label">Gatepass Number</label>
                                <input type="text" name="gatepassNumber" id="gatepassNumber" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please Input Gatepass Number</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="repairDate" class="col-form-label">Repair Date</label>
                                <input type="date" name="repairDate" id="repairDate" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="mb-2 form-group d-flex justify-content-end">
                                <button type="submit" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-truck-fast"></i> Repair</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-5 d-none" id="underRepairColumn">
                        <form id="editRepairItemForm" class="needs-validation" novalidate autocomplete="off">
                            <h3>Current Repair</h3>
                            <div class="mb-2 form-group">
                                <label for="repairDescription_edit" class="col-form-label">Repair Description</label>
                                <input type="text" name="repairDescription" id="repairDescription_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">Please Input Repair Description</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="gatepassNumber_edit" class="col-form-label">Gatepass Number</label>
                                <input type="text" name="gatepassNumber" id="gatepassNumber_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">Please Input Gatepass Number</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="repairDate_edit" class="col-form-label">Repair Date</label>
                                <input type="date" name="repairDate" id="repairDate_edit" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required disabled>
                            </div>
                            <div class="mb-2 form-group d-flex justify-content-end action-column" id="viewRepairButtonGroup">
                                <button type="button" id="finishRepairButton" class="btn btn-sm shadow-sm btn-info"><i class="fas fa-circle-check"></i> Finish Repair</button>
                                <button type="button" id="editRepairButton" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-pen"></i> Edit</button>
                            </div>
                            <div class="mb-2 form-group d-none justify-content-end action-column" id="editRepairButtonGroup">
                                <button type="button" id="cancelEditRepairButton" class="btn btn-sm shadow-sm btn-danger"><i class="fas fa-ban"></i> Cancel</button>
                                <button type="submit" id="saveRepairButton" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-floppy-disk"></i> Save</button>
                            </div>
                            <input type="hidden" name="repairId" id="repairId_edit">
                        </form>
                    </div>
                    <div class="col-7">
                        <div class="d-flex justify-content-between align-items-center px-4">
                            <h3>Repair History</h3>
                            <h3>Total Repair/s: <span id="totalRepairs"></span></h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="repairHistoryTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Repair Description</th>
                                        <th scope="col">Gatepass Number</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">Finished Date</th>
                                        <th scope="col">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="repairHistory">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>