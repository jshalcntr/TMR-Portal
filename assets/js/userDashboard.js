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
