$(document).ready(function () {
    const subProfileTable = $("#subProfileTable").DataTable({
        ajax: {
            url: "../../backend/sales-management/getSubProfiles.php",
            type: "GET",
        },
        columns: [
            { data: "clientFirstName" },
            { data: "csNumber" },
            { data: "inquiryDate" },
            { data: "phone" },
            { data: "gender" },
            { data: "jobLevel" },
            { data: "workNature" },
            {
                data: "id",
                render: function (data, type, row) {
                    return `<i class="fas fa-xl fa-circle-info viewSubProfileModal text-primary" data-sub-profile-id="${data}" role="button" data-bs-toggle="modal" data-bs-target="#viewSubProfilingModal"></i>`;
                },
            },
        ],
        columnDefs: [
            {
                targets: [3],
                orderable: false
            },
        ]
        ,
        destroy: true,
        serverSide: false,
        processing: true,
    });
});
