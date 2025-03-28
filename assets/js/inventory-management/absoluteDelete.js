$(document).ready(function () {
    let absoluteDeleteValidationTimeout;
    $("#absoluteDeleteForm").submit(function (e) {
        e.preventDefault();
        if (absoluteDeleteValidationTimeout) {
            clearTimeout(absoluteDeleteValidationTimeout);
        }
        $("#absoluteDeleteForm").removeClass('was-validated');
        $("#absoluteDeleteReason")[0].setCustomValidity('');

        let formIsValid = true;
        let inventoryId = queriedId;
        let absoluteDeleteReason = $("#absoluteDeleteReason").val();

        $("#absoluteDeleteReason").removeClass('is-invalid');

        if (!absoluteDeleteReason || absoluteDeleteReason === '' || $("#absoluteDeleteReason").val().trim().length < 4) {
            $("#absoluteDeleteReason")[0].setCustomValidity('A valid reason for this change is required.');
            $("#absoluteDeleteReason").next(".invalid-feedback").text('A valid reason for this change is required.');
            formIsValid = false;
        } else {
            $("#absoluteDeleteReason")[0].setCustomValidity('');
        }

        if (formIsValid) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to request this changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-success)',
                cancelButtonColor: 'var(--bs-secondary)',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../../backend/inventory-management/addAbsoluteDeleteRequest.php",
                        data: {
                            absoluteDeleteReason: absoluteDeleteReason,
                            inventoryId: inventoryId
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: `${response.message}`,
                                    icon: 'success',
                                    confirmButtonColor: 'var(--bs-success)'
                                }).then(() => {
                                    populateTable();
                                    fetchAllRepairs(queriedId);
                                    $("#absoluteDeleteModal").modal('hide');
                                    setTimeout(() => {
                                        $("#requestChangesModal").modal('hide');
                                        setTimeout(() => {
                                            $("#viewInventoryModal").modal('show');
                                        }, 1000);
                                    }, 1000);

                                    $.ajax({
                                        type: "POST",
                                        url: "../../backend/inventory-management/createMultipleNotification.php",
                                        data: {
                                            receiverAuth: 'inventory_super_auth',
                                            inventoryId: queriedId,
                                            requestId: response.data.requestId,
                                            notificationType: "request_created",
                                            notificationSubject: "requests for Absolute Deletion",
                                            notificationDescription: "Request to Delete an Item Permanently."
                                        },
                                        success: function (response) {
                                            if (response.status === 'internal-error') {
                                                Swal.fire({
                                                    title: 'Error! ',
                                                    text: `${response.message}`,
                                                    icon: 'error',
                                                    confirmButtonColor: 'var(--bs-danger)'
                                                });
                                            } else if (response.status === 'minor-error') {
                                                console.log(response);
                                            }
                                        }
                                    });
                                })
                            } else if (response.status === 'internal-error') {
                                Swal.fire({
                                    title: 'Error!',
                                    text: `${response.message}`,
                                    icon: 'error',
                                    confirmButtonColor: 'var(--bs-danger)'
                                })
                            }
                        }
                    });
                }
            })
        }
        $(this).addClass('was-validated');
        absoluteDeleteValidationTimeout = setTimeout(() => {
            $(this).removeClass('was-validated');
        }, 3000);
    });
});