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


const categoryData = {
    "Hardware Issues": [
        "Laptop/Desktop Issues",
        "Printer/Scanner Problems",
        "Network Equipment (Routers, Switches)",
        "Peripheral Devices (Keyboard, Mouse)",
        "Hardware Replacement or Upgrade"
    ],
    "Software Issues": [
        "Operating System Problems",
        "Software Installation/Update",
        "Application Crashes",
        "License and Activation Issues",
        "Compatibility Issues"
    ],
    "Network and Connectivity": [
        "Internet Connectivity",
        "VPN Access",
        "Network Configuration",
        "Wi-Fi Issues",
        "Network Security"
    ],
    "Account and Access Management": [
        "Account Creation/Deletion",
        "Password Reset/Recovery",
        "Permission or Role Changes",
        "Single Sign-On (SSO) Issues",
        "Account Lockouts"
    ],
    "Email and Communication": [
        "Email Setup/Configuration",
        "Spam or Phishing Emails",
        "Distribution List Management",
        "Email Quota Issues",
        "Calendar/Meeting Issues"
    ],
    "Security and Compliance": [
        "Antivirus and Malware Protection",
        "Data Security Incidents",
        "Security Policy Violations",
        "User Awareness Training",
        "Access Control Issues"
    ],
    "IT Service Requests": [
        "New Hardware/Software Request",
        "Equipment Loan or Purchase",
        "System Access Requests",
        "IT Consultation",
        "Workspace Setup (Desks, Monitors)"
    ],
    "System and Application Performance": [
        "Slow System Performance",
        "Application Latency",
        "Server Downtime/Outages",
        "Database Issues",
        "Resource Utilization (CPU, Memory)"
    ],
    "Backup and Recovery": [
        "Data Backup Issues",
        "Restore Requests",
        "Cloud Storage Issues",
        "Data Loss Incident",
        "Disaster Recovery Planning"
    ],
    "User Training and Support": [
        "New User Orientation",
        "Software Training",
        "IT Policies and Procedures",
        "Knowledge Base Access",
        "FAQ and Documentation Updates"
    ],
    "Other/Miscellaneous": [
        "General IT Assistance",
        "Requests Outside Defined Categories",
        "Feedback and Suggestions",
        "System Enhancement Requests",
        "Administrative Requests"
    ]
};

// Render Category Buttons
$.each(categoryData, function (category) {
    $('#categoryList').append(`
        <div class="col-6 col-md-5 mb-2">
        <button type="button" class="btn btn-outline-secondary btn-sm category-btn" data-category="${category}">
            ${category}
        </button>
        </div>
    `);
});

// Handle Category Selection
$(document).on('click', '.category-btn', function () {
    const selectedCategory = $(this).data('category');
    $('#ticket_category').val(selectedCategory);
    $('#ticket_category_display').text(selectedCategory);


    // Highlight selected category
    $('.category-btn').removeClass('active');
    $(this).addClass('active');

    // Show corresponding subjects
    const subjects = categoryData[selectedCategory];
    $('#subjectList').empty();
    subjects.forEach(subject => {
        $('#subjectList').append(`
            <div class="col-6 col-md-5 mb-2">
            <button type="button" class="btn btn-outline-secondary btn-sm subject-btn" data-subject="${subject}">
                ${subject}
            </button>
            </div>
        `);
    });
    $('#categoryContainer').hide(); // Hide subject container initially
    $('#subjectContainer').show();
});

// Handle Subject Selection
$(document).on('click', '.subject-btn', function () {
    const selectedSubject = $(this).data('subject');
    $('#ticket_subject').val(selectedSubject);
    $('#ticket_subject_display').text(selectedSubject);
    // Highlight selected subject
    $('.subject-btn').removeClass('active');
    $(this).addClass('active');
    $('#subjectContainer').hide();
    $('#ticketForm').show();

});
$(document).on('click', '#backToCategory', function () {
    $('#subjectContainer').hide();
    $('#categoryContainer').show();
    $('#ticketForm')[0].reset(); // Reset form
});
$(document).on('click', '#backToSubject', function () {
    $('#ticketForm').hide();
    $('#subjectContainer').show();
});

$("#createTicketModal").on('hidden.bs.modal', function () {
    document.activeElement.blur();
    $('#ticketForm')[0].reset(); // Reset form
    $('#ticketForm').hide();
    $('#subjectContainer').hide();
    $('#categoryContainer').show();
    $('#categoryContainer .category-btn').removeClass('active');
});

