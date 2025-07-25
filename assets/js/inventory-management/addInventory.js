$(document).ready(function () {
    let createInventoryValidationTimeout;

    $(".createInventoryModalBtn").click(function (e) {
        e.preventDefault();

        if (createInventoryValidationTimeout) {
            clearTimeout(createInventoryValidationTimeout);
        }
        $("#createInventoryForm").removeClass('was-validated');

        $("#itemType").val("").trigger('change');
        $("#itemCategory").val("");
        $("#itemBrand").val("");
        $("#itemModel").val("");
        $("#itemSpecification").val("");
        $("#user").val("");
        $("#computerName").val("");
        $("#department").val("");
        $("#isFreebies").prop('checked', false);
        $("#supplierName").val("");
        $("#serialNumber").val("");
        $("#price").val("");
        $("#status").val("Active");
        $("#remarks").val("");
        $("#dateAcquired").val(new Date().toISOString().split('T')[0]);
    });

    // $("#itemType").on('change', function () {
    //     if ($(this).val() === '') {
    //         $("#itemCategory").val('');
    //         $("#itemCategory").prop('disabled', true);
    //     } else {
    //         $("#itemCategory").val($(this).val());
    //         $("#itemCategory").prop('disabled', false);
    //     }
    // })

    const createInventoryForm = $('#createInventoryForm');

    createInventoryForm.each(function () {
        $(this).submit(function (e) {
            e.preventDefault();
            if (createInventoryValidationTimeout) {
                clearTimeout(createInventoryValidationTimeout);
            }
            if (!this.checkValidity()) {
                e.stopPropagation();
            } else {
                $("#itemCategory").prop('disabled', false);
                Swal.fire({
                    title: 'Add to Inventory?',
                    text: "Are you sure you want to add this inventory?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--bs-success)',
                    cancelButtonColor: 'var(--bs-danger)',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = $(this).serialize();
                        $.ajax({
                            type: 'POST',
                            url: '../../backend/inventory-management/addInventory.php',
                            data: formData,
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: `${response.message}`,
                                        icon: 'success',
                                        confirmButtonColor: 'var(--bs-success)'
                                    }).then(() => {
                                        populateTable();
                                        setTimeout(() => {
                                            $("#createInventoryModal").modal('hide');
                                        }, 150);
                                    })
                                } else if (response.status === 'internal-error') {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: `${response.message}`,
                                        icon: 'error',
                                        confirmButtonColor: 'var(--bs-danger)'
                                    })
                                }
                                $("#itemCategory").prop('disabled', true);
                            },
                            error: function (xhr, status, error) {
                                console.log(xhr.responseText);
                                console.log(status);
                                console.log(error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An internal error occurred. Please contact MIS.',
                                    icon: 'error',
                                    confirmButtonColor: 'var(--bs-danger)'
                                })
                            }
                        })
                    } else {
                        $("#itemCategory").prop('disabled', true);
                    }
                })
            }
            $(this).addClass('was-validated');
            createInventoryValidationTimeout = setTimeout(() => {
                $(this).removeClass('was-validated');
            }, 3000);
        });
    })
});