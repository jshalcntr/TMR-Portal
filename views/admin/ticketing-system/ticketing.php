<?php
session_start();

require('../../../backend/dbconn.php');
require('../../../backend/middleware/pipes.php');
require('../../../backend/middleware/authorize.php');

if (authorize($_SESSION['user']['role'] == "ADMIN", $conn)) {
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

    <title>Dashboard</title>
    <link rel="stylesheet" href="../../../assets/css/custom/ticketing-system/ticketing.css">
    <link rel="stylesheet" href="../../../assets/css/custom/shared/dashboard.css">
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
                            <div class="card shadow mb-4 col-md-2" data-category="overdue" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3 text-truncate">
                                    <h6 class="m-0 font-weight-bold text-primary">Overdue Tasks</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="overdue-tasks">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="today-due" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3 text-truncate">
                                    <h6 class="m-0 font-weight-bold text-primary">Tickets Due Today</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="today-due-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="open" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3 text-truncate">
                                    <h6 class="m-0 font-weight-bold text-primary">Open Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="open-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="for-approval" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3 text-truncate">
                                    <h6 class="m-0 font-weight-bold text-primary">For Approval Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="for-approval-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="unassigned" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3 text-truncate">
                                    <h6 class="m-0 font-weight-bold text-primary">Unassigned Tickets</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="card-title font-weight-bold" id="unassigned-tickets">0</h1>
                                </div>
                            </div>
                            <div class="card shadow mb-4 col-md-2" data-category="finished" onclick="fetchAndShowTickets(this)">
                                <div class="card-header py-3 text-truncate">
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
                            <div class="modal-dialog modal-xl modal-dialog-centered  modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white custom-scrollable-body">
                                        <h5 class="modal-title fw-bold" id="ticketModalLabel">Tickets</h5>
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
                        <div class="modal fade" id="ticketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-ticket-alt me-2"></i> Ticket Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 row custom-scrollable-body">
                                        <!-- Header with Chat Button -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">

                                            <!-- <button id="openChatButton" class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                                data-id="" data-title="" data-requestor=""
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Chat with requestor">
                                                <i class="fa-solid fa-comments me-1"></i> Chat
                                            </button> -->
                                        </div>

                                        <!-- Ticket Information in a Card -->
                                        <div class="card shadow-sm border-0 ticket-details-card col-md-8">
                                            <div class="card-body p-3 ">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <table class="table table-bordered table-striped mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="bg-light w-50">Ticket ID</th>
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
                                                                    <th class="bg-light">Status</th>
                                                                    <td><span id="ticketStatus"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">Priority</th>
                                                                    <td><span id="ticketPriority"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">Date Created</th>
                                                                    <td><span id="ticketDateCreated"></span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table table-bordered table-striped mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="bg-light w-50">Date Accepted</th>
                                                                    <td><span id="ticketDateAccepted"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">Due Date</th>
                                                                    <td><span id="ticketDueDate"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">Handler</th>
                                                                    <td><span id="ticketHandlerName"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">Changes</th>
                                                                    <td><span id="ticketChangesDescription"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">For Approval Due Date</th>
                                                                    <td><span id="ticketForApprovalDueDate"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">Date Approved</th>
                                                                    <td><span id="ticketDateApproved"></span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- File attachments (if any) below the two columns -->
                                                <div class="mt-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <strong class="d-block text-muted mb-1">Description:</strong>
                                                            <div id="ticketDescription"></div>
                                                            <strong class="d-block text-muted mb-1">Requestor Attachment:</strong>
                                                            <span id="ticketAttachment"></span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong class="d-block text-muted mb-1">For Approval Reason:</strong>
                                                            <span id="ticketForApprovalReason"></span>
                                                            <strong class="d-block text-muted mb-1">For Approval Attachment:</strong>
                                                            <span id="ticketforApprovalAttachment"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Chatbox on the right -->
                                        <div id="chatBoxDiv" class="card shadow-sm border-0 col-md-4 d-flex flex-column chat-card"> <!-- Right card -->
                                            <div id="chatHistoryDiv" class="card-body p-3 d-flex flex-column">
                                                <h6 id="chatHistoryTitle" class="text-gray-600 fw-bold border-bottom pb-2">Chat History</h6>
                                                <div id="chatHistory" class="overflow-auto flex-grow-1 mb-3"></div>
                                                <div class="input-group">
                                                    <textarea id="chatInput" class="form-control" placeholder="Type a message..." rows="3"></textarea>
                                                    <button id="sendChatMessage" class="btn btn-primary">Send</button>
                                                </div>
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

                        <!-- Modal for Ticket Details -->
                        <div class="modal fade" id="unassignedticketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-ticket-alt me-2"></i> Unassigned Ticket</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="claimTicketForm" enctype="multipart/form-data">
                                        <div class="modal-body p-4  custom-scrollable-body">
                                            <div class="row">
                                                <!-- Ticket Information in a Card -->
                                                <div class="card shadow-sm border-0 col-md-7">
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
                                                                    <td class="small"><span id="unassignedticketDescription"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">Attachment</th>
                                                                    <td><span id="unassignedticketAttachment"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="bg-light">Created</th>
                                                                    <td><span id="unassignedticketDateCreated"></span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
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
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ticketPriority" id="prioritySpecial" value="SPECIAL">
                                                            <label class="form-check-label text-secondary" for="prioritySpecial">
                                                                Special (custom)
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div id="customPriorityWrapper" class="mt-2" style="display: none;">
                                                        <label for="customPriority" class="form-label fw-bold text-info">Custom Priority Date:</label>
                                                        <input type="date" id="customPriority" class="form-control" placeholder="Select date">
                                                    </div>

                                                    <!-- For Approval Checkbox -->
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="checkbox" id="forApprovalCheckbox">
                                                        <label class="form-check-label text-info fw-bold" for="forApprovalCheckbox">
                                                            For Approval
                                                        </label>
                                                    </div>
                                                    <!-- Reason for Approval Textarea (initially hidden) -->
                                                    <div id="forApprovalReasonWrapper" class="mt-2" style="display: none;">
                                                        <label for="forApprovalReason" class="form-label fw-bold text-info">Reason for Approval:</label>
                                                        <textarea id="forApprovalReason" class="form-control" rows="3"></textarea>

                                                        <label for="forApprovalAttachment" class="form-label mt-2">Attach file (optional):</label>
                                                        <input type="file" class="form-control" id="forApprovalAttachment" name="for_approval_attachment">
                                                    </div>
                                                </div>
                                                <!-- Claim Button -->
                                                <div class="d-flex justify-content-end mt-3">
                                                    <button id="claimButton" class="btn btn-primary" onclick="claimTicket(event)">
                                                        <i class="fa-solid fa-hand-pointer me-1"></i> Claim Ticket
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Closed Ticket Details -->
                        <div class="modal fade" id="closedTicketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-ticket-alt me-2"></i> Closed Ticket</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 custom-scrollable-body">
                                        <div class="row">
                                            <!-- Ticket Information in a Card -->
                                            <div class="card shadow-sm border-0 col-md-8">
                                                <div class="card-body p-3">
                                                    <table class="table table-bordered table-striped mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th class="bg-light w-25">Ticket ID</th>
                                                                <td><span id="closedticketId"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="bg-light">Created</th>
                                                                <td><span id="closedticketRequestDate"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="bg-light">Claimed</th>
                                                                <td><span id="closedticketClaimDate"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="bg-light">Closed</th>
                                                                <td><span id="closedticketCloseDate"></span></td>
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
                                                                <th class="bg-light">Handler</th>
                                                                <td><span id="closedticketHandlerId"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="bg-light">Conclusion</th>
                                                                <td><span id="closedticketConclusion"></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- Chatbox on the right -->
                                            <div id="closeChatBoxDiv" class="card shadow-sm border-0 col-md-4 d-flex flex-column chat-card"> <!-- Right card -->
                                                <div id="closeChatHistoryDiv" class="card-body p-3 d-flex flex-column">
                                                    <h6 id="closeChatHistoryTitle" class="text-gray-600 border-bottom pb-2">Chat History</h6>
                                                    <div id="closeChatHistory" class="overflow-auto flex-grow-1 mb-3"></div>
                                                    <div class="input-group">
                                                        <textarea id="closeChatInput" class="form-control" placeholder="Type a message..." rows="3"></textarea>
                                                        <button id="sendCloseChatMessage" class="btn btn-primary">Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Request Reopen Section -->
                                            <div class="d-flex justify-content-center gap-3 mt-4">
                                                <button id="showChangesButton" class="btn btn-outline-info">
                                                    <i class="fa-solid fa-undo-alt me-1"></i> Request Reopen
                                                </button>
                                            </div>
                                            <div id="changesSection" class="mt-3 border rounded p-3 bg-light" style="display: none;">
                                                <label for="ticketReopenDescription" class="fw-bold">Reason for Reopening:</label>
                                                <textarea id="ticketReopenDescription" class="form-control mt-2" rows="3" placeholder="Enter reason..."></textarea>

                                                <div class="d-flex justify-content-between mt-3">
                                                    <button id="submitChangesButton" class="btn btn-outline-success">
                                                        <i class="fa-solid fa-paper-plane me-1"></i> Submit Request
                                                    </button>
                                                    <button id="cancelChangesButton" class="btn btn-outline-danger">
                                                        <i class="fa-solid fa-times me-1"></i> Cancel
                                                    </button>
                                                </div>
                                            </div>
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
                            <div id="chatboxMessages" class="chatbox-message"> -->
                        <!-- Chat messages will be populated here -->
                        <!-- </div>
                            <div class="chatbox-input">
                                <input type="text" id="chatboxInput" placeholder="Type a message...">
                                <button id="sendChatboxMessage">Send</button>
                            </div>
                        </div> -->


                        <!------------------------------------------Charts--------------------------------------------------->
                        <!-- Date Filter + Line Chart -->
                        <div class="col-md-8">
                            <!-- Chart Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <!-- Title -->
                                        <h6 class="m-0 font-weight-bold text-primary">Closed Tickets</h6>

                                        <!-- Date Filter -->
                                        <div class="d-flex align-items-center mt-2 mt-md-0">
                                            <input type="date" id="startDate" name="start_date" class="form-control form-control-sm mr-2">
                                            <span class="mx-1">to</span>
                                            <input type="date" id="endDate" name="end_date" class="form-control form-control-sm mx-2">
                                            <button id="filterBtn" class="btn btn-sm btn-primary">Filter</button>
                                        </div>
                                    </div>
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
<script src="../../../assets/js/admin/ticketing-system/admin-tickets.js"></script>

</html>