$(document).ready(function () {
    $('#ticketForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Create a FormData object for AJAX
        var formData = new FormData(this);

        $.ajax({
            url: '../../../backend/user/ticketing-system/newticket.php', // Change this to your PHP processing file
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#form-message').text('Submitting...').removeClass('text-danger').addClass('text-info');
            },
            success: function (response) {
                $('#form-message').text(response).removeClass('text-info').addClass('text-success');
                $('#ticketForm')[0].reset(); // Reset the form on success
            },
            error: function (xhr, status, error) {
                console.error(error);
                console.error(status);
                console.error(xhr.responseText);
                $('#form-message').text('Error. Please try again.').removeClass('text-info').addClass('text-danger');
            }
        });
    });
});