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
                <th>Requested</th>
                <th>Claimed</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Handler</th>
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
                    const dateAccepted = ticket.date_accepted ?? '';
                    const handler_name = ticket.handler_name ?? '';

                    const formattedDueDate = dueDate ? formatDate(dueDate) : 'N/A';
                    const formattedDateClosed = dateClosed ? formatDate(dateClosed) : 'N/A';
                    const formattedDateCreated = dateCreated ? formatDate(dateCreated) : 'N/A';
                    const formattedDateClaim = dateAccepted ? formatDate(dateAccepted) : 'N/A';
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
                            <td>${ticketId}</td>
                            <td>${fullName} - ${department}</td>
                            <td>${formattedDateCreated}</td>
                            <td>${formattedDateClaim}</td>
                            <td>${subject}</td>
                            <td>${status}</td>
                            <td>${handler_name}</td>
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

                $(`#${tableId}`).DataTable({
                    "order": [[0, "desc"]] // Sort by date created in descending order
                });
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
    const conclusionAttachmentLink = ticket.ticket_conclusion_attachment
        ? `<a href="../../../${ticket.ticket_conclusion_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : '';
    document.getElementById('closedticketId').innerText = ticket.ticket_id;
    document.getElementById('closedticketRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('closedticketRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('closedticketSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('closedticketDescription').innerText = ticket.ticket_description || 'N/A';
    document.getElementById('closedticketType').innerText = ticket.ticket_type || 'N/A';
    document.getElementById('closedticketAttachment').innerHTML = attachmentLink;
    document.getElementById('closedticketConclusion').innerHTML = ticket.ticket_conclusion + " " + conclusionAttachmentLink || 'N/A';
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
    $('#openChatButtonClosed').data('id', ticket.ticket_id).data('requestor', ticket.ticket_requestor_id).data('title', 'T#' + ticket.ticket_id + ' | ' + ticket.ticket_subject); // Set ticket ID and title for chat button
    document.activeElement.blur();
    $('#ticketModal').modal('hide');
    // Show the details modal
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

    document.getElementById('reasonForReopen').innerText = ticket.ticket_changes_description || 'N/A';
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
    $('#openChatButton').data('id', ticket.ticket_id).data('requestor', ticket.ticket_requestor_id).data('title', 'T#' + ticket.ticket_id + ' | ' + ticket.ticket_subject); // Set ticket ID and title for chat button
    document.activeElement.blur();
    $('#ticketModal').modal('hide');
    // Show the approve/reject reopen modal
    $('#approveRejectReopenModal').modal('show');
}

// Function to handle row click and show ticket details modal
function showTicketDetails(ticket) {
    // Populate modal with ticket details
    const attachmentLink = ticket.ticket_attachment
        ? `<a href="../../../${ticket.ticket_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : 'N/A';
    document.getElementById('ticketId').innerText = ticket.ticket_id;
    document.getElementById('ticketRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('ticketRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('ticketSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('ticketDescription').innerText = ticket.ticket_description || 'N/A';
    document.getElementById('ticketType').innerText = ticket.ticket_type || 'N/A';
    document.getElementById('ticketAttachment').innerHTML = attachmentLink;
    document.getElementById('ticketConclusion').innerText = ticket.ticket_conclusion || 'N/A';
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
    $('#openChatButton').data('id', ticket.ticket_id).data('requestor', ticket.ticket_requestor_id).data('title', 'T#' + ticket.ticket_id + ' | ' + ticket.ticket_subject); // Set ticket ID and title for chat button
    // Show the details modal
    document.activeElement.blur();
    $('#ticketModal').modal('hide');
    $('#ticketDetailsModal').modal('show');
}

function showAllTicketDetails(ticket) {
    // Populate modal with ticket details
    const attachmentLink = ticket.ticket_attachment
        ? `<a href="../../../${ticket.ticket_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : 'N/A';
    document.getElementById('ticketIdAll').innerText = ticket.ticket_id;
    document.getElementById('ticketRequestorIdAll').innerText = ticket.full_name || 'N/A';
    document.getElementById('ticketRequestorDepartmentAll').innerText = ticket.department || 'N/A';
    document.getElementById('ticketSubjectAll').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('ticketDescriptionAll').innerText = ticket.ticket_description || 'N/A';
    document.getElementById('ticketTypeAll').innerText = ticket.ticket_type || 'N/A';
    document.getElementById('ticketAttachmentAll').innerHTML = attachmentLink;
    document.getElementById('ticketHandlerAll').innerText = ticket.handler_name || 'N/A';
    document.getElementById('ticketConclusionAll').innerText = ticket.ticket_conclusion || 'N/A';
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
    $('#openChatButton').data('id', ticket.ticket_id).data('requestor', ticket.ticket_requestor_id).data('title', 'T#' + ticket.ticket_id + ' | ' + ticket.ticket_subject); // Set ticket ID and title for chat button
    // Show the details modal
    document.activeElement.blur();
    $('#ticketModal').modal('hide');
    $('#allTicketDetailsModal').modal('show');
    // loadHandlerOptions(); // Load handler options for reassigning ticket
}

// Function to handle row click and show ticket details modal
function showUnassignedTicketDetails(ticket) {
    // Populate modal with ticket details
    const unassignedAttachmentLink = ticket.ticket_attachment
        ? `<a href="../../../${ticket.ticket_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : 'N/A';
    document.getElementById('unassignedticketId').innerText = ticket.ticket_id;
    document.getElementById('unassignedticketRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('unassignedticketRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('unassignedticketSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('unassignedticketDescription').innerText = ticket.ticket_description || 'N/A';
    document.getElementById('unassignedticketType').innerText = ticket.ticket_type || 'N/A';
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
    document.activeElement.blur();
    $('#ticketModal').modal('hide');
    $('#unassignedticketDetailsModal').modal('show');
}



// Function to claim the ticket
function claimTicket() {
    const ticketId = document.getElementById('unassignedticketId').innerText;
    const forApproval = document.getElementById('forApprovalCheckbox').checked;
    const ticketStatus = forApproval ? 'FOR APPROVAL' : 'OPEN';

    // Get selected priority
    const selectedPriority = document.querySelector('input[name="ticketPriority"]:checked');
    const ticketPriority = selectedPriority ? selectedPriority.value : 'NORMAL';

    // Send updated details to the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/update_ticket.php',
        method: 'POST',
        data: {
            ticket_id: ticketId,
            ticket_status: ticketStatus,
            ticket_priority: ticketPriority
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket claimed successfully',
                    showConfirmButton: false,
                    timer: 1500
                });
                refreshTicketList();
                $('#unassignedticketDetailsModal').modal('hide');
                fetchAndShowTickets();
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

// function loadHandlerOptions() {
//     $.ajax({
//         url: '../../../backend/admin/ticketing-system/fetch_handlers.php',
//         method: 'POST',
//         dataType: 'json',
//         success: function (response) {
//             console.log('Response:', response); // Check what comes back

//             let select = $('#reassignHandlerSelect');
//             select.empty().append('<option value="">-- Select Handler --</option>');

//             if (response.status === 'success' && Array.isArray(response.data)) {
//                 response.data.forEach(handlers => {
//                     select.append(`<option value="${handlers.id}">${handlers.full_name}</option>`);
//                 });
//             } else {
//                 select.append('<option disabled>No handlers found</option>');
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error('AJAX error:', error);
//         }
//     });
// }




function reassignTicket(ticketId) {
    Swal.fire({
        title: 'Reassign Ticket',
        input: 'select',
        inputLabel: 'Select new handler',
        inputPlaceholder: 'Choose handler',
        showCancelButton: true,
        confirmButtonText: 'Reassign',
        inputOptions: {}, // will be filled dynamically
        didOpen: () => {
            fetch('../../../backend/admin/ticketing-system/fetch_handlers.php')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const inputOptions = {};
                        data.data.forEach(handler => { // FIXED LINE
                            inputOptions[handler.id] = handler.full_name;
                        });
                        Swal.getInput().innerHTML = ''; // clear first
                        for (const id in inputOptions) {
                            const option = document.createElement('option');
                            option.value = id;
                            option.text = inputOptions[id];
                            Swal.getInput().appendChild(option);
                        }
                    } else {
                        Swal.showValidationMessage('Failed to load handlers');
                    }
                });
        },
        preConfirm: (handlerId) => {
            if (!handlerId) {
                Swal.showValidationMessage('Please select a handler');
            }
            return fetch('../../../backend/s-admin/ticketing-system/reassign-ticket.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    ticket_id: ticketId,
                    handler_id: handlerId
                })
            }).then(res => res.json());
        }
    }).then(result => {
        if (result.isConfirmed && result.value.status === 'success') {
            Swal.fire('Success', 'Ticket reassigned successfully.', 'success').then(() => {
                // Optional: refresh table or UI
                location.reload(true);
            });
        } else if (result.value?.status === 'error') {
            Swal.fire('Error', result.value.message, 'error');
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
function cancelTicketDetails1() {
    document.getElementById('ticketDueDate').disabled = true;
    document.getElementById('ticketStatus').disabled = true;
    document.getElementById('closeTicketButton').style.display = 'inline-block';
    document.getElementById('saveButton').style.display = 'none';
    document.getElementById('cancelsaveButton').style.display = 'none';
}

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
        url: '../../../backend/s-admin/ticketing-system/update_ticket.php', // Adjust the path as needed
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
                    showConfirmButton: false,
                    timer: 1500
                });
                refreshTicketList();
                $('#ticketDetailsModal').modal('hide');
                location.reload(); // Reload the page to reflect changes
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
    speech.rate = 0.8;

    function setVoiceAndSpeak() {
        const voices = window.speechSynthesis.getVoices();
        let selectedVoice = voices.find(v => v.name === 'Google UK English Female');

        if (!selectedVoice && voices.length > 0) {
            selectedVoice = voices.find(v => v.lang.startsWith('en')) || voices[0]; // fallback
        }

        if (selectedVoice) {
            speech.voice = selectedVoice;
        }

        window.speechSynthesis.speak(speech);
    }

    // If voices are not yet loaded
    if (window.speechSynthesis.getVoices().length === 0) {
        window.speechSynthesis.onvoiceschanged = setVoiceAndSpeak;
    } else {
        setVoiceAndSpeak();
    }
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


$(document).ready(function () {
    let chatboxOpen = false;
    let chatboxTimer = null;

    // Open chatbox
    $(document).on('click', '#openChatButton, #openChatButtonUnassigned, #openChatButtonClosed', function () {
        suppressTicketModal = true;
        const ticketId = $(this).data('id');
        const ticketTitle = $(this).data('title');
        const ticketRequestor = $(this).data('requestor');

        $("#closedTicketDetailsModal").modal('hide');
        $("#reopenTicketDetailsModal").modal('hide');
        $("#unassignedticketDetailsModal").modal('hide');
        $("#ticketDetailsModal").modal('hide');
        $("#confirmReopenModal").modal('hide');
        $('#ticketModal').modal('hide');

        openChatbox(ticketId, ticketTitle, ticketRequestor);

        // Reset the suppression flag after a short delay (to avoid race conditions)
        setTimeout(() => suppressTicketModal = false, 500);
    });

    // Function to open chatbox
    function openChatbox(ticketId, ticketTitle, ticketRequestor) {
        chatboxOpen = true;
        $('#chatboxTitle').text(ticketTitle);
        $('#chatbox').data('ticket-id', ticketId).data('requestor', ticketRequestor).show();
        fetchChatboxMessages(ticketId);
    }

    // Close chatbox
    $('#closeChatbox').on('click', function () {
        chatboxOpen = false;
        clearTimeout(chatboxTimer); // Stop further polling
        $('#chatbox').hide();
    });

    // Fetch chatbox messages
    function fetchChatboxMessages(ticketId) {
        if (!chatboxOpen) return; // Stop polling if chatbox is closed

        $.ajax({
            url: '../../../backend/admin/ticketing-system/fetch_chat_messages.php',
            type: 'GET',
            data: { ticket_id: ticketId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const chatboxMessages = $('#chatboxMessages');
                    chatboxMessages.empty();
                    response.data.forEach(message => {
                        const formattedDateTime = formatDateTime(message.ticket_convo_date);
                        const readStatus = message.is_read ? 'read' : 'unread';
                        const messageElement = `
                            <div class="chat-message ${readStatus}">
                                <strong>${message.full_name}:</strong> ${message.ticket_messages}
                                <div class="small text-gray-500">${formattedDateTime}</div>
                            </div>
                            <hr>`;
                        chatboxMessages.append(messageElement);
                    });
                } else {
                    console.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching chat messages: ", error);
            },
            complete: function () {
                // Poll again only if chatbox is still open
                if (chatboxOpen) {
                    chatboxTimer = setTimeout(() => fetchChatboxMessages(ticketId), 1000);
                }
            }
        });
    }


    // Send chatbox message
    $('#sendChatboxMessage').on('click', function () {
        const ticketId = $('#chatbox').data('ticket-id');
        const ticketRequestor = $('#chatbox').data('requestor');
        const message = $('#chatboxInput').val();
        if (message.trim() !== '') {
            $.ajax({
                url: '../../../backend/admin/ticketing-system/send_chat_message.php', // Change this to your PHP endpoint
                type: 'POST',
                data: { ticket_id: ticketId, message: message, requestor: ticketRequestor },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#chatboxInput').val('');
                        fetchChatboxMessages(ticketId, ticketRequestor); // Refresh chat messages
                    } else {
                        console.error(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error sending chat message: ", error);
                }
            });
        }
    });

    // Function to format date and time
    function formatDateTime(dateTime) {
        const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
        const formattedDateTime = new Date(dateTime).toLocaleString('en-US', options);
        return formattedDateTime.replace(',', ' |');
    }
});

function runBackupScript() {
    fetch('../../../backend/s-admin/ticketing-system/backup_and_transfer.php') // Your PHP backup script URL
        .then(response => response.text())
        .then(data => {
            console.log("✅ Backup Triggered: ", data);
        })
        .catch(error => {
            console.error("❌ Error triggering backup: ", error);
        });
}

// Check every minute if time is 6:00 PM
setInterval(() => {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();

    // Run only once at 6:00 PM (18:00)
    if (hours === 9 && minutes === 18) {
        runBackupScript();
    }
}, 60000); // Check every 60 seconds