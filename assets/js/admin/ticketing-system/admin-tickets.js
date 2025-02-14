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
    const hours = date.getHours();
    const minutes = date.getMinutes();
    const ampm = hours >= 12 ? 'pm' : 'am';
    const formattedHours = hours % 12 || 12; // Convert to 12-hour format
    const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
    const month = date.getMonth() + 1; // Months are zero-based
    const day = date.getDate();
    const year = date.getFullYear().toString().slice(-2); // Get last two digits of the year

    return `${formattedHours}:${formattedMinutes} ${ampm} ${month}-${day}-${year}`;
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

    // Update modal title
    document.getElementById('ticketModalLabel').innerText = modalTitle[category];

    // Fetch data from the backend
    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_tickets.php', // Adjust the path as needed
        method: 'GET',
        data: { category: category },
        success: function (response) {
            if (response.status === 'success') {
                const tableBody = document.querySelector('#ticketTable tbody');
                tableBody.innerHTML = ''; // Clear existing rows

                // Populate table with tickets
                response.data.forEach(ticket => {
                    const attachmentLink = ticket.ticket_attachment
                        ? `<a target="_blank" class="badge badge-info">Attachment</a>`
                        : '';
                    const formattedDueDate = ticket.ticket_due_date ? formatDate(ticket.ticket_due_date) : 'N/A';
                    const formattedDateCreated = ticket.date_created ? formatDate(ticket.date_created) : 'N/A';
                    const row = `
                        <tr class="clickable-row" data-ticket='${JSON.stringify(ticket)}'>
                            <td>${ticket.ticket_id}</td>
                            <td>${ticket.full_name} - ${ticket.department}</td>
                            <td>${formattedDateCreated}</td>
                            <td>${ticket.ticket_subject}</td>
                            <td>${ticket.ticket_status}</td>
                            <td>${formattedDueDate}</td>
                            <td>${attachmentLink}</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });

                // Initialize DataTables
                $('#ticketTable').DataTable();

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
                } else {
                    // Add event listener for row click
                    document.querySelectorAll('.clickable-row').forEach(row => {
                        row.addEventListener('click', function () {
                            const ticket = JSON.parse(this.getAttribute('data-ticket'));
                            showTicketDetails(ticket);
                        });
                    });
                }


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
    document.getElementById('closedticketId').innerText = ticket.ticket_id;
    document.getElementById('closedticketRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('closedticketRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('closedticketSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('closedticketDescription').innerText = ticket.ticket_description || 'N/A';
    document.getElementById('closedticketType').innerText = ticket.ticket_type || 'N/A';
    document.getElementById('closedticketAttachment').innerHTML = attachmentLink;
    document.getElementById('closedticketConclusion').innerText = ticket.ticket_conclusion || 'N/A';

    // Set the value of the date-time picker
    document.getElementById('closedticketDueDate').value = ticket.ticket_due_date || '';

    // Populate status select options
    const statusSelect = document.getElementById('closedticketStatus');
    const statuses = ['OPEN', 'PENDING', 'ON GOING', 'FOR APPROVAL', 'PRIORITY', 'REJECTED', 'APPROVED', 'FINISHED', 'CLOSED', 'CANCELLED'];
    statusSelect.innerHTML = ''; // Clear existing options
    statuses.forEach(status => {
        const option = document.createElement('option');
        option.value = status;
        option.text = status;
        if (status === ticket.ticket_status) {
            option.selected = true;
        }
        statusSelect.appendChild(option);
    });

    // Fetch handler names from the MIS department
    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_handlers.php', // Adjust the path as needed
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const handlerSelect = document.getElementById('closedticketHandlerId');
                handlerSelect.innerHTML = ''; // Clear existing options

                // Populate select options with handler names
                response.data.forEach(handler => {
                    const option = document.createElement('option');
                    option.value = handler.id;
                    option.text = handler.full_name;
                    if (handler.id === ticket.ticket_handler_id) {
                        option.selected = true;
                    }
                    handlerSelect.appendChild(option);
                });
            } else {
                console.error('Error:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });

    $('#ticketModal').modal('hide');
    // Show the details modal
    $('#closedTicketDetailsModal').modal('show');

}

// Function to handle row click and show confirm reopen modal
function showReopenTicketDetails(ticket) {
    // Populate modal with ticket details
    const attachmentLink = ticket.ticket_attachment
        ? `<a href="../../../${ticket.ticket_attachment.replace(/^(\.\.\/)+/, '')}" target="_blank" class="badge badge-info">View Attachment</a>`
        : 'N/A';
    document.getElementById('confirmReopenTicketId').innerText = ticket.ticket_id;
    document.getElementById('confirmReopenRequestorId').innerText = ticket.full_name || 'N/A';
    document.getElementById('confirmReopenRequestorDepartment').innerText = ticket.department || 'N/A';
    document.getElementById('confirmReopenSubject').innerText = ticket.ticket_subject || 'N/A';
    document.getElementById('confirmReopenDescription').innerText = ticket.ticket_description || 'N/A';

    $('#ticketModal').modal('hide');
    // Show the confirm reopen modal
    $('#confirmReopenModal').modal('show');
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
    // Set the value of the date-time picker
    document.getElementById('ticketDueDate').value = ticket.ticket_due_date || '';
    if (ticket.ticket_due_date === null || ticket.ticket_due_date === '0000-00-00 00:00:00' || ticket.ticket_due_date === '') {
        document.getElementById('closeTicketButton').style.display = 'none';
    } else {
        document.getElementById('closeTicketButton').style.display = 'inline-block';
    }
    // Populate status select options
    const statusSelect = document.getElementById('ticketStatus');
    const statuses = ['OPEN', 'PENDING', 'ON GOING', 'FOR APPROVAL', 'PRIORITY', 'REJECTED', 'APPROVED', 'FINISHED', 'CLOSED', 'CANCELLED'];
    statusSelect.innerHTML = ''; // Clear existing options
    statuses.forEach(status => {
        const option = document.createElement('option');
        option.value = status;
        option.text = status;
        if (status === ticket.ticket_status) {
            option.selected = true;
        }
        statusSelect.appendChild(option);
    });
    // Fetch handler names from the MIS department
    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_handlers.php', // Adjust the path as needed
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const handlerSelect = document.getElementById('ticketHandlerId');
                handlerSelect.innerHTML = ''; // Clear existing options
                // Populate select options with handler names
                response.data.forEach(handler => {
                    const option = document.createElement('option');
                    option.value = handler.id;
                    option.text = handler.full_name;
                    if (handler.id === ticket.ticket_handler_id) {
                        option.selected = true;
                    }
                    handlerSelect.appendChild(option);
                });
            } else {
                console.error('Error:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
    // Show the details modal
    $('#ticketModal').modal('hide');
    $('#ticketDetailsModal').modal('show');
}

// Function to handle row click and show ticket details modal
function showUnassignedTicketDetails(ticket) {
    document.getElementById('errorMessage').innerText = '';
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
    document.getElementById('unassignedticketConclusion').innerText = ticket.ticket_conclusion || 'N/A';
    document.getElementById('unassignedticketAttachment').innerHTML = unassignedAttachmentLink;

    // Set the value of the date-time picker
    document.getElementById('unassignedticketDueDate').value = ticket.ticket_due_date || '';

    // Populate status select options
    const statusSelect = document.getElementById('unassignedticketStatus');
    const statuses = ['OPEN', 'PENDING', 'ON GOING', 'FOR APPROVAL', 'PRIORITY', 'REJECTED', 'APPROVED', 'FINISHED', 'CLOSED', 'CANCELLED'];
    statusSelect.innerHTML = ''; // Clear existing options
    statuses.forEach(status => {
        const option = document.createElement('option');
        option.value = status;
        option.text = status;
        if (status === ticket.ticket_status) {
            option.selected = true;
        }
        statusSelect.appendChild(option);
    });

    // Fetch handler names from the MIS department
    $.ajax({
        url: '../../../backend/admin/ticketing-system/fetch_handlers.php', // Adjust the path as needed
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const handlerSelect = document.getElementById('unassignedticketHandlerId');
                handlerSelect.innerHTML = ''; // Clear existing options

                // Populate select options with handler names
                response.data.forEach(handler => {
                    const option = document.createElement('option');
                    option.value = handler.id;
                    option.text = handler.full_name;
                    if (handler.id === ticket.ticket_handler_id) {
                        option.selected = true;
                    }
                    handlerSelect.appendChild(option);
                });
            } else {
                console.error('Error:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });

    // Show the details modal
    $('#ticketModal').modal('hide');
    $('#unassignedticketDetailsModal').modal('show');
}



// Function to claim the ticket
function claimTicket() {
    const ticketId = document.getElementById('unassignedticketId').innerText;
    const dueDate = document.getElementById('unassignedticketDueDate').value;
    const forApproval = document.getElementById('forApprovalCheckbox').checked;
    const ticketStatus = forApproval ? 'FOR APPROVAL' : 'OPEN';

    if (dueDate === '') {
        document.getElementById('errorMessage').innerText = 'Please select a due date';
        setTimeout(function () {
            document.getElementById('errorMessage').innerText = '';
        }, 3000);
    } else {
        // Send updated details to the backend
        $.ajax({
            url: '../../../backend/admin/ticketing-system/update_ticket.php', // Adjust the path as needed
            method: 'POST',
            data: {
                ticket_id: ticketId,
                ticket_status: ticketStatus,
                ticket_due_date: dueDate
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
                    fetchAndShowTickets("unassigned");
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
}

// Function to enable editing of ticket details
function enableEditing() {
    document.getElementById('ticketDueDate').disabled = false;
    document.getElementById('ticketStatus').disabled = false;
    // document.getElementById('ticketHandlerId').disabled = false;
    document.getElementById('editButton').style.display = 'none';
    document.getElementById('closeTicketButton').style.display = 'none';
    document.getElementById('saveButton').style.display = 'inline-block';
    document.getElementById('cancelsaveButton').style.display = 'inline-block';
}
// Function to cancel enable editing of ticket details
function cancelTicketDetails() {
    document.getElementById('ticketDueDate').disabled = true;
    document.getElementById('ticketStatus').disabled = true;
    // document.getElementById('ticketHandlerId').disabled = true;
    document.getElementById('editButton').style.display = 'inline-block';
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
    // document.getElementById('ticketHandlerId').disabled = true;
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

// Function to show the conclusion text area
function showConclusionTextArea() {
    document.getElementById('conclusionTextArea').style.display = 'block';
    document.getElementById('saveConclusionButton').style.display = 'inline-block';
    document.getElementById('closeTicketButton').style.display = 'none';
    document.getElementById('editButton').style.display = 'none';
    document.getElementById('cancelsaveButton').style.display = 'inline-block';
}

// Function to cancel enable editing of ticket details
function cancelTicketDetails() {
    document.getElementById('ticketDueDate').disabled = true;
    document.getElementById('ticketStatus').disabled = true;
    // document.getElementById('ticketHandlerId').disabled = true;
    document.getElementById('editButton').style.display = 'inline-block';
    document.getElementById('closeTicketButton').style.display = 'inline-block';
    document.getElementById('saveButton').style.display = 'none';
    document.getElementById('cancelsaveButton').style.display = 'none';
    document.getElementById('saveConclusionButton').style.display = 'none';
    document.getElementById('conclusionTextArea').style.display = 'none';
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
            url: '../../../backend/user/ticketing-system/reopen_ticket.php',
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
    // Show confirm reopen modal when "Request Reopen" button is clicked
    $('#showReopenChangesButton').on('click', function () {
        $('#confirmReopenModal').modal('show');
    });

    // Handle submission of reopen request
    $('#submitReopenRequestButton').on('click', function () {
        const ticketId = $('#confirmReopenTicketId').text();
        const reopenReasonDescription = $('#reopenReasonDescription').val();

        if (reopenReasonDescription.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please enter a reason for reopening the ticket.'
            });
            return;
        }

        $.ajax({
            url: '../../../backend/user/ticketing-system/reopen_ticket.php',
            type: 'POST',
            data: {
                ticket_id: ticketId,
                reopen_reason_description: reopenReasonDescription
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Ticket reopen request submitted successfully!'
                    }).then(() => {
                        $('#confirmReopenModal').modal('hide');
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
                    text: 'Error submitting reopen request. Please try again later.'
                });
            }
        });
    });

    // Handle cancellation of reopen request
    $('#cancelReopenRequestButton').on('click', function () {
        $('#confirmReopenModal').modal('hide');
        $('#reopenReasonDescription').val('');
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

    // Get the list of available voices
    const voices = window.speechSynthesis.getVoices();

    // Find the Microsoft Zira voice
    const femaleVoice = voices.find(voice => voice.name === 'Google UK English Female');

    // Set the Microsoft Zira voice if found
    if (femaleVoice) {
        speech.voice = femaleVoice;
    }

    window.speechSynthesis.speak(speech);
}

window.speechSynthesis.onvoiceschanged = () => {
    console.log(window.speechSynthesis.getVoices());
};

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

$("#closedTicketDetailsModal").on('hidden.bs.modal', function () {
    $('#ticketModal').modal('show');
});
$("#reopenTicketDetailsModal").on('hidden.bs.modal', function () {
    $('#ticketModal').modal('show');
});
$("#unassignedticketDetailsModal").on('hidden.bs.modal', function () {
    $('#ticketModal').modal('show');
});
$("#ticketDetailsModal").on('hidden.bs.modal', function () {
    $('#ticketModal').modal('show');
});
$("#confirmReopenModal").on('hidden.bs.modal', function () {
    $('#ticketModal').modal('show');
});
