$(document).ready(function () {
    let editFAFormValidationTimeout;
    $("#editFAForm").submit(function (e) {
        e.preventDefault();
        if (editFAFormValidationTimeout) {
            clearTimeout(editFAFormValidationTimeout);
        }
        $("#editFAForm").removeClass('was-validated');
        $("#newFA")[0].setCustomValidity('');
        $("#newFAReason")[0].setCustomValidity('');

        let formIsValid = true;
        let inventoryId = queriedId;
        let newFA = $("#newFA").val();
        let newFAReason = $("#newFAReason").val();

        $("#newFA, #newFAReason").removeClass('is-invalid');

        const faFormat = /^TMRMIS\d{2}-\d{4}$/;

        if (!faFormat.test(newFA)) {
            $("#newFA")[0].setCustomValidity('Invalid FA Number Format');
            $("#newFA").next(".invalid-feedback").text('Invalid FA Number Format');
            formIsValid = false;
        } else {
            $.ajax({
                type: "GET",
                url: "../../../backend/admin/inventory-management/checkFAExistence.php",
                data: {
                    newFA: newFA,
                },
                success: function (response) {
                    if (response.status === 'internal-error') {
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        })
                    } else if (response.status === 'success') {
                        if (response.exists) {
                            $("#newFA")[0].setCustomValidity('FA Number already exists');
                            $("#newFA").next(".invalid-feedback").text('FA Number already exists');
                            formIsValid = false;
                        }
                    }
                }
            });
        }

        if (!newFAReason || newFAReason === '' || $("#newFAReason").val().trim().length < 4) {
            $("#newFAReason")[0].setCustomValidity('A valid reason for this change is required.');
            $("#newFAReason").next(".invalid-feedback").text('A valid reason for this change is required.');
            formIsValid = false;
        }


        if (formIsValid) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to request this changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-success)',
                cancelButtonColor: 'var(--bs-secondary)',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../../../backend/admin/inventory-management/addFAEditRequest.php",
                        data: {
                            newFA: newFA,
                            newFAReason: newFAReason,
                            inventoryId: inventoryId
                        },
                        success: function (response) {
                            if (response.status === 'internal-error') {
                                Swal.fire({
                                    title: 'Error!',
                                    text: `${response.message}`,
                                    icon: 'error',
                                    confirmButtonColor: 'var(--bs-danger)'
                                })
                            } else if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: `${response.message}`,
                                    icon: 'success',
                                    confirmButtonColor: 'var(--bs-success)'
                                }).then(() => {
                                    populateTable();
                                    fetchAllRepairs(queriedId);
                                    $("#editFAModal").modal('hide');
                                    setTimeout(() => {
                                        $("#requestChangesModal").modal('hide');
                                        setTimeout(() => {
                                            $("#viewInventoryModal").modal('show');
                                        }, 1000);
                                    }, 1000);
                                })
                            }
                        }
                    });
                }
            })
        }

        $(this).addClass('was-validated');
        editFAFormValidationTimeout = setTimeout(() => {
            $(this).removeClass('was-validated');
        }, 3000);
    });

});