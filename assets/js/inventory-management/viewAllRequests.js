$(document).ready(function () {
    $("#viewAllRequestsBtn").on('click', function () {
        let target = $(this).attr('data-bs-target');
        $(target).modal('show');
        $("#viewInventoryModal").modal('hide');
    });
    $("#viewAllRequestsModal").on('hidden.bs.modal', function () {
        if (!$("#viewInventoryModal").hasClass('show') && !$("#viewRequestModal").hasClass("show")) {
            $("#viewInventoryModal").modal('show');
        }
    });
    $("#viewRequestModal").on('hidden.bs.modal', function () {
        $("#viewAllRequestsModal").modal('show');
    });

    let viewAllRequestsTable = "";

    $("#viewAllRequestsBtn").click(function (e) {
        if (viewAllRequestsTable !== "") viewAllRequestsTable.destroy();

        viewAllRequestsTable = $('#allRequestsTable').DataTable({
            ajax: {
                url: "../../backend/inventory-management/getAllRequests.php",
                type: "GET",
                data: function (d) {
                    d.inventoryId = queriedId
                }
            },
            columns: [
                { data: "requestName" },
                { data: "requestReason" },
                {
                    data: "requestDatetime",
                    render: function (data, type, row) {
                        return convertToReadableDate(data)
                    }
                },
                { data: "requestor" },
                {
                    data: "requestId",
                    render: function (data, type, row) {
                        return `<i class="fas fa-eye text-primary viewRequestBtn" 
                                role="button" data-request-id="${data}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewRequestModal"
                                ></i>`;
                    }
                },
            ],
            dom: 't',
            destroy: true,
            serverSide: false,
            processing: false,
            order: [[2, 'desc']],
            columnDefs: [
                {
                    targets: [0, 1, 2, 3, 4],
                    orderable: false
                },
                {
                    targets: [2],
                    type: "date",
                    orderDataType: "dom-data-order"
                }
            ],
            createdRow: function (row, data) {
                $('td', row).eq(2).attr('data-order', data.requestDate);
            }
        });
    });
});