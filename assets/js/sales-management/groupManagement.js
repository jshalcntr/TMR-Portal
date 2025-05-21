$(document).ready(function () {
    const groupsTable = $('#groupsTable').DataTable({
        ajax: {
            url: "../../backend/sales-management/getAllGroups.php",
            type: "GET",
        },
        columns: [
            { data: "groupNumber" },
            { data: "groupName" },
            { data: "groupMembers" },
            {
                data: "id",
                render: function (data, type, row) {
                    return `
                    <div class="d-flex align-items-center justify-content-center" style="gap: 16px;">
                        <i class="fas fa-xl fa-pen-to-square text-primary editGroupDetailsBtn"
                            role="button"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Edit"
                            data-group-id="${data}"
                            data-bs-toggle="modal"
                            data-bs-target="#editGroupDetailsModal">
                        </i>
                        <i class="fas fa-xl fa-eraser text-danger archiveGroupBtn"
                            role="button"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Remove"
                            data-group-id="${data}"
                            data-bs-toggle="modal"
                            data-bs-target="#">
                        </i>
                    </div>
                    `
                }
            },
        ],
        destroy: true,
        serverSide: false,
        processing: true
    })

    groupsTable.on('draw', function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
});