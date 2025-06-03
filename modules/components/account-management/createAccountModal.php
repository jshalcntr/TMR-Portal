<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="createAccountModalLabel">Create New Account</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body">
                <form id="createAccountForm" class="container needs-validation" novalidate autocomplete="off">
                    <div class="row">
                        <h3 class="h5">Account Details</h3>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="fullName" class="col-form-label">Full Name</label>
                                <input type="text" name="fullName" id="fullName" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">
                                    Full name is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="username" class="col-form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">
                                    Username is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="role" class="col-form-label">Role</label>
                                <select name="role" id="role" class="form-select form-select-sm" required>
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
                                <label for="department" class="col-form-label">Department</label>
                                <select name="department" id="department" class="form-select form-select-sm" required>
                                    <option value="" selected hidden>--Select Department--</option>
                                </select>
                                <div class="invalid-feedback">Please Select Department</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="section" class="col-form-label">Section</label>
                                <select name="section" id="section" class="form-select form-select-sm" required disabled>
                                    <option value="" selected hidden>--Select Section--</option>
                                </select>
                                <div class="invalid-feedback">Please Select Section</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mb-4" id="toggleRow">
                        <div class="line"></div>
                        <p class="h5">Authorizations</p>
                        <button type="button" class="d-flex justify-content-center align-items-center" id="toggleAuthorizationsBtn" data-toggle="collapse" href="#collapseAuthorizations" role="button" aria-expanded="false" aria-controls="collapseAuthorizations"></button>
                    </div>
                    <div class="row mt-2 mb-4 collapse" id="collapseAuthorizations">
                        <div class="col">
                            <div class="row inventory-authorization-row">
                                <p class="h5">Inventory Management</p>
                            </div>
                            <div class="row inventory-authorization-row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inventoryView" name="inventoryView" value="1">
                                        <label class="form-check-label" for="inventoryView">View</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inventoryEdit" name="inventoryEdit" value="1">
                                        <label class="form-check-label" for="inventoryEdit">Edit</label>
                                    </div>
                                </div>
                                <div class="col <?= $authorizations['accounts_super'] ? "" : "d-none" ?>">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inventoryEdit" name="inventorySuper" value="1">
                                        <label class="form-check-label" for="inventorySuper">Super</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row account-authorization-row">
                                <p class="h5">Accounts Management</p>
                            </div>
                            <div class="row account-authorization-row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="accountsView" name="accountsView" value="1">
                                        <label class="form-check-label" for="accountsView">View</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="accountsEdit" name="accountsEdit" value="1">
                                        <label class="form-check-label" for="accountsEdit">Edit</label>
                                    </div>
                                </div>
                                <div class="col <?= $authorizations['accounts_super'] ? "" : "d-none" ?>">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="accountsSuper" name="accountsSuper" value="1">
                                        <label class="form-check-label" for="accountsSuper">Super</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="d-flex justify-content-end actions-group">
                                <button type="submit" class="btn btn-sm shadow-sm btn-primary"><i class="fa-solid fa-user-check"></i> Add User</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>