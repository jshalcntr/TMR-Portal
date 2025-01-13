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
                        url: "../../../backend/shared/profile-setting/editFullName.php",
                        data: {
                            accountId: $("#accountId").val(),
                            fullName: $("#fullName_edit").val()
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
            url: "../../../backend/shared/profile-setting/getProfileInformation.php",
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
                    $('#authPP').attr('src', accountInfo.profile_picture !== 'no-link' ? accountInfo.profile_picture : "../../../assets/img/no-profile.png");
                    $("#profilePicture").attr('src', accountInfo.profile_picture !== 'no-link' ? accountInfo.profile_picture : "../../../assets/img/no-profile.png");
                }
            }
        });
    }
    fetchProfileInformation();

    $("#editProfilePictureBtn").on('click', function () {
        const accountId = $("#accountId").val();

        $("#profilePictureFile").val("");

        $.ajax({
            type: "GET",
            url: "../../../backend/shared/profile-setting/getProfileInformation.php",
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
                    $("#dpPreview").attr('src', accountInfo.profile_picture !== 'no-link' ? accountInfo.profile_picture : "../../../assets/img/no-profile.png");
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
        $.ajax({
            type: "GET",
            url: "../../../backend/shared/profile-setting/getProfileInformation.php",
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
                    $("#dpPreview").attr('src', accountInfo.profile_picture !== 'no-link' ? accountInfo.profile_picture : "../../../assets/img/no-profile.png");
                }
            }
        });
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
                    url: "../../../backend/shared/profile-setting/editProfilePicture.php",
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
});