$(document).ready(function () {
    const table = $("#ticketsTable").DataTable({
        ajax: "../../../backend/user/ticketing-system/get_all_tickets.php",
        responsive: true,
        pageLength: 10,
        order: [[9, "desc"]], // Column 9 is "Created"
        createdRow: function (row, data, dataIndex) {
            const status = data[4]; // Status column

            if (status === "FOR APPROVAL") {
                $(row).addClass("table-warning");
            } else if (status === "OPEN" || status === "APPROVED") {
                $(row).addClass("table-default");
            } else if (
                status === "CLOSED" ||
                status === "CANCELLED" ||
                status === "REJECTED"
            ) {
                $(row).addClass("table-secondary");
            }
            // ⛔ Add d-none d-sm-table-cell to these columns manually
            // Indexes to HIDE on mobile
            const hideOnMobile = [2, 3, 4, 8, 9, 10, 11, 12, 13, 14, 15];

            hideOnMobile.forEach(function (colIdx) {
                $("td", row).eq(colIdx).addClass("d-none d-sm-table-cell");
            });
        },
        columnDefs: [
            {
                targets: [7], // Due Date
                render: function (data, type, row) {
                    const dateFinished = row[11];
                    if (type === "display") {
                        if (dateFinished !== "N/A") {
                            return `<span class="countdown" data-finished="true">Finished</span>`;
                        }
                        return data !== "N/A"
                            ? `<span class="countdown" data-date="${data}">Loading...</span>`
                            : "N/A";
                    }
                    return data;
                },
            },
            {
                targets: [8], // Approval Due
                render: function (data, type, row) {
                    const dateApproved = row[13];
                    const dateFinished = row[11];

                    if (type === "display") {
                        if (dateFinished !== "N/A" && dateApproved === "N/A") {
                            return "N/A";
                        }
                        if (dateApproved !== "N/A") {
                            return `<span class="countdown" data-approved="true">Approved</span>`;
                        }
                        return data !== "N/A"
                            ? `<span class="countdown" data-date="${data}">Loading...</span>`
                            : "N/A";
                    }
                    return data;
                },
                className: 'd-none d-sm-table-cell' // ✅ Hide on XS, show on SM+
            },
            // Add class names to hide these columns on small devices
            { targets: [2, 3, 4, 8, 9, 10, 11, 12, 13, 14, 15], className: 'd-none d-sm-table-cell' }
        ],
        drawCallback: function () {
            updateCountdowns();
        },
    });
    // Reload the table every 2 seconds
    setInterval(function () {
        table.ajax.reload(null, false); // false keeps the current paging
    }, 2000);
});

