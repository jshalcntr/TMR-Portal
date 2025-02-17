$(document).ready(function () {
    let unretireValidationTimeout;
    $("#unretireForm").submit(function (e) {
        e.preventDefault();
        if (unretireValidationTimeout) {
            clearTimeout(unretireValidationTimeout);
        }
        $("#unretireForm").removeClass('was-validated');
        $("#unretireReason")[0].setCustomValidity('');

        let formIsValid = true;
        let inventoryId = queriedId;
        let unretireReason = $("#unretireReason").val();

        $("#unretireReason").removeClass('is-invalid');

        if (!unretireReason || unretireReason === '' || $("#unretireReason").val().trim().length < 4) {
            $("#unretireReason")[0].setCustomValidity('A valid reason for this change is required.');
            $("#unretireReason").next(".invalid-feedback").text('A valid reason for this change is required.');
            formIsValid = false;
        } else {
            $("#unretireReason")[0].setCustomValidity('');
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
                        url: "../../backend/inventory-management/addUnretireRequest.php",
                        data: {
                            unretireReason: unretireReason,
                            inventoryId: inventoryId
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: `${response.message}`,
                                    icon: 'success',
                                    confirmButtonColor: 'var(--bs-success)'
                                }).then(() => {
                                    populateTable();
                                    fetchAllRepairs(queriedId);
                                    $("#unretireModal").modal('hide');
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
        unretireValidationTimeout = setTimeout(() => {
            $(this).removeClass('was-validated');
        }, 3000);
    });
});