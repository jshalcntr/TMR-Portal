$(document).ready(function () {

    let editInventoryValidationTimeout;
    $(document).on('click', '.viewInventoryBtn', function (e) {
        e.preventDefault();
        if (!$("#itemType_edit").prop('disabled')) {
            toggleEditModal();
        }
        if (editInventoryValidationTimeout) {
            clearTimeout(editInventoryValidationTimeout);
        }
        $("#editInventoryForm").removeClass('was-validated');

        const queriedId = $(this).data('inventory-id');

        $.ajax({
            type: "GET",
            url: "../../../backend/admin/inventory-management/getInventory.php",
            data: {
                id: queriedId
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
                    const inventoryData = response.data[0];
                    $("#assetNumber_edit").text((inventoryData.fa_number) ? inventoryData.fa_number : "Non-Fixed Asset");
                    $("#itemType_edit").val(inventoryData.item_type);
                    $("#itemName_edit").val(inventoryData.item_name);
                    $("#itemBrand_edit").val(inventoryData.brand);
                    $("#itemModel_edit").val(inventoryData.model);
                    $("#user_edit").val(inventoryData.user);
                    $("#department_edit").val(inventoryData.department);
                    $("#dateAcquired_edit").val(inventoryData.date_acquired);
                    $("#supplierName_edit").val(inventoryData.supplier);
                    $("#serialNumber_edit").val(inventoryData.serial_number);
                    $("#status_edit").val(inventoryData.status);
                    $("#price_edit").val(inventoryData.price);
                    $("#remarks_edit").val(inventoryData.remarks);
                    $("#id_edit").val(queriedId);

                    if (inventoryData.status === "Retired") {
                        if ($("#viewActionsRow").hasClass('d-flex')) {
                            $("#viewActionsRow").removeClass('d-flex');
                            $("#viewActionsRow").addClass('d-none');
                        }
                        if ($("#retiredActionsRow").hasClass("d-none")) {
                            $("#retiredActionsRow").removeClass("d-none");
                            $("#retiredActionsRow").addClass("d-flex");
                        }

                        $.ajax({
                            type: "GET",
                            url: "../../../backend/admin/inventory-management/getDisposal.php",
                            data: {
                                inventoryId: queriedId
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
                                    const disposalData = response.data;
                                    if (disposalData.length == 0) {
                                        if ($("#disposeButton").hasClass("d-none")) {
                                            $("#disposeButton").removeClass("d-none");
                                        }
                                    } else {
                                        if (!$("#disposeButton").hasClass("d-none")) {
                                            $("#disposeButton").addClass("d-none");
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        if ($("#viewActionsRow").hasClass('d-none')) {
                            $("#viewActionsRow").removeClass('d-none');
                            $("#viewActionsRow").addClass('d-flex');
                        }
                        if ($("#retiredActionsRow").hasClass("d-flex")) {
                            $("#retiredActionsRow").removeClass("d-flex");
                            $("#retiredActionsRow").addClass("d-none");
                        }
                    }

                    $.ajax({
                        type: "GET",
                        url: "../../../backend/admin/inventory-management/getAllRepairs.php",
                        data: {
                            inventoryId: queriedId
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
                                const allRepairs = response.data;
                                let html = "";
                                for (let i = 0; i < allRepairs.length; i++) {
                                    html += `<tr> +
                                                <td>${allRepairs[i].repair_description}</td>
                                                <td>${allRepairs[i].gatepass_number}</td>
                                                <td>${convertToReadableDate(allRepairs[i].start_date)}</td>
                                                <td>${convertToReadableDate(allRepairs[i].end_date)}</td>
                                                <td>${allRepairs[i].remarks === null ? "N/A" : allRepairs[i].remarks}</td>
                                            </tr>`;
                                }
                                $("#repairHistory").html(html);
                            }
                        }
                    });
                    if (inventoryData.status === "Active" || inventoryData.status === "Repaired") {
                        if ($("#noRepairColumn").hasClass('d-none')) {
                            $("#noRepairColumn").removeClass('d-none');
                        }
                        if (!$("#underRepairColumn").hasClass("d-none")) {
                            $("#underRepairColumn").addClass('d-none');
                        }
                    } else if (inventoryData.status === "Under Repair") {
                        $.ajax({
                            type: "GET",
                            url: "../../../backend/admin/inventory-management/getLatestRepair.php",
                            data: {
                                inventoryId: queriedId
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
                                    const latestRepair = response.data[0];
                                    $("#repairId_edit").val(latestRepair.repair_id);
                                    $("#repairDescription_edit").val(latestRepair.repair_description);
                                    $("#gatepassNumber_edit").val(latestRepair.gatepass_number);
                                    $("#repairDate_edit").val(latestRepair.start_date);
                                }
                            }
                        });

                        if ($("#underRepairColumn").hasClass('d-none')) {
                            $("#underRepairColumn").removeClass('d-none');
                        }
                        if (!$("#noRepairColumn").hasClass("d-none")) {
                            $("#noRepairColumn").addClass('d-none');
                        }
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log(xhr.responseText);
            }
        });
    });

    const toggleEditModal = () => {
        $("#itemType_edit").prop('disabled', !$("#itemType_edit").prop('disabled'));
        $("#itemName_edit").prop('disabled', !$("#itemName_edit").prop('disabled'));
        $("#itemBrand_edit").prop('disabled', !$("#itemBrand_edit").prop('disabled'));
        $("#itemModel_edit").prop('disabled', !$("#itemModel_edit").prop('disabled'));
        $("#user_edit").prop('disabled', !$("#user_edit").prop('disabled'));
        $("#department_edit").prop('disabled', !$("#department_edit").prop('disabled'));
        $("#dateAcquired_edit").prop('disabled', !$("#dateAcquired_edit").prop('disabled'));
        $("#supplierName_edit").prop('disabled', !$("#supplierName_edit").prop('disabled'));
        $("#serialNumber_edit").prop('disabled', !$("#serialNumber_edit").prop('disabled'));
        $("#price_edit").prop('disabled', !$("#price_edit").prop('disabled'));
        $("#remarks_edit").prop('disabled', !$("#remarks_edit").prop('disabled'));

        $("#viewActionsRow").toggleClass('d-flex');
        $("#viewActionsRow").toggleClass('d-none');
        $("#editActionsRow").toggleClass('d-flex');
        $("#editActionsRow").toggleClass('d-none');
    }
    $("#editButton").on('click', function () {
        toggleEditModal();
    });
    $("#cancelButton").on('click', function () {
        toggleEditModal();

        const queriedId = $("#id_edit").val();

        $.ajax({
            type: "GET",
            url: "../../../backend/admin/inventory-management/getInventory.php",
            data: {
                id: queriedId
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

                    const inventoryData = response.data[0];

                    $("#assetNumber_edit").text((inventoryData.fa_number) ? inventoryData.fa_number : "Non-Fixed Asset");
                    $("#itemType_edit").val(inventoryData.item_type);
                    $("#itemName_edit").val(inventoryData.item_name);
                    $("#itemBrand_edit").val(inventoryData.brand);
                    $("#itemModel_edit").val(inventoryData.model);
                    $("#user_edit").val(inventoryData.user);
                    $("#department_edit").val(inventoryData.department);
                    $("#dateAcquired_edit").val(inventoryData.date_acquired);
                    $("#supplierName_edit").val(inventoryData.supplier);
                    $("#serialNumber_edit").val(inventoryData.serial_number);
                    $("#status_edit").val(inventoryData.status);
                    $("#price_edit").val(inventoryData.price);
                    $("#remarks_edit").val(inventoryData.remarks);
                    $("#id_edit").val(queriedId);
                }
            }
        });
    });

    const editInventoryForm = $("#editInventoryForm");

    editInventoryForm.each(function () {
        $(this).submit(function (e) {
            e.preventDefault();
            if (editInventoryValidationTimeout) {
                clearTimeout(editInventoryValidationTimeout);
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
                        $.ajax({
                            type: "POST",
                            url: "../../../backend/admin/inventory-management/editInventory.php",
                            data: formData,
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: `${response.message}`,
                                        icon: 'success',
                                        confirmButtonColor: 'var(--bs-success)'
                                    }).then(() => {
                                        window.location.reload();
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
            $(this).addClass('was-validated');
            editInventoryValidationTimeout = setTimeout(() => {
                $(this).removeClass('was-validated');
            }, 3000);
        });
    });

    $("#retireInventoryButton").on('click', function () {
        Swal.fire({
            title: "Retire Inventory?",
            text: "Are you sure you want to retire this inventory?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-success)',
            cancelButtonColor: 'var(--bs-danger)',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const queriedId = $("#id_edit").val();
                $.ajax({
                    type: "POST",
                    url: "../../../backend/admin/inventory-management/retireInventory.php",
                    data: {
                        id: queriedId
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: `${response.message}`,
                                icon: 'success',
                                confirmButtonColor: 'var(--bs-success)'
                            }).then(() => {
                                window.location.reload();
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

    $("#disposeButton").on('click', function () {
        $("#viewInventoryModal").modal('hide');
        $("#disposeInventoryModal").modal('show');
    });

    $("#disposeInventoryModal").on('hidden.bs.modal', function () {
        $("#viewInventoryModal").modal('show');
    });

    $("#addToDisposalForm").on('submit', function (e) {
        e.preventDefault();

        const inventoryId = $("#id_edit").val();
        const formData = $(this).serialize();
        const fullData = `${formData}&inventoryId=${encodeURIComponent(inventoryId)}`

        $.ajax({
            type: "POST",
            url: "../../../backend/admin/inventory-management/disposeInventory.php",
            data: fullData,
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: `${response.message}`,
                        icon: 'success',
                        confirmButtonColor: 'var(--bs-success)'
                    }).then(() => {
                        window.location.reload();
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
    });
});