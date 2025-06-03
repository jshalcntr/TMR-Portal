var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
// Initialize previous counts
let previousCounts = {
    overdue: 0,
    today_due: 0,
    open: 0,
    for_approval: 0,
    unassigned: 0,
    finished: 0,
    all: 0
};

let isFirstLoad = 0;

function formatDate(dateString) {
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return 'N/A';

    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();

    let hours = date.getHours();
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;

    return `${month} ${day}, ${year} ${hours}:${minutes} ${ampm}`;
}

function calculateRemainingTime(dueDate) {
    if (!dueDate) {
        return 'N/A';
    }

    const now = new Date();
    const due = new Date(dueDate);

    if (isNaN(due.getTime())) {
        return 'N/A';
    }

    const diff = due - now;

    if (diff <= 0) {
        return `${formatDate(dueDate)}`;
    }

    const hours = Math.floor(diff / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

    return `${hours}h ${minutes}m ${seconds}s`;
}

function updateTimers() {
    document.querySelectorAll('.ticket-due-timer').forEach(timer => {
        const dueDate = timer.getAttribute('data-due-date');
        if (dueDate) {
            timer.innerText = calculateRemainingTime(dueDate);
        } else {
            timer.innerText = 'N/A';
        }
    });
}

setInterval(updateTimers, 1000);


$(document).ready(function () {
    // Fetch ticket counts from the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_ticket_counts.php', // Adjust the path as needed
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const data = response.data;
                // Set previousCounts to the initial data values
                previousCounts = {
                    overdue: data.overdue || 0,
                    today_due: data.today_due || 0,
                    open: data.open || 0,
                    for_approval: data.all_for_approval || 0,
                    all_overdue: data.all_overdue || 0,
                    all_today_due: data.all_today_due || 0,
                    all_open: data.open || 0,
                    all_for_approval: data.all_for_approval || 0,
                    unassigned: data.unassigned || 0,
                    finished: data.finished || 0,
                    all_reopen: data.all_reopen || 0,
                    all: data.all || 0
                };
                // Update the numbers in the cards
                $('#overdue-tasks').text(data.overdue || 0);
                $('#today-due-tickets').text(data.today_due || 0);
                $('#open-tickets').text(data.open || 0);
                $('#for-approval-tickets').text(data.for_approval || 0);
                $('#unassigned-tickets').text(data.unassigned || 0);
                $('#closed-tickets').text(data.finished || 0);
                $('#all-tickets').text(data.all || 0);
                $('#all-overdue-tasks').text(data.all_overdue || 0);
                $('#all-today-due-tickets').text(data.all_today_due || 0);
                $('#all-open-tickets').text(data.all_open || 0);
                $('#reopen-tickets').text(data.all_reopen || 0);
                $('#all-for-approval-tickets').text(data.all_for_approval || 0);
            } else {
                console.error('Error:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});




// Function to handle card click (fetch tickets and show table modal)
function fetchAndShowTickets(card) {
    const category = card.getAttribute('data-category');
    const modalTitle = {
        'overdue': 'Overdue Tasks',
        'today-due': 'Tickets Due Today',
        'open': 'Open Tickets',
        'for-approval': 'For Approval Tickets',
        'unassigned': 'Unassigned Tickets',
        'finished': 'Closed Tickets',
        'all-overdue': 'All Overdue Tasks',
        'all-today-due': 'All Tickets Due Today',
        'all-open': 'All Open Tickets',
        'all-for-approval': 'All For Approval Tickets',
        'reopen-tickets': 'Request Reopen',
        'all': 'All Tickets'
    };
    // Clear and rebuild the table with a dynamic ID
    const tableContainer = document.getElementById('ticketTableContainer');
    const tableId = `ticketTable-${category}`;
    tableContainer.innerHTML = `
    <table class="table table-bordered table-hover" id="${tableId}" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Requestor</th>
                <th>Date Requested</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Due Date</th>
                <th id="dateClosedHeader">Date Closed</th>
                <th>Attachment</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    `;
    // Update modal title
    document.getElementById('ticketModalLabel').innerText = modalTitle[category];

    // Fetch data from the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_tickets.php', // Adjust the path as needed
        method: 'GET',
        data: { category: category },
        success: function (response) {
            if (response.status === 'success') {
                const tableBody = document.querySelector(`#${tableId} tbody`);
                let hasClosedTicket = false;
                tableBody.innerHTML = ''; // Clear previous rows first

                response.data.forEach(ticket => {
                    const ticketId = ticket.ticket_id ?? 'N/A';
                    const fullName = ticket.full_name ?? 'N/A';
                    const department = ticket.department ?? 'N/A';
                    const subject = ticket.ticket_subject ?? 'N/A';
                    const status = ticket.ticket_status ?? 'N/A';
                    const dueDate = ticket.ticket_due_date ?? '';
                    const dateClosed = ticket.date_finished ?? '';
                    const dateCreated = ticket.date_created ?? '';

                    const formattedDueDate = dueDate ? formatDate(dueDate) : 'N/A';
                    const formattedDateClosed = dateClosed ? formatDate(dateClosed) : 'N/A';
                    const formattedDateCreated = dateCreated ? formatDate(dateCreated) : 'N/A';
                    // Only add the class if the ticket is not CLOSED
                    const dueTimerClass = ticket.ticket_status !== 'CLOSED' ? 'ticket-due-timer' : '';

                    const attachmentLink = ticket.ticket_attachment
                        ? `<a href="${ticket.ticket_attachment}" target="_blank" class="badge bg-info text-dark">Attachment</a>`
                        : '';

                    const showDateClosed = status === 'CLOSED';

                    if (showDateClosed) {
                        hasClosedTicket = true;
                    }
                    let priorityClass = ''; // Default class for priority
                    if (ticket.ticket_priority === 'CRITICAL') {
                        priorityClass = 'text-danger font-weight-bold'; // Add a class for critical priority
                    } else if (ticket.ticket_priority === 'IMPORTANT') {
                        priorityClass = 'text-warning font-weight-bold'; // Add a class for important priority
                    } else if (ticket.ticket_priority === 'NORMAL') {
                        priorityClass = 'text-primary font-weight-bold'; // Add a class for normal priority
                    } else {
                        priorityClass = 'text-secondary'; // Default class for other priorities
                    }

                    const row = `
                        <tr class="clickable-row" data-ticket='${JSON.stringify(ticket)}'>
                            <td>#${ticketId}</td>
                            <td>${fullName} - ${department}</td>
                            <td>${formattedDateCreated}</td>
                            <td>${subject}</td>
                            <td>${status}</td>
                            <td class="${dueTimerClass} ${priorityClass}" data-due-date="${dueDate}">${formattedDueDate}</td>
                            <td class="date-closed-cell" style="${showDateClosed ? '' : 'display: none;'}">${formattedDateClosed}</td>
                            <td>${attachmentLink}</td>
                        </tr>
                    `;

                    tableBody.innerHTML += row;
                });

                // Show or hide the Date Closed column based on the result
                const dateClosedHeader = document.getElementById('dateClosedHeader');
                const dateClosedCells = document.querySelectorAll('.date-closed-cell');

                if (!hasClosedTicket) {
                    dateClosedHeader.style.display = 'none';
                    dateClosedCells.forEach(cell => {
                        cell.style.display = 'none';
                    });
                } else {
                    dateClosedHeader.style.display = '';
                    dateClosedCells.forEach(cell => {
                        cell.style.display = '';
                    });
                }




                if (category === 'finished') { // Add event listener for row click
                    document.querySelectorAll('.clickable-row').forEach(row => {
                        row.addEventListener('click', function () {
                            const ticket = JSON.parse(this.getAttribute('data-ticket'));
                            showClosedTicketDetails(ticket);
                        });
                    });
                }
                else if (category === 'unassigned') {
                    document.querySelectorAll('.clickable-row').forEach(row => {
                        row.addEventListener('click', function () {
                            const ticket = JSON.parse(this.getAttribute('data-ticket'));
                            showUnassignedTicketDetails(ticket);
                        });
                    });
                } else if (category === 'reopen-tickets') {
                    document.querySelectorAll('.clickable-row').forEach(row => {
                        row.addEventListener('click', function () {
                            const ticket = JSON.parse(this.getAttribute('data-ticket'));
                            showReopenTicketDetails(ticket);
                        });
                    });
                } else if (category === 'all-overdue' || category === 'all-today-due' || category === 'all-open' || category === 'all-for-approval') {
                    document.querySelectorAll('.clickable-row').forEach(row => {
                        row.addEventListener('click', function () {
                            const ticket = JSON.parse(this.getAttribute('data-ticket'));
                            showAllTicketDetails(ticket);
                        });
                    });
                } else {
                    // Add event listener for row click
                    document.querySelectorAll('.clickable-row').forEach(row => {
                        row.addEventListener('click', function () {
                            const ticket = JSON.parse(this.getAttribute('data-ticket'));
                            showTicketDetails(ticket);
                        });
                    });
                }

                // Initialize DataTables
                if ($.fn.DataTable.isDataTable(`#${tableId}`)) {
                    $(`#${tableId}`).DataTable().destroy();
                }

                $(`#${tableId}`).DataTable();
                // Show the modal
                $('#ticketModal').modal('show');
            } else {
                console.error('Error:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}

// Function to handle row click and show closed ticket details modal
function showClosedTicketDetails(ticket) {
    // Populate modal with ticket details

    const attachmentLink = ticket.ticket_attachment
        ? `<a href="../../../${ticket.ticket_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : 'N/A';
    const dateAccepted = ticket.date_accepted ?? '';
    const dateClosed = ticket.date_finished ?? '';
    const dateCreated = ticket.date_created ?? '';

    const formattedDateAccepted = dateAccepted ? formatDate(dateAccepted) : 'N/A';
    const formattedDateClosed = dateClosed ? formatDate(dateClosed) : 'N/A';
    const formattedDateCreated = dateCreated ? formatDate(dateCreated) : 'N/A';
    document.getElementById('closedticketId').innerText = ticket.ticket_id;
    document.getElementById('closedticketRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('closedticketHandlerId').innerText = ticket.handler_name || 'N/A';
    document.getElementById('closedticketRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('closedticketSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('closedticketDescription').innerText = ticket.ticket_description || 'N/A';
    document.getElementById('closedticketType').innerText = ticket.ticket_type || 'N/A';
    document.getElementById('closedticketAttachment').innerHTML = attachmentLink;
    document.getElementById('closedticketConclusion').innerText = ticket.ticket_conclusion || 'N/A';
    document.getElementById('closedticketRequestDate').innerText = formattedDateCreated || 'N/A';
    document.getElementById('closedticketClaimDate').innerText = formattedDateAccepted || 'N/A';
    document.getElementById('closedticketCloseDate').innerText = formattedDateClosed || 'N/A';
    // Check if ticket_id exists in ticket_convo_tbl
    $.ajax({
        url: '../../../backend/shared/ticketing-system/check_ticket_convo.php', // Replace with your actual endpoint
        method: 'POST',
        data: { ticket_id: ticket.ticket_id },
        success: function (response) {
            if (response.exists) {
                $('#openChatButtonClosed').removeClass('btn-outline-secondary').addClass('btn-primary');
            } else {
                $('#openChatButtonClosed').removeClass('btn-primary').addClass('btn-outline-secondary');
            }
        }
    });
    $('#closeChatHistory')
        .data('ticket-id', ticket.ticket_id)
        .data('requestor', ticket.ticket_requestor_id); // Set ticket ID and title for chat button
    fetchClosedChatboxMessages(ticket.ticket_id);
    isFirstLoad = 0; // Reset the flag when a new ticket is clicked$('#ticketModal').modal('hide');
    // Show the details modal
    $('#ticketModal').modal('hide');
    $('#closedTicketDetailsModal').modal('show');

}

// Function to handle row click and show approve/reject reopen modal
function showReopenTicketDetails(ticket) {
    // Populate modal with ticket details
    const attachmentLink = ticket.ticket_attachment
        ? `<a href="../../../${ticket.ticket_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : 'N/A';
    document.getElementById('approveRejectReopenTicketId').innerText = ticket.ticket_id;
    document.getElementById('approveRejectReopenRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('approveRejectReopenRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('approveRejectReopenSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('approveRejectReopenDescription').innerText = ticket.ticket_description || 'N/A';

    document.getElementById('approveRejectReopenDescription').innerText = ticket.ticket_changes_description || 'N/A';
    document.getElementById('approveRejectReopenHandler').innerText = ticket.handler_name || 'N/A';
    $.ajax({
        url: '../../../backend/shared/ticketing-system/check_ticket_convo.php', // Replace with your actual endpoint
        method: 'POST',
        data: { ticket_id: ticket.ticket_id },
        success: function (response) {
            if (response.exists) {
                $('#openChatButton').removeClass('btn-outline-secondary').addClass('btn-primary');
            } else {
                $('#openChatButton').removeClass('btn-primary').addClass('btn-outline-secondary');
            }
        }
    });

    $('#ticketModal').modal('hide');
    // Show the approve/reject reopen modal
    $('#approveRejectReopenModal').modal('show');
}

// Function to handle row click and show ticket details modal
function showTicketDetails(ticket) {
    const formatDate = (dateStr) => {
        return dateStr ? new Date(dateStr).toLocaleString() : 'N/A';
    };

    const attachmentLink = ticket.ticket_attachment
        ? `<a href="../../../${ticket.ticket_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : 'N/A';

    const approvalAttachmentLink = ticket.for_approval_attachment
        ? `<a href="../../../uploads/for_approval/${ticket.for_approval_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View File</a>`
        : 'N/A';
    const formatedDate = (dateStr) => {
        return dateStr ? new Date(dateStr).toLocaleString() : 'N/A';
    };

    const formattedDueDate = formatedDate(ticket.ticket_due_date);
    const formattedApprovalDueDate = formatedDate(ticket.ticket_for_approval_due_date);

    // Set classes based on priority
    let priorityClass = '';
    let duedateClass = '';
    let approvalDuedateClass = '';

    if (ticket.ticket_priority === 'CRITICAL') {
        priorityClass = 'text-danger';
        duedateClass = 'text-danger';
        approvalDuedateClass = 'text-danger';
    } else if (ticket.ticket_priority === 'IMPORTANT') {
        priorityClass = 'text-warning';
        duedateClass = 'text-warning';
        approvalDuedateClass = 'text-warning';
    } else if (ticket.ticket_priority === 'NORMAL') {
        priorityClass = 'text-primary';
        duedateClass = 'text-primary';
        approvalDuedateClass = 'text-primary';
    } else {
        priorityClass = 'text-secondary';
        duedateClass = 'text-secondary';
        approvalDuedateClass = 'text-secondary';
    }

    // Override with default class if formatted dates are N/A
    if (formattedDueDate === 'N/A') {
        duedateClass = 'text-secondary';
    }
    if (formattedApprovalDueDate === 'N/A') {
        approvalDuedateClass = 'text-secondary';
    }

    document.getElementById('ticketId').innerText = ticket.ticket_id || 'N/A';
    document.getElementById('ticketRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('ticketRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('ticketSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('ticketDescription').innerText = ticket.ticket_description || 'N/A';
    document.getElementById('ticketStatus').innerText = ticket.ticket_status || 'N/A';
    document.getElementById('ticketPriority').innerText = ticket.ticket_priority || 'N/A';
    document.getElementById('ticketHandlerName').innerText = ticket.handler_name || 'N/A';
    document.getElementById('ticketConclusion').innerText = ticket.ticket_conclusion || 'N/A';
    document.getElementById('ticketChangesDescription').innerText = ticket.changes_description || 'N/A';
    document.getElementById('ticketForApprovalReason').innerText = ticket.for_approval_reason || 'N/A';
    document.getElementById('ticketDateCreated').innerText = formatDate(ticket.date_created);
    document.getElementById('ticketDateAccepted').innerText = formatDate(ticket.date_accepted);
    document.getElementById('ticketDueDate').innerText = formattedDueDate;
    document.getElementById('ticketForApprovalDueDate').innerText = formattedApprovalDueDate;
    document.getElementById('ticketDateApproved').innerText = formatDate(ticket.date_approved);
    document.getElementById('ticketAttachment').innerHTML = attachmentLink;
    document.getElementById('ticketforApprovalAttachment').innerHTML = approvalAttachmentLink;
    $('#ticketPriority').addClass(priorityClass);
    $('#ticketDueDate').addClass(duedateClass);
    $('#ticketForApprovalDueDate').addClass(approvalDuedateClass);

    // Chat button status via AJAX
    $.ajax({
        url: '../../../backend/shared/ticketing-system/check_ticket_convo.php',
        method: 'POST',
        data: { ticket_id: ticket.ticket_id },
        success: function (response) {
            if (response.exists) {
                $('#openChatButton').removeClass('btn-outline-secondary').addClass('btn-primary');
            } else {
                $('#openChatButton').removeClass('btn-primary').addClass('btn-outline-secondary');
            }
        }
    });

    // Set chat button data
    $('#chatHistory')
        .data('ticket-id', ticket.ticket_id)
        .data('requestor', ticket.ticket_requestor_id)
    fetchChatboxMessages(ticket.ticket_id);
    isFirstLoad = 0; // Reset the flag when a new ticket is clicked
    // Show the details modal
    $('#ticketModal').modal('hide');
    $('#ticketDetailsModal').modal('show');
}


// Function to handle row click and show ticket details modal
function showUnassignedTicketDetails(ticket) {
    // Populate modal with ticket details
    const unassignedAttachmentLink = ticket.ticket_attachment
        ? `<a href="../../../${ticket.ticket_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : 'N/A';
    let desc = ticket.ticket_description || 'N/A';

    // Replace CRLF (\r\n), CR (\r), and LF (\n) with space or \n (your choice)
    let cleanedDesc = desc.replace(/\\r\\n|\\n|\\r/g, '\n');
    const dateCreated = ticket.date_created ?? '';
    const formattedDateCreated = dateCreated ? formatDate(dateCreated) : 'N/A';
    document.getElementById('unassignedticketId').innerText = ticket.ticket_id;
    document.getElementById('unassignedticketRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('unassignedticketRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('unassignedticketSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('unassignedticketDescription').innerText = cleanedDesc;
    document.getElementById('unassignedticketDateCreated').innerText = formattedDateCreated || 'N/A';
    document.getElementById('unassignedticketAttachment').innerHTML = unassignedAttachmentLink;
    $.ajax({
        url: '../../../backend/shared/ticketing-system/check_ticket_convo.php', // Replace with your actual endpoint
        method: 'POST',
        data: { ticket_id: ticket.ticket_id },
        success: function (response) {
            if (response.exists) {
                $('#openChatButtonUnassigned').removeClass('btn-outline-secondary').addClass('btn-primary');
            } else {
                $('#openChatButtonUnassigned').removeClass('btn-primary').addClass('btn-outline-secondary');
            }
        }
    });
    $('#openChatButtonUnassigned').data('id', ticket.ticket_id).data('requestor', ticket.ticket_requestor_id).data('title', 'T#' + ticket.ticket_id + ' | ' + ticket.ticket_subject); // Set ticket ID and title for chat button
    // Show the details modal

    $('#ticketModal').modal('hide');
    $('#unassignedticketDetailsModal').modal('show');
    $('#forApprovalCheckbox').prop('checked', false);
    $('#forApprovalReasonWrapper').slideUp();
    $('#forApprovalReason').val('');
    $('#forApprovalAttachment').val('');
}

// Function to claim the ticket
$(document).ready(function () {
    $('#forApprovalCheckbox').on('change', function () {
        if ($(this).is(':checked')) {
            $('#forApprovalReasonWrapper').slideDown();
            $('#forApprovalReasonWrapper').toggle(this.checked);
            $('#forApprovalReason').focus();
        } else {
            $('#forApprovalReasonWrapper').slideUp();
            $('#forApprovalReason').val('');
        }
    });
});

function claimTicket(event) {
    event.preventDefault();
    const ticketId = $('#unassignedticketId').text();
    const forApproval = $('#forApprovalCheckbox').is(':checked');
    const ticketStatus = forApproval ? 'FOR APPROVAL' : 'OPEN';
    const selectedPriority = $('input[name="ticketPriority"]:checked').val() || 'NORMAL';
    const forApprovalReason = $('#forApprovalReason').val();
    const ticketPriorityDate = $('#customPriority').val() || null;
    const attachmentFile = $('#forApprovalAttachment')[0]?.files?.[0] || null;

    const formData = new FormData();
    formData.append('ticket_id', ticketId);
    formData.append('ticket_status', ticketStatus);
    formData.append('ticket_priority', selectedPriority);
    formData.append('ticket_priority_date', ticketPriorityDate);
    formData.append('for_approval_reason', forApproval ? forApprovalReason : '');
    formData.append('for_approval_attachment', attachmentFile);



    $.ajax({
        url: '../../../backend/admin/ticketing-system/claim_ticket.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket claimed successfully ',
                    showConfirmButton: true,
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'AJAX error',
                text: error
            });
        }
    });
}





// Function to enable editing of ticket details
function enableEditing() {
    document.getElementById('ticketDueDate').disabled = false;
    document.getElementById('ticketStatus').disabled = false;
    document.getElementById('closeTicketButton').style.display = 'none';
    document.getElementById('saveButton').style.display = 'inline-block';
    document.getElementById('cancelsaveButton').style.display = 'inline-block';
}
// Function to cancel enable editing of ticket details
// function cancelTicketDetails() {
//     document.getElementById('ticketDueDate').disabled = true;
//     document.getElementById('ticketStatus').disabled = true;
//     document.getElementById('closeTicketButton').style.display = 'inline-block';
//     document.getElementById('saveButton').style.display = 'none';
//     document.getElementById('cancelsaveButton').style.display = 'none';
// }

function enableUnassignedEditing() {
    document.getElementById('unassignedticketDueDate').disabled = false;
    document.getElementById('unassignedticketStatus').disabled = false;
    document.getElementById('unassignedticketHandlerId').disabled = false;
    document.getElementById('unassignededitButton').style.display = 'none';
    document.getElementById('unassignedsaveButton').style.display = 'inline-block';
    document.getElementById('unassignedcancelsaveButton').style.display = 'inline-block';
}

function cancelUnassignedTicketDetails() {
    document.getElementById('unassignedticketDueDate').disabled = true;
    document.getElementById('unassignedticketStatus').disabled = true;
    document.getElementById('unassignedticketHandlerId').disabled = true;
    document.getElementById('unassignededitButton').style.display = 'inline-block';
    document.getElementById('unassignedsaveButton').style.display = 'none';
    document.getElementById('unassignedcancelsaveButton').style.display = 'none';
}
function showConclusionTextArea() {
    let textArea = document.getElementById('conclusionTextArea');
    let saveButton = document.getElementById('saveConclusionButton');
    let closeButton = document.getElementById('closeTicketButton');
    let cancelButton = document.getElementById('cancelsaveButton');

    // Remove 'd-none' class to show elements
    textArea.classList.remove('fade', 'd-none');
    textArea.classList.add('show');
    saveButton.classList.remove('d-none');
    cancelButton.classList.remove('d-none');

    // Hide Close Ticket button
    closeButton.classList.add('d-none');
}

// Function to cancel editing of ticket details
function cancelTicketDetails() {
    let textArea = document.getElementById('conclusionTextArea');
    let cancelButton = document.getElementById('cancelsaveButton');
    let saveConclusionButton = document.getElementById('saveConclusionButton');
    let closeButton = document.getElementById('closeTicketButton');

    // Hide text area and buttons
    textArea.classList.add('d-none');
    cancelButton.classList.add('d-none');
    saveConclusionButton.classList.add('d-none');

    // Show Close Ticket button
    closeButton.classList.remove('d-none');
}



// Function to save edited ticket details
function saveTicketDetails() {
    const ticketId = document.getElementById('ticketId').innerText;
    const ticketDueDate = document.getElementById('ticketDueDate').value;
    const ticketStatus = document.getElementById('ticketStatus').value;
    const ticketHandlerId = document.getElementById('ticketHandlerId').value;

    // Send updated details to the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/update_ticket.php', // Adjust the path as needed
        method: 'POST',
        data: {
            ticket_id: ticketId,
            ticket_due_date: ticketDueDate,
            ticket_status: ticketStatus,
            ticket_handler_id: ticketHandlerId
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket details updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                });
                refreshTicketList();
                $('#ticketDetailsModal').modal('hide');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'AJAX error',
                text: error
            });
        }
    });

    document.getElementById('ticketDueDate').disabled = true;
    document.getElementById('ticketStatus').disabled = true;
    // document.getElementById('ticketHandlerId').disabled = true;
    document.getElementById('editButton').style.display = 'inline-block';
    document.getElementById('saveButton').style.display = 'none';
}


function saveUnassignedTicketDetails() {
    const ticketId = document.getElementById('unassignedticketId').innerText;
    const ticketDueDate = document.getElementById('unassignedticketDueDate').value;
    const ticketStatus = document.getElementById('unassignedticketStatus').value;
    const ticketHandlerId = document.getElementById('unassignedticketHandlerId').value;
    // Send updated details to the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/update_ticket.php', // Adjust the path as needed
        method: 'POST',
        data: {
            ticket_id: ticketId,
            ticket_due_date: ticketDueDate,
            ticket_status: ticketStatus,
            ticket_handler_id: ticketHandlerId
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket details updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                });
                refreshTicketList();
                $('#unassignedticketDetailsModal').modal('hide');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'AJAX error',
                text: error
            });
        }
    });

    document.getElementById('ticketDueDate').disabled = true;
    document.getElementById('ticketStatus').disabled = true;
    document.getElementById('editButton').style.display = 'inline-block';
    document.getElementById('saveButton').style.display = 'none';
}

// Function to reopen ticket
function requestReopen() {
    const closedticketId = document.getElementById('closedticketId').innerText;
    const closedticketDueDate = document.getElementById('closedticketDueDate').value;
    const closedticketStatus = "REOPEN";
    const closedticketHandlerId = document.getElementById('closedticketHandlerId').value;

    // Send updated details to the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/update_ticket.php', // Adjust the path as needed
        method: 'POST',
        data: {
            ticket_id: closedticketId,
            ticket_due_date: closedticketDueDate,
            ticket_status: closedticketStatus,
            ticket_handler_id: closedticketHandlerId
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket details updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                });
                refreshTicketList();
                $('#closedticketDetailsModal').modal('hide');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'AJAX error',
                text: error
            });
        }
    });
}


// Function to save the conclusion and update the ticket status to "CLOSED"
function saveConclusion() {
    const ticketId = document.getElementById('ticketId').innerText;
    const conclusion = document.getElementById('conclusionTextArea').value;

    // Send updated details to the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/close_ticket.php', // Adjust the path as needed
        method: 'POST',
        data: {
            ticket_id: ticketId,
            ticket_status: 'CLOSED',
            ticket_conclusion: conclusion
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket closed successfully',
                    showConfirmButton: true,
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'AJAX error',
                text: error
            });
        }
    });

    document.getElementById('conclusionTextArea').style.display = 'none';
    document.getElementById('saveConclusionButton').style.display = 'none';
    document.getElementById('closeTicketButton').style.display = 'inline-block';
}

//request for reopen
$(document).ready(function () {
    // Show changes section when "Make Changes" button is clicked
    $('#showChangesButton').on('click', function () {
        $('#changesSection').show();
        $('#showChangesButton').hide();
    });

    // Handle submission of changes
    $('#submitChangesButton').on('click', function () {
        const ticketId = $('#closedticketId').text();
        const changesDescription = $('#ticketChangesDescription').val();

        if (changesDescription.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please enter a description for the changes.'
            });
            return;
        }

        $.ajax({
            url: '../../../backend/admin/ticketing-system/reopen_ticket.php',
            type: 'POST',
            data: {
                ticket_id: ticketId,
                changes_description: changesDescription
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Ticket updated successfully!'
                    }).then(() => {
                        $('#closedTicketDetailsModal').modal('hide');
                        // Optionally, refresh the ticket list or perform other actions
                        refreshTicketList();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating ticket. Please try again later.'
                });
            }
        });
    });

    // Handle cancellation of changes
    $('#cancelChangesButton').on('click', function () {
        $('#changesSection').hide();
        $('#ticketChangesDescription').val('');
        $('#showChangesButton').show();
    });
});

$(document).ready(function () {
    // Show approve/reject reopen modal when "Request Reopen" button is clicked
    $('#showReopenChangesButton').on('click', function () {
        $('#approveRejectReopenModal').modal('show');
    });

    // Handle approval of reopen request
    $('#approveReopenRequestButton').on('click', function () {
        const ticketId = $('#approveRejectReopenTicketId').text();
        const reopenReasonDescription = $('#approveRejectReopenReasonDescription').val();

        if (reopenReasonDescription.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please enter a reason for reopening the ticket.'
            });
            return;
        }

        $.ajax({
            url: '../../../backend/s-admin/ticketing-system/approve_reopen_ticket.php',
            type: 'POST',
            data: {
                ticket_id: ticketId,
                reopen_reason_description: reopenReasonDescription,
                action: 'OPEN'
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Ticket reopen request approved successfully!'
                    }).then(() => {
                        $('#approveRejectReopenModal').modal('hide');
                        // Optionally, refresh the ticket list or perform other actions
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error approving reopen request. Please try again later.'
                });
            }
        });
    });

    // Handle rejection of reopen request
    $('#rejectReopenRequestButton').on('click', function () {
        const ticketId = $('#approveRejectReopenTicketId').text();
        const reopenReasonDescription = $('#approveRejectReopenReasonDescription').val();

        if (reopenReasonDescription.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please enter a reason for rejecting the reopen request.'
            });
            return;
        }

        $.ajax({
            url: '../../../backend/s-admin/ticketing-system/approve_reopen_ticket.php',
            type: 'POST',
            data: {
                ticket_id: ticketId,
                reopen_reason_description: reopenReasonDescription,
                action: 'CLOSED'
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Ticket reopen request rejected successfully!'
                    }).then(() => {
                        $('#approveRejectReopenModal').modal('hide');
                        // Optionally, refresh the ticket list or perform other actions
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error rejecting reopen request. Please try again later.'
                });
            }
        });
    });
});



// Function to refresh the list of ticket details
function refreshTicketList() {
    // Fetch ticket counts from the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_ticket_counts.php', // Adjust the path as needed
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const data = response.data;
                var ticket = "";
                // Update the numbers in the cards
                $('#overdue-tasks').text(data.overdue || 0);
                $('#today-due-tickets').text(data.today_due || 0);
                $('#open-tickets').text(data.open || 0);
                $('#for-approval-tickets').text(data.for_approval || 0);
                $('#unassigned-tickets').text(data.unassigned || 0);
                $('#finished-tickets').text(data.finished || 0);
                $('#closed-tickets').text(data.finished || 0);
                $('#all-tickets').text(data.all || 0);
                $('#all-overdue-tasks').text(data.all_overdue || 0);
                $('#all-today-due-tickets').text(data.all_today_due || 0);
                $('#all-open-tickets').text(data.all_open || 0);
                $('#all-for-approval-tickets').text(data.all_for_approval || 0);

                if (data.overdue > 1 || data.today_due > 1) {
                    ticket = "tickets";
                } else {
                    ticket = "ticket";
                }
                // Check for new tickets in specific categories and play alert tone
                if (data.overdue > previousCounts.overdue) {
                    speakAlert('You have ' + data.overdue + ' new overdue ' + ticket + '.');
                    showNotification('You have ' + data.overdue + ' new overdue ' + ticket + '.');
                }
                if (data.today_due > previousCounts.today_due) {
                    speakAlert('You have ' + data.today_due + ' new ' + ticket + ' due today.');
                    showNotification('You have ' + data.today_due + ' new ' + ticket + ' due today.');
                }
                if (data.open > previousCounts.open) {
                    speakAlert('You have ' + data.open + ' new open ' + ticket + '.');
                    showNotification('You have ' + data.open + ' new open ' + ticket + '.');
                }
                if (data.unassigned > previousCounts.unassigned) {
                    speakAlert('There is ' + data.unassigned + ' unassigned ' + ticket + '.');
                    showNotification('There is ' + data.unassigned + ' unassigned ' + ticket + '.');
                }

                // Update previous counts
                previousCounts = data;

                // Refresh the displayed data
                const activeCard = document.querySelector('.card.active');
                if (activeCard) {
                    const category = activeCard.getAttribute('data-category');
                    fetchAndShowTickets(activeCard);
                } else {
                    console.error('No active card found');
                }
            } else {
                console.error('Error:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}

// Function to use text-to-speech for alerts with Microsoft Zira as default
function speakAlert(message) {
    const speech = new SpeechSynthesisUtterance(message);
    speech.lang = 'en-US';
    speech.rate = 0.8; // Slow down the speech (default is 1)

    const voices = window.speechSynthesis.getVoices();
    const femaleVoice = voices.find(voice => voice.name === 'Google UK English Female');

    if (femaleVoice) {
        speech.voice = femaleVoice;
    }

    window.speechSynthesis.speak(speech);
}
// window.speechSynthesis.onvoiceschanged = () => {
//     console.log(window.speechSynthesis.getVoices());
// };

// Set interval to refresh tickets every 30 seconds
setInterval(refreshTicketList, 10000);



function showNotification(message) {
    const container = document.getElementById('notification-container');
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerText = message;

    container.appendChild(notification);

    // Show the notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    // Hide the notification after 5 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            container.removeChild(notification);
        }, 500);
    }, 5000);
}



let suppressTicketModal = false;

$("#closedTicketDetailsModal").on('hidden.bs.modal', function () {
    document.activeElement.blur();
    if (!suppressTicketModal) $('#ticketModal').modal('show');
});

$("#reopenTicketDetailsModal").on('hidden.bs.modal', function () {
    document.activeElement.blur();
    if (!suppressTicketModal) $('#ticketModal').modal('show');
});

$("#unassignedticketDetailsModal").on('hidden.bs.modal', function () {
    document.activeElement.blur();
    if (!suppressTicketModal) $('#ticketModal').modal('show');
});

$("#ticketDetailsModal").on('hidden.bs.modal', function () {
    document.activeElement.blur();
    if (!suppressTicketModal) $('#ticketModal').modal('show');
});

$("#allTicketDetailsModal").on('hidden.bs.modal', function () {
    document.activeElement.blur();
    if (!suppressTicketModal) $('#ticketModal').modal('show');
});

$("#confirmReopenModal").on('hidden.bs.modal', function () {
    document.activeElement.blur();
    if (!suppressTicketModal) $('#ticketModal').modal('show');
});

// $(document).ready(function () {
//     let chatboxOpen = false;

//     // Open chatbox
//     $(document).on('click', '#openChatButton, #openChatButtonUnassigned, #openChatButtonClosed', function () {
//         suppressTicketModal = true;
//         const ticketId = $(this).data('id');
//         const ticketTitle = $(this).data('title');
//         const ticketRequestor = $(this).data('requestor');

//         $("#closedTicketDetailsModal").modal('hide');
//         $("#reopenTicketDetailsModal").modal('hide');
//         $("#unassignedticketDetailsModal").modal('hide');
//         $("#ticketDetailsModal").modal('hide');
//         $("#confirmReopenModal").modal('hide');
//         $('#ticketModal').modal('hide');

//         openChatbox(ticketId, ticketTitle, ticketRequestor);

//         // Reset the suppression flag after a short delay (to avoid race conditions)
//         setTimeout(() => suppressTicketModal = false, 500);
//     });

//     // Function to open chatbox
//     function openChatbox(ticketId, ticketTitle, ticketRequestor) {
//         chatboxOpen = true;
//         $('#chatboxTitle').text(ticketTitle);
//         $('#chatbox').data('ticket-id', ticketId).data('requestor', ticketRequestor).show();
//         fetchChatboxMessages(ticketId);
//     }

//     // Close chatbox
//     $('#closeChatbox').on('click', function () {
//         chatboxOpen = false;
//         clearTimeout(chatboxTimer); // Stop further polling
//         $('#chatbox').hide();
//     });


// });

let chatboxTimer = null;

// Fetch chatbox messages
function fetchChatboxMessages(ticketId) {
    clearTimeout(chatboxTimer); // Stop further polling

    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_chat_messages.php',
        type: 'GET',
        data: { ticket_id: ticketId },
        dataType: 'json',
        success: function (response) {
            const chatboxMessages = $('#chatHistory');
            chatboxMessages.empty();

            if (response.status === 'success') {
                response.data.forEach(message => {
                    const formattedDateTime = formatDateTimeforChat(message.ticket_convo_date);
                    const isOwnMessage = message.ticket_user_id === message.session_user_id;

                    const messageBubble = `
                        <div class="d-flex ${isOwnMessage ? 'justify-content-end' : 'justify-content-start'} mb-2">
                            <div class="p-2 rounded-3 shadow-sm ${isOwnMessage ? 'bg-primary text-white text-end' : 'bg-light text-dark text-start'}" style="max-width: 75%;">
                                ${!isOwnMessage ? `<div class="fw-semibold mb-1">${message.full_name}</div>` : ''}
                                <div>${message.ticket_messages}</div>
                                <div class="small mt-1 ${isOwnMessage ? 'text-light' : 'text-muted'}">${formattedDateTime}</div>
                            </div>
                        </div>`;

                    chatboxMessages.append(messageBubble);
                });

                if (isFirstLoad <= 1) {
                    scrollToBottom();
                }
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching chat messages:", error);
        },
        complete: function () {
            chatboxTimer = setTimeout(() => fetchChatboxMessages(ticketId), 1000);
            isFirstLoad++;
        }
    });
}
function fetchClosedChatboxMessages(ticketId) {
    clearTimeout(chatboxTimer); // Stop further polling

    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_chat_messages.php',
        type: 'GET',
        data: { ticket_id: ticketId },
        dataType: 'json',
        success: function (response) {
            const chatboxMessages = $('#closeChatHistory');
            chatboxMessages.empty();

            if (response.status === 'success') {
                response.data.forEach(message => {
                    const formattedDateTime = formatDateTimeforChat(message.ticket_convo_date);
                    const isOwnMessage = message.ticket_user_id === message.session_user_id;

                    const messageBubble = `
                        <div class="d-flex ${isOwnMessage ? 'justify-content-end' : 'justify-content-start'} mb-2">
                            <div class="p-2 rounded-3 shadow-sm ${isOwnMessage ? 'bg-primary text-white text-end' : 'bg-light text-dark text-start'}" style="max-width: 75%;">
                                ${!isOwnMessage ? `<div class="fw-semibold mb-1">${message.full_name}</div>` : ''}
                                <div>${message.ticket_messages}</div>
                                <div class="small mt-1 ${isOwnMessage ? 'text-light' : 'text-muted'}">${formattedDateTime}</div>
                            </div>
                        </div>`;

                    chatboxMessages.append(messageBubble);
                });

                if (isFirstLoad <= 1) {
                    scrollToBottom();
                }
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching chat messages:", error);
        },
        complete: function () {
            chatboxTimer = setTimeout(() => fetchClosedChatboxMessages(ticketId), 1000);
            isFirstLoad++;
        }
    });
}

// Send chatbox message
$(document).on('click', '#sendChatMessage', function () {
    const ticketId = $('#chatHistory').data('ticket-id');
    const ticketRequestor = $('#chatHistory').data('requestor');
    const message = $('#chatInput').val().trim();

    if (!ticketId || !ticketRequestor || message === '') {
        alert('Please enter a message');
        return;
    }

    $.ajax({
        url: '../../../backend/admin/ticketing-system/send_chat_message.php',
        type: 'POST',
        data: {
            ticket_id: ticketId,
            message: message,
            requestor: ticketRequestor
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#chatInput').val('');
                fetchChatboxMessages(ticketId);
                isFirstLoad = 0;
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error sending chat message: ", error);
        }
    });
});
$(document).on('click', '#sendCloseChatMessage', function () {
    const ticketId = $('#closeChatHistory').data('ticket-id');
    const ticketRequestor = $('#closeChatHistory').data('requestor');
    const message = $('#closeChatInput').val().trim();

    if (!ticketId || !ticketRequestor || message === '') {
        alert('Please enter a message');
        return;
    }

    $.ajax({
        url: '../../../backend/admin/ticketing-system/send_chat_message.php',
        type: 'POST',
        data: {
            ticket_id: ticketId,
            message: message,
            requestor: ticketRequestor
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#closeChatInput').val('');
                fetchClosedChatboxMessages(ticketId);
                isFirstLoad = 0;
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error sending chat message: ", error);
        }
    });
});
function adjustChatHistoryHeight() {
    const tableCardHeight = $('.ticket-details-card').outerHeight();
    const chatCard = $('.chat-card'); // You forgot this line
    const chatCardBody = chatCard.find('.card-body');
    const chatTitleHeight = chatCard.find('h5').outerHeight(true);
    const inputGroupHeight = chatCard.find('.input-group').outerHeight(true);

    const paddingBuffer = 32; // Adjust if needed for padding/margin
    chatCardBody.height(tableCardHeight);

    const chatHistoryMaxHeight = tableCardHeight - chatTitleHeight - inputGroupHeight - paddingBuffer;

    $('#chatHistory').css('max-height', chatHistoryMaxHeight + 'px');
    $('#closeChatHistory').css('max-height', chatHistoryMaxHeight + 'px');
}

// Call after AJAX loads content, and on resize
$(document).ready(function () {
    adjustChatHistoryHeight();

    // Also run on window resize
    $(window).on('resize', function () {
        adjustChatHistoryHeight();
    });
});


function scrollToBottom() {
    const container = $('#chatHistory');
    container.scrollTop(container[0].scrollHeight);

    const containerClosed = $('#closeChatHistory');
    containerClosed.scrollTop(containerClosed[0].scrollHeight);
}
function formatDateTimeforChat(dateTimeString) {
    const messageDate = new Date(dateTimeString);
    const now = new Date();

    // Reset time to midnight for comparisons
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);

    const messageDay = new Date(messageDate.getFullYear(), messageDate.getMonth(), messageDate.getDate());

    let dateLabel;

    if (messageDay.getTime() === today.getTime()) {
        dateLabel = 'Today';
    } else if (messageDay.getTime() === yesterday.getTime()) {
        dateLabel = 'Yesterday';
    } else if (messageDay > new Date(today.getTime() - 6 * 86400000)) {
        // Within the last 6 days (excluding today & yesterday)
        dateLabel = messageDate.toLocaleDateString(undefined, { weekday: 'short' }); // e.g., Mon
    } else {
        dateLabel = messageDate.toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }); // e.g., May 19, 2025
    }

    const timeLabel = messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }); // 08:30 AM
    return `${dateLabel} ${timeLabel}`;
}
// Function to format date and time
function formatDateTime(dateTime) {
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
    const formattedDateTime = new Date(dateTime).toLocaleString('en-US', options);
    return formattedDateTime.replace(',', ' |');
}
$(document).ready(function () {
    const todayPlusTwo = new Date();
    todayPlusTwo.setDate(todayPlusTwo.getDate() + 2);

    const yyyy = todayPlusTwo.getFullYear();
    const mm = String(todayPlusTwo.getMonth() + 1).padStart(2, '0');
    const dd = String(todayPlusTwo.getDate()).padStart(2, '0');

    const minDate = `${yyyy}-${mm}-${dd}`;

    $('#customPriority').attr('min', minDate);
});

$(document).ready(function () {
    $('input[name="ticketPriority"]').on('change', function () {
        if ($('#prioritySpecial').is(':checked')) {
            $('#customPriorityWrapper').slideDown();
        } else {
            $('#customPriorityWrapper').slideUp();
            $('#customPriority').val('');
        }
    });
});