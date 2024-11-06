//? DATA TABLES
$(document).ready(function() {
    $('#inventoryTable').DataTable({
        "columnDefs": [{
            "targets": [5],
            "type": "date",
            "orderDataType": "dom-data-order"
        }],
        "order": [
            [0, "desc"]
        ],
    });
});