$(document).ready(function () {
    $("#pendingTicketsLink").click(function (e) {
        e.preventDefault();

    });
});

const redirectToTable = (linkName) => {
    if (linkName == "pending") {

    } else if (linkName == "approval") {

    } else if (linkName == "finished") {

    }
}

$(document).ready(function () {
    function fetchTicketCount() {
        $.ajax({
            url: '../../backend/user/ticketing-system/fetch_ticket_count.php', // Path to your PHP file
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const userTickets = response.data.user_tickets;
                    const departmentTickets = response.data.department_tickets;
                    // const userticketCount = response.user_tickets || 0; // Default to 0 if no count
                    // const departmentticketCount = response.department_tickets || 0; // Default to 0 if no count
                    $('#userticketCountDisplay').text(userTickets); // Update your HTML element
                    $('#departmentticketCountDisplay').text(departmentTickets); // Update your HTML element
                } else {
                    console.error(response.message);
                    $('#userticketCountDisplay').text('Error'); // Display error message
                    $('#departmentticketCountDisplay').text('Error'); // Display error message
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching ticket count:', error);
                $('#userticketCountDisplay').text('Error'); // Display error message
                $('#departmentticketCountDisplay').text('Error'); // Display error message
            }
        });
    }

    // Fetch ticket count every 5 seconds
    setInterval(fetchTicketCount, 5000);
    fetchTicketCount(); // Initial fetch
});

$(document).ready(function () {
    function fetchTicketCounts() {
        $.ajax({
            url: '../../backend/user/ticketing-system/get_tickets_count.php', // Adjust the path
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const counts = response.data;

                    // Update the counts in the HTML
                    $('#pendingCount').text(counts.pending_count);
                    $('#closedCount').text(counts.closed_count);
                } else {
                    console.error('Error fetching counts:', response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }

    // Call the function on page load
    fetchTicketCounts();

    // Optionally refresh counts periodically (every 5 seconds)
    setInterval(fetchTicketCounts, 5000);
});

$(document).ready(function () {
    // Fetch ticket counts from the backend
    $.ajax({
        url: '../../backend/admin/ticketing-system/fetch_ticket_counts.php', // Adjust the path as needed
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const data = response.data;

                // Update the numbers in the cards
                $('#overdue-tasks').text(data.overdue || 0);
                $('#today-due-tickets').text(data.today_due || 0);
                $('#open-tickets').text(data.open || 0);
                $('#for-approval-tickets').text(data.for_approval || 0);
                $('#unassigned-tickets').text(data.unassigned || 0);
                $('#closed-tickets').text(data.finished || 0);
                $('#all-tickets').text(data.all || 0);
            } else {
                console.error('Error:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});