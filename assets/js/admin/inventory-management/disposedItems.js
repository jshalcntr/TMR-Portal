let disposedTable;
$(document).ready(function () {
    $("#disposedListTable").DataTable({
        ajax: {
            url: "../../../backend/admin/inventory-management/getAllDisposed.php",
            type: "GET",
        },
        columns: [
            { data: "disposedDateReadable" },
            {
                data: "scannedFile",
                render: function (data, type, row) {
                    return `<a class="text-danger " href="${data}" target="_blank"><i class="fa-solid fa-file-pdf fa-2x"></i></a>`
                }
            },
            {
                data: "disposedId",
                render: function (data, type, row) {
                    return `<i class="fas fa-eye fa-2x text-primary view-disposed-modal" role="button" data-disposed-id="${data}" data-bs-toggle="modal" data-bs-target="#viewDisposedInventoryModal"></i>`
                }
            }
        ],
        createdRow: function (row, data, dataIndex) {
            $('td', row).eq(0).attr('data-order', data.disposedDate);
        }
        ,
        columnDefs: [{
            targets: 0,
            type: "date",
            orderDataType: "dom-data-order"
        }],
        order: [
            [0, "desc"],
        ],
        serverSide: false,
        processing: true
    })

});
$(document).on('click', '.view-disposed-modal', function () {
    let disposedId = $(this).data('disposed-id');

    if ($.fn.DataTable.isDataTable('#disposedItemsTable')) {
        disposedTable.destroy();
        $("#disposedItemsTable tbody").empty();
    }

    disposedTable = $("#disposedItemsTable").DataTable({
        ajax: {
            url: '../../../backend/admin/inventory-management/getAllDisposedItems.php',
            type: 'GET',
            data: {
                disposedId: disposedId
            }
        },
        columns: [
            { data: "faNumber" },
            { data: "itemType" },
            { data: "user" },
            { data: "department" }
        ],
        order: [
            [0, "desc"]
        ],
        processing: true,
        serverSide: false
    })
});