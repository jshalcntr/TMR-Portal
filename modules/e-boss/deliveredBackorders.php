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
    $authSection = $_SESSION['user']['section_name'];

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

    <title>E-BOSS - Delivered Backorders</title>

    <?php include "../components/shared/external-css-import.php" ?>
    <link rel="stylesheet" href="../../assets/css/custom/e-boss/e-boss.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "../components/shared/sidebar.php" ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../components/shared/topbar.php" ?>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-2 text-gray-800">Delivered Backorders</h1>
                        <div class="d-flex align-items-center">
                            <a href="backorders.php" class="btn btn-sm btn-outline-primary shadow-sm mr-2"><i class="fas fa-list fa-sm"></i> Backorders</a>
                            <a href="cancelledBackorders.php" class="btn btn-sm btn-outline-primary shadow-sm mr-2"><i class="fas fa-cancel fa-sm"></i> Cancelled Backorder</a>
                            <a href="deletedBackorders.php" class="btn btn-sm btn-outline-primary shadow-sm mr-2"><i class="fas fa-trash fa-sm"></i> Deleted Backorder</a>
                            <a href="deliveredBackorders.php" class="btn btn-sm btn-primary shadow-sm mr-2"><i class="fas fa-check fa-sm"></i> Delivered Backorder</a>
                            <button class="btn btn-sm btn-primary shadow-sm" id="exportBtn">
                                <i class="fas fa-download fa-sm"></i> Export Excel
                            </button>
                        </div>
                    </div>

                    <!-- Bulk Operations -->
                    <div class="card shadow mb-4" id="bulkOperations" style="display: none;">
                        <div class="card-body">
                            <div class="alert alert-info">
                                <strong>Bulk Operations:</strong>
                                <span id="selectedCount">0</span> item(s) selected
                                <div class="btn-group ms-3" role="group">
                                    <button class="btn btn-sm btn-warning" id="bulkRestoreBtn">
                                        <i class="fas fa-undo"></i> Restore Selected
                                    </button>
                                    <button class="btn btn-sm btn-danger" id="bulkDeleteBtn">
                                        <i class="fas fa-trash"></i> Delete Selected
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered small dataTable no-footer" id="backordersRecordsTable" width="100%" cellspacing="0">
                                    <thead class="table-bg-primary text-white">
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>RO NUMBER</th>
                                            <th>CUSTOMER NAME</th>
                                            <th>ORDER DATE</th>
                                            <th>AGING</th>
                                            <th>ORDER NO</th>
                                            <th>SOURCE</th>
                                            <th>PART NUMBER</th>
                                            <th>PART NAME</th>
                                            <th>QTY</th>
                                            <th>BO PRICE</th>
                                            <th>TOTAL</th>
                                            <th>1ST ETA</th>
                                            <th>2ND ETA</th>
                                            <th>3RD ETA</th>
                                            <th>ORDER TYPE</th>
                                            <th>SERVICE TYPE</th>
                                            <th>APPOINTMENT DATE</th>
                                            <th>APPOINTMENT TIME</th>
                                            <th>APPOINTMENT NOTES</th>
                                            <th>SCHEDULED BY</th>
                                            <th>SERVICE ESTIMATOR</th>
                                            <th>UNIT / MODEL</th>
                                            <th>PLATE NO</th>
                                            <th>UNIT STATUS</th>
                                            <th>REMARKS</th>
                                            <th>ORDER STATUS</th>
                                            <th>DELIVERY DATE</th>
                                            <th>ACTION</th>
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

    <?php include '../components/e-boss/actionsModal.php'; ?>
</body>
<?php include '../components/shared/external-js-import.php'; ?>
<script src="../../assets/js/e-boss/deliveredBackorders.js"></script>
<script src="../../assets/js/e-boss/backorderActions.js"></script>
<script src="../../assets/js/e-boss/getServiceEstimator.js"></script>

</html>