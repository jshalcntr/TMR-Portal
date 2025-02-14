<?php
session_start();

require('../../../backend/dbconn.php');
require('../../../backend/middleware/pipes.php');
require('../../../backend/middleware/authorize.php');

if (authorize($_SESSION['user']['role'] == "S-ADMIN", $conn)) {
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
    <link rel="stylesheet" href="../../../assets/css/custom/ticketing-system/ticketing.css">
    <?php include '../../components/external-css-import.php' ?>

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
                    <div class="row">
                        <div class="col-md-12 row">
                            <div class="card shadow mb-4 col-md-2" data-category="all-overdue" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">All Overdue Tasks</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="all-overdue-tasks">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="all-today-due" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">All Tickets Due Today</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="all-today-due-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="all-open" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Open Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="all-open-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="all-for-approval" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">All For Approval Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="all-for-approval-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="reopen-tickets" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Request Reopen</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="reopen-tickets">0</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="card shadow mb-4 col-md-2" data-category="overdue" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Overdue Tasks</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="overdue-tasks">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="today-due" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tickets Due Today</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="today-due-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="open" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Open Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="open-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="for-approval" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">For Approval Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="for-approval-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="unassigned" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Unassigned Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="unassigned-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="finished" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Closed Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="closed-tickets">0</h1>
                                </div>
                            </div>
                            <!-- <div class="card shadow mb-4 col-md-2" data-category="all" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">All Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="all-tickets">0</h1>
                                </div>
                            </div> -->
                        </div>

                        <!-- Modal for Tickets Table -->
                        <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true" data-bs-backdrop="static">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ticketModalLabel">Tickets</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover" id="ticketTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Ticket ID</th>
                                                    <th>Requestor</th>
                                                    <th>Date Requested</th>
                                                    <th>Subject</th>
                                                    <th>Status</th>
                                                    <th>Due Date</th>
                                                    <th>Attachment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Rows will be dynamically inserted -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Ticket Details -->
                        <div class="modal fade" id="ticketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" data-bs-backdrop="static" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ticketDetailsModalLabel">Ticket Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Ticket ID:</strong> <span id="ticketId"></span></p>
                                        <p><strong>Requestor:</strong> <span id="ticketRequestorId"></span></p>
                                        <p><strong>Department:</strong> <span id="ticketRequestorDepartment"></span></p>
                                        <p><strong>Subject:</strong> <span id="ticketSubject"></span></p>
                                        <p><strong>Description:</strong> <span id="ticketDescription"></span></p>
                                        <p><strong>Type:</strong> <span id="ticketType"></span></p>
                                        <p><strong>Attachment:</strong> <span id="ticketAttachment"></span></p>
                                        <p><strong>Handler:</strong>
                                            <select id="ticketHandlerId" class="form-control" disabled>
                                                <!-- Options will be dynamically inserted -->
                                            </select>
                                        </p>
                                        <p><strong>Status:</strong>
                                            <select id="ticketStatus" class="form-control" disabled>
                                                <!-- Options will be dynamically inserted -->
                                            </select>
                                        </p>
                                        <p><strong>Due Date:</strong>
                                            <input type="datetime-local" id="ticketDueDate" class="form-control" disabled>
                                        </p>
                                        <p><strong>Conclusion:</strong> <span id="ticketConclusion"></span></p>
                                        <textarea id="conclusionTextArea" style="display: none;" class="form-control" placeholder="Enter conclusion here..."></textarea>
                                        <hr>
                                        <button id="editButton" class="btn btn-outline-info" onclick="enableEditing()">Edit</button>
                                        <button id="saveButton" class="btn btn-outline-primary" onclick="saveTicketDetails()" style="display: none;">Save</button>
                                        <button id="cancelsaveButton" class="btn btn-outline-danger" onclick="cancelTicketDetails()" style="display: none; float: right">Cancel</button>
                                        <button id="closeTicketButton" class="btn btn-outline-danger" onclick="showConclusionTextArea()">Close Ticket</button>
                                        <button id="saveConclusionButton" class="btn btn-outline-primary" onclick="saveConclusion()" style="display: none;">Save Conclusion</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Ticket Details -->
                        <div class="modal fade" id="unassignedticketDetailsModal" tabindex="-1" aria-labelledby="unassignedticketDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ticketDetailsModalLabel">Ticket Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Ticket ID:</strong> <span id="unassignedticketId"></span></p>
                                        <p><strong>Requestor:</strong> <span id="unassignedticketRequestorId"></span></p>
                                        <p><strong>Department:</strong> <span id="unassignedticketRequestorDepartment"></span></p>
                                        <p><strong>Subject:</strong> <span id="unassignedticketSubject"></span></p>
                                        <p><strong>Description:</strong> <span id="unassignedticketDescription"></span></p>
                                        <p><strong>Attachment:</strong> <span id="unassignedticketAttachment"></span></p>
                                        <p><strong>Type:</strong> <span id="unassignedticketType"></span></p>
                                        <p><strong>Handler:</strong>
                                            <select id="unassignedticketHandlerId" disabled>
                                                <option value="" disabled selected>Select Handler</option>
                                                <!-- Options will be dynamically inserted -->
                                            </select>
                                        </p>
                                        <p><strong>Status:</strong>
                                            <select id="unassignedticketStatus" disabled>
                                                <!-- Options will be dynamically inserted -->
                                            </select>
                                        </p>
                                        <p><strong>Due Date:</strong>
                                            <input type="datetime-local" id="unassignedticketDueDate" required>
                                        </p>
                                        <p><span id="errorMessage" class="text-danger"></span></p>
                                        <p><strong>Conclusion:</strong> <span id="unassignedticketConclusion"></span></p>
                                        <div>
                                            <input type="checkbox" id="forApprovalCheckbox"> For Approval
                                        </div>
                                        <button id="unassignededitButton" class="btn btn-outline-info" onclick="enableUnassignedEditing()">Edit</button>
                                        <button id="claimButton" class="btn btn-success" onclick="claimTicket()">Claim</button>
                                        <button id="unassignedsaveButton" class="btn btn-outline-primary" onclick="saveUnassignedTicketDetails()" style="display: none;">Save</button>
                                        <button id="unassignedcancelsaveButton" class="btn btn-outline-danger" onclick="cancelUnassignedTicketDetails()" style="display: none; float: right">Cancel</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Closed Ticket Details -->
                        <div class="modal fade" id="closedTicketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ticketDetailsModalLabel">Ticket Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Ticket ID:</strong> <span id="closedticketId"></span></p>
                                        <p><strong>Requestor:</strong> <span id="closedticketRequestorId"></span></p>
                                        <p><strong>Department:</strong> <span id="closedticketRequestorDepartment"></span></p>
                                        <p><strong>Subject:</strong> <span id="closedticketSubject"></span></p>
                                        <p><strong>Description:</strong> <span id="closedticketDescription"></span></p>
                                        <p><strong>Type:</strong> <span id="closedticketType"></span></p>
                                        <p><strong>Attachment:</strong> <span id="closedticketAttachment"></span></p>
                                        <p><strong>Handler:</strong>
                                            <select id="closedticketHandlerId" disabled>
                                                <!-- Options will be dynamically inserted -->
                                            </select>
                                        </p>
                                        <p><strong>Status:</strong>
                                            <select id="closedticketStatus" disabled>
                                                <!-- Options will be dynamically inserted -->
                                            </select>
                                        </p>
                                        <p><strong>Due Date:</strong>
                                            <input type="datetime-local" id="closedticketDueDate" disabled>
                                        </p>
                                        <p><strong>Conclusion:</strong> <span id="closedticketConclusion"></span></p>
                                        <button id="ReopeButton" class="btn btn-outline-info" onclick="reopenTicket()">Reopen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Confirm Reopen Request -->
                        <div class="modal fade" id="confirmReopenModal" tabindex="-1" aria-labelledby="confirmReopenModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmReopenModalLabel">Confirm Reopen Request</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Ticket ID:</strong> <span id="confirmReopenTicketId"></span></p>
                                        <p><strong>Requestor:</strong> <span id="confirmReopenRequestorId"></span></p>
                                        <p><strong>Department:</strong> <span id="confirmReopenRequestorDepartment"></span></p>
                                        <p><strong>Subject:</strong> <span id="confirmReopenSubject"></span></p>
                                        <p><strong>Description:</strong> <span id="confirmReopenDescription"></span></p>
                                        <p><strong>Reason for Reopening:</strong></p>
                                        <textarea id="reopenReasonDescription" class="form-control" rows="3"></textarea>
                                        <button id="submitReopenRequestButton" class="btn btn-outline-success mt-2">Confirm Reopen</button>
                                        <button id="cancelReopenRequestButton" class="btn btn-outline-danger mt-2" style="float: right;">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!------------------------------------------Charts--------------------------------------------------->

                        <!-- line Chart -->
                        <div class="col-md-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Closed Tickets</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="ticketAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pie Chart -->
                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Department Tickets</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="ticketPieChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


</body>
<?php include "../../components/external-js-import.php" ?>
<script src="../../../assets/js/admin/ticketing-system/ticket-chart-area.js"></script>
<script src="../../../assets/js/admin/ticketing-system/ticket-chart-pie.js"></script>
<script src="../../../assets/js/admin/ticketing-system/admin-tickets.js"></script>

</html>