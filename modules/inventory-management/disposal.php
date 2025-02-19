<?php
session_start();

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

    <title>Invertory Management</title>


    <!-- <link rel="stylesheet" href="http://172.16.14.44/dependencies/css/bootstrap/v5.3.3/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="http://172.16.14.44/dependencies/javascript/sweetalert2-11.14.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/sb-admin-2.css">
    <link rel="stylesheet" href="../../../assets/vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../assets/css/custom/global.css"> -->
    <?php include "../components/shared/external-css-import.php" ?>
    <link rel="stylesheet" href="../../assets/css/custom/inventory-management/disposal.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "../components/shared/sidebar.php" ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../components/shared/topbar.php" ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Disposal Management</h1>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">For Disposal</h6>
                                    <?php if ($authorizations['inventory_edit']): ?>
                                        <div class="actions d-flex flex-row-reverse gap-2" id="forDisposalActions">
                                            <form action="../../backend/inventory-management/createDisposalForm.php" method="post">
                                                <button type="submit" class="btn btn-sm shadow-sm btn-primary createDisposalFormBtn"><i class="fas fa-file-lines"></i> Create Disposal Form</button>
                                            </form>
                                            <button type="button" class="btn btn-sm shadow-sm btn-info disposeItemsBtn" data-bs-toggle="modal" data-bs-target="#disposeItemsModal"><i class="fas fa-dumpster"></i> Dispose All Items</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="forDisposalTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Asset No.</th>
                                                    <th scope="col">Item type</th>
                                                    <th scope="col">User</th>
                                                    <th scope="col">Computer Name</th>
                                                    <th scope="col">Department</th>
                                                    <th scope="col">Date Retired</th>
                                                    <th scope="col">Remarks</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Disposed Items</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="disposedListTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Date Disposed</th>
                                                    <th>Disposal Form</th>
                                                    <th>View Items Disposed</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($authorizations['inventory_edit']): ?>
        <?php include '../components/inventory-management/disposeItemsModal.php'; ?>
        <?php include '../components/inventory-management/viewDisposedInventoryModal.php'; ?>
    <?php endif; ?>
</body>

<?php include '../components/shared/external-js-import.php'; ?>
<script src="../../assets/js/inventory-management/forDisposal.js"></script>
<?php if ($authorizations['inventory_edit']): ?>
    <script src="../../assets/js/inventory-management/uploadDisposalForm.js"></script>
<?php endif; ?>
<script src="../../assets/js/inventory-management/disposedItems.js"></script>

</html>