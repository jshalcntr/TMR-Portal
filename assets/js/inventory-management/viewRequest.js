let requestId;
$(document).ready(function () {
    $(document).on('click', '.viewRequestBtn', function (e) {
        e.preventDefault();
        requestId = $(this).data('request-id');
        $.ajax({
            type: "GET",
            url: "../../backend/inventory-management/getRequest.php",
            data: {
                requestId
            },
            success: function (response) {
                if (response.status === 'internal-error') {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });
                } else if (response.status === 'success') {
                    const requestInfo = response.data[0];
                    $("#requestedByPicture").attr('src', requestInfo.profile_picture !== 'no-link' ? requestInfo.profile_picture : "../../assets/img/no-profile.png");
                    $("#requestedBy").text(requestInfo.full_name);
                    $("#faNumber").text(requestInfo.fa_number === "" ? "Non-Fixed Asset" : requestInfo.fa_number);
                    $("#viewItemCategory").text(requestInfo.item_category);
                    $("#viewComputerName").text(requestInfo.computer_name);
                    $("#requestType").text(requestInfo.request_name);
                    $("#requestReason").text(requestInfo.request_reason);

                    if (requestInfo.request_status === "pending") {
                        if ($("#requestAction").hasClass('d-none')) {
                            $("#requestAction").removeClass('d-none');
                        }
                    } else {
                        if (!$("#requestAction").hasClass('d-none')) {
                            $("#requestAction").addClass('d-none');
                        }
                    }
                    if (requestInfo.new_fa_number === null) {
                        if (!$("#newFaNumberColumn").hasClass('d-none')) {
                            $("#newFaNumberColumn").addClass('d-none');
                        }
                    } else {
                        $("#newFaNumber").text(requestInfo.new_fa_number);
                        if ($("#newFaNumberColumn").hasClass('d-none')) {
                            $("#newFaNumberColumn").removeClass('d-none');
                        }
                    }
                }
            }
        });
    });
});