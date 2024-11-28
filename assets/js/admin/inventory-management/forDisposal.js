$(document).ready(function () {
    // $('#forDisposalTable').DataTable({
    //     "columnDefs": [{
    //         "targets": [5],
    //         "type": "date",
    //         "orderDataType": "dom-data-order"
    //     }],
    //     "order": [
    //         [5, "desc"]
    //     ],
    // });
    $('#forDisposalTable').DataTable({
        "ajax": {
            "url": "../../../backend/admin/inventory-management/getAllForDisposals.php",
            "type": "GET",
            "dataSrc": function (json) {
                if (!json.data || json.data.length === 0) {
                    if ($("#forDisposalActions").hasClass("d-flex")) {
                        $("#forDisposalActions").removeClass("d-flex");
                        $("#forDisposalActions").addClass("d-none");
                    }
                } else {
                    if ($("#forDisposalActions").hasClass("d-none")) {
                        $("#forDisposalActions").addClass("d-flex");
                        $("#forDisposalActions").removeClass("d-none");
                    }
                }
                return json.data;
            }
        },
        "columns": [
            { "data": "faNumber" },
            { "data": "itemType" },
            { "data": "user" },
            { "data": "department" },
            { "data": "dateRetiredReadable" },
            { "data": "remarks" }
        ],
        "columnDefs": [{
            "targets": [4],
            "type": "date",
            "orderDataType": "dom-data-order"
        }],
        "createdRow": function (row, data, dataIndex) {
            $('td', row).eq(4).attr('data-order', data.dateRetired);
        },
        "order": [
            [4, "desc"]
        ],
        "serverSide": false,
        "processing": true
    });

    $('#disposableItemsTable').DataTable({
        "ajax": {
            "url": "../../../backend/admin/inventory-management/getAllForDisposals.php",
            "type": "GET",
            "dataSrc": function (json) {
                const ids = json.data.map(item => item.id);
                $("#disposableItemIds").val(JSON.stringify(ids));
                return json.data;
            }
        },
        "columns": [
            { "data": "faNumber" },
            { "data": "itemType" },
            { "data": "user" },
            { "data": "department" },
        ],
        "order": [
            [0, "desc"]
        ],
        "serverSide": false,
        "processing": true,
    });

    // $("#disposeItemsModal").on('click', function () {
    //     $('#disposableItemsTable').DataTable().ajax.reload();
    //     $('#forDisposalTable').DataTable().ajax.reload();
    // });

    $("#disposeItemsForm").on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "../../../backend/admin/inventory-management/uploadDisposalForm.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                Swal.fire({
                    title: "Uploading...",
                    text: "Please wait while the file is being uploaded.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
            },
            success: function (response) {
                Swal.close();
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: `${response.message}`,
                        icon: 'success',
                        confirmButtonColor: 'var(--bs-success)'
                    }).then(() => {
                        $('#disposableItemsTable').DataTable().ajax.reload();
                        $('#forDisposalTable').DataTable().ajax.reload();
                        $('#disposedListTable').DataTable().ajax.reload();
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        title: 'Error!',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    }).then(() => {
                        console.log(response);
                    });
                }
            }
        });
    });
});
