<div class="modal fade" id="viewInventoryModal" tabindex="-1" aria-labelledby="viewInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="viewInventoryModalLabel">Item View | Asset #: <span id="assetNumber_edit"></span></h3>
                <div class="header-actions d-flex align-items-center" style="gap: 8px;">
                    <?php if ($authorizations['inventory_edit'] && !$authorizations['inventory_super']): ?>
                        <button type="button" class="btn btn-circle shadow-sm btn-info" id="requestChangesBtn" role="button" data-bs-placement="bottom" title="Request Changes" data-bs-target="#requestChangesModal" data-bs-toggle="tooltip"><i class="fa-solid fa-comment-pen"></i></button>
                    <?php endif; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-xl-3">
                <form id="editInventoryForm" class="container needs-validation" novalidate autocomplete="off">
                    <div class="row mb-lg-3">
                        <div class="col">
                            <h4 class="mb-2">Item Details</h4>
                            <div class="mb-2 form-group">
                                <label for="itemType_edit" class="col-form-label">Item Type</label>
                                <select name="itemType" id="itemType_edit" class="form-select form-select-sm" required disabled>
                                    <option value="" selected hidden>--Select Item Type--</option>
                                    <option value="Computer System">Computer System</option>
                                    <option value="Computer Hardware">Computer Hardware</option>
                                    <option value="Computer Peripherals">Computer Peripherals</option>
                                    <option value="Network Peripherals">Network Peripherals</option>
                                    <option value="Audio & Visual Devices">Audio & Visual Devices</option>
                                    <option value="MIS Tools">MIS Tools</option>
                                </select>
                                <div class="invalid-feedback">Please Select Item Type</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="itemCategory_edit" class="col-form-label">Item Category</label>
                                <select name="itemCategory" id="itemCategory_edit" class="form-select form-select-sm" disabled required>

                                </select>
                                <div class="invalid-feedback">Please Select Item Category</div>
                            </div>

                            <div class="mb-2 form-group">
                                <label for="itemBrand_edit" class="col-form-label">Item Brand</label>
                                <input type="text" name="itemBrand" id="itemBrand_edit" class="form-control form-control-sm" required disabled></input>
                                <div class="invalid-feedback">Please Input Item Brand</div>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="itemModel_edit" class="col-form-label">Item Model</label>
                                <input type="text" name="itemModel" id="itemModel_edit" class="form-control form-control-sm" required disabled></input>
                                <div class="invalid-feedback">Please Input Item Model</div>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="itemSpecification_edit" class="col-form-label">Item Specification</label>
                                <textarea name="itemSpecification" id="itemSpecification_edit" class="form-control form-control-sm" required disabled></textarea>
                                <div class="invalid-feedback">Please Input Item Specification</div>
                            </div>
                            <hr class="sidebar-divider">
                            <h4 class="mb-2">Item User Information</h4>
                            <div class="mb-2 form-group">
                                <label for="user_edit" class="col-form-label">User Name</label>
                                <input type="text" name="user" id="user_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">Please Input User Name</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="computerName_edit" class="col-form-label">Computer Name</label>
                                <input type="text" name="computerName" id="computerName_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">Please Input Computer Name</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="department_edit" class="col-form-label">Department</label>
                                <select name="department" id="department_edit" class="form-select form-select-sm" required disabled>
                                    <option value="" selected hidden>--Select Department--</option>
                                    <option value="VSA">VSA</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="EOD">EOD</option>
                                    <option value="SVC">SVC</option>
                                    <option value="PARTS">PARTS</option>
                                    <option value="HRAD">HRAD</option>
                                    <option value="F&I">F&I</option>
                                    <option value="Accounting">Accounting</option>
                                    <option value="MIS">MIS</option>
                                    <option value="CRD">CRD</option>
                                    <option value="Undeployed">Undeployed</option>
                                </select>
                                <div class="invalid-feedback">Please Select Department</div>
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="mb-2">Supply Details</h4>
                            <div class="mb-2 form-group">
                                <label for="dateAcquired_edit" class="col-form-label">Date Acquired</label>
                                <input type="date" name="dateAcquired" id="dateAcquired_edit" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>" required disabled>
                                <div class="invalid-feedback">Please Input Date Acquired</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="supplierName_edit" class="col-form-label">Supplier Name</label>
                                <input type="text" name="supplierName" id="supplierName_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">Please Input Supplier Name</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="serialNumber_edit" class="col-form-label">Serial Number</label>
                                <input type="text" name="serialNumber" id="serialNumber_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">Please Input Serial Number</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="price_edit" class="col-form-label">Price</label>
                                <input type="number" name="price" id="price_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">Please Input Valid price</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="status_edit" class="col-form-label">Status</label>
                                <select name="status" id="status_edit" class="form-select form-select-sm" required disabled>
                                    <option value="" hidden>--Select Item Status--</option>
                                    <option value="Active">Active</option>
                                    <option value="Under Repair" hidden>Under Repair</option>
                                    <option value="Repaired">Repaired</option>
                                    <option value="Retired">Retired</option>
                                </select>
                                <div class="invalid-feedback">Please Select Item Status</div>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="remarks_edit" class="col-form-label">Remarks</label>
                                <textarea name="remarks" id="remarks_edit" class="form-control form-control-sm" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <?php if ($authorizations['inventory_edit']): ?>
                        <div class="row action-row">
                            <div class="col d-flex justify-content-end align-items-end action-column" id="viewActionsRow">
                                <button type="button" class="btn btn-sm shadow-sm btn-danger" id="retireInventoryButton"><i class="fas fa-calendar-xmark"></i> Retire</button>
                                <button type="button" class="btn btn-sm shadow-sm btn-warning" id="repairButton"><i class="fas fa-screwdriver-wrench"></i> Repair</button>
                                <button type="button" class="btn btn-sm shadow-sm btn-primary" id="editButton"><i class="fas fa-pencil"></i> Edit</button>
                            </div>
                            <div class="col d-none justify-content-end align-items-end action-column" id="editActionsRow">
                                <button type="button" class="btn btn-sm shadow-sm btn-danger" id="cancelButton"><i class="fas fa-ban"></i> Cancel</button>
                                <button type="submit" class="btn btn-sm shadow-sm btn-primary" id="saveButton"><i class="fas fa-floppy-disk"></i> Save</button>
                            </div>
                            <div class="col d-none justify-content-end align-items-end action-column" id="retiredActionsRow1">
                                <button type="button" class="btn btn-sm shadow-sm btn-danger" id="disposeButton"><i class="fas fa-dumpster"></i> Dispose</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="id" id="id_edit">
                </form>
            </div>
        </div>
    </div>
</div>