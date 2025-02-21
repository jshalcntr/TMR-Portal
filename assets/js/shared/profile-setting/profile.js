$(document).ready(function () {
    let editNameValidationTimeout;
    $("#editFullNameBtn").click(function (e) {
        e.preventDefault();
        toggleEditName();
    });
    $("#cancelEditFullNameBtn").click(function (e) {
        e.preventDefault();
        toggleEditName();
    });

    $("#profileInformationForm").submit(function (e) {
        e.preventDefault();
        if (editNameValidationTimeout) {
            clearTimeout(editNameValidationTimeout);
        }

        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            const accountId = $("#accountId").val();
            const fullName = $("#fullName_edit").val();

            Swal.fire({
                title: 'Are you sure?',
                text: "Save this as your new Full Name?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-success)',
                cancelButtonColor: 'var(--bs-secondary)',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../../backend/shared/profile-setting/editFullName.php",
                        data: {
                            accountId: accountId,
                            fullName: fullName
                        },
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
                                })
                                toggleEditName();
                            }
                        }
                    });
                }
            })
        }
        $("#profileInformationForm").addClass('was-validated');
        editNameValidationTimeout = setTimeout(() => {
            $("#profileInformationForm").removeClass('was-validated');
        }, 3000)

    });

    const toggleEditName = () => {
        if ($("#viewFullNameBtnGroup").hasClass('d-flex')) {
            $("#viewFullNameBtnGroup").removeClass('d-flex');
            $("#viewFullNameBtnGroup").addClass('d-none');
            $("#editFullNameBtnGroup").addClass('d-flex');
            $("#editFullNameBtnGroup").removeClass('d-none');
        } else if ($("#editFullNameBtnGroup").hasClass('d-flex')) {
            $("#editFullNameBtnGroup").removeClass('d-flex');
            $("#editFullNameBtnGroup").addClass('d-none');
            $("#viewFullNameBtnGroup").addClass('d-flex');
            $("#viewFullNameBtnGroup").removeClass('d-none');
        }
        if ($("#fullName_edit").prop('disabled')) {
            $("#fullName_edit").prop('disabled', false);
        } else {
            $("#fullName_edit").prop('disabled', true);
        }
        fetchProfileInformation();
    }

    const fetchProfileInformation = () => {
        const accountId = $("#accountId").val();

        $.ajax({
            type: "GET",
            url: "../../backend/shared/profile-setting/getProfileInformation.php",
            data: {
                accountId: accountId
            },
            success: function (response) {
                if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error!',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });
                } else {
                    const accountInfo = response.data[0];
                    $("#fullName_edit").val(accountInfo.full_name);
                    $("#authFullName").text(accountInfo.full_name);
                    $('#authPP').attr('src', accountInfo.profile_picture !== 'no-link' ? accountInfo.profile_picture : "../../assets/img/no-profile.png");
                    $("#profilePicture").attr('src', accountInfo.profile_picture !== 'no-link' ? accountInfo.profile_picture : "../../assets/img/no-profile.png");
                    if (accountInfo.profile_picture === 'no-link') {
                        $("#removeProfilePicture").addClass('d-none');
                    } else {
                        $("#removeProfilePicture").removeClass('d-none');
                    }
                }
            }
        });
    }
    fetchProfileInformation();

    $("#editProfilePictureBtn").on('click', function () {
        const accountId = $("#accountId").val();

        $("#profilePictureFile").val("");

        fetchProfileInformation();

        $.ajax({
            type: "GET",
            url: "../../backend/shared/profile-setting/getProfileInformation.php",
            data: {
                accountId: accountId
            },
            success: function (response) {
                if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error!',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });
                } else {
                    const accountInfo = response.data[0];
                    $("#dpPreview").attr('src', accountInfo.profile_picture !== 'no-link' ? accountInfo.profile_picture : "../../assets/img/no-profile.png");
                }
            }
        });
        $("#dpSubmitFormBtn").addClass("d-none");
        $("#unattachFile").addClass("d-none");
    });

    $("#profilePictureFile").on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (event) {
                $("#dpPreview").attr('src', event.target.result);
            };

            reader.readAsDataURL(file);
            $("#dpSubmitFormBtn").removeClass("d-none");
            $("#unattachFile").removeClass("d-none");
        }
    });

    $("#unattachFile").on('click', function () {
        const accountId = $("#accountId").val();

        $("#profilePictureFile").val("");
        $("#dpSubmitFormBtn").addClass("d-none");
        $(this).addClass("d-none");
    });

    $("#editProfilePictureModalBody").submit(function (e) {
        e.preventDefault();

        const accountId = $("#accountId").val();

        const formData = new FormData(this);

        formData.append('accountId', accountId);

        Swal.fire({
            title: 'Are you sure?',
            text: "Save this as your new Profile Picture?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-success)',
            cancelButtonColor: 'var(--bs-secondary)',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../backend/shared/profile-setting/editProfilePicture.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === "internal-error") {
                            Swal.fire({
                                title: 'Error!',
                                text: `${response.message}`,
                                icon: 'error',
                                confirmButtonColor: 'var(--bs-danger)'
                            });
                        } else {
                            if (response.status === "internal-error") {
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
                                    $("#editProfilePictureModal").modal('hide');
                                    fetchProfileInformation();
                                });
                            }
                        }
                    }
                });
            }
        });
    });

    $("#removeProfilePicture").on('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove your Profile Picture?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-danger)',
            cancelButtonColor: 'var(--bs-secondary)',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../backend/shared/profile-setting/removeProfilePicture.php",
                    data: {
                        accountId: $("#accountId").val(),
                        profilePictureLink: $("#dpPreview").attr('src')
                    },
                    success: function (response) {
                        if (response.status === "internal-error") {
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
                                $("#editProfilePictureModal").modal('hide');
                                fetchProfileInformation();
                            });
                        }
                    }
                });
            }
        })
    });

    $("#toggleCurrentPassword").on('click', function () {
        togglePassword("#toggleCurrentPassword", "#currentPassword");
    });

    $("#toggleNewPassword").on('click', function () {
        togglePassword("#toggleNewPassword", "#newPassword");
    });

    $("#toggleConfirmPassword").on('click', function () {
        togglePassword("#toggleConfirmPassword", "#confirmPassword");
    });

    let changePasswordValidationTimeout;
    $("#changePasswordForm").on('submit', async function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (changePasswordValidationTimeout) {
            clearTimeout(changePasswordValidationTimeout);
        }

        let formIsValid = true;
        let accountId = $("#accountId").val();
        let currentPassword = $("#currentPassword").val();
        let newPassword = $("#newPassword").val();
        let confirmPassword = $("#confirmPassword").val();

        $("#changePasswordForm").removeClass('was-validated');
        $("#currentPassword, #newPassword, #confirmPassword").removeClass('is-invalid');

        // let passValidity = ;

        // console.log(passValidity);
        if (!currentPassword) {
            $("#currentPassword")[0].setCustomValidity('Please enter your current password');
            $("#currentPassword").next(".invalid-feedback").text('Please enter your current password')
            formIsValid = false;
        } else if (!await checkCurrentPassword(accountId, currentPassword).then(response => { return response.validity; })) {
            $("#currentPassword")[0].setCustomValidity('Incorrect current password');
            $("#currentPassword").next(".invalid-feedback").text('Incorrect current password');
            formIsValid = false;
        } else {
            $("#currentPassword")[0].setCustomValidity('');
        }

        let passwordCriteria = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,20}$/;
        if (!newPassword) {
            $("#newPassword")[0].setCustomValidity(`New Password can't be empty.`);
            $("#newPassword").next(".invalid-feedback").text(`New Password can't be empty.`);
            formIsValid = false;
        } else if (!passwordCriteria.test(newPassword)) {
            $("#newPassword")[0].setCustomValidity('Password must be 8-20 characters long and contain at least one lowercase letter, one uppercase letter, one number, and one special character.');
            $("#newPassword").next(".invalid-feedback").text('Password must be 8-20 characters long and contain at least one lowercase letter, one uppercase letter, one number, and one special character.');
            formIsValid = false;
        } else {
            $("#newPassword")[0].setCustomValidity('');
            $("#newPassword").next(".invalid-feedback").text('');
        }

        if (newPassword !== confirmPassword) {
            $("#confirmPassword")[0].setCustomValidity('Passwords do not match.');
            $("#confirmPassword").next(".invalid-feedback").text('Passwords do not match.');
            formIsValid = false;
        } else {
            $("#confirmPassword")[0].setCustomValidity('');
            $("#confirmPassword").next(".invalid-feedback").text('');
        }

        if (formIsValid) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change your password?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-success)',
                cancelButtonColor: 'var(--bs-secondary)',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../../backend/shared/profile-setting/changePassword.php",
                        data: {
                            accountId: accountId,
                            newPassword: newPassword
                        },
                        success: function (response) {
                            if (response.status === "internal-error") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            } else if (response.status === "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    $("#changePasswordModal").modal('hide');
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 5000);
                                })
                            }
                        }
                    });
                }
            })
        }
        $("#changePasswordForm").addClass('was-validated');
        changePasswordValidationTimeout = setTimeout(() => {
            $("#changePasswordForm").removeClass('was-validated');
            $("#currentPassword, #newPassword, #confirmPassword").removeClass('is-invalid');
        }, 3000);
    });

    const togglePassword = (togglerId, inputId) => {
        if ($(togglerId).hasClass('fa-eye-slash')) {
            $(togglerId).removeClass('fa-eye-slash');
            $(togglerId).addClass('fa-eye');
            $(inputId).attr('type', 'text');
        } else if ($(togglerId).hasClass('fa-eye')) {
            $(togglerId).removeClass('fa-eye');
            $(togglerId).addClass('fa-eye-slash');
            $(inputId).attr('type', 'password');
        }
    }

    const checkCurrentPassword = (accountId, currentPassword) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "POST",
                url: "../../backend/shared/profile-setting/checkCurrentPassword.php",
                data: {
                    accountId: accountId,
                    currentPassword: currentPassword
                },
                success: function (response) {
                    if (response.status === "internal-error") {
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        });
                        reject(response)
                    } else if (response.status === "success") {
                        resolve(response);
                    }
                }
            });
        })
    }
});