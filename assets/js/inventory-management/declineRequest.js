$(document).ready(function () {
    $('#declineRequestBtn').on('click', function () {
        Swal.fire({
            title: 'Are you sure you want to decline this request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary-color)',
            cancelButtonColor: 'var(--bs-danger)',
            confirmButtonText: 'Yes, decline it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../backend/inventory-management/declineRequest.php",
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

                                const notificationDescription = response.data.requestType === "Unretire" ? "Unretire request was declined." : (response.data.requestType === "Edit FA Number" ? "Edit FA Number request was declined." : "Absolute Deletion request was declined.");
                                const requestorId = response.data.requestorId;
                                $.ajax({
                                    type: "POST",
                                    url: "../../backend/inventory-management/createNotification.php",
                                    data: {
                                        receiverId: requestorId,
                                        inventoryId: queriedId,
                                        notificationType: "request_decline",
                                        notificationSubject: "declines your request.",
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

    $('#declineRequestBtn_N').on('click', function () {
        Swal.fire({
            title: 'Are you sure you want to decline this request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary-color)',
            cancelButtonColor: 'var(--bs-danger)',
            confirmButtonText: 'Yes, decline it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../backend/inventory-management/declineRequest.php",
                    data: {
                        requestId: requestNotificationId
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
                                $('#viewRequestModalNotif').modal('hide');
                                populateTable();

                                const notificationDescription = response.data.requestType === "Unretire" ? "Unretire request was declined." : (response.data.requestType === "Edit FA Number" ? "Edit FA Number request was declined." : "Absolute Deletion request was declined.");
                                const requestorId = response.data.requestorId;
                                const requestedAsset = response.data.requestedAsset;
                                console.log(requestedAsset);
                                $.ajax({
                                    type: "POST",
                                    url: "../../backend/inventory-management/createNotification.php",
                                    data: {
                                        receiverId: requestorId,
                                        inventoryId: requestedAsset,
                                        notificationType: "request_decline",
                                        notificationSubject: "declines your request.",
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