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

    <title>Inventory Management</title>


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
    <link rel="stylesheet" href="../../assets/css/custom/inventory-management/inventory.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "../components/shared/sidebar.php" ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../components/shared/topbar.php" ?>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-2 text-gray-800">Inventory Management</h1>
                        <div id="inventoryNotificationBtnGroup">
                            <i class="fa-solid fa-bell-exclamation text-primary fa-xl mr-4" role="button" data-bs-toggle="modal" data-bs-target="#inventoryNotifications" id="viewInventoryNotificationsButton"></i>
                            <div id="newNotificationsCount" class="d-none"></div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Inventory</h6>
                            <div class="actions d-flex flex-row-reverse gap-3">
                                <?php if ($authorizations['inventory_edit']): ?>
                                    <button class="btn btn-sm shadow-sm btn-primary createInventoryModalBtn" data-bs-toggle="modal" data-bs-target="#createInventoryModal"><i class="fas fa-circle-plus"></i> Add Item</button>
                                    <button class="btn btn-sm shadow-sm btn-sm shadow-sm btn-success importInventoryModalBtn" data-bs-toggle="modal" data-bs-target="#importInventoryModal"><i class="fas fa-file-import"></i> Import Data</button>
                                <?php endif; ?>
                                <button class="btn btn-sm shadow-sm btn-warning exportInventoryModalBtn" data-bs-toggle="modal" data-bs-target="#exportInventoryModal" id="exportInventoryModalBtn"><i class="fas fa-file-export"></i> Export Data</button>
                                <!-- <button class="btn btn-sm shadow-sm btn-secondary modalBtn" data-bs-toggle="modal" data-bs-target="#createInventoryModal"><i class="fas fa-print"></i> Print</button> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table small" id="inventoryTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Inventory Id</th>
                                            <th scope="col">Asset No.</th>
                                            <th scope="col">User</th>
                                            <th scope="col">PC Name</th>
                                            <th scope="col">
                                                Item Type
                                                <select id="filterItemType" class="form-select form-select-sm" role="button" data-column-index="3">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">
                                                Item Category
                                                <select id="filterCategory" class="form-select form-select-sm" role="button" data-column-index="4">
                                                    <option value="">All</option>
                                                    <option value="Keyboard">Keyboard</option>
                                                    <option value="Mouse">Mouse</option>
                                                    <option value="Headset">Headset</option>
                                                    <option value="Webcam">Webcam</option>
                                                    <option value="Scanner">Scanner</option>
                                                    <option value="Wireless HDMI">Wireless HDMI</option>
                                                    <option value="External Drive">External Drive</option>
                                                </select>
                                            </th>
                                            <th scope="col">
                                                Brand
                                                <select id="filterBrand" class="form-select form-select-sm" role="button" data-column-index="5">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">Model</th>
                                            <th scope="col">Date Acquired</th>
                                            <th scope="col">
                                                Supplier
                                                <select id="filterSupplier" class="form-select form-select-sm" role="button" data-column-index="8">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">Serial Number</th>
                                            <th scope="col">Department
                                                <select id="filterDepartment" class="form-select form-select-sm" role="button" data-column-index="10">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">
                                                Status
                                                <select id="filterStatus" class="form-select form-select-sm" role="button" data-column-index="11">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">View</th>
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
    <?php include '../components/inventory-management/inventoryNotificationsModal.php' ?>
    <?php if ($authorizations['inventory_edit']): ?>
        <?php include '../components/inventory-management/createInventoryModal.php' ?>
        <?php include '../components/inventory-management/importInventoryModal.php' ?>
        <?php include '../components/inventory-management/repairItemModal.php' ?>
        <?php include '../components/inventory-management/finishRepairModal.php' ?>
        <?php include '../components/inventory-management/disposeInventoryModal.php' ?>
        <?php if (!$authorizations['inventory_super']): ?>
            <?php include '../components/inventory-management/requestChangesModal.php' ?>
            <?php include '../components/inventory-management/viewRequestHistoryModal.php' ?>
            <?php include '../components/inventory-management/editFAModal.php' ?>
            <?php include '../components/inventory-management/absoluteDeleteModal.php' ?>
            <?php include '../components/inventory-management/unretireModal.php' ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($authorizations['inventory_super']): ?>
        <?php include '../components/inventory-management/viewAllRequestsModal.php' ?>
        <?php include '../components/inventory-management/viewRequestModal.php' ?>
    <?php endif; ?>
    <?php include '../components/inventory-management/exportInventoryModal.php' ?>
    <?php include '../components/inventory-management/viewInventoryModal.php' ?>
</body>
<?php include '../components/shared/external-js-import.php'; ?>
<script src="../../assets/js/inventory-management/inventory.js"></script>
<script src="../../assets/js/inventory-management/exportFile.js"></script>
<script src="../../assets/js/inventory-management/viewInventory.js"></script>
<?php if ($authorizations['inventory_edit']): ?>
    <script src="../../assets/js/inventory-management/addInventory.js"></script>
    <script src="../../assets/js/inventory-management/importFile.js"></script>
    <script src="../../assets/js/inventory-management/repairItem.js"></script>
    <script src="../../assets/js/inventory-management/requestChanges.js"></script>
    <script src="../../assets/js/inventory-management/viewRequestHistory.js"></script>
    <script src="../../assets/js/inventory-management/editFA.js"></script>
    <script src="../../assets/js/inventory-management/absoluteDelete.js"></script>
    <script src="../../assets/js/inventory-management/unretire.js"></script>
<?php endif; ?>
<?php if ($authorizations['inventory_super']): ?>
    <script src="../../assets/js/inventory-management/viewAllRequests.js"></script>
    <script src="../../assets/js/inventory-management/viewRequest.js"></script>
    <script src="../../assets/js/inventory-management/acceptRequest.js"></script>
    <script src="../../assets/js/inventory-management/declineRequest.js"></script>
<?php endif; ?>
<script src="../../assets/js/inventory-management/inventoryNotifications.js"></script>

</html>