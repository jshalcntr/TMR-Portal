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
                            <div class="card shadow border-0">
                                <!-- Card Header -->
                                <div class="card-header bg-primary text-white d-flex align-items-center">
                                    <i class="fa-solid fa-ticket-alt me-2"></i>
                                    <h5 class="mb-0">New Ticket</h5>
                                </div>

                                <div class="card-body">
                                    <form id="ticketForm" method="POST" enctype="multipart/form-data">
                                        <!-- Ticket Category -->
                                        <div class="mb-3">
                                            <label for="ticket_category" class="form-label fw-bold">Category</label>
                                            <?php include "../../../backend/user/ticketing-system/ticketcategory.php" ?>
                                            <select name="ticket_category" id="ticket_category" class="form-select" required>
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

                                        <!-- Subject -->
                                        <div class="mb-3">
                                            <label for="ticket_subject" class="form-label fw-bold">Subject</label>
                                            <input type="text" name="ticket_subject" id="ticket_subject" class="form-control" placeholder="Enter subject" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label for="ticket_content" class="form-label fw-bold">Description</label>
                                            <textarea name="ticket_content" id="ticket_content" class="form-control" rows="5" placeholder="Enter ticket description" required></textarea>
                                        </div>

                                        <!-- Attachment -->
                                        <div class="mb-3">
                                            <label for="ticket_attachment" class="form-label fw-bold">Attachment</label>
                                            <div class="input-group">
                                                <input type="file" name="ticket_attachment" id="ticket_attachment" class="form-control">
                                                <label class="input-group-text" for="ticket_attachment"><i class="fa-solid fa-paperclip"></i></label>
                                            </div>
                                            <small class="form-text text-muted">Allowed file types: .jpg, .png, .pdf, .docx</small>
                                            <div id="file-error" class="text-danger mt-1"></div>
                                        </div>

                                        <!-- Success/Error Message -->
                                        <div id="form-message" class="text-center my-3"></div>

                                        <!-- Loading Spinner -->
                                        <!-- <div id="loading-spinner" class="d-flex justify-content-center my-3" style="display: none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div> -->

                                        <!-- Submit Button -->
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="submit_ticket" class="btn btn-primary">
                                                <i class="fa-solid fa-paper-plane me-1"></i> Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Similar Tickets Section (Hidden by Default) -->
                            <div class="card card-body shadow mt-3 d-none" id="similar-ticket"></div>
                        </div>
                        <!-- End of Ticket Form -->


                        <!-- Heads for Approval Ticket -->
                        <div class="<?= $divsize . " " . $divhidden ?>">
                            <div class="card shadow border-0">
                                <!-- Card Header -->
                                <div class="card-header bg-warning text-dark d-flex align-items-center">
                                    <i class="fa-solid fa-clock me-2"></i>
                                    <h5 class="mb-0">For Approval</h5>
                                </div>

                                <div class="card-body overflow-auto" style="max-height: 400px;">
                                    <div id="forApprovalContainer" class="d-flex flex-column align-items-center">
                                        <!-- Loading Spinner -->
                                        <div id="loading-spinner" class="d-flex justify-content-center my-3">
                                            <div class="spinner-border text-warning" role="status">
                                                <span class="visually-hidden">Loading tickets...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of for approval ticket -->
                        <!-- Pending Tickets Section -->
                        <div id="pendingTickets" class="<?= $divsize ?>">
                            <div class="card shadow border-0">
                                <!-- Card Header -->
                                <div class="card-header bg-info text-white d-flex align-items-center">
                                    <i class="fa-solid fa-hourglass-half me-2"></i>
                                    <h5 class="mb-0">Pending Tickets</h5>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body overflow-auto" style="max-height: 400px;">
                                    <div id="pendingTicketList" class="d-flex flex-column align-items-center">
                                        <!-- Loading Spinner -->
                                        <div id="loading-spinner" class="d-flex justify-content-center my-3">
                                            <div class="spinner-border text-info" role="status">
                                                <span class="visually-hidden">Loading tickets...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Pending Tickets Section -->
                        <!-- My Ticket History Section -->
                        <div class="<?= $divsize ?>">
                            <div class="card shadow border-0">
                                <!-- Card Header -->
                                <div class="card-header bg-dark text-white d-flex align-items-center">
                                    <i class="fa-solid fa-folder-closed me-2"></i>
                                    <h5 class="mb-0">My Ticket History</h5>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body overflow-auto" style="max-height: 400px;">
                                    <div id="closedTicketList" class="d-flex flex-column align-items-center">
                                        <!-- Loading Spinner -->
                                        <div id="loading-spinner" class="d-flex justify-content-center my-3">
                                            <div class="spinner-border text-dark" role="status">
                                                <span class="visually-hidden">Loading closed tickets...</span>
                                            </div>
                                        </div>

                                        <!-- Placeholder for Empty State -->
                                        <p id="noTicketsMessage" class="text-muted mt-3" style="display: none;">
                                            <i class="fa-solid fa-box-open me-2"></i> No closed tickets found.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of My Ticket History Section -->

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
                                                        <tr>
                                                            <th class="bg-light">Approval Due Date</th>
                                                            <td><span id="ticketDueDateApproval" class="text-warning"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Approval & Rejection Buttons -->
                                        <div class="d-flex justify-content-center gap-3 mt-4">
                                            <button id="approveButton" class="btn btn-primary">
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
                                                        <tr>
                                                            <th class="bg-light">Handler</th>
                                                            <td><span id="ticketHandler"></span></td>
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