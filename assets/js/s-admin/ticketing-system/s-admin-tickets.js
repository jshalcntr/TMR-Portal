function fetchAndShowTickets(element) {
    const category = $(element).data('category');

    $.ajax({
        url: '../../../backend/user/ticketing-system/fetch_tickets.php', // Change this to your PHP endpoint
        type: 'POST',
        data: { category: category },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                // Update the UI with the fetched tickets
                if (category === 'all-overdue') {
                    $('#all-overdue-tasks').text(response.data.length);
                } else if (category === 'all-today-due') {
                    $('#all-today-due-tickets').text(response.data.length);
                } else if (category === 'all-open') {
                    $('#all-open-tickets').text(response.data.length);
                } else if (category === 'all-for-approval') {
                    $('#all-for-approval-tickets').text(response.data.length);
                }
                else if (category === 'all-closed') {
                    $('#all-closed-tickets').text(response.data.length);
                }
                // Additional code to display the tickets in a modal or another element
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching tickets: ", error);
        }
    });
}