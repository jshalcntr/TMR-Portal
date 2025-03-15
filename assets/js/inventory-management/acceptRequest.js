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
                            });
                        }
                    }
                });
            }
        })
    });
});