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
