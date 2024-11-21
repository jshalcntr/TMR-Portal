$(document).ready(function () {
    $('#forDisposalTable').DataTable({
        "columnDefs": [{
            "targets": [5],
            "type": "date",
            "orderDataType": "dom-data-order"
        }],
        "order": [
            [5, "desc"]
        ],
    });
});