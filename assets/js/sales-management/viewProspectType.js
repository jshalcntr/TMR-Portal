function initializeProspectTable(tableId, url, modalId) {
    $(`#${tableId}`).DataTable({
        ajax: {
            url: url,
            type: "GET",
            dataSrc: "",
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                console.log("Status:", status);
                console.log("Response Text:", xhr.responseText);
            },
        },
        columns: [
            { data: "customerFirstName" },
            { data: "inquiryDate" },
            { data: "inquirySource" },
            { data: "contactNumber" },
            { data: "gender" },
            { data: "maritalStatus" },
            { data: "birthday" },
            {
                data: "id",
                render: function (data) {
                    return `
                    <i class="fas fa-circle-info fa-lg text-primary"role="button" data-bs-toggle="modal" data-bs-target="#${modalId}" data-inquiry-id="${data}"></i>`;
                },
            },
        ],
        destroy: true,
        processing: true,
    });
}

initializeProspectTable(
    "prospectTypeWarmTable",
    "../../backend/sales-management/getProspectTypeWarm.php",
    "prospectTypeWarmModal"
);
initializeProspectTable(
    "prospectTypeHotTable",
    "../../backend/sales-management/getProspectTypeHot.php",
    "viewProspectTypeHotModal"
);
initializeProspectTable(
    "prospectTypeColdTable",
    "../../backend/sales-management/getProspectTypeCold.php",
    "prospectTypeColdModal"
);
