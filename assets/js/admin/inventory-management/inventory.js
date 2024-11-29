//? DATA TABLES
const populateTable = () => {
    $.ajax({
        type: "GET",
        url: "../../../backend/admin/inventory-management/getAllInventory.php",
        success: function (response) {
            if (response.status === 'internal-error') {
                Swal.fire({
                    title: 'Error!',
                    text: `${response.message}`,
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                });
            } else {
                if ($.fn.DataTable.isDataTable("#inventoryTable")) {
                    $("#inventoryTable").DataTable().destroy();
                }

                $.fn.dataTable.ext.order['dom-data-order-num'] = function (settings, col) {
                    return this.api().column(col, { order: 'index' }).nodes().map(function (td) {
                        return parseFloat($(td).data('order')) || 0;
                    });
                };

                $("#inventoryTable").DataTable({
                    data: response.data,
                    columns: [
                        { data: "faNumber" },
                        { data: "itemType" },
                        { data: "itemCategory" },
                        { data: "brand" },
                        { data: "model" },
                        { data: "dateAcquiredReadable" },
                        { data: "supplier" },
                        { data: "serialNumber" },
                        { data: "user" },
                        { data: "department" },
                        { data: "status" },
                        { data: "pricePhp" },
                        { data: "remarks" },
                        {
                            data: "id",
                            render: function (data, type, row) {
                                return `<i class="fas fa-eye text-primary viewInventoryBtn" 
                                        role="button" data-inventory-id="${data}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewInventoryModal"></i>`;
                            }
                        }
                    ],
                    destroy: true,
                    serverSide: false,
                    processing: true,
                    columnDefs: [{
                        targets: [5],
                        type: "date",
                        orderDataType: "dom-data-order"
                    }],
                    order: [
                        [5, "desc"]
                    ],
                });
            }
        }
    });
}

const fetchAllRepairs = (queriedId) => {
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
                $("#itemCategory_edit").val(inventoryData.item_category);
                $("#itemBrand_edit").val(inventoryData.brand);
                $("#itemModel_edit").val(inventoryData.model);
                $("#itemSpecification_edit").val(inventoryData.item_specification);
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
                                            <td class="remarks-column">${allRepairs[i].remarks === null ? "N/A" : allRepairs[i].remarks}</td>
                                        </tr>`;
                            }
                            $("#totalRepairs").text(allRepairs.length);
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
}
$(document).ready(function () {
    populateTable();
});