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

$(document).ready(function () {
    $('#ticketForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Create a FormData object for AJAX
        var formData = new FormData(this);

        $.ajax({
            url: '../../../backend/user/ticketing-system/newticket.php', // Change to your PHP file
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#form-message').text('Submitting...').removeClass('text-danger').addClass('text-info');
                $('#loading-spinner').show(); // Show the Bootstrap spinner

                // Optional: Set a timer to update the message if loading takes longer
                // setTimeout(function () {
                //     $('#form-message').text('Still submitting, please wait...');
                // }, 3000); // Updates after 3 seconds
            },
            success: function (response) {
                $('#form-message').text(response.message).removeClass('text-info').addClass(response.status === 'success' ? 'text-success' : 'text-danger');
                if (response.status === 'success') {
                    $('#ticketForm')[0].reset(); // Reset the form on success
                    $('#loading-spinner').hide();
                    document.querySelector('.similar-ticket').classList.add('hidden');
                    fetchTickets();
                }

            },
            error: function (xhr, status, error) {
                console.error(error);
                $('#form-message').text('Error submitting ticket. Please try again.').removeClass('text-info').addClass('text-danger');
                $('#loading-spinner').hide();
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
    // Ensure the date string is ISO compatible by replacing the space with 'T'
    const date = new Date(dateString.replace(' ', 'T'));

    // Format date as "Nov 27, 2024"
    const formattedDate = date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });

    // Format time as "08:30 AM"
    const formattedTime = date.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
    });

    return { date: formattedDate, time: formattedTime };
}
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
                            const { date, time } = formatDateTime(ticket.date_created); // Get separate date and time
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
                                data-handler="${ticket.handler_name || 'N/A'}" 
                                data-requestor="${ticket.requestor_name || 'N/A'}"
                                data-attachment="${ticket.ticket_attachment || ''}">
                                <div class="text-truncate">${ticket.ticket_subject}</div>
                                <div class="small text-gray-500 text-truncate">${ticket.ticket_description}</div>
                                <div class="small text-gray-500 text-truncate">
                                    <strong>Created:</strong> ${date}, ${time} | 
                                    <strong>Requestor:</strong> ${ticket.requestor_name} | 
                                    ${attachmentLink}
                                </div>
                            </button>
                            <hr>`;
                            approvalContainer.append(ticketHtml);
                        });

                        // Add click event to open modal
                        $('.ticket-items').on('click', function () {
                            const ticketData = $(this).data();
                            $('#ticketModalTitle').text(ticketData.subject);
                            $('#ticketModalDescription').text(ticketData.description);
                            $('#ticketModalDate').text(ticketData.date);
                            $('#ticketModalTime').text(ticketData.time);
                            $('#ticketModalHandler').text(ticketData.handler);
                            $('#ticketModalRequestor').text(ticketData.requestor);
                            $('#approveButton').data('id', ticketData.id); // Add ticket ID to approve button
                            $('#rejectButton').data('id', ticketData.id); // Add ticket ID to reject button
                            if (ticketData.attachment) {
                                $('#ticketModalAttachment').html(`<a href="${ticketData.attachment}" target="_blank" class="text-primary">View Attachment</a>`);
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

    // Approve ticket
    $('#approveButton').on('click', function () {
        const ticketId = $(this).data('id');
        $.ajax({
            url: '../../../backend/user/ticketing-system/update_ticket_status.php',
            type: 'POST',
            data: { ticket_id: ticketId, status: 'Approved' },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Ticket approved successfully!'
                    });
                    $('#forApprovalticketModal').modal('hide');
                    forApprovalTickets(); // Refresh the ticket list
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
                    text: 'Error approving ticket. Please try again later.'
                });
            }
        });
    });

    // Reject ticket
    $('#rejectButton').on('click', function () {
        const ticketId = $(this).data('id');
        $.ajax({
            url: '../../../backend/user/ticketing-system/update_ticket_status.php',
            type: 'POST',
            data: { ticket_id: ticketId, status: 'Rejected' },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Ticket rejected successfully!'
                    });
                    $('#forApprovalticketModal').modal('hide');
                    forApprovalTickets(); // Refresh the ticket list
                } else if (response.status === 'error') {
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
                    text: 'Error rejecting ticket. Please try again later.'
                });
            }
        });
    });

    setInterval(forApprovalTickets, 30000);
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
        const { date, time } = formatDateTime(ticket.date_created); // Get separate date and time
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
                    data-date="${date}" 
                    data-time="${time}" 
                    data-handler="${handlerName}" 
                    data-handlerId="${ticket.ticket_handler_id}" 
                    data-status="${type}">
                    <div class="text-truncate">${ticket.ticket_subject}</div>
                    <div class="small text-gray-500 text-truncate">${ticket.ticket_description}</div>
                    <div class="small text-gray-500 text-truncate">
                        <strong>Created:</strong> ${date}, ${time} | 
                        <strong>Handler:</strong> ${handlerName} | ${ticket.ticket_handler_id} | 
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
        const time = $(this).data('time');
        const status = $(this).data('status');
        const handlerName = $(this).data('handler');
        const handlerId = $(this).data('handlerId');

        $('#ticketTitle').text(title);
        $('#ticketDescription').text(description);
        if (attachment !== null) {
            $('#ticketAttachment').html(`<a href="${attachment.replace("backend/", '')}" target="_blank" class="text-primary">View Attachment</a>`);
        } else {
            $('#ticketAttachment').text('No attachment.');
        }

        $('#ticketDate').text(date);
        $('#ticketTime').text(time);

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
                
            `);
        } else if (status === 'Rejected') {
            actionButtons.append(`
                <button class="btn btn-outline-primary btn-sm" disabled data-id="${ticketId}">Re-open Ticket</button>    
            `);
        }
        // Check if ticket_id exists in ticket_convo_tbl
        $.ajax({
            url: '../../../backend/shared/ticketing-system/check_ticket_convo.php', // Replace with your actual endpoint
            method: 'POST',
            data: { ticket_id: ticketId },
            success: function (response) {
                if (response.exists) {
                    $('#openChatButton').removeClass('btn-outline-secondary').addClass('btn-primary');
                } else {
                    $('#openChatButton').removeClass('btn-primary').addClass('btn-outline-secondary');
                }
            }
        });
        $('#openChatButton').data('id', ticketId).data('requestor', handlerId).data('title', 'T#' + ticketId + ' | ' + title); // Set ticket ID and title for chat button
        $('#ticketsModal').modal('show');
    });
    function scrollToBottom() {
        const chatboxMessages = document.getElementById('chatboxMessages');
        if (chatboxMessages) {
            chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
        }
    }

    // Scroll to bottom when the page loads
    window.onload = function () {
        scrollToBottom();
    };
    $(document).ready(function () {
        // Function to scroll to the bottom of the chatbox
        // Function to scroll to the bottom of the chatbox


        // Open chatbox
        $(document).on('click', '#openChatButton', function () {
            const ticketId = $(this).data('id');
            const ticketTitle = $(this).data('title');
            const ticketRequestor = $(this).data('requestor');
            openChatbox(ticketId, ticketTitle, ticketRequestor);
        });

        // Function to open chatbox
        function openChatbox(ticketId, ticketTitle, ticketRequestor) {
            $('#chatboxTitle').text(ticketTitle);
            $('#chatbox').data('ticket-id', ticketId).data('requestor', ticketRequestor).show();
            scrollToBottom();
            fetchChatboxMessages(ticketId);
        }

        // Close chatbox
        $('#closeChatbox').on('click', function () {
            $('#chatbox').hide();
        });

        // Fetch chatbox messages
        function fetchChatboxMessages(ticketId) {
            $.ajax({
                url: '../../../backend/user/ticketing-system/fetch_chat_messages.php',
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

                        // Auto-scroll to bottom when new messages load
                        scrollToBottom();
                    } else {
                        console.error(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching chat messages: ", error);
                },
                complete: function () {
                    // Fetch new messages every 3 seconds
                    setTimeout(() => fetchChatboxMessages(ticketId), 1000);
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
                    url: '../../../backend/user/ticketing-system/send_chat_message.php', // Change this to your PHP endpoint
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

    // Cancel pending ticket
    $(document).on('click', '#cancelTicket', function () {
        const ticketId = $(this).data('id');
        updateTicketStatus(ticketId, 'CANCELLED');
    });

    // Re-open closed ticket
    $(document).on('click', '#reopenTicket', function () {
        const ticketId = $(this).data('id');
        recreateTicket(ticketId);
    });

    function recreateTicket(ticketId) {
        $.ajax({
            url: '../../../backend/user/ticketing-system/recreate_ticket.php', // Change this to your PHP endpoint
            type: 'POST',
            data: { ticket_id: ticketId },
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
                console.error("Error recreating ticket: ", error);
            }
        });
    }
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
