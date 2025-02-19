<div class="modal fade" id="viewAccountModal" tabindex="-1" aria-labelledby="viewAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="viewAccountModalLabel">Account View</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAccountForm" class="container needs-validation" novalidate autocomplete="off">
                    <div class="row">
                        <h3 class="h5">Account Details</h3>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="fullName_edit" class="col-form-label">Full Name</label>
                                <input type="text" name="fullName" id="fullName_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">
                                    Full name is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="username_edit" class="col-form-label">Username</label>
                                <input type="text" name="username" id="username_edit" class="form-control form-control-sm" required disabled>
                                <div class="invalid-feedback">
                                    Username is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="role_edit" class="col-form-label">Role</label>
                                <select name="role" id="role_edit" class="form-select form-select-sm" required disabled>
                                    <option value="" selected hidden>--Select Role--</option>
                                    <option value="USER">USER</option>
                                    <option value="HEAD">HEAD</option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="S-ADMIN">SUPER ADMIN</option>
                                </select>
                                <div class="invalid-feedback">
                                    Role is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="department_edit" class="col-form-label">Department</label>
                                <select name="department" id="department_edit" class="form-select form-select-sm" required disabled>
                                    <option value="" selected hidden>--Select Department--</option>
                                    <option value="VSA">VSA</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="EOD">EOD</option>
                                    <option value="Service">Service</option>
                                    <option value="Parts & Accessories">Parts and Accessories</option>
                                    <option value="HRAD">HRAD</option>
                                    <option value="F&I">F&I</option>
                                    <option value="Accounting">Accounting</option>
                                    <option value="MIS">MIS</option>
                                    <option value="CRD">CRD</option>
                                </select>
                                <div class="invalid-feedback">Please Select Department</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 mb-4" id="toggleRow">
                        <div class="line"></div>
                        <p class="h5">Authorizations</p>
                        <button type="button" class="d-flex justify-content-center align-items-center" data-toggle="collapse" href="#collapseAuthorizations" role="button" aria-expanded="false" aria-controls="collapseAuthorizations"></button>
                    </div>
                    <div class="row mt-2 mb-4 collapse" id="collapseAuthorizations">
                        <div class="col">
                            <div class="row">
                                <p class="h5">Inventory Management</p>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inventoryView_edit" name="inventoryView" value="1" disabled>
                                        <label clas s="form-check-label" for="inventoryView_edit">View</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inventoryEdit_edit" name="inventoryEdit" value="1" disabled>
                                        <label class="form-check-label" for="inventoryEdit_edit">Edit</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="h5">Accounts Management</p>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="accountsView_edit" name="accountsView" value="1" disabled>
                                        <label class="form-check-label" for="accountsView_edit">View</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="accountsEdit_edit" name="accountsEdit" value="1" disabled>
                                        <label class="form-check-label" for="accountsEdit_edit">Edit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($authorizations['accounts_edit']): ?>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="d-flex justify-content-end actions-group" id="viewAccountActionGroup">
                                    <button type="button" class="btn btn-sm shadow-sm btn-primary" id="editAccountButton"><i class="fas fa-pencil"></i> Edit</button>
                                </div>
                                <div class="d-none justify-content-end actions-group" id="editAccountActionGroup">
                                    <button type="button" class="btn btn-sm shadow-sm btn-danger" id="cancelEditAccountButton"><i class="fas fa-ban"></i> Cancel</button>
                                    <button type="submit" class="btn btn-sm shadow-sm btn-primary" id="saveAccountButton"><i class="fas fa-floppy-disk"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="id" id="id_edit">
                </form>
            </div>
        </div>
    </div>
</div>