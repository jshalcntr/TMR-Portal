$(document).ready(function () {

    $("#editAccountForm").submit(function (e) {
        e.preventDefault();
        $("#username").next(".invalid-feedback").text("Username is required.");
        if (editAccountValidationTimeout) {
            clearTimeout(editAccountValidationTimeout);
        }
        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            const username = $("#username_edit").val();
            const id = $("#id_edit").val();

            $.ajax({
                type: "GET",
                url: "../../backend/account-management/checkUsernameExistenceEdit.php",
                data: {
                    id: id,
                    username: username,
                },
                success: function (response) {
                    if (response.status === 'internal-error') {
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        });
                    } else if (response.status === 'success') {
                        if (response.exists) {
                            $("#username_edit")[0].setCustomValidity("Username already exists.");
                            $("#username_edit").next(".invalid-feedback").text("Username already exists.");
                        } else {
                            $("#username_edit")[0].setCustomValidity('');
                            Swal.fire({
                                title: "Save Account Details?",
                                text: "Are you sure you want to save the account details?",
                                icon: "question",
                                showCancelButton: true,
                                confirmButtonColor: "var(--bs-success)",
                                cancelButtonColor: "var(--bs-danger)",
                                confirmButtonText: "Confirm",
                                cancelButtonText: "Cancel",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const formData = $("#editAccountForm").serialize();
                                    console.log(formData);
                                    $.ajax({
                                        type: "POST",
                                        url: "../../backend/account-management/editAccount.php",
                                        data: formData,
                                        success: function (response) {
                                            if (response.status === 'internal-error') {
                                                Swal.fire({
                                                    title: 'Error!',
                                                    text: `${response.message}`,
                                                    icon: 'error',
                                                    confirmButtonColor: 'var(--bs-danger)'
                                                });
                                            } else {
                                                Swal.fire({
                                                    title: 'Success!',
                                                    text: `${response.message}`,
                                                    icon: 'success',
                                                    confirmButtonColor: 'var(--bs-success)'
                                                }).then(() => {
                                                    $('#accountsTable').DataTable().ajax.reload();
                                                    $("#fullName_edit").prop('disabled', !$("#fullName_edit").prop('disabled'));
                                                    $("#username_edit").prop('disabled', !$("#username_edit").prop('disabled'));
                                                    $("#role_edit").prop('disabled', !$("#role_edit").prop('disabled'));
                                                    $("#department_edit").prop('disabled', !$("#department_edit").prop('disabled'));
                                                    $("#inventoryView_edit").prop('disabled', !$("#inventoryView_edit").prop('disabled'));
                                                    $("#inventoryEdit_edit").prop('disabled', !$("#inventoryEdit_edit").prop('disabled'));
                                                    $("#accountsView_edit").prop('disabled', !$("#accountsView_edit").prop('disabled'));
                                                    $("#accountsEdit_edit").prop('disabled', !$("#accountsEdit_edit").prop('disabled'));

                                                    $("#viewAccountActionGroup").removeClass('d-none');
                                                    $("#viewAccountActionGroup").addClass('d-flex');
                                                    $("#editAccountActionGroup").removeClass('d-flex');
                                                    $("#editAccountActionGroup").addClass('d-none');

                                                    $.ajax({
                                                        type: "GET",
                                                        url: "../../backend/account-management/getAccount.php",
                                                        data: {
                                                            queriedId
                                                        },
                                                        success: function (response) {
                                                            if (response.status === "internal-error") {
                                                                Swal.fire({
                                                                    title: 'Error!',
                                                                    text: `${response.message}`,
                                                                    icon: 'error',
                                                                    confirmButtonColor: 'var(--bs-danger)'
                                                                });
                                                            } else if (response.status === "success") {
                                                                const data = response.data[0];

                                                                $("#fullName_edit").val(data.full_name);
                                                                $("#username_edit").val(data.username);
                                                                $("#role_edit").val(data.role);
                                                                $("#department_edit").val(data.department);
                                                                $("#inventoryView_edit").prop('checked', data.inventory_view_auth);
                                                                $("#inventoryEdit_edit").prop('checked', data.inventory_edit_auth);
                                                                $("#accountsView_edit").prop('checked', data.accounts_view_auth);
                                                                $("#accountsEdit_edit").prop('checked', data.accounts_edit_auth);
                                                                $("#id_edit").val(data.id);
                                                            }
                                                        }
                                                    });
                                                });
                                            }
                                        }
                                    });
                                }
                            })
                        }
                    }
                }
            });
        }
        $(this).addClass('was-validated');
        editAccountValidationTimeout = setTimeout(() => {
            $(this).removeClass('was-validated');
        }, 3000);
    });

    $("#username_edit").on('input', function () {
        this.setCustomValidity('');
    });
});