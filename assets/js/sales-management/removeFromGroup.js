$(document).ready(function () {
    $(document).on('click', '.removeMemberBtn', function () {
        const accountId = $(this).data('account-id');

        Swal.fire({
            title: `Are you sure you want to remove this member?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary-color)',
            cancelButtonColor: 'var(--bs-danger)',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../backend/sales-management/removeFromGroup.php",
                    data: {
                        accountId: accountId
                    },
                    success: function (response) {
                        if (response.status === 'internal-error') {
                            Swal.fire({
                                title: 'Error! ',
                                text: `${response.message}`,
                                icon: 'error',
                                confirmButtonColor: 'var(--bs-danger)'
                            })
                        } else if (response.status === "success") {
                            Swal.fire({
                                title: 'Success! ',
                                text: `${response.message}`,
                                icon: 'success',
                                confirmButtonColor: 'var(--bs-success)'
                            }).then(() => {
                                $('#groupsTable').DataTable().ajax.reload();
                                $('#groupingsTable').DataTable().ajax.reload();
                            })

                        }
                    }
                });
            }
        });
    });
});