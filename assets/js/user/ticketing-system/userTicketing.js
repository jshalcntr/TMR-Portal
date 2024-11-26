const textarea = document.getElementById("ticket_content");
const maxRows = 20;

// Calculate max height based on line height and max rows
const lineHeight = parseFloat(window.getComputedStyle(textarea).lineHeight);
const maxHeight = lineHeight * maxRows;

textarea.addEventListener("input", function () {
    this.style.height = "auto"; // Reset height to shrink if necessary

    // Set height to scrollHeight but limit it to maxHeight
    if (this.scrollHeight > maxHeight) {
        this.style.height = maxHeight + "px";
        this.style.overflowY = "scroll"; // Show scrollbar if max height reached
    } else {
        this.style.height = this.scrollHeight + "px";
        this.style.overflowY = "hidden"; // Hide scrollbar within limit
    }
});


// populate from similar tickets 

document.addEventListener('DOMContentLoaded', function () {
    const ticketCategoryInput = document.getElementById('ticket_category');
    const ticketSubjectInput = document.getElementById('ticket_subject');
    const ticketContentInput = document.getElementById('ticket_content');
    const similarTicketDiv = document.querySelector('.similar-ticket');

    // Listen for input on the ticket subject field
    ticketSubjectInput.addEventListener('input', function () {
        const subject = ticketSubjectInput.value.trim();

        if (subject.length > 2) {
            fetch(`../../../backend/user/ticketing-system/similarticket.php?category=${ticketCategoryInput.value.trim() + '&subject=' + encodeURIComponent(subject)}`)
                .then(response => response.json())
                .then(data => {
                    similarTicketDiv.innerHTML = ''; // Clear previous results

                    if (data.length > 0) {
                        similarTicketDiv.classList.remove('hidden');

                        data.forEach(ticket => {
                            const ticketItem = document.createElement('div');
                            ticketItem.textContent = ticket.ticket_subject + " | " + ticket.requestor_name;
                            ticketItem.className = 'ticket-item';
                            similarTicketDiv.appendChild(ticketItem);

                            // Make ticket item clickable to populate fields
                            ticketItem.addEventListener('click', function () {
                                ticketCategoryInput.value = ticket.ticket_type;
                                ticketSubjectInput.value = ticket.ticket_subject;
                                ticketContentInput.value = ticket.ticket_description;
                                similarTicketDiv.classList.add('hidden'); // Hide suggestions after selection
                            });
                        });
                    } else {
                        similarTicketDiv.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error fetching similar tickets:', error));
        } else {
            similarTicketDiv.classList.add('hidden'); // Hide if input is cleared or too short
        }
    });
});



// Validate ticket attachement
$(document).ready(function () {
    $('#ticket_attachment').on('change', function () {
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        const maxFileSize = 2 * 1024 * 1024; // 2 MB in bytes
        const file = this.files[0];

        // Reset error message
        $('#file-error').text('');

        if (file) {
            // Get file extension
            const fileExtension = file.name.split('.').pop().toLowerCase();
            // Check if the file extension is allowed
            if (!allowedExtensions.includes(fileExtension)) {
                $('#file-error').text('Invalid file type. Allowed types: .jpg, .png, .pdf, .docx');
                this.value = ''; // Clear the file input
                return;
            }

            // Check if the file size is within the limit
            if (file.size > maxFileSize) {
                $('#file-error').text('File size exceeds 2 MB. Please choose a smaller file.');
                this.value = ''; // Clear the file input
                return;
            }
        }
    });

    // Form submission
    $('#ticketForm').on('submit', function (e) {
        if ($('#file-error').text()) {
            e.preventDefault(); // Stop form submission if there's an error
            alert('Please resolve the file upload issue before submitting.');
        }
    });
});



$(document).ready(function () {
    // Fetch "For Approval" tickets
    function forApprovalTickets() {
        $.ajax({
            url: '../../../backend/user/ticketing-system/fetch_for_approval_tickets.php', // Adjust the path
            type: 'GET',
            success: function (response) {
                if (response.status === 'success') {
                    const tickets = response.data;
                    const approvalContainer = $('#forApprovalContainer'); // Add an ID to the container
                    approvalContainer.empty(); // Clear previous content

                    if (tickets.length > 0) {
                        tickets.forEach(ticket => {
                            const attachmentLink = ticket.ticket_attachment
                                ? `<a href="${ticket.ticket_attachment}" target="_blank" class="badge badge-info">Attachment</a>`
                                : '';

                            const ticketHtml = `
                            <button class="dropdown-item align-items-center ticket-items" 
                                data-id="${ticket.ticket_id}" 
                                data-subject="${ticket.ticket_subject}" 
                                data-description="${ticket.ticket_description}" 
                                data-date="${ticket.date_created}" 
                                data-handler="${ticket.handler_name || 'N/A'}" 
                                data-requestor="${ticket.requestor_name || 'N/A'}"
                                data-attachment="${ticket.ticket_attachment || ''}">
                                <div class="text-truncate">${ticket.ticket_subject}</div>
                                <div class="small text-gray-500 text-truncate">${ticket.ticket_description}</div>
                                <div class="small text-muted text-truncate">
                                    <strong>Created:</strong> ${ticket.date_created} | 
                                    <strong>Requestor:</strong> ${ticket.requestor_name} | 
                                    ${attachmentLink}
                                </div>
                            </button>
                        `;
                            approvalContainer.append(ticketHtml);
                        });

                        // Add click event to open modal
                        $('.ticket-items').on('click', function () {
                            const ticketData = $(this).data();
                            $('#ticketModalTitle').text(ticketData.subject);
                            $('#ticketModalDescription').text(ticketData.description);
                            $('#ticketModalDate').text(ticketData.date);
                            $('#ticketModalHandler').text(ticketData.handler);
                            $('#ticketModalRequestor').text(ticketData.requestor);
                            if (ticketData.attachment) {
                                $('#ticketModalAttachment').html(`<a href="${ticketData.attachment}" target="_blank" class="btn btn-info">View Attachment</a>`);
                            } else {
                                $('#ticketModalAttachment').text('No attachment available.');
                            }
                            $('#forApprovalticketModal').modal('show');
                        });
                    } else {
                        approvalContainer.append('<p>No tickets for approval found.</p>');
                    }
                } else {
                    console.error(response.message);
                    $('#forApprovalContainer').html('<p class="text-danger">Error fetching tickets. Please try again later.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                $('#forApprovalContainer').html('<p class="text-danger">Error fetching tickets. Please try again later.</p>');
            }
        });
    }
    setInterval(forApprovalTickets, 5000);
    forApprovalTickets();
});



// Function to fetch tickets and populate the lists
function fetchTickets() {
    $.ajax({
        url: '../../../backend/user/ticketing-system/get_tickets.php', // Change this to your PHP endpoint
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                populateTickets(response.data.pending, '#pendingTicketList', 'Pending');
                populateTickets(response.data.closed, '#closedTicketList', 'Closed');
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching tickets: ", error);
        }
    });
}
// Populate ticket lists
function populateTickets(tickets, containerSelector, type) {
    const container = $(containerSelector);
    container.empty();
    tickets.forEach(ticket => {
        const attachmentLink = ticket.ticket_attachment
            ? `<a href="${ticket.ticket_attachment}" target="_blank" class="badge badge-info">Attachment</a>`
            : '';
        const handlerName = ticket.handler_name ? ticket.handler_name : 'Unassigned';
        const ticketElement = `
                <button class="dropdown-item align-items-center ticket-item" 
                    data-id="${ticket.ticket_id}" 
                    data-title="${ticket.ticket_subject}" 
                    data-description="${ticket.ticket_description}" 
                    data-attachment="${ticket.ticket_attachment}" 
                    data-date="${ticket.date_created}" 
                    data-handler="${handlerName}" 
                    data-status="${type}">
                    <div class="text-truncate">${ticket.ticket_subject}</div>
                    <div class="small text-gray-500 text-truncate">${ticket.ticket_description}</div>
                    <div class="small text-muted text-truncate">
                        <strong>Created:</strong> ${ticket.date_created} | 
                        <strong>Handler:</strong> ${handlerName} | 
                        ${attachmentLink}
                    </div>
                </button>
                <hr>`;
        container.append(ticketElement);
    });
}



$(document).ready(function () {
    // Load tickets
    fetchTickets();



    // Click event for tickets
    $(document).on('click', '.ticket-item', function (e) {
        e.preventDefault();

        // Populate modal with ticket details
        const ticketId = $(this).data('id');
        const title = $(this).data('title');
        const description = $(this).data('description');
        const attachment = $(this).data('attachment');
        const date = $(this).data('date');
        const status = $(this).data('status');
        const handlerName = $(this).data('handler');

        $('#ticketTitle').text(title);
        $('#ticketDescription').text(description);
        if (attachment !== null) {
            $('#ticketAttachment').html(`<a href="${attachment}" target="_blank" class="text-primary">View Attachment</a>`);
        } else {
            $('#ticketAttachment').text('No attachment.');
        }

        $('#ticketDate').text(date);

        const actionButtons = $('#actionButtons');
        actionButtons.empty();

        if (status !== 'Closed' && handlerName === 'Unassigned') {
            actionButtons.append(`
                <button class="btn btn-outline-danger btn-sm" id="cancelTicket" data-id="${ticketId}">Cancel Ticket</button>
            `);
        } else if (status !== 'Closed' && handlerName !== 'Unassigned') {
            actionButtons.append(`
                <button class="btn btn-outline-secondary btn-sm" disabled data-id="${ticketId}">Cancel Ticket</button>
            `);
        } else if (status === 'Closed') {
            actionButtons.append(`
                <button class="btn btn-outline-primary btn-sm" id="reopenTicket" data-id="${ticketId}">Re-open Ticket</button>
            `);
        }

        $('#ticketsModal').modal('show');
    });

    // Cancel pending ticket
    $(document).on('click', '#cancelTicket', function () {
        const ticketId = $(this).data('id');
        updateTicketStatus(ticketId, 'CANCELLED');
    });

    // Re-open closed ticket
    $(document).on('click', '#reopenTicket', function () {
        const ticketId = $(this).data('id');
        updateTicketStatus(ticketId, 'OPEN');
    });

    // Function to update ticket status
    function updateTicketStatus(ticketId, newStatus) {
        $.ajax({
            url: '../../../backend/user/ticketing-system/update_ticket_status.php', // Change this to your PHP endpoint
            type: 'POST',
            data: { ticket_id: ticketId, status: newStatus },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#ticketsModal').modal('hide');
                    fetchTickets(); // Reload tickets
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error updating ticket status: ", error);
            }
        });
    }
});
