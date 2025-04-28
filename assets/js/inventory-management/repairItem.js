$(document).ready(function () {
    $(document).on('click', '#repairButton', function () {
        $("#repairItemForm").removeClass('was-validated');
        $("#repairItemModal").modal('show');

        $("#viewInventoryModal").modal('hide');
        $("#repairDate").attr('min', $("#dateAcquired_edit").val());
    });
    $(document).on('click', '#finishRepairButton', function () {
        $.ajax({
            type: "GET",
            url: "../../backend/inventory-management/getRepair.php",
            data: {
                repairId: $("#repairId_edit").val()
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
                    const repairData = response.data[0];
                    $("#repairId_finish").val(repairData.repair_id);
                    $("#date_repaired").attr("min", repairData.start_date);
                    $("#date_repaired").val(new Date().toISOString().split('T')[0]);
                    $("#repair_remarks").val("");
                }
            }
        });

        $("#repairItemModal").modal('hide');
        $("#finishRepairModal").modal('show');
    });
    $("#repairItemModal").on('hidden.bs.modal', function () {
        if ($("#finishRepairModal").attr("aria-hidden")) {
            $("#viewInventoryModal").modal('show');
        }
        $("#repairDescription_edit").val("");
        $("#gatepassNumber_edit").val("");
        $("#repairDate_edit").val("");
    });
    $("#finishRepairModal").on('hidden.bs.modal', function () {
        $("#repairDescription_edit").val("");
        $("#gatepassNumber_edit").val("");
        $("#repairDate_edit").val("");
        $("#repairItemModal").modal('show');
    })

    let repairItemValidationTimeout;

    $("#repairItemForm").submit(function (e) {
        e.preventDefault();

        if (repairItemValidationTimeout) {
            clearTimeout(repairItemValidationTimeout);
        }
        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            const formData = $(this).serialize();

            const inventoryId = $("#id_edit").val();

            const fullData = `${formData}&inventoryId=${encodeURIComponent(inventoryId)}`;

            $.ajax({
                type: "POST",
                url: "../../backend/inventory-management/addRepair.php",
                data: fullData,
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
                        })
                    }
                }
            });
        }
        $(this).addClass('was-validated');
        repairItemValidationTimeout = setTimeout(() => {
            $(this).removeClass('was-validated');
        }, 3000);
    });

    const toggleEditRepairButton = () => {
        $("#repairDescription_edit").prop('disabled', !$("#repairDescription_edit").prop('disabled'));
        $("#gatepassNumber_edit").prop('disabled', !$("#gatepassNumber_edit").prop('disabled'));
        $("#repairDate_edit").prop('disabled', !$("#repairDate_edit").prop('disabled'));

        $("#viewRepairButtonGroup").toggleClass('d-flex');
        $("#viewRepairButtonGroup").toggleClass('d-none');
        $("#editRepairButtonGroup").toggleClass('d-flex');
        $("#editRepairButtonGroup").toggleClass('d-none');
    }

    $("#editRepairButton").on('click', function () {
        toggleEditRepairButton();
    });
    $("#cancelEditRepairButton").on('click', function () {
        toggleEditRepairButton();
    });

    let editRepairValidationTimeout;

    $("#editRepairItemForm").submit(function (e) {
        e.preventDefault();

        if (editRepairValidationTimeout) {
            clearTimeout(editRepairValidationTimeout);
        }
        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            Swal.fire({
                title: "Edit Inventory?",
                text: "Are you sure you want to edit this inventory?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-success)',
                cancelButtonColor: 'var(--bs-danger)',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = $(this).serialize();

                    const inventoryId = $("#id_edit").val();

                    const fullData = `${formData}&inventoryId=${encodeURIComponent(inventoryId)}`;

                    $.ajax({
                        type: "POST",
                        url: "../../backend/inventory-management/editRepair.php",
                        data: fullData,
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: `${response.message}`,
                                    icon: 'success',
                                    confirmButtonColor: 'var(--bs-success)'
                                }).then(() => {
                                    populateTable();
                                    toggleEditRepairButton();
                                })
                            } else if (response.status === 'internal-error') {
                                Swal.fire({
                                    title: 'Error!',
                                    text: `${response.message}`,
                                    icon: 'error',
                                    confirmButtonColor: 'var(--bs-danger)'
                                })
                            }
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
                    });
                }
            })

        }
    });
    $("#finishRepairForm").on('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Finish Repair?",
            text: "Are you sure you want to finish this repair?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-success)',
            cancelButtonColor: 'var(--bs-danger)',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../backend/inventory-management/finishRepair.php",
                    data: {
                        repairId: $("#repairId_edit").val(),
                        inventoryId: $("#id_edit").val(),
                        date_repaired: $("#date_repaired").val(),
                        repair_remarks: $("#repair_remarks").val()
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
                                $("#finishRepairModal").modal('hide');
                                $("#repairDescription_edit").val("");
                                $("#gatepassNumber_edit").val("");
                                $("#repairDate_edit").val("");
                            })
                        } else if (response.status === 'internal-error') {
                            Swal.fire({
                                title: 'Error!',
                                text: `${response.message}`,
                                icon: 'error',
                                confirmButtonColor: 'var(--bs-danger)'
                            })
                        }
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
                });
            }
        })
    });
    $("#cancelEditRepairButton").on('click', function () {
        $.ajax({
            type: "GET",
            url: "../../backend/inventory-management/getRepair.php",
            data: {
                repairId: $("#repairId_edit").val()
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
                    const repairData = response.data[0];
                    $("#repairDescription_edit").val(repairData.repair_description);
                    $("#gatepassNumber_edit").val(repairData.gatepass_number);
                    $("#repairDate_edit").val(repairData.start_date);
                }
            }
        });
    });
});
