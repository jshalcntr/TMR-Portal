// Function to format date and time
function formatDateTime(dateTime) {
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
    const formattedDateTime = new Date(dateTime).toLocaleString('en-US', options);
    return formattedDateTime.replace(',', ' |');
}

$(document).ready(function () {
    let previousMessageCount = 0; // Track the previous unread message count

    // Function to play an alert sound
    function playAlertSound() {
        const audio = new Audio('/tmr-portal/asset/media/chat-message.mp3');
        audio.play();
    }

    // Fetch unread messages
    function fetchUnreadMessages() {
        $.ajax({
            url: '/tmr-portal/backend/shared/ticketing-system/admin_fetch_unread_messages.php', // Change this to your PHP endpoint
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const messagesList = $('#messagesList');
                    messagesList.empty();

                    if (response.data.length > 0) {
                        response.data.forEach(message => {
                            const formattedDateTime = formatDateTime(message.ticket_convo_date);
                            const messageElement = `
                                <button class="dropdown-item d-flex align-items-center" id="openChatButton" 
                                    data-id="${message.ticket_id}" 
                                    data-title="T#${message.ticket_id + " | " + message.ticket_subject}" 
                                    data-requestor="${message.ticket_requestor_id}">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="${message.profile_picture}" alt="...">
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">${message.ticket_messages}</div>
                                        <div class="small text-gray-500">${message.full_name} · ${formattedDateTime}</div>
                                    </div>
                                </button>`;
                            messagesList.append(messageElement);
                        });

                        // Check if new messages have arrived
                        if (response.data.length > previousMessageCount) {
                            playAlertSound(); // Play alert sound
                        }
                    } else {
                        messagesList.append('<p class="dropdown-item text-center small text-gray-500">No unread messages</p>');
                    }

                    // Update the counter
                    $('#message-counter').text(response.data.length);

                    // Update the previous message count
                    previousMessageCount = response.data.length;
                } else {
                    console.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching unread messages: ", error);
            }
        });
    }

    // Fetch unread messages on page load
    setInterval(fetchUnreadMessages, 3000); // Check every 3 seconds
});
