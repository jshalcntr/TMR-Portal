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
                            // Format the date and time from the database
                            const dateTime = new Date(ticket.date_created.replace(' ', 'T'));
                            const date = dateTime.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                            });
                            const time = dateTime.toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: 'numeric',
                                hour12: true,
                            });

                            // Create the ticket HTML
                            const ticketHtml = `
                                <div class=" align-items-center" 
                                    data-id="${ticket.ticket_id}" 
                                    data-subject="${ticket.ticket_subject}" 
                                    data-description="${ticket.ticket_description}" 
                                    data-date="${date}" 
                                    data-handler="${ticket.handler_name || 'N/A'}" 
                                    data-requestor="${ticket.requestor_name || 'N/A'}"
                                    data-attachment="${ticket.ticket_attachment || ''}">
                                    <div class="text-truncate">${ticket.ticket_subject}</div>
                                    <div class="small text-gray-500 ">${ticket.ticket_description}</div>
                                    <div class="small text-gray-500 text-truncate">
                                        <button class="btn btn-light btn-sm btn-right similar-ticket-items">Select</button>
                                        <strong>Created:</strong> ${date} | 
                                        <strong>Requestor:</strong> ${ticket.requestor_name} | 
                                    </div>
                                    
                                </div>
                                <hr>
                            `;

                            // Append the HTML to the container
                            similarTicketDiv.insertAdjacentHTML('beforeend', ticketHtml);

                            // Add click event to populate fields
                            similarTicketDiv.querySelectorAll('.similar-ticket-items').forEach(item => {
                                item.addEventListener('click', function () {
                                    ticketCategoryInput.value = ticket.ticket_type;
                                    ticketSubjectInput.value = ticket.ticket_subject;
                                    ticketContentInput.value = ticket.ticket_description;
                                    similarTicketDiv.classList.add('hidden'); // Hide suggestions after selection
                                });
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
setInterval(fetchTickets, 5000); // Fetch tickets every 5 seconds
// Function to submit a new ticket  
$(document).ready(function () {
    $('#ticketForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        Swal.fire({
            title: 'Submitting Ticket',
            text: 'Please wait...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '../../../backend/user/ticketing-system/newticket.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        fetchTickets();
                    });
                    $('#ticketForm')[0].reset(); // Reset form
                    document.querySelector('.similar-ticket').classList.add('hidden');
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'There was a problem submitting the ticket.',
                        icon: 'error'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire({
                    title: 'Server Error',
                    text: 'Something went wrong. Please try again later.',
                    icon: 'error'
                });
            }
        });
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


// Separate date and time
function formatDateTime(dateString) {
    if (!dateString || typeof dateString !== 'string') {
        return { date: 'N/A', time: 'N/A' };
    }

    // Replace space with T to ensure ISO compatibility
    const date = new Date(dateString.replace(' ', 'T'));

    if (isNaN(date.getTime())) {
        return { date: 'Invalid Date', time: 'Invalid Time' };
    }

    // Format date as "Apr 4, 2025"
    const formattedDate = date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });

    // Format time as "10:00 AM"
    const formattedTime = date.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
    });

    return { date: formattedDate, time: formattedTime };
}

