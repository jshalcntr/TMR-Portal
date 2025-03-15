$(document).ready(function () {
    let requestTable = "";
    $("#viewRequestHistoryBtn").click(function (e) {
        // $.ajax({
        //     type: "GET",
        //     url: "../../backend/inventory-management/getPersonalRequests.php",
        //     data: {
        //         inventoryId: queriedId
        //     },
        //     success: function (response) {
        //         if(response.status === 'internal-error'){
        //             Swal.fire({
        //                 title: 'Error! ',
        //                 text: `${response.message}`,
        //                 icon: 'error',
        //                 confirmButtonColor: 'var(--bs-danger)'
        //             });
        //         }else if(response.status === 'success'){

        //         }
        //     }
        // });
        if (requestTable !== "") requestTable.destroy();
        requestTable = $('#requestHistoryTable').DataTable({
            ajax: {
                url: "../../backend/inventory-management/getPersonalRequests.php",
                type: "GET",
                data: function (d) {
                    d.inventoryId = queriedId
                }
            },
            dataSrc: function (response) {
                if (response.status === 'internal-error') {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });
                    return [];
                }
                return response.data;
            },
            columns: [
                { data: 'requestName' },
                { data: 'requestReason' },
                {
                    data: 'requestDatetime', render: function (data, type, row) {
                        return convertToReadableDateTime(data)
                    }
                },
                {
                    data: 'status', render: function (data, type, row) {
                        if (data === 'pending') {
                            return `<i class="fa-solid fa-circle text-warning fa-2xs glow-icon__pending"></i>`
                        } else if (data === 'accepted') {
                            return `<i class="fa-solid fa-circle text-primary fa-2xs glow-icon__accepted"></i>`
                        } else if (data === 'declined') {
                            return `<i class="fa-solid fa-circle text-danger fa-2xs glow-icon__declined"></i>`
                        }
                    }
                },
            ],
            dom: 't',
            destroy: true,
            serverSide: false,
            processing: true,
            order: [[2, 'desc']],
            columnDefs: [
                {
                    targets: [0, 1, 2, 3],
                    orderable: false
                },
                {
                    targets: [2],
                    type: "date",
                    orderDataType: "dom-data-order"
                }
            ],
            createdRow: function (row, data) {
                $('td', row).eq(2).attr('data-order', data.requestDatetime);
            }
        });
    });
});