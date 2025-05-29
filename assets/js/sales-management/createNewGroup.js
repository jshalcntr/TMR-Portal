let createNewGroupValidationTimeout;
$(document).ready(function () {
    $("#createNewGroupBtn").on("click", function () {
        $("#createNewGroupForm")[0].reset()
    });

    $("#createNewGroupForm").on("submit", function (e) {
        e.preventDefault();

        if (createNewGroupValidationTimeout) {
            clearTimeout(createNewGroupValidationTimeout);
        }
        $("#createNewGroupForm").removeClass('was-validated');

        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            Swal.fire({
                title: "Create New Group?",
                text: "Are you sure you want to add this new group?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "var(--bs-success)",
                cancelButtonColor: "var(--bs-danger)",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "../../backend/sales-management/addNewGroup.php",
                        data: formData,
                        success: function (response) {
                            if (response.status === 'internal-error') {
                                Swal.fire({
                                    title: "Error!",
                                    text: `${response.message}`,
                                    icon: "error",
                                    confirmButtonColor: "var(--bs-danger)",
                                });
                            } else if (response.status === 'success') {
                                Swal.fire({
                                    title: "Success!",
                                    text: `${response.message}`,
                                    icon: "success",
                                    confirmButtonColor: "var(--bs-success)",
                                }).then(() => {
                                    $('#groupsTable').DataTable().ajax.reload();
                                    $('#groupingsTable').DataTable().ajax.reload();
                                    $('#createNewGroupModal').modal('hide');
                                });
                            }
                        }
                    });
                }
            })
        }
        $(this).addClass('was-validated');
        createNewGroupValidationTimeout = setTimeout(function () {
            $('#createNewGroupForm').removeClass('was-validated');
        }, 3000);
    });
});