function updateCountdowns() {
    const countdownElements = document.querySelectorAll('.countdown');

    countdownElements.forEach(el => {
        const dateStr = el.dataset.date;
        const isApproved = el.dataset.approved === "true";
        const isFinished = el.dataset.finished === "true";

        if (isApproved) {
            el.textContent = 'Approved';
            el.classList.remove('text-danger');
            return;
        }

        if (isFinished) {
            el.textContent = 'Finished';
            el.classList.remove('text-danger');
            return;
        }

        if (!dateStr || dateStr === 'N/A') {
            el.textContent = 'N/A';
            el.classList.remove('text-danger');
            return;
        }

        const targetDate = new Date(dateStr);
        const now = new Date();
        const diff = targetDate - now;

        if (isNaN(targetDate.getTime()) || diff <= 0) {
            el.textContent = 'Expired';
            el.classList.add('text-danger');
            return;
        }

        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);

        el.textContent = `${hours}h ${minutes}m`;
        el.classList.remove('text-danger');
    });

    setTimeout(updateCountdowns, 60 * 1000);
}
let isFirstLoad = 0;
$(document).on('click', '.view-ticket', function () {
    const btn = $(this);
    const status = btn.data('status');
    const userRole = btn.data('user-role');

    const isForApproval = status === 'FOR APPROVAL';

    // Shared data
    const ticketId = btn.data('id');
    const subject = btn.data('subject');
    const type = btn.data('type');
    const priority = btn.data('priority');
    const description = btn.data('description');
    const conclusion = btn.data('conclusion');
    const handler = btn.data('handler');
    const requestor = btn.data('requestor');
    const approvalDue = btn.data('approval-due');
    const reason = btn.data('reason');
    const approvalDate = btn.data('approved');
    const ticketAttachmentUrl = btn.data('attachment-url');
    const approvalAttachmentUrl = btn.data('approval-attachment-url');
    const created = btn.data('created');
    const finished = btn.data('finished');
    const isUnassigned = status === 'REJECTED' || handler === 'Unassigned' || status === 'CANCELLED';
    const isRoleHead = userRole === 'HEAD';

    $('#approvalButtons')
        .removeClass('d-flex') // Remove both first
        .addClass(isRoleHead ? 'd-flex' : 'd-none'); // Add only one
    $('#chatBoxDiv').toggle(!isUnassigned);
    $('#chatHistoryTitle').toggle(!isUnassigned);
    $('#chatInput').toggle(!isUnassigned);
    $('#sendChatMessage').toggle(!isUnassigned);
    $('#chatHistory').toggle(!isUnassigned);
    $('#chatHistoryDiv').toggle(!isUnassigned);
    $('#chatBoxDiv')
        .removeClass('d-flex shadow-sm') // Remove both first
        .addClass(isUnassigned ? 'd-none' : 'd-flex shadow-sm');

    $('.ticket-details-card')
        .removeClass('col-md-6 col-md-12') // Remove both first
        .addClass(isUnassigned ? 'col-md-12' : 'col-md-6'); // Add only one

    if (isForApproval) {
        // ========== For Approval Modal ==========
        $('#ticketModalId').text(ticketId);
        $('#ticketModalTitle').text(subject);
        $('#ticketModalDescription').text(description);

        if (created && created !== 'N/A') {
            const [date, time] = created.split(' ');
            $('#ticketModalDate').text(date);
            $('#ticketModalTime').text(time);
        } else {
            $('#ticketModalDate').text('N/A');
            $('#ticketModalTime').text('');
        }

        $('#ticketModalRequestor').text(requestor);
        $('#ticketModalRequestorDepartment').text(btn.data('requestor-department') ?? '');
        $('#ticketModalHandler').text(handler);
        $('#ticketModalPriority').text(priority);

        if (ticketAttachmentUrl) {
            $('#ticketModalAttachment').html(`<a href="${ticketAttachmentUrl}" target="_blank">View Attachment</a>`);
        } else {
            $('#ticketModalAttachment').text('No attachment.');
        }
        $('#approveButton').data('id', ticketId).data('priority', priority);

        $('#rejectButton').data('id', ticketId).data('priority', priority);
        $('#ticketModalApprovalReason').text(reason || 'N/A');
        $('#ticketModalDueDateApproval').text(approvalDue || 'N/A');

        if (approvalAttachmentUrl) {
            $('#ticketModalApprovalAttachment').html(`<a href="${approvalAttachmentUrl}" target="_blank">View Attachment</a>`);
        } else {
            $('#ticketModalApprovalAttachment').text('No attachment.');
        }

        $('#forApprovalticketModal').modal('show');

    } else {
        // ========== Regular Ticket Modal ==========
        $('#ticketNumber').text(ticketId);
        $('#ticketTitle').text(subject);
        $('#ticketStatus').text(status);
        $('#ticketDueDate').text(btn.data('due'));
        $('#ticketHandler').text(handler);

        if (created && created !== 'N/A') {
            const [date, time] = created.split(' ');
            $('#ticketDate').text(date);
            $('#ticketTime').text(time);
        } else {
            $('#ticketDate').text('N/A');
            $('#ticketTime').text('');
        }

        $('#ticketPriority').text(priority);
        $('#ticketRequestor').text(requestor);
        $('#ticketApprovalDueDate').text(approvalDue);
        $('#ticketApprovalReason').text(reason);
        $('#ticketApprovalDate').text(approvalDate);

        if (finished && finished !== 'N/A') {
            const [endDate, endTime] = finished.split(' ');
            $('#ticketEndDate').text(endDate);
            $('#ticketEndTime').text(endTime);
        } else {
            $('#ticketEndDate').text('N/A');
            $('#ticketEndTime').text('');
        }

        $('#ticketConclusion').text(conclusion);
        $('#ticketDescription').text(description);

        if (approvalAttachmentUrl) {
            $('#ticketApprovalAttachment').html(`<a href="${approvalAttachmentUrl}" target="_blank">View Attachment</a>`);
        } else {
            $('#ticketApprovalAttachment').text('No attachment.');
        }

        if (ticketAttachmentUrl) {
            $('#ticketAttachment').html(`<a href="${ticketAttachmentUrl}" target="_blank">View Attachment</a>`);
        } else {
            $('#ticketAttachment').text('No attachment.');
        }

        $('#approvalDueDateRow').toggle(approvalDue && approvalDue !== 'N/A');
        $('#approvalReasonRow').toggle(reason && reason !== 'N/A');
        $('#approvalDateRow').toggle(approvalDate && approvalDate !== 'N/A');
        $('#approvalAttachmentRow').toggle(!!approvalAttachmentUrl);
        $('#dateClosedRow').toggle(finished && finished !== 'N/A');

        $('#ticketsModal').modal('show');
    }


    // Chatbox Setup
    $('#chatHistory')
        .data('ticket-id', ticketId)
        .data('requestor', requestor);
    isFirstLoad = 0; // Reset the flag when a new ticket is clicked
    fetchChatboxMessages(ticketId);
});


let chatboxInterval;

function fetchChatboxMessages(ticketId) {
    clearTimeout(chatboxInterval); // Stop any running loop first

    $.ajax({
        url: '../../../backend/user/ticketing-system/fetch_chat_messages.php',
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
            chatboxInterval = setTimeout(() => fetchChatboxMessages(ticketId), 1000);
            isFirstLoad++;
        }
    });
}



function scrollToBottom() {
    const container = $('#chatHistory');
    container.scrollTop(container[0].scrollHeight);
}

