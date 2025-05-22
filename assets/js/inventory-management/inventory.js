//? DATA TABLES
const populateTable = () => {
    $.ajax({
        type: "GET",
        url: "../../backend/inventory-management/getAllInventory.php",
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
                        {
                            data: "pricePhp",
                            render: function (data, type, row) {
                                return type === "display" ? data : parseFloat(data.replace(/[^\d.]/g, "")) || 0;
                            }
                        },
                        { data: "remarks" },
                        {
                            data: "id",
                            render: function (data) {
                                return `<i class="fas fa-eye text-primary viewInventoryBtn fa-xl" 
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
                            targets: [1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 13, 14],
                            orderable: false
                        },
                        {
                            targets: [7],
                            type: "date",
                            orderDataType: "dom-data-order"
                        },
                        {
                            targets: [12],
                            type: "num"
                        }
                    ],
                    createdRow: function (row, data) {
                        $('td', row).eq(7).attr('data-order', data.dateAcquired);
                    }
                });

                populateDropdown("#filterItemType", table, 3);
                populateDropdown("#filterCategory", table, 4);
                populateDropdown("#filterBrand", table, 5);
                populateDropdown("#filterSupplier", table, 8);
                populateDropdown("#filterDepartment", table, 10);
                populateDropdown("#filterStatus", table, 11);

                $("#filterItemType, #filterCategory, #filterBrand, #filterSupplier, #filterDepartment, #filterStatus").on("change", function () {
                    table.draw();

                    const allFilters = [
                        "#filterItemType",
                        "#filterCategory",
                        "#filterBrand",
                        "#filterSupplier",
                        "#filterDepartment",
                        "#filterStatus"
                    ];

                    allFilters.forEach((filter) => {
                        const columnIndex = $(filter).data("column-index");
                        if ($(filter).val() === "") {
                            console.log(columnIndex);
                            updateDropdown(filter, table, columnIndex);
                        }
                    })
                });

                // $("#filterCategory").empty().append(
                //     `
                //     <option value="">All</option>
                //     `
                // );


                // $.ajax({
                //     type: "GET",
                //     url: "../../backend/inventory-management/getCategories.php",
                //     success: function (response) {
                //         if (response.status === "internal-error") {
                //             Swal.fire({
                //                 title: "Error!",
                //                 text: `${response.message}`,
                //                 icon: "error",
                //                 confirmButtonColor: "var(--bs-danger)",
                //             });
                //         } else {
                //             const categories = response.data;
                //             categories.forEach((category) => {
                //                 $("#filterCategory").append(
                //                     $('<option>', {
                //                         value: category.item_category,
                //                         text: category.item_category,
                //                     })
                //                 );
                //             });
                //         }
                //     }
                // });

                $.fn.dataTable.ext.search = [
                    function (settings, data) {
                        const itemType = $("#filterItemType").val();
                        const itemCategory = $("#filterCategory").val();
                        const brand = $("#filterBrand").val();
                        const supplier = $("#filterSupplier").val();
                        const department = $("#filterDepartment").val();
                        const status = $("#filterStatus").val();

                        const matchesItemType = itemType === "" || data[3] === itemType; // Column 1: Item Type
                        const matchesCategory = itemCategory === "" || data[4] === itemCategory; // Column 2: Item Category
                        const matchesBrand = brand === "" || data[5] === brand; // Column 2: Brand
                        const matchesSupplier = supplier === "" || data[8] === supplier; // Column 7: Supplier
                        const matchesDepartment = department === "" || data[10] === department; // Column 9: Department
                        const matchesStatus = status === "" || data[11] === status; // Column 10: Status

                        return matchesItemType && matchesCategory && matchesBrand && matchesSupplier && matchesDepartment && matchesStatus;
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
const updateDropdown = (selector, table, columnIndex) => {
    const dropdown = $(selector);
    dropdown.empty().append(new Option("All", "")); // Reset dropdown

    let uniqueValues = new Set();

    // Iterate through only visible (filtered) rows
    table.rows({ filter: "applied" }).data().each((row) => {
        uniqueValues.add(row[table.column(columnIndex).dataSrc()]); // Get column data dynamically
    });

    // Populate dropdown with unique values
    uniqueValues.forEach((value) => {
        if (value) dropdown.append(new Option(value, value)); // Avoid blank values
    });

}

const fetchAllRepairs = (queriedId) => {
    $.ajax({
        type: "GET",
        url: "../../backend/inventory-management/getInventory.php",
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
                    if ($("#retiredActionsRow1").hasClass("d-none")) {
                        $("#retiredActionsRow1").removeClass("d-none");
                        $("#retiredActionsRow1").addClass("d-flex");
                    }
                    if ($("#retiredActionsRow2").hasClass("d-none")) {
                        $("#retiredActionsRow2").removeClass("d-none");
                        $("#retiredActionsRow2").addClass("d-flex");
                    }

                    $.ajax({
                        type: "GET",
                        url: "../../backend/inventory-management/getDisposal.php",
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
                    if ($("#retiredActionsRow1").hasClass("d-flex")) {
                        $("#retiredActionsRow1").removeClass("d-flex");
                        $("#retiredActionsRow1").addClass("d-none");
                    }
                    if ($("#retiredActionsRow2").hasClass("d-flex")) {
                        $("#retiredActionsRow2").removeClass("d-flex");
                        $("#retiredActionsRow2").addClass("d-none");
                    }
                }

                $.ajax({
                    type: "GET",
                    url: "../../backend/inventory-management/getAllRepairs.php",
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
                        url: "../../backend/inventory-management/getLatestRepair.php",
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

const fetchItemCategory = (typeId, categoryId) => {
    if ($(typeId).val() === '') {
        $(categoryId).val('');
        $(categoryId).prop('disabled', true);
    } else {
        $(categoryId).val($(typeId).val());
        $(categoryId).prop('disabled', false);
    }
    const itemCategories = {
        "": [""],
        "Computer System": ['Desktop', 'NUC', 'AIO', 'Laptop', 'Hybrid Laptop', 'Network Video Recorder'],
        "Computer Hardware": ['CPU Fan', 'Computer Case', 'Hard Drive', 'Motherboard', 'Optical Disk Drive', 'PowerSupply', 'Processor', 'RAM', 'Video Card'],
        "Computer Peripherals": ['CCTV', 'HDMI Splitter', 'Headset', 'Keyboard', 'Monitor', 'Monitor Bracket', 'Mouse', 'Printer', 'Scanner', 'Speaker', 'UPS', 'UPS Battery', 'Webcam', 'Wireless HDMI', 'External Storage'],
        "Network Peripherals": ['Access Point', 'POE Injector', 'Router', 'Switch'],
        "Audio & Visual Devices": ['Camera', 'Gimbal', 'HDMI Switcher', 'Microphone', 'Mixer', 'Speaker', 'Tripod', 'TV Bracket'],
        "MIS Tools": ['Crimping Tool', 'Drill', 'Hammer', 'Knockout Punch', 'Punching Tool', 'Screw Driver', 'Tester']
    }

    const itemType = $(typeId).val();
    $(categoryId).empty();

    $(categoryId).append(`<option value="" selected hidden>--Select Item Category--</option>`);

    if (itemType in itemCategories) {
        itemCategories[itemType].forEach(category => {
            $(categoryId).append(`<option value="${category}">${category}</option>`);
        });
    }
}
$(document).ready(function () {
    populateTable();
    $('[data-bs-toggle="tooltip"]').tooltip();
    $("#itemType").on("change", function () {
        const typeId = "#itemType"
        const categoryId = "#itemCategory"
        fetchItemCategory(typeId, categoryId);
    });
    $("#itemType_edit").on("change", function () {
        const typeId = "#itemType_edit"
        const categoryId = "#itemCategory_edit"
        fetchItemCategory(typeId, categoryId);
        $(categoryId).prop('disabled', true);
    });
});