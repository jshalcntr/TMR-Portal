<div class="modal fade" id="createInventoryModal" tabindex="-1" aria-labelledby="createInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="createInventoryModalLabel">Add New Item</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createInventoryForm" class="container needs-validation" novalidate autocomplete="off">
                    <div class="row mb-lg-2">
                        <div class="col">
                            <h4 class="mb-2">Item Details</h4>
                            <div class="mb-2 form-group">
                                <label for="itemType" class="col-form-label">Item Type</label>
                                <select name="itemType" id="itemType" class="form-select form-select-sm" required>
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
                                <label for="itemCategory" class="col-form-label">Item Category</label>
                                <select name="itemCategory" id="itemCategory" class="form-control form-control-sm form-select" required>
                                    <option value="" selected hidden>--Select Item Category--</option>
                                </select>
                                <div class="invalid-feedback">Please Select Item Category</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="itemBrand" class="col-form-label">Item Brand</label>
                                <input type="text" name="itemBrand" id="itemBrand" class="form-control form-control-sm" required></input>
                                <div class="invalid-feedback">Please Input Item Brand</div>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="itemModel" class="col-form-label">Item Model</label>
                                <input type="text" name="itemModel" id="itemModel" class="form-control form-control-sm" required></input>
                                <div class="invalid-feedback">Please Input Item Model</div>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="itemSpecification" class="col-form-label">Item Specification</label>
                                <textarea name="itemSpecification" id="itemSpecification" class="form-control form-control-sm" required></textarea>
                                <div class="invalid-feedback">Please Input Item Specification</div>
                            </div>
                            <hr class="sidebar-divider">
                            <h4 class="mb-2">Item User Information</h4>
                            <div class="mb-2 form-group">
                                <label for="user" class="col-form-label">User Name</label>
                                <input type="text" name="user" id="user" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please Input User Name</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="computerName" class="col-form-label">Computer Name</label>
                                <input type="text" name="computerName" id="computerName" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please Input Computer Name</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="department" class="col-form-label">Department</label>
                                <select name="department" id="department" class="form-select form-select-sm" required>
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
                                <label for="dateAcquired" class="col-form-label">Date Acquired</label>
                                <input type="date" name="dateAcquired" id="dateAcquired" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required>
                                <div class="invalid-feedback">Please Input Date Acquired</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="supplierName" class="col-form-label">Supplier Name</label>
                                <input type="text" name="supplierName" id="supplierName" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please Input Supplier Name</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="serialNumber" class="col-form-label">Serial Number</label>
                                <input type="text" name="serialNumber" id="serialNumber" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please Input Serial Number</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="price" class="col-form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please Input Valid price</div>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="status" class="col-form-label">Status</label>
                                <select name="status" id="status" class="form-select form-select-sm" required value="Active">
                                    <option value="Active">Active</option>
                                </select>
                                <div class="invalid-feedback">Please Select Item Status</div>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="remarks" class="col-form-label">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control form-control-sm"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row action-row">
                        <div class="col d-flex justify-content-end align-items-end">
                            <button type="submit" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-floppy-disk"></i> Add to Inventory</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>