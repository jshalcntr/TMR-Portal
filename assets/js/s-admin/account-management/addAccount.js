$(document).ready(function () {
    let createAccountValidationTimeout;
    $("#createAccountModalBtn").on('click', function (e) {
        e.preventDefault();
        if (createAccountValidationTimeout) {
            clearTimeout(createAccountValidationTimeout);
        }
        $("#createAccountForm").removeClass('was-validated');
        $("#createAccountForm")[0].reset();
    });

    $("#createAccountForm").submit(function (e) {
        e.preventDefault();

        $("#username").next(".invalid-feedback").text("Username is required.");

        if (createAccountValidationTimeout) {
            clearTimeout(createAccountValidationTimeout);
        }

        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            const username = $("#username").val();

            $.ajax({
                type: "GET",
                url: "../../../backend/s-admin/account-management/checkUsernameExistence.php",
                data: {
                    username: username
                },
                success: function (response) {
                    if (response.status === 'internal-error') {
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        })
                    } else if (response.status === "success") {
                        if (response.exists) {
                            $("#username")[0].setCustomValidity("Username already exists.");
                            $("#username").next(".invalid-feedback").text("Username already exists.");
                            // $("#createAccountForm").addClass('was-validated');
                        } else {
                            $("#username")[0].setCustomValidity('');
                            // console.log(`Data: ${$("#createAccountForm").serialize()}`);
                            $.ajax({
                                type: "POST",
                                url: "../../../backend/s-admin/account-management/addAccount.php",
                                data: $("#createAccountForm").serialize(),
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            title: 'Success!',
                                            html: `${response.message}`,
                                            icon: 'success',
                                            confirmButtonColor: 'var(--bs-success)'
                                        }).then(() => {
                                            $("#createAccountModal").modal('hide');
                                            $('#accountsTable').DataTable().ajax.reload();
                                        });
                                    }
                                }
                            });
                        }
                    }
                }
            });
        }
        $("#createAccountForm").addClass('was-validated');
        createAccountValidationTimeout = setTimeout(() => {
            $("#createAccountForm").removeClass('was-validated');
        }, 3000);
    });

    $("#username").on('input', function () {
        this.setCustomValidity('');
    });
});