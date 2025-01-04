let queriedId;
let editAccountValidationTimeout;
$(document).ready(function () {
    $(document).on('click', '.viewAccountBtn', function (e) {
        e.preventDefault();
        $("#editAccountForm")[0].reset();
        if (editAccountValidationTimeout) {
            clearTimeout(editAccountValidationTimeout);
        }
        $("#editAccountForm").removeClass('was-validated');
        if (!$("#fullName_edit").prop('disabled')) {
            toggleEditModal();
        }
        if ($("#editAccountActionGroup").hasClass('d-flex')) {
            $("#viewAccountActionGroup").removeClass('d-none');
            $("#viewAccountActionGroup").addClass('d-flex');
            $("#editAccountActionGroup").removeClass('d-flex');
            $("#editAccountActionGroup").addClass('d-none');
        }

        queriedId = $(this).data('account-id');
        $.ajax({
            type: "GET",
            url: "../../../backend/s-admin/account-management/getAccount.php",
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

    $("#editAccountButton").on('click', function () {
        toggleEditModal();
        $("#viewAccountActionGroup").removeClass('d-flex');
        $("#viewAccountActionGroup").addClass('d-none');
        $("#editAccountActionGroup").removeClass('d-none');
        $("#editAccountActionGroup").addClass('d-flex');
    });
    $("#cancelEditAccountButton").on('click', function () {
        toggleEditModal();
        $("#viewAccountActionGroup").removeClass('d-none');
        $("#viewAccountActionGroup").addClass('d-flex');
        $("#editAccountActionGroup").removeClass('d-flex');
        $("#editAccountActionGroup").addClass('d-none');

        $.ajax({
            type: "GET",
            url: "../../../backend/s-admin/account-management/getAccount.php",
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

    const toggleEditModal = () => {
        $("#fullName_edit").prop('disabled', !$("#fullName_edit").prop('disabled'));
        $("#username_edit").prop('disabled', !$("#username_edit").prop('disabled'));
        $("#role_edit").prop('disabled', !$("#role_edit").prop('disabled'));
        $("#department_edit").prop('disabled', !$("#department_edit").prop('disabled'));
        $("#inventoryView_edit").prop('disabled', !$("#inventoryView_edit").prop('disabled'));
        $("#inventoryEdit_edit").prop('disabled', !$("#inventoryEdit_edit").prop('disabled'));
        $("#accountsView_edit").prop('disabled', !$("#accountsView_edit").prop('disabled'));
        $("#accountsEdit_edit").prop('disabled', !$("#accountsEdit_edit").prop('disabled'));
    }
});