$(document).ready(function () {
    $(document).on('click', '.archiveGroupBtn', function () {

        Swal.fire({
            title: `Are you sure you want to archive this group?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary-color)',
            cancelButtonColor: 'var(--bs-danger)',
            confirmButtonText: 'Yes, archive it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../backend/sales-management/archiveGroup.php",
                    data: {
                        groupId: $(this).data('group-id')
                    },
                    success: function (response) {
                        if (response === "internal-error") {
                            Swal.fire({
                                title: 'Error! ',
                                text: `${response.message}`,
                                icon: 'error',
                                confirmButtonColor: 'var(--bs-danger)'
                            })
                        } else {
                            Swal.fire({
                                title: 'Success! ',
                                text: `${response.message}`,
                                icon: 'success',
                                confirmButtonColor: 'var(--bs-success)'
                            }).then(() => {
                                $('#groupsTable').DataTable().ajax.reload();
                            })
                        }
                    }
                });
            }
        })
    });
});