// Attach send handler
$(document).on('click', '#sendChatMessage', function () {
    const ticketId = $('#chatHistory').data('ticket-id');
    const ticketRequestor = $('#chatHistory').data('requestor');
    const message = $('#chatInput').val().trim();

    if (!ticketId || !ticketRequestor || message === '') {
        alert('Please enter a message');
        return;
    }

    $.ajax({
        url: '../../../backend/user/ticketing-system/send_chat_message.php',
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
}

// Call after AJAX loads content, and on resize
$(document).ready(function () {
    adjustChatHistoryHeight();

    // Also run on window resize
    $(window).on('resize', function () {
        adjustChatHistoryHeight();
    });
});




// populate from similar tickets 
// document.addEventListener('DOMContentLoaded', function () {
//     const ticketCategoryInput = document.getElementById('ticket_category');
//     const ticketSubjectInput = document.getElementById('ticket_subject');
//     const ticketContentInput = document.getElementById('ticket_content');
//     const similarTicketDiv = document.querySelector('.similar-ticket');

//     // Listen for input on the ticket subject field
//     ticketSubjectInput.addEventListener('input', function () {
//         const subject = ticketSubjectInput.value.trim();

//         if (subject.length > 2) {
//             fetch(`../../../backend/user/ticketing-system/similarticket.php?category=${ticketCategoryInput.value.trim() + '&subject=' + encodeURIComponent(subject)}`)
//                 .then(response => response.json())
//                 .then(data => {
//                     similarTicketDiv.innerHTML = ''; // Clear previous results

//                     if (data.length > 0) {
//                         similarTicketDiv.classList.remove('hidden');

//                         data.forEach(ticket => {
//                             // Format the date and time from the database
//                             const dateTime = new Date(ticket.date_created.replace(' ', 'T'));
//                             const date = dateTime.toLocaleDateString('en-US', {
//                                 year: 'numeric',
//                                 month: 'short',
//                                 day: 'numeric',
//                             });
//                             const time = dateTime.toLocaleTimeString('en-US', {
//                                 hour: 'numeric',
//                                 minute: 'numeric',
//                                 hour12: true,
//                             });

//                             // Create the ticket HTML
//                             const ticketHtml = `
//                                 <div class=" align-items-center" 
//                                     data-id="${ticket.ticket_id}" 
//                                     data-subject="${ticket.ticket_subject}" 
//                                     data-description="${ticket.ticket_description}" 
//                                     data-date="${date}" 
//                                     data-handler="${ticket.handler_name || 'N/A'}" 
//                                     data-requestor="${ticket.requestor_name || 'N/A'}"
//                                     data-attachment="${ticket.ticket_attachment || ''}">
//                                     <div class="text-truncate">${ticket.ticket_subject}</div>
//                                     <div class="small text-gray-500 ">${ticket.ticket_description}</div>
//                                     <div class="small text-gray-500 text-truncate">
//                                         <button class="btn btn-light btn-sm btn-right similar-ticket-items">Select</button>
//                                         <strong>Created:</strong> ${date} | 
//                                         <strong>Requestor:</strong> ${ticket.requestor_name} | 
//                                     </div>

//                                 </div>
//                                 <hr>
//                             `;

//                             // Append the HTML to the container
//                             similarTicketDiv.insertAdjacentHTML('beforeend', ticketHtml);

//                             // Add click event to populate fields
//                             similarTicketDiv.querySelectorAll('.similar-ticket-items').forEach(item => {
//                                 item.addEventListener('click', function () {
//                                     ticketCategoryInput.value = ticket.ticket_type;
//                                     ticketSubjectInput.value = ticket.ticket_subject;
//                                     ticketContentInput.value = ticket.ticket_description;
//                                     similarTicketDiv.classList.add('hidden'); // Hide suggestions after selection
//                                 });
//                             });
//                         });
//                     } else {
//                         similarTicketDiv.classList.add('hidden');
//                     }
//                 })
//                 .catch(error => console.error('Error fetching similar tickets:', error));
//         } else {
//             similarTicketDiv.classList.add('hidden'); // Hide if input is cleared or too short
//         }
//     });
// });

// Function to fetch tickets and populate the lists
// function fetchTickets() {
//     $.ajax({
//         url: '../../../backend/user/ticketing-system/get_tickets.php', // Change this to your PHP endpoint
//         type: 'GET',
//         dataType: 'json',
//         success: function (response) {
//             if (response.status === 'success') {
//                 populateTickets(response.data.pending, '#pendingTicketList', 'Pending');
//                 populateTickets(response.data.closed, '#closedTicketList', 'Closed');
//             } else {
//                 console.error(response.message);
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error("Error fetching tickets: ", error);
//         }
//     });
// }
// setInterval(fetchTickets, 5000); // Fetch tickets every 5 seconds
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
                        showConfirmButton: true
                    }).then(() => {
                        location.reload(); // Reload the page after submission
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

// $(document).ready(function () {
//     function forApprovalTickets() {
//         $.ajax({
//             url: '../../../backend/user/ticketing-system/fetch_for_approval_tickets.php',
//             type: 'GET',
//             success: function (response) {
//                 if (response.status === 'success') {
//                     const tickets = response.data;
//                     const approvalContainer = $('#forApprovalContainer');
//                     approvalContainer.empty();

//                     if (tickets.length > 0) {
//                         tickets.forEach(ticket => {
//                             const { date, time } = formatDateTime(ticket.date_created);
//                             const dueDate = new Date(ticket.ticket_for_approval_due_date);
//                             const now = new Date();
//                             let countdownText = getCountdownText(dueDate, now);
//                             let formattedDueDate = formatDueDate(ticket.ticket_for_approval_due_date);
//                             if (dueDate < now) {
//                                 formattedDueDate = 'Expired';
//                                 $('#ticketDueDateApproval').removeClass('text-warning').addClass('text-danger');
//                             }
//                             let priorityClass = '';
//                             if (ticket.ticket_priority === 'CRITICAL') {
//                                 priorityClass = 'text-danger';
//                             } else if (ticket.ticket_priority === 'IMPORTANT') {
//                                 priorityClass = 'text-warning';
//                             } else if (ticket.ticket_priority === 'NORMAL') {
//                                 priorityClass = 'text-secondary';
//                             }

//                             const attachmentLink = ticket.ticket_attachment
//                                 ? `<a href="${ticket.ticket_attachment}" target="_blank" class="badge badge-info">Attachment</a>`
//                                 : '';

//                             const ticketHtml = `
//                             <button class="dropdown-item align-items-center ticket-items" 
//                                 data-id="${ticket.ticket_id}" 
//                                 data-subject="${ticket.ticket_subject}" 
//                                 data-description="${ticket.ticket_description}" 
//                                 data-date="${date}" 
//                                 data-time="${time}" 
//                                 data-countdown="${countdownText}"
//                                 data-handler="${ticket.handler_name || 'N/A'}" 
//                                 data-requestor="${ticket.requestor_name || 'N/A'}"
//                                 data-attachment="${ticket.ticket_attachment || ''}"
//                                 data-priority="${ticket.ticket_priority}"
//                                 data-handlerid="${ticket.ticket_handler_id}"
//                                 data-reason="${ticket.for_approval_reason || ''}"
//                                 data-approval_attachment="${ticket.for_approval_attachment || ''}"
//                                 data-duedate="${formattedDueDate}">
//                                 <div class="text-truncate">#${ticket.ticket_id} - ${ticket.ticket_subject}</div>
//                                 <div class="small text-gray-500 text-truncate">${ticket.ticket_description}</div>
//                                 <div class="small text-gray-500 text-truncate">
//                                     <strong class="${priorityClass}">Approval Due: <span class="countdown-timer">${countdownText}</span></strong> |
//                                     <strong>Requestor:</strong> ${ticket.requestor_name} | 
//                                     ${attachmentLink}
//                                 </div>
//                             </button>
//                             <hr>`;
//                             approvalContainer.append(ticketHtml);
//                         });

//                         $('.ticket-items').on('click', function () {
//                             const ticketData = $(this).data();
//                             $('#ticketModalTitle').text(ticketData.subject);
//                             $('#ticketModalDescription').text(ticketData.description);
//                             $('#ticketModalDate').text(ticketData.date);
//                             $('#ticketModalTime').text(ticketData.time);
//                             $('#ticketModalDueDateApproval').text(ticketData.duedate);
//                             $('#ticketModalHandler').text(ticketData.handler);
//                             $('#ticketModalRequestor').text(ticketData.requestor);
//                             $('#ticketModalApprovalReason').text(ticketData.reason);
//                             $('#ticketModalPriority').text(ticketData.priority);
//                             $('#ticketModalApprovalAttachment').html(ticketData.approval_attachment ? `<a href="../../../uploads/for_approval/${ticketData.approval_attachment}" target="_blank" class="text-primary">View Attachment</a>` : 'No attachment.');
//                             $('#approveButton').data('id', ticketData.id).data('priority', ticketData.priority);

//                             $('#rejectButton').data('id', ticketData.id).data('priority', ticketData.priority);
//                             if (ticketData.attachment) {
//                                 $('#ticketModalAttachment').html(`<a href="${ticketData.attachment}" target="_blank" class="text-primary">View Attachment</a>`);
//                             } else {
//                                 $('#ticketModalAttachment').text('No attachment available.');
//                             }
//                             if (ticketData.priority === 'CRITICAL') {
//                                 $('#ticketModalPriority').text('CRITICAL').removeClass('text-secondary text-warning').addClass('text-danger');
//                                 $('#ticketModalDueDateApproval').removeClass('text-secondary text-warning').addClass('text-danger');
//                             } else if (ticketData.priority === 'IMPORTANT') {
//                                 $('#ticketModalPriority').text('IMPORTANT').removeClass('text-secondary text-danger').addClass('text-warning');
//                                 $('#ticketModalDueDateApproval').removeClass('text-secondary text-danger').addClass('text-warning');
//                             } else if (ticketData.priority === 'NORMAL') {
//                                 $('#ticketModalPriority').text('NORMAL').removeClass('text-danger text-warning').addClass('text-secondary');
//                                 $('#ticketModalDueDateApproval').removeClass('text-danger text-warning').addClass('text-secondary');
//                             }
//                             $('#forApprovalticketModal').modal('show');
//                         });
//                     } else {
//                         approvalContainer.append('<p>No tickets for approval found.</p>');
//                     }
//                 } else {
//                     console.error(response.message);
//                     $('#forApprovalContainer').html('<p class="text-danger">Error fetching tickets. Please try again later.</p>');
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error(error);
//                 $('#forApprovalContainer').html('<p class="text-danger">Error fetching tickets. Please try again later.</p>');
//             }
//         });
//     }

//     function getCountdownText(dueDate, now) {
//         let diff = dueDate - now;
//         if (diff <= 0) return 'Expired';

//         let days = Math.floor(diff / (1000 * 60 * 60 * 24));
//         let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//         let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
//         let seconds = Math.floor((diff % (1000 * 60)) / 1000);

//         return ` ${hours}h ${minutes}m `;
//     }

//     setInterval(forApprovalTickets, 5000);
//     forApprovalTickets();


// });

$('#approveButton').on('click', function () {
    const ticketId = $(this).data('id');
    const ticketPriority = $(this).data('priority');

    $.ajax({
        url: '../../../backend/user/ticketing-system/update_ticket_status.php',
        type: 'POST',
        data: { ticket_id: ticketId, status: 'Approved', priority: ticketPriority },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Ticket approved successfully!'
                });

                $('#forApprovalticketModal').modal('hide');

                // Reload your DataTable
                if ($.fn.DataTable.isDataTable('#ticketsTable')) {
                    $('#ticketsTable').DataTable().ajax.reload();
                }

                // Optional: refresh card counts or other elements
                if (typeof forApprovalTickets === 'function') {
                    forApprovalTickets();
                }

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


$('#rejectButton').on('click', function () {
    const ticketId = $(this).data('id');
    $.ajax({
        url: '../../../backend/user/ticketing-system/update_ticket_status.php',
        type: 'POST',
        data: { ticket_id: ticketId, status: 'Rejected', priority: $(this).data('priority') },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Ticket has been rejected!'
                });

                $('#forApprovalticketModal').modal('hide');

                // Reload your DataTable
                if ($.fn.DataTable.isDataTable('#ticketsTable')) {
                    $('#ticketsTable').DataTable().ajax.reload();
                }

                // Optional: refresh card counts or other elements
                if (typeof forApprovalTickets === 'function') {
                    forApprovalTickets();
                }

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



// Populate ticket lists
// function populateTickets(tickets, containerSelector, type) {
//     const container = $(containerSelector);
//     container.empty();
//     tickets.forEach(ticket => {
//         const { date, time } = formatDateTime(ticket.date_created || '');
//         // Only format date_finished if it exists
//         let endDate = 'N/A';
//         let endTime = 'N/A';


//         if (ticket.date_finished) {
//             const formattedEnd = formatDateTime(ticket.date_finished);
//             endDate = formattedEnd.date;
//             endTime = formattedEnd.time;
//         }
//         const attachmentLink = ticket.ticket_attachment
//             ? `<a href="${ticket.ticket_attachment}" target="_blank" class="badge badge-info">Attachment</a>`
//             : '';
//         const handlerName = ticket.handler_name ? ticket.handler_name : 'Unassigned';
//         let handlerClass = '';
//         if (handlerName === 'Unassigned') {
//             handlerClass = 'unassigned text-gray-500';
//         } else {
//             handlerClass = '';
//         }
//         let forApproval = '';
//         if (ticket.ticket_status === 'FOR APPROVAL') {
//             forApproval = '<div class="text-warning">For Approval</div>';
//         } else {
//             forApproval = '';
//         }
//         const conclusion = ticket.ticket_conclusion
//             ? `<div class="small text-gray-500 text-truncate">${ticket.ticket_conclusion}</div>` : '';

//         const ticketElement = `
//                 <button class="${handlerClass} dropdown-item align-items-center ticket-item"
//                 data-id="${ticket.ticket_id}"
//                 data-title="${ticket.ticket_subject}"
//                 data-type="${ticket.ticket_type || ''}"
//                 data-description="${ticket.ticket_description}"
//                 data-conclusion="${ticket.ticket_conclusion || ''}"
//                 data-priority="${ticket.ticket_priority || ''}"
//                 data-department="${ticket.requestor_department || ''}"
//                 data-attachment="${ticket.ticket_attachment}"
//                 data-for-approval-attachment="${ticket.for_approval_attachment || ''}"
//                 data-due-date="${ticket.ticket_due_date || ''}"
//                 data-for-approval-due-date="${ticket.ticket_for_approval_due_date || ''}"
//                 data-approval-reason="${ticket.for_approval_reason || ''}"
//                 data-approval-date="${ticket.ticket_date_approved || ''}"
//                 data-date="${date}"
//                 data-time="${time}"
//                 data-endDate="${endDate}"
//                 data-endTime="${endTime}"
//                 data-handler="${handlerName}"
//                 data-requestor="${ticket.requestor_name || ''}"
//                 data-handlerId="${ticket.ticket_handler_id || ''}"
//                 data-ticket-status="${ticket.ticket_status || ''}"
//                 data-status="${type}">
//                     <div class="text-truncate">#${ticket.ticket_id} | ${ticket.ticket_subject}</div>
//                     <div class="small text-gray-500 text-truncate">${ticket.ticket_description}</div>
//                     ${conclusion}
//                     <div class="small text-gray-500 text-truncate">
//                         <strong>Created:</strong> ${date}, ${time} |
//                         <strong>Handler:</strong> ${handlerName} |
//                         <strong>Status:</strong> ${ticket.ticket_status}
//                         ${attachmentLink}
//                         ${forApproval}
//                     </div>
//                 </button>
//                 <hr>`;
//         container.append(ticketElement);
//     });
// }

// $(document).ready(function () {
//     let chatboxInterval; // Declare globally inside the ready function

//     // Load tickets
//     fetchTickets();

//     // Click event for tickets
//     $(document).on('click', '.ticket-item', function (e) {
//         e.preventDefault();

//         const ticketId = $(this).data('id');
//         const title = $(this).data('title');
//         const description = $(this).data('description');
//         const conclusion = $(this).data('conclusion');
//         const attachment = $(this).data('attachment');
//         const date = $(this).data('date');
//         const time = $(this).data('time');
//         const endDate = $(this).data('enddate');
//         const endTime = $(this).data('endtime');
//         const status = $(this).data('status');
//         const ticketStatus = $(this).data('ticket-status');
//         const handlerName = $(this).data('handler');
//         const handlerId = $(this).data('handlerid');
//         const ticketType = $(this).data('type');
//         const ticketPriority = $(this).data('priority');
//         const ticketDueDate = $(this).data('due-date');
//         const ticketApprovalDueDate = $(this).data('for-approval-due-date');
//         const ticketDepartment = $(this).data('department');
//         const ticketApprovalReason = $(this).data('approval-reason');
//         const ticketApprovalDate = $(this).data('approval-date');
//         const ticketRequestor = $(this).data('requestor');
//         const ticketForApprovalAttachment = $(this).data('for-approval-attachment');

//         // Debug: Check if the data is being fetched properly
//         console.log(ticketType, ticketPriority, ticketDueDate, ticketApprovalDueDate, ticketDepartment);

//         // Update modal fields
//         $('#ticketNumber').text(ticketId);
//         $('#ticketTitle').text(title);
//         $('#ticketPriority').text(ticketPriority || 'Not Available');
//         $('#ticketDescription').text(description);
//         $('#ticketConclusion').text(conclusion);
//         $('#ticketDueDate').text(ticketDueDate || 'Not Available');
//         $('#ticketApprovalDueDate').text(ticketApprovalDueDate || 'Not Available');
//         $('#ticketDate').text(date);
//         $('#ticketTime').text(time);
//         $('#ticketEndDate').text(endDate);
//         $('#ticketEndTime').text(endTime);
//         $('#ticketStatus').text(ticketStatus);
//         $('#ticketHandler').text(handlerName);
//         $('#ticketRequestor').text(ticketRequestor || 'Not Available');
//         $('#ticketApprovalReason').text(ticketApprovalReason || 'Not Available');
//         $('#ticketApprovalDate').text(ticketApprovalDate || 'Not Available');
//         $('#ticketDepartment').text(ticketDepartment || 'Not Available');


//         // Handle attachment
//         $('#ticketAttachment').html(attachment ? `<a href="${attachment.replace('backend/', '')}" target="_blank" class="text-primary">View Attachment</a>` : 'No attachment.');
//         $('#ticketApprovalAttachment').html(ticketForApprovalAttachment ? `<a href="../../../uploads/for_approval/${ticketForApprovalAttachment}" target="_blank" class="text-primary">View Attachment</a>` : 'No attachment.');
//         // Show/Hide rows based on ticket status
//         $('#dateClosedRow').toggle(status === 'Closed' || status === 'Rejected' || status === 'Cancelled');
//         $('#conclusionRow').toggle(status === 'Closed' || status === 'Rejected' || status === 'Cancelled');
//         $('#approvalDueDateRow').toggle(ticketStatus === 'FOR APPROVAL' || status === 'Closed');
//         $('#approvalReasonRow').toggle(ticketStatus === 'FOR APPROVAL' || status === 'Closed');
//         $('#approvalDateRow').toggle(ticketStatus === 'APPROVED' || status === 'Closed');
//         $('#approvalAttachmentRow').toggle(ticketStatus === 'FOR APPROVAL' || status === 'Closed');



//         // Set action buttons and show modal
//         const actionButtons = $('#actionButtons').empty();
//         if (status !== 'Closed' && handlerName === 'Unassigned') {
//             actionButtons.append(`<button class="btn btn-outline-danger btn-sm" id="cancelTicket" data-id="${ticketId}">Cancel Ticket</button>`);
//         } else if (status !== 'Closed' && handlerName !== 'Unassigned') {
//             actionButtons.append(`<button class="btn btn-outline-secondary btn-sm" disabled data-id="${ticketId}">Cancel Ticket</button>`);
//         } else if (status === 'Rejected') {
//             actionButtons.append(`<button class="btn btn-outline-primary btn-sm" disabled data-id="${ticketId}">Re-open Ticket</button>`);
//         }

//         // Check if there's a chat record
//         $.ajax({
//             url: '../../../backend/shared/ticketing-system/check_ticket_convo.php',
//             method: 'POST',
//             data: { ticket_id: ticketId },
//             dataType: 'json',
//             success: function (response) {
//                 if (response.exists) {
//                     $('#openChatButton').removeClass('btn-outline-secondary').addClass('btn-primary');
//                 } else {
//                     $('#openChatButton').removeClass('btn-primary').addClass('btn-outline-secondary');
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error("Error checking chat status:", error);
//             }
//         });

//         // Set chat button attributes
//         $('#openChatButton')
//             .attr('data-id', ticketId)
//             .attr('data-requestor', handlerId)
//             .attr('data-title', 'T#' + ticketId + ' | ' + title);

//         $('#ticketsModal').modal('show');
//     });

//     // Open Chatbox
//     $(document).on('click', '#openChatButton', function () {
//         const ticketId = $(this).data('id');
//         const ticketTitle = $(this).data('title');
//         const ticketRequestor = $(this).data('requestor');

//         if (!ticketId || !ticketRequestor) {
//             alert("Missing ticket info");
//             return;
//         }

//         openChatbox(ticketId, ticketTitle, ticketRequestor);
//     });

//     // Open chatbox logic
//     function openChatbox(ticketId, ticketTitle, ticketRequestor) {
//         // Close modals
//         $('#ticketsModal').modal('hide');

//         // Stop old interval
//         clearTimeout(chatboxInterval);

//         // Update UI
//         $('#chatboxTitle').text(ticketTitle);
//         $('#chatbox')
//             .attr('data-ticket-id', ticketId)
//             .attr('data-requestor', ticketRequestor)
//             .show();

//         scrollToBottom();
//         fetchChatboxMessages(ticketId);
//     }

//     // Close chatbox and stop polling
//     $('#closeChatbox').on('click', function () {
//         $('#chatbox').hide();
//         clearTimeout(chatboxInterval); // Stop fetching messages
//     });

//     // Fetch messages
//     function fetchChatboxMessages(ticketId) {
//         clearTimeout(chatboxInterval); // Stop any running loop first

//         $.ajax({
//             url: '../../../backend/user/ticketing-system/fetch_chat_messages.php',
//             type: 'GET',
//             data: { ticket_id: ticketId },
//             dataType: 'json',
//             success: function (response) {
//                 const chatboxMessages = $('#chatboxMessages');
//                 chatboxMessages.empty();

//                 if (response.status === 'success') {
//                     response.data.forEach(message => {
//                         const formattedDateTime = formatDateTime(message.ticket_convo_date);
//                         const readStatus = message.is_read ? 'read' : 'unread';
//                         const messageElement = `
//                             <div class="chat-message ${readStatus}">
//                                 <strong>${message.full_name}:</strong> ${message.ticket_messages}
//                                 <div class="small text-gray-500">${formattedDateTime}</div>
//                             </div>
//                             <hr>`;
//                         chatboxMessages.append(messageElement);
//                     });

//                     scrollToBottom();
//                 } else {
//                     console.error(response.message);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error("Error fetching chat messages:", error);
//             },
//             complete: function () {
//                 // Start polling again
//                 chatboxInterval = setTimeout(() => fetchChatboxMessages(ticketId), 1000);
//             }
//         });
//     }

//     // Send Message
//     $('#sendChatboxMessage').on('click', function () {
//         const ticketId = $('#chatbox').data('ticket-id');
//         const ticketRequestor = $('#chatbox').data('requestor');
//         const message = $('#chatboxInput').val().trim();

//         if (!ticketId || !ticketRequestor || message === '') {
//             alert('Please enter a message');
//             return;
//         }

//         $.ajax({
//             url: '../../../backend/user/ticketing-system/send_chat_message.php',
//             type: 'POST',
//             data: { ticket_id: ticketId, message: message, requestor: ticketRequestor },
//             dataType: 'json',
//             success: function (response) {
//                 if (response.status === 'success') {
//                     $('#chatboxInput').val('');
//                     fetchChatboxMessages(ticketId); // Refresh messages
//                 } else {
//                     alert(response.message);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error("Error sending chat message: ", error);
//             }
//         });
//     });

//     // Format date/time
//     function formatDateTime(dateTime) {
//         const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
//         return new Date(dateTime).toLocaleString('en-US', options).replace(',', ' |');
//     }

//     // Auto scroll
//     function scrollToBottom() {
//         const chatboxMessages = document.getElementById('chatboxMessages');
//         if (chatboxMessages) {
//             chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
//         }
//     }

//     // Cancel Ticket
//     $(document).on('click', '#cancelTicket', function () {
//         const ticketId = $(this).data('id');
//         updateTicketStatus(ticketId, 'CANCELLED');
//     });

//     // Reopen Ticket
//     $(document).on('click', '#reopenTicket', function () {
//         const ticketId = $(this).data('id');
//         recreateTicket(ticketId);
//     });

//     // Helpers
//     function updateTicketStatus(ticketId, newStatus) {
//         $.ajax({
//             url: '../../../backend/user/ticketing-system/update_ticket_status.php',
//             type: 'POST',
//             data: { ticket_id: ticketId, status: newStatus },
//             dataType: 'json',
//             success: function (response) {
//                 alert(response.message);
//                 $('#ticketsModal').modal('hide');
//                 fetchTickets();
//             },
//             error: function (xhr, status, error) {
//                 console.error("Error updating ticket status: ", error);
//             }
//         });
//     }

//     function recreateTicket(ticketId) {
//         $.ajax({
//             url: '../../../backend/user/ticketing-system/recreate_ticket.php',
//             type: 'POST',
//             data: { ticket_id: ticketId },
//             dataType: 'json',
//             success: function (response) {
//                 alert(response.message);
//                 $('#ticketsModal').modal('hide');
//                 fetchTickets();
//             },
//             error: function (xhr, status, error) {
//                 console.error("Error recreating ticket: ", error);
//             }
//         });
//     }
// });

