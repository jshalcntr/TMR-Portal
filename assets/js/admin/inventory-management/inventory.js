//? DATA TABLES
const populateTable = () => {
    $.ajax({
        type: "GET",
        url: "../../../backend/admin/inventory-management/getAllInventory.php",
        success: function (response) {
            if (response.status === "internal-error") {
                Swal.fire({
                    title: "Error!",
                    text: `${response.message}`,
                    icon: "error",
                    confirmButtonColor: "var(--bs-danger)",
                });
            } else {
                if ($.fn.DataTable.isDataTable("#inventoryTable")) {
                    $("#inventoryTable").DataTable().destroy();
                }
                const table = $("#inventoryTable").DataTable({
                    data: response.data,
                    columns: [
                        { data: "faNumber" },
                        { data: "user" },
                        { data: "computerName" },
                        { data: "itemType" },
                        { data: "itemCategory" },
                        { data: "brand" },
                        { data: "model" },
                        { data: "dateAcquiredReadable" },
                        { data: "supplier" },
                        { data: "serialNumber" },
                        { data: "department" },
                        {
                            data: "status",
                        },
                        { data: "pricePhp" },
                        { data: "remarks" },
                        {
                            data: "id",
                            render: function (data) {
                                return `<i class="fas fa-eye text-primary viewInventoryBtn" 
                                        role="button" data-inventory-id="${data}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewInventoryModal"
                                        ></i>`;
                            },
                        },
                    ],
                    destroy: true,
                    serverSide: false,
                    processing: true,
                    order: [[7, "desc"]],
                    columnDefs: [
                        {
                            targets: [3, 4, 10, 11],
                            orderable: false
                        },
                        {
                            targets: [7],
                            type: "date",
                            orderDataType: "dom-data-order"
                        }
                    ],
                    createdRow: function (row, data) {
                        $('td', row).eq(7).attr('data-order', data.dateAcquired);
                    }
                });

                populateDropdown("#filterItemType", table, 3);
                populateDropdown("#filterCategory", table, 4);
                populateDropdown("#filterDepartment", table, 10);
                populateDropdown("#filterStatus", table, 11);

                $("#filterItemType, #filterCategory, #filterDepartment, #filterStatus").on("change", function () {
                    if ($("#filterItemType").val() === 'Accessories') {
                        $("#filterCategory").prop('hidden', false);
                    } else {
                        $("#filterCategory").prop('hidden', true).val('');
                    }
                    table.draw();
                });

                $("#filterCategory").empty().append(
                    `
                    <option value="">All</option>
                    `
                );


                $.ajax({
                    type: "GET",
                    url: "../../../backend/admin/inventory-management/getCategories.php",
                    success: function (response) {
                        if (response.status === "internal-error") {
                            Swal.fire({
                                title: "Error!",
                                text: `${response.message}`,
                                icon: "error",
                                confirmButtonColor: "var(--bs-danger)",
                            });
                        } else {
                            const categories = response.data;
                            categories.forEach((category) => {
                                $("#filterCategory").append(
                                    $('<option>', {
                                        value: category.item_category,
                                        text: category.item_category,
                                    })
                                );
                            });
                        }
                    }
                });

                $.fn.dataTable.ext.search = [
                    function (settings, data) {
                        const itemType = $("#filterItemType").val();
                        const itemCategory = $("#filterCategory").val();
                        const department = $("#filterDepartment").val();
                        const status = $("#filterStatus").val();

                        const matchesItemType = itemType === "" || data[3] === itemType; // Column 1: Item Type
                        const matchesCategory = itemCategory === "" || data[4] === itemCategory; // Column 2: Item Category
                        const matchesDepartment = department === "" || data[10] === department; // Column 9: Department
                        const matchesStatus = status === "" || data[11] === status; // Column 10: Status

                        return matchesItemType && matchesCategory && matchesDepartment && matchesStatus;
                    },
                ];
            }
        },
    });
};

const populateDropdown = (selector, table, columnIndex) => {
    const columnData = table.column(columnIndex).data().unique().sort();
    $(selector).empty().append(new Option("All", ""));
    columnData.each((value) => {
        $(selector).append(new Option(value, value));
    });
};

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
                $("#computerName_edit").val(inventoryData.computer_name);
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
    $('[data-bs-toggle="tooltip"]').tooltip();
});