$(document).ready(function () {
    $('#acceptRequestBtn').on('click', function () {
        Swal.fire({
            title: 'Are you sure you want to accept this request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary-color)',
            cancelButtonColor: 'var(--bs-danger)',
            confirmButtonText: 'Yes, accept it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../backend/inventory-management/acceptRequest.php",
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
                            Swal.fire({
                                title: 'Success! ',
                                text: `${response.message}`,
                                icon: 'success',
                                confirmButtonColor: 'var(--bs-success)'
                            }).then(() => {
                                $('#viewRequestModal').modal('hide');
                                $('#allRequestsTable').DataTable().ajax.reload();
                                populateTable();
                                const notificationDescription = response.data.requestType === "Unretire" ? "Unretire request was accepted." : (response.data.requestType === "Edit FA Number" ? "Edit FA Number request was accepted." : "Absolute Deletion request was accepted.");
                                const notificationType = response.data.requestType === "Unretire" ? "request_unretire_accepted" : (response.data.requestType === "Edit FA Number" ? "request_editFA_accepted" : "request_delete_accepted");
                                const requestorId = response.data.requestorId;
                                $.ajax({
                                    type: "POST",
                                    url: "../../backend/inventory-management/createNotification.php",
                                    data: {
                                        receiverId: requestorId,
                                        inventoryId: queriedId,
                                        notificationType,
                                        notificationSubject: "accepts your request",
                                        notificationDescription
                                    },
                                    success: function (response) {
                                        if (response.status === 'internal-error') {
                                            Swal.fire({
                                                title: 'Error! ',
                                                text: `${response.message}`,
                                                icon: 'error',
                                                confirmButtonColor: 'var(--bs-danger)'
                                            });
                                        }
                                    }
                                });
                            });
                        }
                    }
                });
            }
        })
    });
});