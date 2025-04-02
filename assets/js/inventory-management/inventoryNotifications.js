let requestNotificationId;
$(document).ready(function () {
    fetchNotificationCount();
    setInterval(() => {
        fetchNotificationCount();
    }, 2000);

    $("#viewRequestModalNotif").on("hidden.bs.modal", function () {
        $("#inventoryNotificationsBody").empty();

        $.ajax({
            type: "GET",
            url: "../../backend/inventory-management/getNotifications.php",
            success: function (response) {
                if (response.status === 'internal-error') {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });

                    $("#inventoryNotificationsBody").append(`
                        <div class='row no-notification-row justify-content-center align-items-center'>
                            <p class='my-3 w-auto text-gray-500;'>No notification available</p>
                        </div>
                    `);
                } else if (response.status === 'success') {
                    const notifications = response.data;
                    if (notifications.length > 0) {
                        const notificationsDataLength = notifications.length;
                        // for (let i = 0; i < notificationsDataLength; i++) {
                        //     if (i > 0 && i + 1 < notificationsDataLength) {
                        //         $("#inventoryNotificationsBody").append(`<hr>`);
                        //     }

                        //     $("#inventoryNotificationsBody").append(`
                        //         <div class="row notification-row" role="button">
                        //             <img src="../../assets/img/no-profile.png" style="width: 50px !important; height:50px !important; padding-left: 0px !important; padding-right: 0px !important;">
                        //             <div class="col">
                        //                 <div class="d-flex flex-row align-items-center">
                        //                     <p id="senderName" class="fw-bolder mb-0">Kian Querubin&nbsp;</p>
                        //                     <p id="notificationSubject" class="mb-0">creates new request.&nbsp;&nbsp;</p>
                        //                     <p id="notificationCreation" class="mb-0 text-gray-500"><sup>Just now</sup></p>
                        //                 </div>
                        //                 <div class="d-flex flex-row">
                        //                     <p id="notificationDescription" class="fs-6"><small>Absolute Deletion request for Non-Fixed Asset.</small></p>
                        //                 </div>
                        //             </div>
                        //             <i class="fa-solid fa-circle text-danger fa-2xs glow-icon__declined glow-icon"></i>
                        //         </div>
                        //     `);
                        // }
                        notifications.forEach((notification, index) => {
                            if (index > 0 && index < notificationsDataLength) {
                                $("#inventoryNotificationsBody").append(`<hr>`);
                            }
                            $("#inventoryNotificationsBody").append(`
                                <div class="row notification-row" role="button" data-notification-id="${notification.notification_id}" data-notification-type="${notification.notification_type}" data-inventory-id="${notification.inventory_id}" data-bs-toggle="modal" data-bs-target="#viewRequestModalNotif">
                                    <img src="${notification.sender_profile === 'no-link' ? '../../assets/img/no-profile.png' : notification.sender_profile}" style="width: 50px !important; height:50px !important; padding-left: 0px !important; padding-right: 0px !important;">
                                    <div class="col">
                                        <div class="d-flex flex-row align-items-center">
                                            <p id="senderName" class="fw-bolder mb-0">${notification.sender_name}&nbsp;</p>
                                            <p id="notificationSubject" class="mb-0">${notification.notification_subject}&nbsp;&nbsp;</p>
                                            <p id="notificationCreation" class="mb-0 text-gray-500"><sup>${formatTimeAgo(notification.notification_datetime)}</sup></p>
                                        </div>
                                        <div class="d-flex flex-row">
                                            <p id="notificationDescription" class="fs-6"><small>${notification.notification_description}</small></p>
                                        </div>
                                    </div>
                                    ${notification.isRead === 0 ? `<i class="fa-solid fa-circle text-danger fa-2xs glow-icon__declined glow-icon" ></i>` : ``}
                                </div>
                            `);
                        })
                    } else {
                        $("#inventoryNotificationsBody").append(`
                            <div class='row no-notification-row justify-content-center align-items-center'>
                                <p class='my-3 w-auto text-gray-500;'>No notification available</p>
                            </div>
                        `);
                    }
                }
            }
        });
        $("#inventoryNotifications").modal('show');
    });

    $("#viewInventoryNotificationsButton").on('click', function () {
        $("#inventoryNotificationsBody").empty();

        $.ajax({
            type: "GET",
            url: "../../backend/inventory-management/getNotifications.php",
            success: function (response) {
                if (response.status === 'internal-error') {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });

                    $("#inventoryNotificationsBody").append(`
                        <div class='row no-notification-row justify-content-center align-items-center'>
                            <p class='my-3 w-auto text-gray-500;'>No notification available</p>
                        </div>
                    `);
                } else if (response.status === 'success') {
                    const notifications = response.data;
                    if (notifications.length > 0) {
                        const notificationsDataLength = notifications.length;
                        // for (let i = 0; i < notificationsDataLength; i++) {
                        //     if (i > 0 && i + 1 < notificationsDataLength) {
                        //         $("#inventoryNotificationsBody").append(`<hr>`);
                        //     }

                        //     $("#inventoryNotificationsBody").append(`
                        //         <div class="row notification-row" role="button">
                        //             <img src="../../assets/img/no-profile.png" style="width: 50px !important; height:50px !important; padding-left: 0px !important; padding-right: 0px !important;">
                        //             <div class="col">
                        //                 <div class="d-flex flex-row align-items-center">
                        //                     <p id="senderName" class="fw-bolder mb-0">Kian Querubin&nbsp;</p>
                        //                     <p id="notificationSubject" class="mb-0">creates new request.&nbsp;&nbsp;</p>
                        //                     <p id="notificationCreation" class="mb-0 text-gray-500"><sup>Just now</sup></p>
                        //                 </div>
                        //                 <div class="d-flex flex-row">
                        //                     <p id="notificationDescription" class="fs-6"><small>Absolute Deletion request for Non-Fixed Asset.</small></p>
                        //                 </div>
                        //             </div>
                        //             <i class="fa-solid fa-circle text-danger fa-2xs glow-icon__declined glow-icon"></i>
                        //         </div>
                        //     `);
                        // }
                        notifications.forEach((notification, index) => {
                            if (index > 0 && index < notificationsDataLength) {
                                $("#inventoryNotificationsBody").append(`<hr>`);
                            }
                            $("#inventoryNotificationsBody").append(`
                                <div class="row notification-row" role="button" data-notification-id="${notification.notification_id}" data-notification-type="${notification.notification_type}" data-inventory-id="${notification.inventory_id}">
                                    <img src="${notification.sender_profile === 'no-link' ? '../../assets/img/no-profile.png' : notification.sender_profile}" style="width: 50px !important; height:50px !important; padding-left: 0px !important; padding-right: 0px !important;">
                                    <div class="col">
                                        <div class="d-flex flex-row align-items-center">
                                            <p id="senderName" class="fw-bolder mb-0">${notification.sender_name}&nbsp;</p>
                                            <p id="notificationSubject" class="mb-0">${notification.notification_subject}&nbsp;&nbsp;</p>
                                            <p id="notificationCreation" class="mb-0 text-gray-500"><sup>${formatTimeAgo(notification.notification_datetime)}</sup></p>
                                        </div>
                                        <div class="d-flex flex-row">
                                            <p id="notificationDescription" class="fs-6"><small>${notification.notification_description}</small></p>
                                        </div>
                                    </div>
                                    ${notification.isRead === 0 ? `<i class="fa-solid fa-circle text-danger fa-2xs glow-icon__declined glow-icon" ></i>` : ``}
                                </div>
                            `);
                        })
                    } else {
                        $("#inventoryNotificationsBody").append(`
                            <div class='row no-notification-row justify-content-center align-items-center'>
                                <p class='my-3 w-auto text-gray-500;'>No notification available</p>
                            </div>
                        `);
                    }
                }
            }
        });
    });

    $(document).on('click', '.notification-row', function () {
        const notificationId = $(this).data('notification-id');
        const notificationType = $(this).data('notification-type');
        const inventoryId = $(this).data('inventory-id');
        const glowIcon = $(this).children('.glow-icon');
        $.ajax({
            type: "POST",
            url: "../../backend/inventory-management/toggleNotification.php",
            data: {
                notificationId: notificationId
            },
            success: function (response) {
                if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error!',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    })
                } else if (response.status === "success") {
                    if (glowIcon.length > 0) {
                        glowIcon.remove();
                    }
                }
            }
        });

        if (notificationType === 'request_created') {
            $.ajax({
                type: "GET",
                url: "../../backend/inventory-management/getNotification.php",
                data: {
                    notificationId
                },
                success: function (response) {
                    if (response.status === "internal-error") {
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        })
                    } else if (response.status === "success") {
                        const notification = response.data[0];

                        requestNotificationId = notification.request_id;

                        $.ajax({
                            type: "GET",
                            url: "../../backend/inventory-management/getRequest.php",
                            data: {
                                requestId: requestNotificationId
                            },
                            success: function (response) {
                                if (response.status === 'internal-error') {
                                    Swal.fire({
                                        title: 'Error! ',
                                        text: `${response.message}`,
                                        icon: 'error',
                                        confirmButtonColor: 'var(--bs-danger)'
                                    });
                                } else if (response.status === 'success') {
                                    const requestInfo = response.data[0];
                                    $("#requestedByPicture_N").attr('src', requestInfo.profile_picture !== 'no-link' ? requestInfo.profile_picture : "../../assets/img/no-profile.png");
                                    $("#requestedBy_N").text(requestInfo.full_name);
                                    $("#faNumber_N").text(requestInfo.fa_number === "" ? "Non-Fixed Asset" : requestInfo.fa_number);
                                    $("#viewItemCategory_N").text(requestInfo.item_category);
                                    $("#viewComputerName_N").text(requestInfo.computer_name);
                                    $("#requestType_N").text(requestInfo.request_name);
                                    $("#requestReason_N").text(requestInfo.request_reason);
                                    if (requestInfo.request_status === "pending") {
                                        if ($("#requestAction_N").hasClass('d-none')) {
                                            $("#requestAction_N").removeClass('d-none');
                                        }
                                    } else {
                                        if (!$("#requestAction_N").hasClass('d-none')) {
                                            $("#requestAction_N").addClass('d-none');
                                        }
                                    }
                                    if (requestInfo.new_fa_number === null) {
                                        if (!$("#newFaNumberColumn_N").hasClass('d-none')) {
                                            $("#newFaNumberColumn_N").addClass('d-none');
                                        }
                                    } else {
                                        $("#newFaNumber_N").text(requestInfo.new_fa_number);
                                        if ($("#newFaNumberColumn_N").hasClass('d-none')) {
                                            $("#newFaNumberColumn_N").removeClass('d-none');
                                        }
                                    }
                                    $("#inventoryNotifications").modal('hide');
                                    $("#viewRequestModalNotif").modal('show');
                                }
                            }
                        });
                    }
                }
            });
        } else if (notificationType === "request_editFA_accepted" || notificationType === "request_unretire_accepted" || notificationType === "request_decline") {
            let editInventoryValidationTimeout;
            if (!$("#itemType_edit").prop('disabled')) {
                toggleEditModal();
            }
            if (editInventoryValidationTimeout) {
                clearTimeout(editInventoryValidationTimeout);
            }
            $("#editInventoryForm").removeClass('was-validated');

            queriedId = inventoryId;

            $.ajax({
                type: "GET",
                url: "../../backend/inventory-management/getInventory.php",
                data: {
                    id: queriedId
                },
                success: function (response) {
                    if (response.status === "internal-error") {
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        });
                    } else {
                        const inventoryData = response.data[0];
                        $("#assetNumber_edit").text((inventoryData.fa_number) ? inventoryData.fa_number : "Non-Fixed Asset");
                        $("#itemType_edit").val(inventoryData.item_type).trigger('change');
                        $("#itemCategory_edit").val(inventoryData.item_category);
                        $("#itemBrand_edit").val(inventoryData.brand);
                        $("#itemModel_edit").val(inventoryData.model);
                        $("#itemSpecification_edit").val(inventoryData.item_specification);
                        $("#user_edit").val(inventoryData.user);
                        $("#computerName_edit").val(inventoryData.computer_name);
                        $("#department_edit").val(inventoryData.department);
                        $("#dateAcquired_edit").val(inventoryData.date_acquired);
                        $("#supplierName_edit").val(inventoryData.supplier);
                        $("#serialNumber_edit").val(inventoryData.serial_number);
                        $("#status_edit").val(inventoryData.status);
                        $("#price_edit").val(inventoryData.price);
                        $("#remarks_edit").val(inventoryData.remarks);
                        $("#id_edit").val(queriedId);

                        if (inventoryData.status === "Retired") {
                            if ($("#viewActionsRow").hasClass('d-flex')) {
                                $("#viewActionsRow").removeClass('d-flex');
                                $("#viewActionsRow").addClass('d-none');
                            }

                            if ($("#retiredActionsRow1").hasClass("d-none")) {
                                $("#retiredActionsRow1").removeClass("d-none");
                                $("#retiredActionsRow1").addClass("d-flex");
                            }
                            if ($("#retiredActionsRow2").hasClass("d-none")) {
                                $("#retiredActionsRow2").removeClass("d-none");
                                $("#retiredActionsRow2").addClass("d-flex");
                            }

                            $.ajax({
                                type: "GET",
                                url: "../../backend/inventory-management/getDisposal.php",
                                data: {
                                    inventoryId: queriedId
                                },
                                success: function (response) {
                                    if (response.status === "internal-error") {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: `${response.message}`,
                                            icon: 'error',
                                            confirmButtonColor: 'var(--bs-danger)'
                                        });
                                    } else if (response.status === "success") {
                                        const disposalData = response.data;
                                        if (disposalData.length == 0) {
                                            if ($("#disposeButton").hasClass("d-none")) {
                                                $("#disposeButton").removeClass("d-none");
                                            }
                                        } else {
                                            if (!$("#disposeButton").hasClass("d-none")) {
                                                $("#disposeButton").addClass("d-none");
                                            }
                                        }
                                    }
                                }
                            });
                        } else {
                            if ($("#viewActionsRow").hasClass('d-none')) {
                                $("#viewActionsRow").removeClass('d-none');
                                $("#viewActionsRow").addClass('d-flex');
                            }
                            if ($("#retiredActionsRow1").hasClass("d-flex")) {
                                $("#retiredActionsRow1").removeClass("d-flex");
                                $("#retiredActionsRow1").addClass("d-none");
                            }
                            if ($("#retiredActionsRow2").hasClass("d-flex")) {
                                $("#retiredActionsRow2").removeClass("d-flex");
                                $("#retiredActionsRow2").addClass("d-none");
                            }
                        }
                        $.ajax({
                            type: "GET",
                            url: "../../backend/inventory-management/getAllRepairs.php",
                            data: {
                                inventoryId: queriedId
                            },
                            success: function (response) {
                                if (response.status === "internal-error") {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: `${response.message}`,
                                        icon: 'error',
                                        confirmButtonColor: 'var(--bs-danger)'
                                    });
                                } else if (response.status === "success") {
                                    const allRepairs = response.data;
                                    let html = "";
                                    for (let i = 0; i < allRepairs.length; i++) {
                                        html += `<tr> +
                                                        <td>${allRepairs[i].repair_description}</td>
                                                        <td>${allRepairs[i].gatepass_number}</td>
                                                        <td>${convertToReadableDate(allRepairs[i].start_date)}</td>
                                                        <td>${convertToReadableDate(allRepairs[i].end_date)}</td>
                                                        <td class="remarks-column">${allRepairs[i].remarks === null ? "N/A" : allRepairs[i].remarks}</td>
                                                    </tr>`;
                                    }
                                    $("#totalRepairs").text(allRepairs.length);
                                    $("#repairHistory").html(html);
                                }
                            }
                        });
                        if (inventoryData.status === "Active" || inventoryData.status === "Repaired") {
                            if ($("#noRepairColumn").hasClass('d-none')) {
                                $("#noRepairColumn").removeClass('d-none');
                            }
                            if (!$("#underRepairColumn").hasClass("d-none")) {
                                $("#underRepairColumn").addClass('d-none');
                            }
                        } else if (inventoryData.status === "Under Repair") {
                            $.ajax({
                                type: "GET",
                                url: "../../backend/inventory-management/getLatestRepair.php",
                                data: {
                                    inventoryId: queriedId
                                },
                                success: function (response) {
                                    if (response.status === "internal-error") {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: `${response.message}`,
                                            icon: 'error',
                                            confirmButtonColor: 'var(--bs-danger)'
                                        });
                                    } else if (response.status === "success") {
                                        const latestRepair = response.data[0];
                                        $("#repairId_edit").val(latestRepair.repair_id);
                                        $("#repairDescription_edit").val(latestRepair.repair_description);
                                        $("#gatepassNumber_edit").val(latestRepair.gatepass_number);
                                        $("#repairDate_edit").val(latestRepair.start_date);
                                    }
                                }
                            });

                            if ($("#underRepairColumn").hasClass('d-none')) {
                                $("#underRepairColumn").removeClass('d-none');
                            }
                            if (!$("#noRepairColumn").hasClass("d-none")) {
                                $("#noRepairColumn").addClass('d-none');
                            }
                        }
                    }
                    $('#inventoryNotifications').modal('hide');
                    $('#viewInventoryModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.log(error);
                    console.log(status);
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

const fetchNotificationCount = () => {
    $.ajax({
        type: "GET",
        url: "../../backend/inventory-management/getNotificationCount.php",
        success: function (response) {
            if (response.status === 'success') {
                const notificationCount = response.data[0]['COUNT(*)'];
                $("#newNotificationsCount").text(notificationCount < 10 ? notificationCount : '9+');
                if (notificationCount > 0) {
                    if ($("#newNotificationsCount").hasClass('d-none')) {
                        $("#newNotificationsCount").removeClass('d-none');
                        $("#newNotificationsCount").addClass('d-flex');
                    }
                } else {
                    if (!$("#newNotificationsCount").hasClass('d-none')) {
                        $("#newNotificationsCount").addClass('d-none');
                        $("#newNotificationsCount").removeClass('d-flex');
                    }
                }
            }
        }
    });
}