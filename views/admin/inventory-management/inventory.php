<?php
session_start();

require('../../../vendor/autoload.php');
require('../../../backend/dbconn.php');
require('../../../backend/middleware/pipes.php');
require('../../../backend/middleware/authorize.php');

if (authorize($_SESSION['user']['role'] == "ADMIN", $conn) || authorize($_SESSION['user']['role'] == "S-ADMIN", $conn)) {
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
                                    <button class="btn btn-sm shadow-sm btn-primary createInventoryModalBtn" data-bs-toggle="modal" data-bs-target="#createInventoryModal"><i class="fas fa-circle-plus"></i> Add Item</button>
                                    <button class="btn btn-sm shadow-sm btn-sm shadow-sm btn-success importInventoryModalBtn" data-bs-toggle="modal" data-bs-target="#importInventoryModal"><i class="fas fa-file-import"></i> Import Data</button>
                                <?php endif; ?>
                                <button class="btn btn-sm shadow-sm btn-warning exportInventoryModalBtn" data-bs-toggle="modal" data-bs-target="#exportInventoryModal" id="exportInventoryModalBtn"><i class="fas fa-file-export"></i> Export Data</button>
                                <!-- <button class="btn btn-sm shadow-sm btn-secondary modalBtn" data-bs-toggle="modal" data-bs-target="#createInventoryModal"><i class="fas fa-print"></i> Print</button> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Asset No.</th>
                                            <th scope="col">User</th>
                                            <th scope="col">PC Name</th>
                                            <th scope="col">
                                                Item Type
                                                <select id="filterItemType" class="form-select form-select-sm">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">
                                                Item Category
                                                <select id="filterCategory" class="form-select form-select-sm" hidden>
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
                                            <th scope="col">Brand</th>
                                            <th scope="col">Model</th>
                                            <th scope="col">Date Acquired</th>
                                            <th scope="col">Supplier</th>
                                            <th scope="col">Serial Number</th>
                                            <th scope="col">Department
                                                <select id="filterDepartment" class="form-select form-select-sm">
                                                    <option value="">All</option>
                                                </select>
                                            </th>
                                            <th scope="col">
                                                Status
                                                <select id="filterStatus" class="form-select form-select-sm">
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
    <?php if ($authorizations['inventory_edit']): ?>
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
                                            <option value="Desktop">Desktop</option>
                                            <option value="Laptop">Laptop</option>
                                            <option value="Monitor">Monitor</option>
                                            <option value="Printer">Printer</option>
                                            <option value="Hardisk">Hardisk</option>
                                            <option value="RAM">RAM</option>
                                            <option value="Video Card">Video Card</option>
                                            <option value="UPS">UPS</option>
                                            <option value="UPS Battery">UPS Battery</option>
                                            <option value="Router">Router</option>
                                            <option value="Accessories">Accessories</option>
                                        </select>
                                        <div class="invalid-feedback">Please Select Item Type</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="itemCategory" class="col-form-label">Item Category</label>
                                        <select name="itemCategory" id="itemCategory" class="form-control form-control-sm form-select" required>
                                            <option value="" selected hidden>--Select Item Category--</option>
                                            <option value="Desktop" hidden>Desktop</option>
                                            <option value="Laptop" hidden>Laptop</option>
                                            <option value="Monitor" hidden>Monitor</option>
                                            <option value="Printer" hidden>Printer</option>
                                            <option value="Hardisk" hidden>Hardisk</option>
                                            <option value="RAM" hidden>RAM</option>
                                            <option value="Video Card" hidden>Video Card</option>
                                            <option value="UPS" hidden>UPS</option>
                                            <option value="UPS Battery" hidden>UPS Battery</option>
                                            <option value="Router" hidden>Router</option>
                                            <option value="Keyboard">Keyboard</option>
                                            <option value="Mouse">Mouse</option>
                                            <option value="Headset">Headset</option>
                                            <option value="Webcam">Webcam</option>
                                            <option value="Scanner">Scanner</option>
                                            <option value="Wireless HDMI">Wireless HDMI</option>
                                            <option value="External Drive">External Drive</option>
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
        <div class="modal fade" id="importInventoryModal" tabindex="-1" aria-labelledby="importInventoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="importInventoryModalLabel">Import File</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-lg-3">
                        <form class="container" id="importInventoryForm" enctype="multipart/form-data" autocomplete="off">
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="file-upload-contain">
                                        <label for="importFile" id="dragZone" class="custom-upload-dropzone d-flex align-items-center justify-content-center flex-column p-xl-5">
                                            <i class="fas fa-cloud-arrow-up fa-3x" id="droppingLogo"></i>
                                            <p class="h2">Drag and Drop File Here</p>
                                        </label>
                                        <input type="file" id="importFile" name="importFile" accept=".csv, .xls, .xlsx" class="d-none">
                                        <div id="filePreview" class="d-none align-items-center justify-content-center p-xl-5">
                                            <i class="fas fa-table fa-2x text-info mr-1"></i>
                                            <p class="h5 mb-0" id="fileName">No File Selected</p>
                                            <i class="fas fa-trash text-danger" id="removeFileBtn"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none" id="actionGroup">
                                <div class="col d-flex justify-content-end align-items-end">
                                    <button type="submit" class="btn-sm shadow-sm btn btn-primary"><i class="fas fa-floppy-disk"></i> Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="repairItemModal" tabindex="-1" aria-labelledby="repairItemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="repairItemModalLabel">Repair Item</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-lg-4 container">
                        <div class="row">
                            <div class="col-5 d-none" id="noRepairColumn">
                                <form id="repairItemForm" class="needs-validation" novalidate autocomplete="off">
                                    <h3>Add To Repair</h3>
                                    <div class="mb-2 form-group">
                                        <label for="repairDescription" class="col-form-label">Repair Description</label>
                                        <input type="text" name="repairDescription" id="repairDescription" class="form-control form-control-sm" required>
                                        <div class="invalid-feedback">Please Input Repair Description</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="gatepassNumber" class="col-form-label">Gatepass Number</label>
                                        <input type="text" name="gatepassNumber" id="gatepassNumber" class="form-control form-control-sm" required>
                                        <div class="invalid-feedback">Please Input Gatepass Number</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="repairDate" class="col-form-label">Repair Date</label>
                                        <input type="date" name="repairDate" id="repairDate" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
                                    </div>
                                    <div class="mb-2 form-group d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-truck-fast"></i> Repair</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-5 d-none" id="underRepairColumn">
                                <form id="editRepairItemForm" class="needs-validation" novalidate autocomplete="off">
                                    <h3>Current Repair</h3>
                                    <div class="mb-2 form-group">
                                        <label for="repairDescription_edit" class="col-form-label">Repair Description</label>
                                        <input type="text" name="repairDescription" id="repairDescription_edit" class="form-control form-control-sm" required disabled>
                                        <div class="invalid-feedback">Please Input Repair Description</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="gatepassNumber_edit" class="col-form-label">Gatepass Number</label>
                                        <input type="text" name="gatepassNumber" id="gatepassNumber_edit" class="form-control form-control-sm" required disabled>
                                        <div class="invalid-feedback">Please Input Gatepass Number</div>
                                    </div>
                                    <div class="mb-2 form-group">
                                        <label for="repairDate_edit" class="col-form-label">Repair Date</label>
                                        <input type="date" name="repairDate" id="repairDate_edit" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required disabled>
                                    </div>
                                    <div class="mb-2 form-group d-flex justify-content-end action-column" id="viewRepairButtonGroup">
                                        <button type="button" id="finishRepairButton" class="btn btn-sm shadow-sm btn-info"><i class="fas fa-circle-check"></i> Finish Repair</button>
                                        <button type="button" id="editRepairButton" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-pen"></i> Edit</button>
                                    </div>
                                    <div class="mb-2 form-group d-none justify-content-end action-column" id="editRepairButtonGroup">
                                        <button type="button" id="cancelEditRepairButton" class="btn btn-sm shadow-sm btn-danger"><i class="fas fa-ban"></i> Cancel</button>
                                        <button type="submit" id="saveRepairButton" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-floppy-disk"></i> Save</button>
                                    </div>
                                    <input type="hidden" name="repairId" id="repairId_edit">
                                </form>
                            </div>
                            <div class="col-7">
                                <div class="d-flex justify-content-between align-items-center px-4">
                                    <h3>Repair History</h3>
                                    <h3>Total Repair/s: <span id="totalRepairs"></span></h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="repairHistoryTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Repair Description</th>
                                                <th scope="col">Gatepass Number</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">Finished Date</th>
                                                <th scope="col">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="repairHistory">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="finishRepairModal" tabindex="-1" aria-labelledby="finishRepairModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="finishRepairModalLabel">Finish Repair</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-lg-4">
                        <form class="container" id="finishRepairForm" autocomplete="off">
                            <div class="form-group mb-3">
                                <label for="date_repaired">Date Repaired</label>
                                <input type="date" id="date_repaired" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="repair_remarks">Remarks</label>
                                <textarea id="repair_remarks" class="form-control form-control-sm" required></textarea>
                            </div>
                            <div class="d-flex justify-content-end action-column">
                                <button type="button" class="btn btn-sm shadow-sm btn-danger" data-bs-dismiss="modal"><i class="fas fa-xmark"></i> Close</button>
                                <button type="submit" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-check"></i> Finish</button>
                            </div>
                    </div>
                    <input type="hidden" name="repairId" id="repairId_finish">
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="disposeInventoryModal" tabindex="-1" aria-labelledby="disposeInventoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="disposeInventoryModalLabel">Add to Disposal</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-lg-4">
                        <form class="container" id="addToDisposalForm" autocomplete="off">
                            <div class="form-group mb-3">
                                <label for="repair_remarks">Remarks</label>
                                <textarea id="repair_remarks" class="form-control form-control-sm" name="remarks"></textarea>
                            </div>
                            <div class="d-flex justify-content-end action-column">
                                <button type="button" class="btn btn-sm shadow-sm btn-danger" data-bs-dismiss="modal"><i class="fas fa-xmark"></i> Close</button>
                                <button type="submit" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-trash-plus"></i> Add To Disposal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="requestChangesModal" class="modal fade" tabindex="-1" aria-labelledby="requestChangesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="requestChangesModalLabel">Request Changes | Asset #: <span id="assetNumber_request"></span></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-xl-3 d-flex flex-column align-items-center" style="gap: 8px;">
                        <div class="row">
                            <button type="button" class="btn btn-warning shadow-sm" id="editFABtn" data-bs-toggle="modal" data-bs-target="#editFAModal" style="width: fit-content;"><i class="fas fa-money-check-pen"></i> Edit FA Number</button>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-danger shadow-sm" id="absoluteDeleteBtn" data-bs-toggle="modal" data-bs-target="#absoluteDeleteModal" style="width: fit-content;"><i class="fas fa-trash-can-list"></i> Absolute Deletion</button>
                        </div>
                        <div class="row d-none" id="retiredActionsRow2">
                            <button type="button" class="btn btn-info shadow-sm" id="unretireBtn" data-bs-toggle="modal" data-bs-target="#unretireModal" style="width: fit-content;"><i class="fas fa-clock-rotate-left"></i> Unretire</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="editFAModal" class="modal fade" tabindex="-1" aria-labelledby="editFAModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content px-3">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="editFAModalLabel">Edit FA Number</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editFAForm" class="modal-body p-xl-3" style="gap: 8px;" autocomplete="off" novalidate>
                        <div class="row form-group">
                            <label for="newFA">Desired FA Number:</label>
                            <input type="text" id="newFA" name="newFA" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please enter a valid FA Number</div>
                        </div>
                        <div class="row form-group">
                            <label for="newFAReason">Reason for Changing:</label>
                            <textarea type="text" id="newFAReason" name="newFAReason" class="form-control form-control-sm" required></textarea>
                            <div class="invalid-feedback">Please enter a reason for changing the FA Number</div>
                        </div>
                        <div class="row form-group justify-content-end">
                            <button type="submit" class="btn btn-sm shadow-sm btn-primary w-auto align-self-end"><i class="fa-solid fa-paper-plane-top"></i> Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="absoluteDeleteModal" class="modal fade" tabindex="-1" aria-labelledby="absoluteDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content px-3">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="absoluteDeleteModalLabel">Request Absolute Deletion</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="absoluteDeleteForm" class="modal-body p-xl-3" style="gap: 8px;" autocomplete="off" novalidate>
                        <div class="row form-group">
                            <label for="absoluteDeleteReason">Reason for Deletion:</label>
                            <textarea type="text" id="absoluteDeleteReason" name="absoluteDeleteReason" class="form-control form-control-sm" required></textarea>
                            <div class="invalid-feedback">Please enter a reason for deleting the item</div>
                        </div>
                        <div class="row form-group justify-content-end">
                            <button type="submit" class="btn btn-sm shadow-sm btn-primary w-auto align-self-end"><i class="fa-solid fa-paper-plane-top"></i> Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="unretireModal" class="modal fade" tabindex="-1" aria-labelledby="unretireModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content px-3">
                    <div class="modal-header d-flex justify-content-between align-items-center px-4">
                        <h3 class="modal-title" id="unretireModalLabel">Request to Unretire</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="unretireForm" class="modal-body p-xl-3" style="gap: 8px;" autocomplete="off" novalidate>
                        <div class="row form-group">
                            <label for="unretireReason">Reason for Unretire:</label>
                            <textarea type="text" id="unretireReason" name="unretireReason" class="form-control form-control-sm" required></textarea>
                            <div class="invalid-feedback">Please enter a reason for unretiring the item</div>
                        </div>
                        <div class="row form-group justify-content-end">
                            <button type="submit" class="btn btn-sm shadow-sm btn-primary w-auto align-self-end"><i class="fa-solid fa-paper-plane-top"></i> Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php endif; ?>
    <div class="modal fade" id="exportInventoryModal" tabindex="-1" aria-labelledby="exportInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center px-4">
                    <h3 class="modal-title" id="exportInventoryModalLabel">Export File</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-lg-3">
                    <form class="container" id="exportInventoryForm" method="POST" action="../../../backend/admin/inventory-management/exportInventory.php" autocomplete="off">
                        <div class="row">
                            <div class="col">
                                <h3 class="h5">Choose Asset Type</h3>
                                <div class="form-check mb-1">
                                    <input type="radio" name="assetType_export" id="assetType_All" class="form-check-input" value="all" checked>
                                    <label for="assetType_All" class="form-check-label">All Assets</label>
                                </div>
                                <div class="form-check mb-1">
                                    <input type="radio" name="assetType_export" id="assetType_FA" class="form-check-input" value="fa">
                                    <label for="assetType_FA" class="form-check-label">Fixed Assets Only</label>
                                </div>
                                <div class="form-check mb-1">
                                    <input type="radio" name="assetType_export" id="assetType_nonFA" class="form-check-input" value="nonFa">
                                    <label for="assetType_nonFA" class="form-check-label">Non-Fixed Assets Only</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="h5" for="itemType_export">Choose Item Type</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="all_itemType" class="form-check-input" value="all">
                                    <label for="all_itemType" class="form-check-label">Select All</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="desktop_itemType" class="form-check-input item-checkbox" value="Desktop">
                                    <label for="desktop_itemType" class="form-check-label">Desktop</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="laptop_itemType" class="form-check-input item-checkbox" value="Laptop">
                                    <label for="laptop_itemType" class="form-check-label">Laptop</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="monitor_itemType" class="form-check-input item-checkbox" value="Monitor">
                                    <label for="monitor_itemType" class="form-check-label">Monitor</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="printer_itemType" class="form-check-input item-checkbox" value="Printer">
                                    <label for="printer_itemType" class="form-check-label">Printer</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="hardisk_itemType" class="form-check-input item-checkbox" value="Hardisk">
                                    <label for="hardisk_itemType" class="form-check-label">Hardisk</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="ram_itemType" class="form-check-input item-checkbox" value="RAM">
                                    <label for="ram_itemType" class="form-check-label">RAM</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="videoCard_itemType" class="form-check-input item-checkbox" value="Video Card">
                                    <label for="videoCard_itemType" class="form-check-label">Video Card</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="ups_itemType" class="form-check-input item-checkbox" value="UPS">
                                    <label for="ups_itemType" class="form-check-label">UPS</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="upsBattery_itemType" class="form-check-input item-checkbox" value="UPS Battery">
                                    <label for="upsBattery_itemType" class="form-check-label">UPS Battery</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="router_itemType" class="form-check-input item-checkbox" value="Router">
                                    <label for="router_itemType" class="form-check-label">Router</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="itemType_export[]" id="accessories_itemType" class="form-check-input item-checkbox" value="Accessories">
                                    <label for="accessories_itemType" class="form-check-label">Accessories</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="h5" for="status_export">Choose Status</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="all_status" id="all_status" class="form-check-input" value="all">
                                    <label for="all_status" class="form-check-label">Select All</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="status_export[]" id="active_status" class="form-check-input status-checkbox" value="Active">
                                    <label for="active_status" class="form-check-label">Active</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="status_export[]" id="repaired_status" class="form-check-input status-checkbox" value="Repaired">
                                    <label for="repaired_status" class="form-check-label">Repaired</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="status_export[]" id="under_repair_status" class="form-check-input status-checkbox" value="Under Repair">
                                    <label for="under_repair_status" class="form-check-label">Under Repair</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb1">
                                    <input type="checkbox" name="status_export[]" id="retired_status" class="form-check-input status-checkbox" value="Retired">
                                    <label for="retired_status" class="form-check-label">Retired</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check mb1">
                                    <input type="checkbox" name="status_export[]" id="disposed_status" class="form-check-input status-checkbox" value="Disposed">
                                    <label for="disposed_status" class="form-check-label">Disposed</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="h5">Choose Date</label>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="dateFrom" class="col-form-label">Acquired From</label>
                                    <input type="date" name="dateFrom" id="dateFrom" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="dateTo" class="col-form-label">Aquired To</label>
                                    <input type="date" name="dateTo" id="dateTo" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="exportAllDate" id="exportAllDate" class="form-check-input" value="1">
                                    <label for="exportAllDate" class="form-check-label">Disregard Date Acquired</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end">
                                <button type="submit" class="btn btn-sm shadow-sm btn-lg btn-primary">
                                    <i class="fas fa-download"></i> Export Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewInventoryModal" tabindex="-1" aria-labelledby="viewInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center px-4">
                    <h3 class="modal-title" id="viewInventoryModalLabel">Item View | Asset #: <span id="assetNumber_edit"></span></h3>
                    <div class="header-actions d-flex align-items-center" style="gap: 8px;">
                        <?php if ($authorizations['inventory_edit']): ?>
                            <button type="button" class="btn btn-circle shadow-sm btn-info" id="requestChangesBtn" role="button" data-bs-placement="bottom" title="Request Changes" data-bs-target="#requestChangesModal" data-bs-toggle="tooltip"><i class="fa-solid fa-comment-pen"></i></button>
                        <?php endif; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body p-xl-3">
                    <form id="editInventoryForm" class="container needs-validation" novalidate autocomplete="off">
                        <div class="row mb-lg-3">
                            <div class="col">
                                <h4 class="mb-2">Item Details</h4>
                                <div class="mb-2 form-group">
                                    <label for="itemType_edit" class="col-form-label">Item Type</label>
                                    <select name="itemType" id="itemType_edit" class="form-select form-select-sm" required disabled>
                                        <option value="" selected hidden>--Select Item Type--</option>
                                        <option value="Desktop">Desktop</option>
                                        <option value="Laptop">Laptop</option>
                                        <option value="Monitor">Monitor</option>
                                        <option value="Printer">Printer</option>
                                        <option value="Hardisk">Hardisk</option>
                                        <option value="RAM">RAM</option>
                                        <option value="Video Card">Video Card</option>
                                        <option value="UPS">UPS</option>
                                        <option value="UPS Battery">UPS Battery</option>
                                        <option value="Router">Router</option>
                                        <option value="Accessories">Accessories</option>
                                    </select>
                                    <div class="invalid-feedback">Please Select Item Type</div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label for="itemCategory_edit" class="col-form-label">Item Category</label>
                                    <select name="itemCategory" id="itemCategory_edit" class="form-select form-select-sm" disabled required>
                                        <option value="" selected hidden>--Select Item Category--</option>
                                        <option value="Desktop" hidden>Desktop</option>
                                        <option value="Laptop" hidden>Laptop</option>
                                        <option value="Monitor" hidden>Monitor</option>
                                        <option value="Printer" hidden>Printer</option>
                                        <option value="Hardisk" hidden>Hardisk</option>
                                        <option value="RAM" hidden>RAM</option>
                                        <option value="Video Card" hidden>Video Card</option>
                                        <option value="UPS" hidden>UPS</option>
                                        <option value="UPS Battery" hidden>UPS Battery</option>
                                        <option value="Router" hidden>Router</option>
                                        <option value="Keyboard">Keyboard</option>
                                        <option value="Mouse">Mouse</option>
                                        <option value="Headset">Headset</option>
                                        <option value="Webcam">Webcam</option>
                                        <option value="Scanner">Scanner</option>
                                        <option value="Wireless HDMI">Wireless HDMI</option>
                                        <option value="External Drive">External Drive</option>
                                    </select>
                                    <div class="invalid-feedback">Please Select Item Category</div>
                                </div>

                                <div class="mb-2 form-group">
                                    <label for="itemBrand_edit" class="col-form-label">Item Brand</label>
                                    <input type="text" name="itemBrand" id="itemBrand_edit" class="form-control form-control-sm" required disabled></input>
                                    <div class="invalid-feedback">Please Input Item Brand</div>
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="itemModel_edit" class="col-form-label">Item Model</label>
                                    <input type="text" name="itemModel" id="itemModel_edit" class="form-control form-control-sm" required disabled></input>
                                    <div class="invalid-feedback">Please Input Item Model</div>
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="itemSpecification_edit" class="col-form-label">Item Specification</label>
                                    <textarea name="itemSpecification" id="itemSpecification_edit" class="form-control form-control-sm" required disabled></textarea>
                                    <div class="invalid-feedback">Please Input Item Specification</div>
                                </div>
                                <hr class="sidebar-divider">
                                <h4 class="mb-2">Item User Information</h4>
                                <div class="mb-2 form-group">
                                    <label for="user_edit" class="col-form-label">User Name</label>
                                    <input type="text" name="user" id="user_edit" class="form-control form-control-sm" required disabled>
                                    <div class="invalid-feedback">Please Input User Name</div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label for="computerName_edit" class="col-form-label">Computer Name</label>
                                    <input type="text" name="computerName" id="computerName_edit" class="form-control form-control-sm" required disabled>
                                    <div class="invalid-feedback">Please Input Computer Name</div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label for="department_edit" class="col-form-label">Department</label>
                                    <select name="department" id="department_edit" class="form-select form-select-sm" required disabled>
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
                                    <label for="dateAcquired_edit" class="col-form-label">Date Acquired</label>
                                    <input type="date" name="dateAcquired" id="dateAcquired_edit" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>" required disabled>
                                    <div class="invalid-feedback">Please Input Date Acquired</div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label for="supplierName_edit" class="col-form-label">Supplier Name</label>
                                    <input type="text" name="supplierName" id="supplierName_edit" class="form-control form-control-sm" required disabled>
                                    <div class="invalid-feedback">Please Input Supplier Name</div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label for="serialNumber_edit" class="col-form-label">Serial Number</label>
                                    <input type="text" name="serialNumber" id="serialNumber_edit" class="form-control form-control-sm" required disabled>
                                    <div class="invalid-feedback">Please Input Serial Number</div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label for="price_edit" class="col-form-label">Price</label>
                                    <input type="number" name="price" id="price_edit" class="form-control form-control-sm" required disabled>
                                    <div class="invalid-feedback">Please Input Valid price</div>
                                </div>
                                <div class="mb-2 form-group">
                                    <label for="status_edit" class="col-form-label">Status</label>
                                    <select name="status" id="status_edit" class="form-select form-select-sm" required disabled>
                                        <option value="" hidden>--Select Item Status--</option>
                                        <option value="Active">Active</option>
                                        <option value="Under Repair" hidden>Under Repair</option>
                                        <option value="Repaired">Repaired</option>
                                        <option value="Retired">Retired</option>
                                    </select>
                                    <div class="invalid-feedback">Please Select Item Status</div>
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="remarks_edit" class="col-form-label">Remarks</label>
                                    <textarea name="remarks" id="remarks_edit" class="form-control form-control-sm" disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <?php if ($authorizations['inventory_edit']): ?>
                            <div class="row action-row">
                                <div class="col d-flex justify-content-end align-items-end action-column" id="viewActionsRow">
                                    <button type="button" class="btn btn-sm shadow-sm btn-danger" id="retireInventoryButton"><i class="fas fa-calendar-xmark"></i> Retire</button>
                                    <button type="button" class="btn btn-sm shadow-sm btn-warning" id="repairButton"><i class="fas fa-screwdriver-wrench"></i> Repair</button>
                                    <button type="button" class="btn btn-sm shadow-sm btn-primary" id="editButton"><i class="fas fa-pencil"></i> Edit</button>
                                </div>
                                <div class="col d-none justify-content-end align-items-end action-column" id="editActionsRow">
                                    <button type="button" class="btn btn-sm shadow-sm btn-danger" id="cancelButton"><i class="fas fa-ban"></i> Cancel</button>
                                    <button type="submit" class="btn btn-sm shadow-sm btn-primary" id="saveButton"><i class="fas fa-floppy-disk"></i> Save</button>
                                </div>
                                <div class="col d-none justify-content-end align-items-end action-column" id="retiredActionsRow1">
                                    <button type="button" class="btn btn-sm shadow-sm btn-danger" id="disposeButton"><i class="fas fa-dumpster"></i> Dispose</button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="id" id="id_edit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include '../../components/external-js-import.php'; ?>
<script src="../../../assets/js/admin/inventory-management/inventory.js"></script>
<script src="../../../assets/js/admin/inventory-management/exportFile.js"></script>
<script src="../../../assets/js/admin/inventory-management/viewInventory.js"></script>
<?php if ($authorizations['inventory_edit']): ?>
    <script src="../../../assets/js/admin/inventory-management/addInventory.js"></script>
    <script src="../../../assets/js/admin/inventory-management/importFile.js"></script>
    <script src="../../../assets/js/admin/inventory-management/repairItem.js"></script>
    <script src="../../../assets/js/admin/inventory-management/requestChanges.js"></script>
    <script src="../../../assets/js/admin/inventory-management/editFA.js"></script>
    <script src="../../../assets/js/admin/inventory-management/absoluteDelete.js"></script>
    <script src="../../../assets/js/admin/inventory-management/unretire.js"></script>
<?php endif; ?>



</html>