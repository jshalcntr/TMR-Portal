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
                        <div class="col-md-12 overflow-x-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="h3 mb-0 text-gray-800">Ticketing System</h1>
                                <button id="createTicketButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTicketModal">
                                    <i class="fa-solid fa-edit"></i> Create Ticket
                                </button>
                            </div>
                            <table id="ticketsTable" class="table table-hover small">
                                <thead class="table-bg-primary">
                                    <tr>
                                        <th>Ticket#</th>
                                        <th>Type</th>
                                        <th>Subject</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Requestor</th>
                                        <th>Handler</th>
                                        <th>Due Date</th>
                                        <th>Approval Due</th>
                                        <th>Created</th>
                                        <th>Accepted</th>
                                        <th>Finished</th>
                                        <th>Approval Reason</th>
                                        <th>Date Approved</th>
                                        <th>Attachment</th>
                                        <th>Approval Attachment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Create Ticket Modal -->
                        <div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="createTicketModalLabel"><i class="fa-solid fa-ticket-alt me-2"></i>New Ticket</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Category Selection UI -->
                                        <div id="categoryContainer" class="mb-4">
                                            <h6 class="fw-bold">Select a Category</h6>
                                            <div id="categoryList" class="d-flex flex-wrap gap-2 row"></div>
                                        </div>

                                        <!-- Subject Selection UI -->
                                        <div id="subjectContainer" class="mb-4" style="display:none;">
                                            <h6 class="fw-bold">Select a Subject <button id="backToCategory" class="btn btn-outline-primary btn-sm mb-2 float-end"><i class="fa-solid fa-arrow-left"></i> Back</button></h6>
                                            <div id="subjectList" class="d-flex flex-wrap gap-2 row"></div>
                                        </div>

                                        <form id="ticketForm" method="POST" enctype="multipart/form-data" style="display:none;">
                                            <button id="backToSubject" class="btn btn-outline-primary btn-sm mb-2 float-end"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                            <!-- Category -->
                                            <div class="mb-3">
                                                <label for="ticket_category" class="form-label fw-bold">Category</label>
                                                <input type="hidden" id="ticket_category" name="ticket_category">
                                                <span id="ticket_category_display" class="form-text fw-bold"></span>
                                            </div>
                                            <!-- Subject -->
                                            <div class="mb-3">
                                                <label for="ticket_subject" class="form-label fw-bold">Subject</label>
                                                <input type="hidden" id="ticket_subject" name="ticket_subject">
                                                <span id="ticket_subject_display" class="form-text fw-bold"></span>
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

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" name="submit_ticket" class="btn btn-primary">
                                                    <i class="fa-solid fa-paper-plane me-1"></i> Submit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Begin Ticket Form -->


                        <!-- Ticket Details Modal -->
                        <div class="modal fade" id="forApprovalticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="fw-bold mb-3">Ticket #<span id="ticketModalId"></span> For Approval</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0 ">
                                            <div class="card-body p-3">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Subject</th>
                                                            <td><span id="ticketModalTitle"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Description</th>
                                                            <td><span id="ticketModalDescription"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Created</th>
                                                            <td>
                                                                <span id="ticketModalDate"></span>
                                                                <span id="ticketModalTime"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Requestor</th>
                                                            <td><span id="ticketModalRequestor"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Handler</th>
                                                            <td><span id="ticketModalHandler"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Attachment</th>
                                                            <td><span id="ticketModalAttachment"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Priority</th>
                                                            <td><span id="ticketModalPriority"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <hr class="my-3">
                                                <h6 class="fw-bold mb-3">For Approval Details</h6>
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Approval Reason</th>
                                                            <td><span id="ticketModalApprovalReason"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Approval Due Date</th>
                                                            <td><span id="ticketModalDueDateApproval"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Approval Attachment</th>
                                                            <td><span id="ticketModalApprovalAttachment"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <!-- Approval & Rejection Buttons -->
                                        <div id="approvalButtons" class="d-flex justify-content-center gap-3 mt-4">
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
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-ticket-alt me-2"></i> Ticket #<span id="ticketNumber"></span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 row">
                                        <!-- Header with Chat Button -->
                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0 col-md-6 ticket-details-card"> <!-- Left card -->
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <!-- <button id="openChatButton" class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                                data-id="" data-title="" data-requestor=""
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Chat with MIS">
                                                <i class="fa-solid fa-comments me-1"></i> Chat
                                            </button> -->
                                                </div>
                                                <table class="table table-bordered table-striped table-sm mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Subject</th>
                                                            <td><span id="ticketTitle"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Description</th>
                                                            <td><span id="ticketDescription"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Status</th>
                                                            <td><span id="ticketStatus"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Due Date</th>
                                                            <td><span id="ticketDueDate"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Handler</th>
                                                            <td><span id="ticketHandler"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Created</th>
                                                            <td><span id="ticketDate"></span> <span id="ticketTime"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Attachment</th>
                                                            <td id="ticketAttachment"></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Priority</th>
                                                            <td><span id="ticketPriority"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Requestor</th>
                                                            <td><span id="ticketRequestor"></span> <small class="text-muted" id="ticketRequestorDept"></small></td>
                                                        </tr>
                                                        <tr id="approvalDueDateRow">
                                                            <th class="bg-light">Approval Due Date</th>
                                                            <td><span id="ticketApprovalDueDate"></span></td>
                                                        </tr>
                                                        <tr id="approvalReasonRow">
                                                            <th class="bg-light">For Approval Reason</th>
                                                            <td><span id="ticketApprovalReason"></span></td>
                                                        </tr>
                                                        <tr id="approvalDateRow">
                                                            <th class="bg-light">Date Approved</th>
                                                            <td><span id="ticketApprovalDate"></span></td>
                                                        </tr>
                                                        <tr id="approvalAttachmentRow">
                                                            <th class="bg-light">Handler Attachment</th>
                                                            <td id="ticketApprovalAttachment"></td>
                                                        </tr>
                                                        <tr id="dateClosedRow">
                                                            <th class="bg-light">Date Closed</th>
                                                            <td><span id="ticketEndDate"></span> <span id="ticketEndTime"></span></td>
                                                        </tr>
                                                        <tr id="conclusionRow">
                                                            <th class="bg-light">Conclusion</th>
                                                            <td><span id="ticketConclusion"></span></td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <!-- Right: Chatbox -->
                                        <div id="chatBoxDiv" class="card shadow-sm border-0 col-md-6 d-flex flex-column chat-card"> <!-- Right card -->
                                            <div id="chatHistoryDiv" class="card-body p-3 d-flex flex-column">
                                                <h6 id="chatHistoryTitle" class="text-gray-600 border-bottom pb-2">Chat History</h6>
                                                <div id="chatHistory" class="overflow-auto flex-grow-1 mb-3"></div>
                                                <div class="input-group">
                                                    <textarea id="chatInput" class="form-control" placeholder="Type a message..." rows="3"></textarea>
                                                    <button id="sendChatMessage" class="btn btn-primary">Send</button>
                                                </div>
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
                        <!-- <div id="chatbox" class="chatbox">
                            <div class="chatbox-header">
                                <span id="chatboxTitle">Ticket Title</span>
                                <button id="closeChatbox" class="close-chatbox">&times;</button>
                            </div>
                            <div id="chatboxMessages" class="chatbox-messages"> -->
                        <!-- Chat messages will be populated here -->
                        <!-- </div>
                            <div class="chatbox-input">
                                <input type="text" id="chatboxInput" placeholder="Type a message...">
                                <button id="sendChatboxMessage">Send</button>
                            </div>
                        </div> -->
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