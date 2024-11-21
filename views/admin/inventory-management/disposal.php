<?php
session_start();

require('../../../backend/dbconn.php');
require('../../../backend/middleware/pipes.php');
require('../../../backend/middleware/authorize.php');

if (authorize($_SESSION['user']['role'] == "ADMIN")) {
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
    <?php include "../../components/external-css-import.php" ?>
    <link rel="stylesheet" href="../../../assets/css/custom/admin/inventory-management/disposal.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "../../components/sidebar.php" ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../../components/topbar.php" ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Disposal Management</h1>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">For Disposal</h6>
                                    <div class="actions d-flex flex-row-reverse gap-3">
                                        <form action="../../../backend/admin/inventory-management/createDisposalForm.php" method="post">
                                            <button type="submit" class="btn btn-primary createDisposalFormBtn"><i class="fas fa-file-lines"></i> Create Disposal Form</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table teble-bordered" id="forDisposalTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Asset No.</th>
                                                    <th>Item type</th>
                                                    <th>Item name</th>
                                                    <th>User</th>
                                                    <th>Department</th>
                                                    <th>Date Retired</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $forDisposalSql = "SELECT inventory_records_tbl.fa_number,
                                                                    inventory_records_tbl.item_type,
                                                                    inventory_records_tbl.item_name,
                                                                    inventory_records_tbl.user,
                                                                    inventory_records_tbl.department,
                                                                    inventory_disposal_tbl.date_added,
                                                                    inventory_disposal_tbl.remarks
                                                                    FROM inventory_records_tbl
                                                                    JOIN inventory_disposal_tbl ON inventory_records_tbl.id = inventory_disposal_tbl.inventory_id
                                                                    WHERE inventory_disposal_tbl.isDisposed = 0";

                                                $stmt = $conn->prepare($forDisposalSql);

                                                if ($stmt == false) {
                                                    echo $conn->error;
                                                } else {
                                                    if (!$stmt->execute()) {
                                                        echo $stmt->error;
                                                    } else {
                                                        $forDisposalResult = $stmt->get_result();
                                                        while ($forDisposalRow = $forDisposalResult->fetch_assoc()) {
                                                            $faNumber = $forDisposalRow['fa_number'];
                                                            $itemType = $forDisposalRow['item_type'];
                                                            $itemName = $forDisposalRow['item_name'];
                                                            $user = $forDisposalRow['user'];
                                                            $department = $forDisposalRow['department'];
                                                            $dateRetired = $forDisposalRow['date_added'];
                                                            $remarks = $forDisposalRow['remarks'];
                                                ?>
                                                            <tr>
                                                                <td><?= $faNumber == true ? $faNumber : "N/A" ?></td>
                                                                <td><?= $itemType ?></td>
                                                                <td><?= $itemName ?></td>
                                                                <td><?= $user ?></td>
                                                                <td><?= $department ?></td>
                                                                <td data-order="<?= convertToDate($dateRetired) ?>"><?= convertToReadableDate($dateRetired) ?></td>
                                                                <td class="remarks-column"><?= $remarks == true ? $remarks : "No Remarks" ?></td>
                                                            </tr>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include '../../components/external-js-import.php'; ?>
<script src="../../../assets/js/admin/inventory-management/forDisposal.js"></script>

</html>