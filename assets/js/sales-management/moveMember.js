$(document).ready(function () {
    $(document).on('click', '.moveMemberBtn', function () {
        const accountId = $(this).data('account-id');
        $("#moveMemberForm")[0].reset();
        $("#group_move").empty();
        $("#group_move").append("<option value='' selected hidden>--Select Group--</option>");
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
                        $("#group_move").append(`<option value="${response.data[i].id}">${response.data[i].groupNumber} - ${response.data[i].groupName}</option>`);
                    }
                }
            }
        });
        $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getMemberDetails.php",
            data: {
                accountId
            },
            success: function (response) {

                if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    })
                } else if (response.status === "success") {
                    const value = response.data[0];
                    console.log(value);
                    $("#member_move").val(value.full_name);
                    $("#group_move").val(value.group_id);
                    $("#accountId_move").val(value.account_id);
                }
            }
        });
    });

    let moveMemberValidationTimeout;
    $("#moveMemberForm").submit(function (e) {
        e.preventDefault();

        if (moveMemberValidationTimeout) {
            clearTimeout(moveMemberValidationTimeout);
        }
        $("#moveMemberForm").removeClass("was-validated");

        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            Swal.fire({
                title: "Move Member?",
                text: "Are you sure you want to move this member?",
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
                        url: "../../backend/sales-management/moveMember.php",
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
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#groupsTable').DataTable().ajax.reload();
                                        $('#groupingsTable').DataTable().ajax.reload();
                                        $('#moveMemberModal').modal('hide');
                                        $("#moveMemberForm")[0].reset();
                                    }
                                });
                            }
                        }
                    });
                }
            })
        }
        $(this).addClass('was-validated');
        createNewGroupValidationTimeout = setTimeout(function () {
            $('#moveMemberForm').removeClass('was-validated');
        }, 3000);
    });
});