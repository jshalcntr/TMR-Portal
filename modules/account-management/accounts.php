<?php
session_start();

require('../../vendor/autoload.php');
require('../../backend/dbconn.php');
require('../../backend/middleware/pipes.php');
require('../../backend/middleware/authorize.php');

if (authorize(true, $conn)) {
    $authId = $_SESSION['user']['id'];
    $authUsername = $_SESSION['user']['username'];
    $authFullName = $_SESSION['user']['full_name'];
    $authRole = $_SESSION['user']['role'];
    $authPP = $_SESSION['user']['profile_picture'];
    $authDepartment = $_SESSION['user']['department'];

    $authorizations = setAuthorizations($_SESSION['user']);
} else {
    header("Location: ../../index.php");
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

    <?php include "../components/shared/external-css-import.php" ?>
    <link rel="stylesheet" href="../../assets/css/custom/account-management/accounts.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../components/shared/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include "../components/shared/topbar.php" ?>

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
        <?php include '../components/account-management/createAccountModal.php'; ?>
    <?php endif; ?>
    <?php include '../components/account-management/viewAccountModal.php'; ?>

</body>

<?php include '../components/shared/external-js-import.php' ?>
<script src="../../assets/js/account-management/account.js"></script>
<script src="../../assets/js/account-management/viewAccount.js"></script>
<?php if ($authorizations['accounts_edit']): ?>
    <script src="../../assets/js/account-management/addAccount.js"></script>
    <script src="../../assets/js/account-management/editAccount.js"></script>
<?php endif; ?>

</html>