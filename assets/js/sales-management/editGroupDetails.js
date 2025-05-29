let editGroupDetailsValidationTimeout;
$(document).ready(function () {
    $(document).on('click', '.editGroupDetailsBtn', function (e) {
        e.preventDefault();

        if (editGroupDetailsValidationTimeout) {
            clearTimeout(editGroupDetailsValidationTimeout);
        }
        $("#editGroupDetailsForm").removeClass('was-validated');

        const queriedId = $(this).data('group-id');

        $("#editGroupDetailsForm")[0].reset();
        $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getGroupDetails.php",
            data: {
                groupId: queriedId
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
                    const groupDetails = response.data[0];
                    $("#groupId_edit").val(groupDetails.group_id);
                    $("#groupName_edit").val(groupDetails.group_initials);
                    $("#groupNumber_edit").val(groupDetails.group_number);
                }
            }
        });
    });

    $("#editGroupDetailsForm").submit(function (e) {
        e.preventDefault();

        if (editGroupDetailsValidationTimeout) {
            clearTimeout(editGroupDetailsValidationTimeout);
        }
        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            const formData = $(this).serialize();
            Swal.fire({
                title: "Edit Group Details?",
                text: "Are you sure you want to edit this group details?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-success)',
                cancelButtonColor: 'var(--bs-danger)',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../../backend/sales-management/editGroupDetails.php",
                        data: formData,
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
                                    $('#groupsTable').DataTable().ajax.reload();
                                    $('#groupingsTable').DataTable().ajax.reload();
                                    $("#editGroupDetailsForm")[0].reset();
                                    $("#editGroupDetailsModal").modal('hide');
                                });
                            }
                        }
                    });
                }
            })
        }
        $(this).addClass('was-validated');
        editGroupDetailsValidationTimeout = setTimeout(function () {
            $('#editGroupDetailsForm').removeClass('was-validated');
        }, 3000);
    })
});