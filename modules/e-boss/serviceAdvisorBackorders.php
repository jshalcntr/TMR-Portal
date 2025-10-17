<?php
session_start();

require('../../vendor/autoload.php');
require('../../backend/dbconn.php');
require('../../backend/middleware/pipes.php');
require('../../backend/middleware/authorize.php');

if (authorize($_SESSION['user']['role'] == "ADMIN", $conn)) {
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

    <title>E-BOSS - Service Advisor Backorders</title>

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
                        <h1 class="h3 mb-2 text-gray-800">Service Advisor - Backorders Management</h1>
                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-sm btn-outline-primary shadow-sm mr-2" data-bs-toggle="modal" data-bs-target="#batchAppointmentModal">
                                <i class="fas fa-calendar-plus fa-sm"></i> Batch Schedule
                            </a>
                            <button class="btn btn-sm btn-primary shadow-sm" id="exportBtn">
                                <i class="fas fa-download fa-sm"></i> Export Excel
                            </button>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered small dataTable no-footer" id="serviceAdvisorTable" width="100%" cellspacing="0">
                                    <thead class="table-bg-primary text-white">
                                        <tr>
                                            <th>ORDER DATE</th>
                                            <th>RO NUMBER</th>
                                            <th>CUSTOMER NAME</th>
                                            <th>ORDER NO</th>
                                            <th>PART NUMBER</th>
                                            <th>PART NAME</th>
                                            <th>QTY</th>
                                            <th>UNIT PRICE</th>
                                            <th>TOTAL</th>
                                            <th>ETA 1</th>
                                            <th>ETA 2</th>
                                            <th>ETA 3</th>
                                            <th>AGING</th>
                                            <th>STATUS</th>
                                            <th>SERVICE TYPE</th>
                                            <th>UNIT MODEL</th>
                                            <th>PLATE NO</th>
                                            <th>ACTIONS</th>
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

    <!-- Appointment Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-calendar-plus"></i> Schedule Installation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm">
                        <input type="hidden" id="backorderId" name="backorder_id">

                        <div class="mb-3">
                            <label for="appointmentDate" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" id="appointmentDate" name="appointment_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="appointmentTime" class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" id="appointmentTime" name="appointment_time" required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" id="submitAppointment">
                                <i class="fas fa-save"></i> Schedule
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-eye"></i> Backorder Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewDetailsContainer">
                    <!-- AJAX-loaded view goes here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Batch Appointment Modal -->
    <div class="modal fade" id="batchAppointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-calendar-plus"></i> Batch Schedule Installation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="batchAppointmentForm">
                        <div class="mb-3">
                            <label for="backorderSelect" class="form-label">Select Delivered Backorders</label>
                            <select class="form-control select2" id="backorderSelect" name="backorder_ids[]" multiple required>
                                <!-- Options will be loaded via AJAX -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="batchAppointmentDate" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" id="batchAppointmentDate" name="appointment_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="batchAppointmentTime" class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" id="batchAppointmentTime" name="appointment_time" required>
                        </div>

                        <div class="mb-3">
                            <label for="batchNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="batchNotes" name="notes" rows="3"></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" id="submitBatchAppointment">
                                <i class="fas fa-save"></i> Schedule Selected
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../components/shared/external-js-import.php'; ?>
    <!-- Add Select2 for better dropdown experience -->
    <script src="../../assets/js/e-boss/serviceAdvisorBackorders.js"></script>
</body>

</html>