function formatDueDate(dueDateString) {
    const options = { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true };
    return new Date(dueDateString).toLocaleString('en-US', options);
}
$(document).ready(function () {
    function forApprovalTickets() {
        $.ajax({
            url: '../../../backend/user/ticketing-system/fetch_for_approval_tickets.php',
            type: 'GET',
            success: function (response) {
                if (response.status === 'success') {
                    const tickets = response.data;
                    const approvalContainer = $('#forApprovalContainer');
                    approvalContainer.empty();

                    if (tickets.length > 0) {
                        tickets.forEach(ticket => {
                            const { date, time } = formatDateTime(ticket.date_created);
                            const dueDate = new Date(ticket.ticket_for_approval_due_date);
                            const now = new Date();
                            let countdownText = getCountdownText(dueDate, now);
                            let formattedDueDate = formatDueDate(ticket.ticket_for_approval_due_date);
                            if (dueDate < now) {
                                formattedDueDate = 'Expired';
                                $('#ticketDueDateApproval').removeClass('text-warning').addClass('text-danger');
                            }
                            let priorityClass = '';
                            if (ticket.ticket_priority === 'CRITICAL') {
                                priorityClass = 'text-danger';
                            } else if (ticket.ticket_priority === 'IMPORTANT') {
                                priorityClass = 'text-warning';
                            } else if (ticket.ticket_priority === 'NORMAL') {
                                priorityClass = 'text-secondary';
                            }

                            const attachmentLink = ticket.ticket_attachment
                                ? `<a href="${ticket.ticket_attachment}" target="_blank" class="badge badge-info">Attachment</a>`
                                : '';

                            const ticketHtml = `
                            <button class="dropdown-item align-items-center ticket-items" 
                                data-id="${ticket.ticket_id}" 
                                data-subject="${ticket.ticket_subject}" 
                                data-description="${ticket.ticket_description}" 
                                data-date="${date}" 
                                data-time="${time}" 
                                data-countdown="${countdownText}"
                                data-handler="${ticket.handler_name || 'N/A'}" 
                                data-requestor="${ticket.requestor_name || 'N/A'}"
                                data-attachment="${ticket.ticket_attachment || ''}"
                                data-priority="${ticket.ticket_priority}"
                                data-handlerid="${ticket.ticket_handler_id}"
                                data-duedate="${formattedDueDate}">
                                <div class="text-truncate">#${ticket.ticket_id} - ${ticket.ticket_subject}</div>
                                <div class="small text-gray-500 text-truncate">${ticket.ticket_description}</div>
                                <div class="small text-gray-500 text-truncate">
                                    <strong class="${priorityClass}">Approval Due: <span class="countdown-timer">${countdownText}</span></strong> |
                                    <strong>Requestor:</strong> ${ticket.requestor_name} | 
                                    ${attachmentLink}
                                </div>
                            </button>
                            <hr>`;
                            approvalContainer.append(ticketHtml);
                        });

                        $('.ticket-items').on('click', function () {
                            const ticketData = $(this).data();
                            $('#ticketModalTitle').text(ticketData.subject);
                            $('#ticketModalDescription').text(ticketData.description);
                            $('#ticketModalDate').text(ticketData.date);
                            $('#ticketModalTime').text(ticketData.time);
                            $('#ticketDueDateApproval').text(ticketData.duedate);
                            $('#ticketModalHandler').text(ticketData.handler);
                            $('#ticketModalRequestor').text(ticketData.requestor);
                            $('#approveButton').data('id', ticketData.id);

                            $('#rejectButton').data('id', ticketData.id);
                            if (ticketData.attachment) {
                                $('#ticketModalAttachment').html(`<a href="${ticketData.attachment}" target="_blank" class="text-primary">View Attachment</a>`);
                            } else {
                                $('#ticketModalAttachment').text('No attachment available.');
                            }
                            if (ticketData.priority === 'CRITICAL') {
                                $('#ticketPriority').text('CRITICAL').removeClass('text-secondary text-warning').addClass('text-danger');
                                $('#ticketDueDateApproval').removeClass('text-secondary text-warning').addClass('text-danger');
                            } else if (ticketData.priority === 'IMPORTANT') {
                                $('#ticketPriority').text('IMPORTANT').removeClass('text-secondary text-danger').addClass('text-warning');
                                $('#ticketDueDateApproval').removeClass('text-secondary text-danger').addClass('text-warning');
                            } else if (ticketData.priority === 'NORMAL') {
                                $('#ticketPriority').text('NORMAL').removeClass('text-danger text-warning').addClass('text-secondary');
                                $('#ticketDueDateApproval').removeClass('text-danger text-warning').addClass('text-secondary');
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

    function getCountdownText(dueDate, now) {
        let diff = dueDate - now;
        if (diff <= 0) return 'Expired';

        let days = Math.floor(diff / (1000 * 60 * 60 * 24));
        let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((diff % (1000 * 60)) / 1000);

        return ` ${hours}h ${minutes}m `;
    }

    setInterval(forApprovalTickets, 5000);
    forApprovalTickets();

    $('#approveButton').on('click', function () {
        const ticketId = $(this).data('id');
        $.ajax({
            url: '../../../backend/user/ticketing-system/update_ticket_status.php',
            type: 'POST',
            data: { ticket_id: ticketId, status: 'Approved' },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Success', text: 'Ticket approved successfully!' });
                    $('#forApprovalticketModal').modal('hide');
                    forApprovalTickets();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Error: ' + response.message });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire({ icon: 'error', title: 'Error', text: 'Error approving ticket. Please try again later.' });
            }
        });
    });

    $('#rejectButton').on('click', function () {
        const ticketId = $(this).data('id');
        $.ajax({
            url: '../../../backend/user/ticketing-system/update_ticket_status.php',
            type: 'POST',
            data: { ticket_id: ticketId, status: 'Rejected' },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Success', text: 'Ticket rejected successfully!' });
                    $('#forApprovalticketModal').modal('hide');
                    forApprovalTickets();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Error: ' + response.message });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire({ icon: 'error', title: 'Error', text: 'Error rejecting ticket. Please try again later.' });
            }
        });
    });
});





// Populate ticket lists
function populateTickets(tickets, containerSelector, type) {
    const container = $(containerSelector);
    container.empty();
    tickets.forEach(ticket => {
        const { date, time } = formatDateTime(ticket.date_created || '');
        // Only format date_finished if it exists
        let endDate = 'N/A';
        let endTime = 'N/A';


        if (ticket.date_finished) {
            const formattedEnd = formatDateTime(ticket.date_finished);
            endDate = formattedEnd.date;
            endTime = formattedEnd.time;
        }
        const attachmentLink = ticket.ticket_attachment
            ? `<a href="${ticket.ticket_attachment}" target="_blank" class="badge badge-info">Attachment</a>`
            : '';
        const handlerName = ticket.handler_name ? ticket.handler_name : 'Unassigned';
        let handlerClass = '';
        if (handlerName === 'Unassigned') {
            handlerClass = 'unassigned text-gray-500';
        } else {
            handlerClass = '';
        }
        let forApproval = '';
        if (ticket.ticket_status === 'FOR APPROVAL') {
            forApproval = '<div class="text-warning">For Approval</div>';
        } else {
            forApproval = '';
        }
        const conclusion = ticket.ticket_conclusion
            ? `<div class="small text-gray-500 text-truncate">${ticket.ticket_conclusion}</div>` : '';

        const ticketElement = `
                <button class="${handlerClass} dropdown-item align-items-center ticket-item" 
                    data-id="${ticket.ticket_id}" 
                    data-title="${ticket.ticket_subject}" 
                    data-description="${ticket.ticket_description}" 
                    data-attachment="${ticket.ticket_attachment}" 
                    data-date="${date}" 
                    data-time="${time}" 
                    data-endDate="${endDate}" 
                    data-endTime="${endTime}" 
                    data-handler="${handlerName}" 
                    data-conclusion="${ticket.ticket_conclusion}"
                    data-handlerId="${ticket.ticket_handler_id}" 
                    data-status="${type}">
                    <div class="text-truncate">#${ticket.ticket_id} | ${ticket.ticket_subject}</div>
                    <div class="small text-gray-500 text-truncate">${ticket.ticket_description}</div>
                    ${conclusion}
                    <div class="small text-gray-500 text-truncate">
                        <strong>Created:</strong> ${date}, ${time} | 
                        <strong>Handler:</strong> ${handlerName} | 
                        <strong>Status:</strong> ${ticket.ticket_status} 
                        ${attachmentLink}
                        ${forApproval}
                    </div>
                </button>
                <hr>`;
        container.append(ticketElement);
    });
}

$(document).ready(function () {
    let chatboxInterval; // Declare globally inside the ready function

    // Load tickets
    fetchTickets();

    // Click event for tickets
    $(document).on('click', '.ticket-item', function (e) {
        e.preventDefault();

        const ticketId = $(this).data('id');
        const title = $(this).data('title');
        const description = $(this).data('description');
        const conclusion = $(this).data('conclusion');
        const attachment = $(this).data('attachment');
        const date = $(this).data('date');
        const time = $(this).data('time');
        const endDate = $(this).data('enddate');
        const endTime = $(this).data('endtime');
        const status = $(this).data('status');
        const handlerName = $(this).data('handler');
        const handlerId = $(this).data('handlerid');
        if (handlerName == 'Unassigned') {
            $('#openChatButton').addClass('d-none').removeClass('d-flex');
        } else {
            $('#openChatButton').addClass('d-flex').removeClass('d-none');
        }
        $('#ticketTitle').text(title);
        $('#ticketDescription').text(description);
        $('#ticketAttachment').html(attachment !== null
            ? `<a href="${attachment.replace("backend/", '')}" target="_blank" class="text-primary">View Attachment</a>`
            : 'No attachment.'
        );

        $('#ticketDate').text(date);
        $('#ticketTime').text(time);
        $('#ticketEndDate').text(endDate);
        $('#ticketEndTime').text(endTime);
        $('#ticketHandler').text(handlerName);
        $('#ticketConclusion').text(conclusion);

        $('#dateClosedRow').toggle(status === 'Closed');
        $('#conclusionRow').toggle(status === 'Closed');

        const actionButtons = $('#actionButtons').empty();

        if (status !== 'Closed' && handlerName === 'Unassigned') {
            actionButtons.append(`<button class="btn btn-outline-danger btn-sm" id="cancelTicket" data-id="${ticketId}">Cancel Ticket</button>`);
        } else if (status !== 'Closed' && handlerName !== 'Unassigned') {
            actionButtons.append(`<button class="btn btn-outline-secondary btn-sm" disabled data-id="${ticketId}">Cancel Ticket</button>`);
        } else if (status === 'Rejected') {
            actionButtons.append(`<button class="btn btn-outline-primary btn-sm" disabled data-id="${ticketId}">Re-open Ticket</button>`);
        }

        // Check if there's a chat record
        $.ajax({
            url: '../../../backend/shared/ticketing-system/check_ticket_convo.php',
            method: 'POST',
            data: { ticket_id: ticketId },
            dataType: 'json',
            success: function (response) {
                if (response.exists) {
                    $('#openChatButton').removeClass('btn-outline-secondary').addClass('btn-primary');
                } else {
                    $('#openChatButton').removeClass('btn-primary').addClass('btn-outline-secondary');
                }
            },
            error: function (xhr, status, error) {
                console.error("Error checking chat status:", error);
            }
        });

        // Set chat button attributes
        $('#openChatButton')
            .attr('data-id', ticketId)
            .attr('data-requestor', handlerId)
            .attr('data-title', 'T#' + ticketId + ' | ' + title);

        $('#ticketsModal').modal('show');
    });

    // Open Chatbox
    $(document).on('click', '#openChatButton', function () {
        const ticketId = $(this).data('id');
        const ticketTitle = $(this).data('title');
        const ticketRequestor = $(this).data('requestor');

        if (!ticketId || !ticketRequestor) {
            alert("Missing ticket info");
            return;
        }

        openChatbox(ticketId, ticketTitle, ticketRequestor);
    });

    // Open chatbox logic
    function openChatbox(ticketId, ticketTitle, ticketRequestor) {
        // Close modals
        $('#ticketsModal').modal('hide');

        // Stop old interval
        clearTimeout(chatboxInterval);

        // Update UI
        $('#chatboxTitle').text(ticketTitle);
        $('#chatbox')
            .attr('data-ticket-id', ticketId)
            .attr('data-requestor', ticketRequestor)
            .show();

        scrollToBottom();
        fetchChatboxMessages(ticketId);
    }

    // Close chatbox and stop polling
    $('#closeChatbox').on('click', function () {
        $('#chatbox').hide();
        clearTimeout(chatboxInterval); // Stop fetching messages
    });

    // Fetch messages
    function fetchChatboxMessages(ticketId) {
        clearTimeout(chatboxInterval); // Stop any running loop first

        $.ajax({
            url: '../../../backend/user/ticketing-system/fetch_chat_messages.php',
            type: 'GET',
            data: { ticket_id: ticketId },
            dataType: 'json',
            success: function (response) {
                const chatboxMessages = $('#chatboxMessages');
                chatboxMessages.empty();

                if (response.status === 'success') {
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

                    scrollToBottom();
                } else {
                    console.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching chat messages:", error);
            },
            complete: function () {
                // Start polling again
                chatboxInterval = setTimeout(() => fetchChatboxMessages(ticketId), 1000);
            }
        });
    }

    // Send Message
    $('#sendChatboxMessage').on('click', function () {
        const ticketId = $('#chatbox').data('ticket-id');
        const ticketRequestor = $('#chatbox').data('requestor');
        const message = $('#chatboxInput').val().trim();

        if (!ticketId || !ticketRequestor || message === '') {
            alert('Please enter a message');
            return;
        }

        $.ajax({
            url: '../../../backend/user/ticketing-system/send_chat_message.php',
            type: 'POST',
            data: { ticket_id: ticketId, message: message, requestor: ticketRequestor },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#chatboxInput').val('');
                    fetchChatboxMessages(ticketId); // Refresh messages
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error sending chat message: ", error);
            }
        });
    });

    // Format date/time
    function formatDateTime(dateTime) {
        const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
        return new Date(dateTime).toLocaleString('en-US', options).replace(',', ' |');
    }

    // Auto scroll
    function scrollToBottom() {
        const chatboxMessages = document.getElementById('chatboxMessages');
        if (chatboxMessages) {
            chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
        }
    }

    // Cancel Ticket
    $(document).on('click', '#cancelTicket', function () {
        const ticketId = $(this).data('id');
        updateTicketStatus(ticketId, 'CANCELLED');
    });

    // Reopen Ticket
    $(document).on('click', '#reopenTicket', function () {
        const ticketId = $(this).data('id');
        recreateTicket(ticketId);
    });

    // Helpers
    function updateTicketStatus(ticketId, newStatus) {
        $.ajax({
            url: '../../../backend/user/ticketing-system/update_ticket_status.php',
            type: 'POST',
            data: { ticket_id: ticketId, status: newStatus },
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                $('#ticketsModal').modal('hide');
                fetchTickets();
            },
            error: function (xhr, status, error) {
                console.error("Error updating ticket status: ", error);
            }
        });
    }

    function recreateTicket(ticketId) {
        $.ajax({
            url: '../../../backend/user/ticketing-system/recreate_ticket.php',
            type: 'POST',
            data: { ticket_id: ticketId },
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                $('#ticketsModal').modal('hide');
                fetchTickets();
            },
            error: function (xhr, status, error) {
                console.error("Error recreating ticket: ", error);
            }
        });
    }
});

