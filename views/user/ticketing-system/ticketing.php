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

    <?php include '../../../modules/components/shared/external-css-import.php' ?>
    <link rel="stylesheet" href="../../../assets/css/custom/shared/dashboard.css">
    <link rel="stylesheet" href="../../../assets/css/custom/ticketing-system/ticketing.css">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../../../modules/components/shared/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include "../../../modules/components/shared/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- Begin Ticket Form -->
                        <div class="<?= $divsize ?>">
                            <div class="card card-body shadow">
                                <form id="ticketForm" method="POST" enctype="multipart/form-data">
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
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body p-3">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Description</th>
                                                            <td><span id="ticketModalDescription"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Date Created</th>
                                                            <td>
                                                                <span id="ticketModalDate"></span>
                                                                <span id="ticketModalTime"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Handler</th>
                                                            <td><span id="ticketModalHandler"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Requestor</th>
                                                            <td><span id="ticketModalRequestor"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Attachment</th>
                                                            <td><span id="ticketModalAttachment"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Approval & Rejection Buttons -->
                                        <div class="d-flex justify-content-center gap-3 mt-4">
                                            <button id="approveButton" class="btn btn-success">
                                                <i class="fa-solid fa-check-circle me-1"></i> Approve
                                            </button>
                                            <button id="rejectButton" class="btn btn-danger">
                                                <i class="fa-solid fa-times-circle me-1"></i> Reject
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="ticketsModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <!-- Header with Chat Button -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="modal-title fw-bold"><i class="fa-solid fa-ticket-alt me-2"></i> Ticket Details</h5>
                                            <button id="openChatButton" class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                                data-id="" data-title="" data-requestor=""
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Chat with MIS">
                                                <i class="fa-solid fa-comments me-1"></i> Chat
                                            </button>
                                        </div>

                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body p-3">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Title</th>
                                                            <td><span id="ticketTitle"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Description</th>
                                                            <td><span id="ticketDescription"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Attachment</th>
                                                            <td><span id="ticketAttachment"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Date Created</th>
                                                            <td>
                                                                <span id="ticketDate"></span>
                                                                <span id="ticketTime"></span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Dynamic Action Buttons -->
                                        <div id="actionButtons" class="d-flex justify-content-center gap-3 mt-4">
                                            <!-- Buttons will be dynamically inserted here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chatbox -->
                        <div id="chatbox" class="chatbox">
                            <div class="chatbox-header">
                                <span id="chatboxTitle">Ticket Title</span>
                                <button id="closeChatbox" class="close-chatbox">&times;</button>
                            </div>
                            <div id="chatboxMessages" class="chatbox-messages">
                                <!-- Chat messages will be populated here -->
                            </div>
                            <div class="chatbox-input">
                                <input type="text" id="chatboxInput" placeholder="Type a message...">
                                <button id="sendChatboxMessage">Send</button>
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

<?php include "../../../modules/components/shared/external-js-import.php" ?>
<script src="../../../assets/js/user/ticketing-system/userTicketing.js"></script>
<!-- <script src="../../../assets/js/user/ticketing-system/addTicket.js"></script> -->
<!-- <script src="../../../assets/js/user/ticketing-system/ticket-cetegory.js"></script> -->

</html>