$(document).ready(function () {
    $("#addToGroupBtn").on("click", function () {
        $("#addToGroupForm")[0].reset();
        $("#member").empty();
        $("#member").append("<option value='' selected hidden>--Select Team Member--</option>");
        $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getAllGrouplessMembers.php",
            success: function (response) {
                if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    })
                } else if (response.status === "success") {
                    for (let i = 0; i < response.data.length; i++) {
                        $("#member").append(`<option value="${response.data[i].id}">${response.data[i].full_name} - ${response.data[i].section_name}</option>`);
                    }
                }
            }
        });
        $("#group").empty();
        $("#group").append("<option value='' selected hidden>--Select Group--</option>");
        $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getAllGroups.php",
            success: function (response) {
                if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    })
                } else if (response.status === "success") {
                    for (let i = 0; i < response.data.length; i++) {
                        $("#group").append(`<option value="${response.data[i].id}">${response.data[i].groupNumber} - ${response.data[i].groupName}</option>`);
                    }
                }
            }
        });
    });
    let addToGroupValidationTimeout;
    $("#addToGroupForm").submit(function (e) {
        e.preventDefault();

        if (addToGroupValidationTimeout) {
            clearTimeout(addToGroupValidationTimeout);
        }
        $("#addToGroupForm").removeClass('was-validated');

        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            Swal.fire({
                title: "Add to Group?",
                text: "Are you sure you want to add this member to this group?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "var(--bs-success)",
                cancelButtonColor: "var(--bs-danger)",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            }).then((result) => {
                const formData = $(this).serialize();
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../../backend/sales-management/addMemberToGroup.php",
                        data: formData,
                        success: function (response) {
                            if (response.status === "internal-error") {
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
                                    $('#addToGroupForm')[0].reset();
                                    $('#groupsTable').DataTable().ajax.reload();
                                    $('#groupingsTable').DataTable().ajax.reload();
                                    $('#addToGroupModal').modal('hide');
                                })
                            }
                        }
                    });
                }
            })
        }
        $(this).addClass('was-validated');
        addToGroupValidationTimeout = setTimeout(function () {
            $("#addToGroupForm").removeClass('was-validated');
        }, 5000);
    });
});