$(document).ready(function () {
    let viewInquiryTable = "";

    $("#viewInquiriesBtn").on('click', function () {
        viewInquiryTable = $("#viewInquiriesTable").DataTable({
            ajax: {
                url: "../../backend/sales-management/getInquiries.php",
                type: "GET",
            },
            dataSrc: function (response) {
                if (response.status === "internal-error") {
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
                {
                    data: "customerFirstName",
                    render: function (data, type, row) {
                        return `${row.customerFirstName} ${row.customerLastName}`;
                    }
                },
                { data: "prospectType" },
                {
                    data: "inquiryDateReadable",
                    render: function (data) {
                        return data ? data.toUpperCase() : "N/A";
                    }
                },
                { data: "unitInquired" },
                {
                    data: "appointmentDateReadable",
                    render: function (data) {
                        return data ? data.toUpperCase() : "N/A";
                    }
                },
                {
                    data: "inquiryId",
                    render: function (data, type, row) {
                        return `
                            <i class="fas fa-circle-ellipsis fa-lg text-primary viewInquiryDetailsBtn" role="button" data-inquiry-id="${row.inquiryId}" data-bs-target="#viewInquiryDetailsModal"></i>
                        `;
                    }
                },
            ],
            destroy: true,
            serverSide: false,
            processing: false,
            order: [[2, 'desc']],
            columnDefs: [
                {
                    targets: [5],
                    orderable: false
                },
                {
                    targets: [2],
                    type: "date",
                    orderDataType: "dom-data-order"
                }
            ],
            createdRow: function (row, data) {
                $('td', row).eq(2).attr('data-order', data.inquiryDate);
            }
        })
    });

    $(document).on("click", ".viewInquiryDetailsBtn", function () {
        $("#viewInquiryModal").modal("hide");
        $("#viewInquiryModalDetails").modal("show");
    });

    $("#viewInquiryModalDetails").on("hidden.bs.modal", function () {
        $("#viewInquiryModal").modal("show");
    });
});