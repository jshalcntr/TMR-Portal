$(document).ready(function () {
    $.ajax({
        url: '../../../backend/user/ticketing-system/ticketcategory.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#ticket_category').autocomplete({
                source: data
            });
        },
        error: function (xhr, status, error) {
            console.log(status, xhr);
            console.error('Error fetching ticket types:', error);
        }
    });
});