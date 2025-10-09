$(document).ready(function () {
    let viewInquiriesByProspectTable = "";
    $(".prospectCard").click(function (e) {
        e.preventDefault();

        const prospectType = $(this).data('prospect-type');
        let prospectLogo = "";
        let headerBg = "";
        let textColor = "";
        let buttonColor = "";

        if (prospectType === "Hot") {
            prospectLogo = `<i class="fas fa-fire"></i>`;
            headerBg = "bg-danger";
            textColor = "text-danger";
            buttonColor = "btn-danger";
        } else if (prospectType === "Warm") {
            prospectLogo = `<i class="fas fa-mitten"></i>`;
            headerBg = "bg-warning";
            textColor = "text-warning";
            buttonColor = "btn-warning";
        } else if (prospectType === "Cold") {
            prospectLogo = `<i class="fas fa-snowflake"></i>`;
            headerBg = "bg-info";
            textColor = "text-info";
            buttonColor = "btn-info";
        } else if (prospectType === "Lost") {
            prospectLogo = `<i class="fas fa-person-circle-question"></i>`
            headerBg = "bg-secondary";
            textColor = "text-secondary";
            buttonColor = "btn-secondary";
        }

        $("#selectedProspectType").html(`${prospectLogo} ${prospectType}`);
        $("#viewInquiriesByProspectModal .modal-header").removeClass("bg-primary bg-danger bg-warning bg-info bg-secondary").addClass(headerBg + " text-white");
        $("#updateInquiryByProspectModal .modal-header").removeClass("bg-primary bg-danger bg-warning bg-info bg-secondary").addClass(headerBg + " text-white");
        $("#viewInquiryDetailsByProspectModal .modal-header").removeClass("bg-primary bg-danger bg-warning bg-info bg-secondary").addClass(headerBg + " text-white");
        $("#viewInquiriesByProspectTable thead tr th").removeClass("bg-primary bg-danger bg-warning bg-info bg-secondary").addClass(headerBg + " text-white");
        $("#viewInquiryDetailsByProspectModal button").removeClass("btn-primary btn-danger btn-warning btn-info btn-secondary").addClass(buttonColor + " text-white");
        $("#updateInquiryByProspectModal button").removeClass("btn-primary btn-danger btn-warning btn-info btn-secondary").addClass(buttonColor + " text-white");

        $("#viewInquiriesByProspectModal").modal('show');

        viewInquiriesByProspectTable = $("#viewInquiriesByProspectTable").DataTable({
            ajax: {
                url: "../../backend/sales-management/getInquiriesByProspect.php",
                type: "GET",
                data: {
                    prospectType: prospectType
                }
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
                            <i class="fas fa-circle-ellipsis fa-lg ${textColor} viewInquiryDetailsByProspectBtn" role="button" data-inquiry-id="${row.inquiryId}" data-bs-target="#viewInquiryDetailsByProspectModal"></i>
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
        viewInquiriesByProspectTable.on('draw', function () {
            $("#viewInquiriesByProspectTable_wrapper .active .page-link")
                .removeClass("bg-primary bg-danger bg-warning bg-info bg-secondary text-white")
                .addClass(headerBg + " text-white");
        });
    });
});