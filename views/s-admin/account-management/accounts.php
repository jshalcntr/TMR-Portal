<?php
session_start();

require('../../../backend/dbconn.php');
require('../../../backend/middleware/pipes.php');
require('../../../backend/middleware/authorize.php');

if (authorize($_SESSION['user']['role'] == "S-ADMIN")) {
    $authId = $_SESSION['user']['id'];
    $authUsername = $_SESSION['user']['username'];
    $authFullName = $_SESSION['user']['full_name'];
    $authRole = $_SESSION['user']['role'];
    $authPP = $_SESSION['user']['profile_picture'];
    $authDepartment = $_SESSION['user']['department'];

    $authorizations = setAuthorizations($_SESSION['user']);
} else {
    header("Location: ../../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <?php include "../../components/external-css-import.php" ?>
    <link rel="stylesheet" href="../../../assets/css/custom/s-admin/account-management/accounts.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../../components/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include "../../components/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Account Management</h1>
                        <div class="actions-group">

                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Accounts</h6>
                            <?php if ($authorizations['accounts_edit']): ?>
                                <div class="actions-group">
                                    <button class="btn btn-sm btn-primary shadow-sm" id="createAccountModalBtn" data-bs-toggle="modal" data-bs-target="#createAccountModal"><i class="fas fa-user-plus"></i> Create Account</button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="accountsTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Role
                                                <select id="filterRole" class="form-select form-select-sm">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">Department
                                                <select id="filterDepartment" class="form-select form-select-sm">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">Status
                                                <select id="filterStatus" class="form-select form-select-sm">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <?php if ($authorizations['accounts_edit']): ?>
        <div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="createAccountModalLabel">Create New Account</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                                    </div>
                                    <div class="row">
                                        <p class="h5">Accounts Management</p>
                                    </div>
                                    <div class="row">
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
        <div class="modal fade" id="viewAccountModal" tabindex="-1" aria-labelledby="viewAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog">
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
                            <?php if ($authorizations['inventory_edit']): ?>
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
    <?php endif; ?>

</body>
<?php include '../../components/external-js-import.php' ?>
<script src="../../../assets/js/s-admin/account-management/account.js"></script>
<script src="../../../assets/js/s-admin/account-management/viewAccount.js"></script>
<?php if ($authorizations['accounts_edit']): ?>
    <script src="../../../assets/js/s-admin/account-management/addAccount.js"></script>
    <script src="../../../assets/js/s-admin/account-management/editAccount.js"></script>
<?php endif; ?>

</html>