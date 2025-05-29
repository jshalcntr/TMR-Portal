$(document).ready(function () {
    const groupsTable = $('#groupsTable').DataTable({
        ajax: {
            url: "../../backend/sales-management/getAllGroups.php",
            type: "GET"
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
                        <i class="fas fa-2x fa-pen-to-square text-primary editGroupDetailsBtn"
                            role="button"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Edit"
                            data-group-id="${data}"
                            data-bs-toggle="modal"
                            data-bs-target="#editGroupDetailsModal">
                        </i>
                        <i class="fas fa-2x fa-eraser text-danger archiveGroupBtn"
                            role="button"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Remove"
                            data-group-id="${data}">
                        </i>
                    </div>
                    `
                }
            },
        ],
        columnDefs: [
            {
                targets: [3],
                orderable: false
            },
        ],
        destroy: true,
        serverSide: false,
        processing: true
    })

    groupsTable.on('draw', function () {
        $('[data-toggle="tooltip"]').tooltip();
    })

    const groupingsTable = $("#groupingsTable").DataTable({
        ajax: {
            url: "../../backend/sales-management/getMembersGroupings.php",
            type: "GET",
            dataSrc: function (json) {
                const groupInitials = [...new Set(json.data.map(item => item.groupInitials))]
                const filterGroupInitials = $("#filterGroupInitials");
                filterGroupInitials.empty().append(new Option("All", ""));
                groupInitials.forEach(groupInitial => {
                    filterGroupInitials.append(new Option(groupInitial, groupInitial));
                });

                const groupNumber = [...new Set(json.data.map(item => item.groupNumber))]
                const filterGroupNumber = $("#filterGroupNumber");
                filterGroupNumber.empty().append(new Option("All", ""));
                groupNumber.forEach(groupInitial => {
                    filterGroupNumber.append(new Option(groupInitial, groupInitial));
                });

                return json.data
            }
        },
        columns: [
            { data: "fullName" },
            { data: "groupInitials" },
            { data: "groupNumber" },
            { data: "sectionName" },
            {
                data: "accountId",
                render: function (data, type, row) {
                    return `
                    <div class="d-flex align-items-center justify-content-center" style="gap: 16px;">
                        <i class="fas fa-2x fa-arrow-right-arrow-left text-primary moveMemberBtn"
                            role="button"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Move Member"
                            data-account-id="${data}"
                            data-bs-toggle="modal"
                            data-bs-target="#moveMemberModal">
                        </i>
                        <i class="fas fa-2x fa-user-minus text-danger removeMemberBtn"
                            role="button"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Remove Member"
                            data-account-id="${data}">
                        </i>
                    </div>
                    `
                }
            },
        ],
        columnDefs: [
            {
                targets: [1, 2, 4],
                orderable: false
            }
        ],
        destroy: true,
        serverSide: false,
        processing: true
    })

    $("#filterGroupInitiatls, #filterGroupNumber").on('change', function () {
        const groupInitials = $("#filterGroupInitiatls").val();
        if (groupInitials) {
            groupingsTable.column(1).search(groupInitials).draw();
        } else {
            groupingsTable.column(1).search("").draw();
        }
        const groupNumber = $("#filterGroupNumber").val();
        if (groupNumber) {
            groupingsTable.column(2).search(groupNumber).draw();
        } else {
            groupingsTable.column(2).search("").draw();
        }
    });
    groupingsTable.on('draw', function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
});