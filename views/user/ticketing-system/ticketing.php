<?php
session_start();

require('../../../backend/auth.php');
require('../../../backend/dbconn.php');
require('../../../backend/middleware/pipes.php');
require('../../../backend/middleware/authorize.php');

if (authorize($_SESSION['user']['role'] == "USER" || $_SESSION['user']['role'] == "HEAD", $conn)) {
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

    <?php include '../../components/external-css-import.php' ?>
    <link rel="stylesheet" href="../../../assets/css/custom/user/dashboard.css">
    <link rel="stylesheet" href="../../../assets/css/custom/ticketing-system/ticketing.css">


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
                        <!-- Begin Ticket Form -->
                        <div class="<?= $divsize ?>">
                            <div class="card card-body shadow">
                                <form id="ticketForm" enctype="multipart/form-data">
                                    <!-- <form action="../../../backend/user/ticketing-system/newticket.php" method="POST" enctype="multipart/form-data"> -->
                                    <h3>New Ticket</h3>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <!-- <input type="text" name="ticket_category" id="ticket_category" class="form-control" placeholder="Category" required> -->
                                            <?php include "../../../backend/user/ticketing-system/ticketcategory.php" ?>
                                            <select name="ticket_category" id="ticket_category" class="form-control" required>
                                                <option value="" disabled selected>Select a Category</option>
                                                <?php foreach ($categories as $mainCategory => $subCategories): ?>
                                                    <optgroup label="<?php echo htmlspecialchars($mainCategory); ?>">
                                                        <?php foreach ($subCategories as $subCategory): ?>
                                                            <option value="<?php echo htmlspecialchars($subCategory); ?>">
                                                                <?php echo htmlspecialchars($subCategory); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" name="ticket_subject" id="ticket_subject" class="form-control" placeholder="Subject" required>

                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <textarea name="ticket_content" id="ticket_content" class="form-control" rows="5" placeholder="Description" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="ticket_attachment">Attachment</label>
                                            <input type="file" name="ticket_attachment" id="ticket_attachment" class="form-control-file">
                                            <small class="form-text text-muted">Allowed file types: .jpg, .png, .pdf, .docx</small>
                                            <div id="file-error" class="text-danger mt-1"></div>
                                        </div>
                                    </div>
                                    <!-- Success/Error Message -->
                                    <div id="form-message" class="text-center"></div>
                                    <div id="loading-spinner" class="spinner-border text-info text-center" role="status" style="display: none;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12 text-right">
                                            <button type="submit" name="submit_ticket" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </div>

                                </form>
                                <hr>
                                <div class="similar-ticket card card-body shadow hidden"></div>
                            </div>
                        </div>
                        <!--End of Ticket Form-->
                        <!-- Heads for approval ticket -->
                        <div class="<?= $divsize . " " . $divhidden ?>">
                            <div class="card card-body shadow overflow-auto">
                                <h3 class="page-header">For Approval</h3>
                                <div id="forApprovalContainer">
                                    <!-- Tickets will be dynamically populated here -->
                                    <p>Loading tickets...</p>
                                </div>
                            </div>
                        </div>


                        <!-- End of for approval ticket -->
                        <!-- Pending Tickets -->
                        <div id="pendingTickets" class="<?= $divsize ?>">
                            <div class="card card-body shadow overflow-auto">
                                <h3 class="page-header">Pending Tickets</h3>
                                <div id="pendingTicketList">
                                    <!-- Tickets will be populated here dynamically -->
                                </div>
                            </div>
                        </div>
                        <!-- End of pending tickets -->
                        <!-- ticket history -->
                        <div class="<?= $divsize ?>">
                            <div class="card card-body shadow overflow-auto">
                                <h3 class="page-header">My Ticket History</h3>
                                <div id="closedTicketList">
                                    <!-- Tickets will be populated here dynamically -->
                                </div>
                            </div>
                        </div>
                        <!-- End of ticket history -->
                        <!-- Ticket Details Modal -->
                        <div class="modal fade" id="forApprovalticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ticketModalTitle">Ticket Details</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Description:</strong> <span id="ticketModalDescription"></span></p>
                                        <p><strong>Date Created:</strong> <span id="ticketModalDate"></span> <span id="ticketModalTime"></span></p>
                                        <p><strong>Handler:</strong> <span id="ticketModalHandler"></span></p>
                                        <p><strong>Requestor:</strong> <span id="ticketModalRequestor"></span></p>
                                        <p><strong>Attachment:</strong> <span id="ticketModalAttachment"></span></p>
                                        <div class="text-center">
                                            <button id="approveButton" class="btn btn-success">Approve</button>
                                            <button id="rejectButton" class="btn btn-danger">Reject</button>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="ticketsModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ticketModalLabel">Ticket Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Title:</strong> <span id="ticketTitle"></span></p>
                                        <p><strong>Description:</strong> <span id="ticketDescription"></span></p>
                                        <p><strong>Attachment:</strong> <span id="ticketAttachment"></span></p>
                                        <p><strong>Date Created:</strong> <span id="ticketDate"></span> <span id="ticketTime"></span></p>
                                        <div id="actionButtons" class="text-center">
                                            <!-- Action buttons will be populated dynamically -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
<script src="../../../assets/js/user/ticketing-system/userTicketing.js"></script>
<script src="../../../assets/js/user/ticketing-system/addTicket.js"></script>
<!-- <script src="../../../assets/js/user/ticketing-system/ticket-cetegory.js"></script> -->

</html>