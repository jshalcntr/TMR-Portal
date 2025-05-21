$(document).ready(function () {
    let createAccountValidationTimeout;
    $("#createAccountModalBtn").on('click', function (e) {
        e.preventDefault();
        if (createAccountValidationTimeout) {
            clearTimeout(createAccountValidationTimeout);
        }
        $("#createAccountForm").removeClass('was-validated');
        $("#createAccountForm")[0].reset();
        $("#section").empty();
        $("#section").append(`<option value="" selected hidden>--Select Section--</option>`);

        $.ajax({
            type: "GET",
            url: "../../backend/account-management/getAllDepartments.php",
            success: function (response) {
                if (response.status === 'success') {
                    $("#department").empty();
                    $("#department").append(`<option value="" selected hidden>--Select Department--</option>`);
                    for (let i = 0; i < response.data.length; i++) {
                        $("#department").append(`<option value="${response.data[i].department_id}">${response.data[i].department_name}</option>`);
                    }
                } else if (response.status === 'internal-error') {
                    Swal.fire({
                        title: 'Error!',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    }).then(() => {
                        $("#department").empty();
                        $("#department").append(`<option value="" selected hidden>--Select Department--</option>`);
                    });
                }
            }
        });

        $("#collapseAuthorizations").collapse('hide');
        $("#toggleAuthorizationsBtn").attr('aria-expanded', 'false');
    });
    $("#department").on('change', function () {
        if ($(this).val() === '') {
            $("#section").prop("disabled", true);
        } else {
            $("#section").prop("disabled", false);
        }
        $.ajax({
            type: "GET",
            url: "../../backend/account-management/getSections.php",
            data: {
                departmentId: this.value
            },
            success: function (response) {
                if (response.status === 'success') {
                    $("#section").empty();
                    $("#section").append(`<option value="" selected hidden>--Select Section--</option>`);
                    for (let i = 0; i < response.data.length; i++) {
                        $("#section").append(`<option value="${response.data[i].section_id}">${response.data[i].section_name}</option>`);
                    }
                } else {
                    $("#section").empty();
                    $("#section").append(`<option value="" selected hidden>--Select Section--</option>`);
                }
            }
        });
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
                url: "../../backend/account-management/checkUsernameExistence.php",
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
                            Swal.fire({
                                title: 'Save Account Details?',
                                text: 'Are you sure you want to save the account details?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: 'var(--bs-success)',
                                cancelButtonColor: 'var(--bs-danger)',
                                confirmButtonText: 'Confirm',
                                cancelButtonText: 'Cancel',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: "POST",
                                        url: "../../backend/account-management/addAccount.php",
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
                            })
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