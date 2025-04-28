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
    <?php include '../../../modules/components/shared/external-css-import.php' ?>

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
                                    <h6 class="m-0 font-weight-bold text-primary">All Open Tickets</h6>
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
                                        <div id="ticketTableContainer">
                                            <!-- Table will be injected here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Ticket Details -->
                        <div class="modal fade" id="ticketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" data-bs-backdrop="static" aria-hidden="true">
                            <div class="modal-dialog modal-md">
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
                                                title="Chat with requestor">
                                                <i class="fa-solid fa-comments me-1"></i> Chat
                                            </button>
                                        </div>

                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body p-3">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Ticket ID</th>
                                                            <td><span id="ticketId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Requestor</th>
                                                            <td><span id="ticketRequestorId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Department</th>
                                                            <td><span id="ticketRequestorDepartment"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Subject</th>
                                                            <td><span id="ticketSubject"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Description</th>
                                                            <td><span id="ticketDescription"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Type</th>
                                                            <td><span id="ticketType"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Attachment</th>
                                                            <td><span id="ticketAttachment"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Conclusion Section -->
                                        <div class="mt-4">
                                            <h6 class="fw-bold"><i class="fa-solid fa-clipboard-check me-2"></i> Conclusion</h6>
                                            <p class="mb-2"><span id="ticketConclusion" class="text-muted fst-italic"></span></p>

                                            <!-- Textarea (Initially Hidden) -->
                                            <textarea id="conclusionTextArea" class="form-control mt-2 d-none fade"
                                                placeholder="Enter conclusion here..."></textarea>
                                        </div>

                                        <!-- Sticky Footer Actions -->
                                        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                                            <button id="cancelsaveButton" class="btn btn-outline-danger d-none" onclick="cancelTicketDetails()">
                                                <i class="fa-solid fa-ban me-1"></i> Cancel
                                            </button>
                                            <button id="closeTicketButton" class="btn btn-danger" onclick="showConclusionTextArea()">
                                                <i class="fa-solid fa-times-circle me-1"></i> Close Ticket
                                            </button>
                                            <button id="saveConclusionButton" class="btn btn-primary d-none" onclick="saveConclusion()">
                                                <i class="fa-solid fa-save me-1"></i> Save Conclusion
                                            </button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="allTicketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" data-bs-backdrop="static" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <!-- Header with Chat Button -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="modal-title fw-bold"><i class="fa-solid fa-ticket-alt me-2"></i> Ticket Details</h5>

                                        </div>

                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body p-3">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Ticket ID</th>
                                                            <td><span id="ticketIdAll"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Requestor</th>
                                                            <td><span id="ticketRequestorIdAll"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Department</th>
                                                            <td><span id="ticketRequestorDepartmentAll"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Subject</th>
                                                            <td><span id="ticketSubjectAll"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Description</th>
                                                            <td><span id="ticketDescriptionAll"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Type</th>
                                                            <td><span id="ticketTypeAll"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Attachment</th>
                                                            <td><span id="ticketAttachmentAll"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Handler</th>
                                                            <td><span id="ticketHandlerAll"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Conclusion Section -->
                                        <div class="mt-4">
                                            <h6 class="fw-bold"><i class="fa-solid fa-clipboard-check me-2"></i> Conclusion</h6>
                                            <p class="mb-2"><span id="ticketConclusionAll" class="text-muted fst-italic"></span></p>
                                        </div>
                                        <!-- Reassign Ticket Section -->
                                        <div class="mt-4 border-top pt-3">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button id="reassignTicketButton" class="btn btn-primary" onclick="reassignTicket(document.getElementById('ticketIdAll').innerText)">
                                                    <i class="fa-solid fa-user-edit me-1"></i> Reassign Ticket
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="unassignedticketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <!-- Header with Chat Button -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="modal-title fw-bold"><i class="fa-solid fa-ticket-alt me-2"></i> Unassigned Ticket</h5>
                                            <button id="openChatButtonUnassigned" class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                                data-id="" data-title="" data-requestor=""
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Chat with requestor">
                                                <i class="fa-solid fa-comments me-1"></i> Chat
                                            </button>
                                        </div>

                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body p-3">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Ticket ID</th>
                                                            <td><span id="unassignedticketId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Requestor</th>
                                                            <td><span id="unassignedticketRequestorId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Department</th>
                                                            <td><span id="unassignedticketRequestorDepartment"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Subject</th>
                                                            <td><span id="unassignedticketSubject"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Description</th>
                                                            <td><span id="unassignedticketDescription"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Attachment</th>
                                                            <td><span id="unassignedticketAttachment"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Type</th>
                                                            <td><span id="unassignedticketType"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- For Approval Checkbox -->
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" id="forApprovalCheckbox">
                                            <label class="form-check-label text-info fw-bold" for="forApprovalCheckbox">
                                                For Approval
                                            </label>
                                        </div>

                                        <!-- Ticket Priority -->
                                        <div class="mt-3">
                                            <label class="fw-bold">Priority:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ticketPriority" id="priorityCritical" value="CRITICAL">
                                                <label class="form-check-label text-danger" for="priorityCritical">
                                                    Critical (4 hrs)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ticketPriority" id="priorityImportant" value="IMPORTANT">
                                                <label class="form-check-label text-warning" for="priorityImportant">
                                                    Important (8 hrs)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ticketPriority" id="priorityNormal" value="NORMAL">
                                                <label class="form-check-label text-primary" for="priorityNormal">
                                                    Normal (24 hrs)
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Claim Button -->
                                        <div class="d-flex justify-content-end mt-3">
                                            <button id="claimButton" class="btn btn-primary" onclick="claimTicket()">
                                                <i class="fa-solid fa-hand-pointer me-1"></i> Claim Ticket
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Modal for Closed Ticket Details -->
                        <div class="modal fade" id="closedTicketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <!-- Header with Chat Button -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="modal-title fw-bold"><i class="fa-solid fa-ticket-alt me-2"></i> Closed Ticket</h5>
                                            <button id="openChatButtonClosed" class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                                data-id="" data-title="" data-requestor=""
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Chat with requestor">
                                                <i class="fa-solid fa-comments me-1"></i> Chat
                                            </button>
                                        </div>

                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body p-3">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Ticket ID</th>
                                                            <td><span id="closedticketId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Requestor</th>
                                                            <td><span id="closedticketRequestorId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Department</th>
                                                            <td><span id="closedticketRequestorDepartment"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Subject</th>
                                                            <td><span id="closedticketSubject"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Description</th>
                                                            <td><span id="closedticketDescription"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Type</th>
                                                            <td><span id="closedticketType"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Attachment</th>
                                                            <td><span id="closedticketAttachment"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Conclusion</th>
                                                            <td><span id="closedticketConclusion"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal for Approve or Reject Reopen Request -->
                        <div class="modal fade" id="approveRejectReopenModal" tabindex="-1" aria-labelledby="approveRejectReopenModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content rounded-4 shadow-sm">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-4">
                                        <!-- Header Title -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="modal-title fw-bold" id="approveRejectReopenModalLabel">
                                                <i class="fa-solid fa-rotate-left me-2"></i> Reopen Request Review
                                            </h5>
                                        </div>

                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0 mb-3">
                                            <div class="card-body p-3">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light w-25">Ticket ID</th>
                                                            <td><span id="approveRejectReopenTicketId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Requestor</th>
                                                            <td><span id="approveRejectReopenRequestorId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Department</th>
                                                            <td><span id="approveRejectReopenRequestorDepartment"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Subject</th>
                                                            <td><span id="approveRejectReopenSubject"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Description</th>
                                                            <td><span id="approveRejectReopenDescription"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Handler</th>
                                                            <td><span id="approveRejectReopenHandler"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Reason for Reopening</th>
                                                            <td><span id="reasonForReopen"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Remarks Textarea -->
                                        <div class="mb-3">
                                            <label for="approveRejectReopenReasonDescription" class="form-label fw-semibold">Remarks</label>
                                            <textarea id="approveRejectReopenReasonDescription" class="form-control" rows="3" placeholder="Enter your remarks or justification..."></textarea>
                                        </div>

                                        <!-- Approve / Reject Buttons -->
                                        <div class="d-flex justify-content-end gap-2">
                                            <button id="approveReopenRequestButton" class="btn btn-outline-primary">
                                                <i class="fa-solid fa-thumbs-up me-1"></i> Approve
                                            </button>
                                            <button id="rejectReopenRequestButton" class="btn btn-outline-danger">
                                                <i class="fa-solid fa-ban me-1"></i> Reject
                                            </button>
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
<?php include "../../../modules/components/shared/external-js-import.php" ?>
<script src="../../../assets/js/admin/ticketing-system/ticket-chart-area.js"></script>
<script src="../../../assets/js/admin/ticketing-system/ticket-chart-pie.js"></script>
<script src="../../../assets/js/s-admin/ticketing-system/s-admin-tickets.js"></script>

</html>