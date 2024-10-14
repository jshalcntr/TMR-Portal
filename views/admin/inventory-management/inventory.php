<?php
session_start();

require('../../../backend/dbconn.php');
require('../../../backend/middleware/pipes.php');
require('../../../backend/middleware/authorize.php');

authorize($_SESSION['user']['role'] == "ADMIN");

$authId = $_SESSION['user']['id'];
$authUsername = $_SESSION['user']['username'];
$authFullName = $_SESSION['user']['full_name'];
$authRole = $_SESSION['user']['role'];
$authPP = $_SESSION['user']['profile_picture'];
$authDepartment = $_SESSION['user']['department'];

$authorizations = setAuthorizations($_SESSION['user']);
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


    <link rel="stylesheet" href="http://172.16.14.44/dependencies/css/bootstrap/v5.3.3/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="http://172.16.14.44/dependencies/javascript/sweetalert2-11.14.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/sb-admin-2.css">
    <link rel="stylesheet" href="../../../assets/vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../assets/css/custom/global.css">
    <link rel="stylesheet" href="../../../assets/css/custom/admin/inventory-management/inventory.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "../../components/sidebar.php" ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../../components/topbar.php" ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Inventory Management</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Inventory</h6>
                            <div class="actions d-flex flex-row-reverse gap-3">
                                <?php if ($authorizations['inventory_edit']): ?>
                                    <button class="btn btn-primary modalBtn" data-bs-toggle="modal" data-bs-target="#createInventoryModal"><i class="fas fa-circle-plus"></i> Add Item</button>
                                    <button class="btn btn-success modalBtn" data-bs-toggle="modal" data-bs-target="#"><i class="fas fa-file-import"></i> Import Data</button>
                                <?php endif; ?>
                                <button class="btn btn-warning modalBtn" data-bs-toggle="modal" data-bs-target="#createInventoryModal"><i class="fas fa-file-export"></i> Export Data</button>
                                <button class="btn btn-secondary modalBtn" data-bs-toggle="modal" data-bs-target="#createInventoryModal"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Asset No.</th>
                                            <th>Item type</th>
                                            <th>Item name</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Date Acquired</th>
                                            <th>Supplier</th>
                                            <th>Serial Number</th>
                                            <th>User</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $inventorySql = "SELECT * FROM inventory_records_tbl";
                                        $stmt = $conn->prepare($inventorySql);

                                        if ($stmt == false) {
                                            echo $conn->error;
                                        } else {
                                            if (!$stmt->execute()) {
                                                echo $stmt->error;
                                            } else {
                                                $inventoryResult = $stmt->get_result();
                                                while ($inventoryRow = $inventoryResult->fetch_assoc()) {
                                                    $faNumber = $inventoryRow['fa_number'];
                                                    $itemType = $inventoryRow['item_type'];
                                                    $itemName = $inventoryRow['item_name'];
                                                    $brand = $inventoryRow['brand'];
                                                    $model = $inventoryRow['model'];
                                                    $dateAcquired = $inventoryRow['date_acquired'];
                                                    $supplier = $inventoryRow['supplier'];
                                                    $serialNumber = $inventoryRow['serial_number'];
                                                    $user = $inventoryRow['user'];
                                                    $department = $inventoryRow['department'];
                                                    $status = $inventoryRow['status'];
                                                    $remarks = $inventoryRow['remarks'];
                                        ?>
                                                    <tr>
                                                        <td><?= $faNumber ?></td>
                                                        <td><?= $itemType ?></td>
                                                        <td><?= $itemName ?></td>
                                                        <td><?= $brand ?></td>
                                                        <td><?= $model ?></td>
                                                        <td data-order="<?= convertToDate($dateAcquired) ?>"><?= convertToReadableDate($dateAcquired) ?></td>
                                                        <td><?= $supplier ?></td>
                                                        <td><?= $serialNumber ?></td>
                                                        <td><?= $user ?></td>
                                                        <td><?= $department ?></td>
                                                        <td><?= $status ?></td>
                                                        <td><?= $remarks ?></td>
                                                    </tr>
                                        <?php }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($authorizations['inventory_edit']): ?>
        <div class="modal fade" id="createInventoryModal" tabindex="-1" aria-labelledby="createInventoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="createInventoryModalLabel">Add New Item</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createInventoryForm" class="container needs-validation" novalidate>
                            <div class="row mb-lg-3">
                                <div class="col">
                                    <h4 class="mb-2">Item Details</h4>
                                    <div class="mb-2 form-group">
                                        <label for="itemType" class="col-form-label">Item Type</label>
                                        <select name="itemType" id="itemType" class="form-control form-select" required>
                                            <option value="" selected hidden>--Select Item Type--</option>
                                            <option value="Printer">Printer</option>
                                            <option value="Desktop">Desktop</option>
                                            <option value="Laptop">Laptop</option>
                                            <option value="Tools">Tools</option>
                                            <option value="Accessories">Accessories</option>
                                        </select>
                                        <div class="invalid-feedback">Please Select Item Type</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="itemName" class="col-form-label">Item Name</label>
                                        <input type="text" name="itemName" id="itemName" class="form-control" required></input>
                                        <div class="invalid-feedback">Please Input Item Name</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="itemBrand" class="col-form-label">Item Brand</label>
                                        <input type="text" name="itemBrand" id="itemBrand" class="form-control" required></input>
                                        <div class="invalid-feedback">Please Input Item Brand</div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="itemModel" class="col-form-label">Item Model</label>
                                        <input type="text" name="itemModel" id="itemModel" class="form-control" required></input>
                                        <div class="invalid-feedback">Please Input Item Model</div>
                                    </div>
                                    <hr class="sidebar-divider">
                                    <h4 class="mb-2">Item User Information</h4>
                                    <div class="mb-2 form-group">
                                        <label for="user" class="col-form-label">User Name</label>
                                        <input type="text" name="user" id="user" class="form-control" required>
                                        <div class="invalid-feedback">Please Input User Name</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="department" class="col-form-label">Department</label>
                                        <select name="department" id="department" class="form-control form-select" required>
                                            <option value="" selected hidden>--Select Department--</option>
                                            <option value="Vehicle Sales Admin">Vehicle Sales Admin</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Executive Office Department">Executive Office Department</option>
                                            <option value="Service Department">Service Department</option>
                                            <option value="Parts & Accessories Department">Parts and Accessories Department</option>
                                            <option value="Human Resources and Administration Department">Human Resources and Administration Department</option>
                                            <option value="Finance & Insurance Department">Finance & Insurance Department</option>
                                            <option value="Accounting Department">Accounting Department</option>
                                            <option value="Management Information System Department">Management Information System Department</option>
                                            <option value="Customer Relations Department">Customer Relations Department</option>
                                        </select>
                                        <div class="invalid-feedback">Please Select Department</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h4 class="mb-2">Supply Details</h4>
                                    <div class="mb-2 form-group">
                                        <label for="dateAcquired" class="col-form-label">Date Acquired</label>
                                        <input type="date" name="dateAcquired" id="dateAcquired" class="form-control" max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required>
                                        <div class="invalid-feedback">Please Input Date Acquired</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="supplierName" class="col-form-label">Supplier Name</label>
                                        <input type="text" name="supplierName" id="supplierName" class="form-control" required>
                                        <div class="invalid-feedback">Please Input Supplier Name</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="serialNumber" class="col-form-label">Serial Number</label>
                                        <input type="text" name="serialNumber" id="serialNumber" class="form-control" required>
                                        <div class="invalid-feedback">Please Input Serial Number</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="price" class="col-form-label">Price</label>
                                        <input type="number" name="price" id="price" class="form-control" required>
                                        <div class="invalid-feedback">Please Input Valid price</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="status" class="col-form-label">Status</label>
                                        <select name="status" id="status" class="form-control form-select" required>
                                            <option value="" hidden>--Select Item Status--</option>
                                            <option value="Active">Active</option>
                                            <option value="Repaired">Repaired</option>
                                            <option value="Retired">Retired</option>
                                        </select>
                                        <div class="invalid-feedback">Please Select Item Status</div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="remarks" class="col-form-label">Remarks</label>
                                        <textarea name="remarks" id="remarks" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row action-row">
                                <div class="col d-flex justify-content-end align-items-end">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> Add to Inventory</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>


<script src="http://172.16.14.44/dependencies/javascript/bootstrap/v5.3.3/bootstrap.bundle.js"></script>
<script src="../../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../../assets/js/sb-admin-2.min.js"></script>
<script src="http://172.16.14.44/dependencies/javascript/sweetalert2-11.14.2/dist/sweetalert2.all.min.js"></script>
<script src="../../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../../../assets/js/inventory.js"></script>
<?php if ($authorizations['inventory_edit']): ?>
    <script src="../../../assets/js/addInventory.js"></script>
<?php endif; ?>

</html>