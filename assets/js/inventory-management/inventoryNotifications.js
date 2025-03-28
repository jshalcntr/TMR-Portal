$(document).ready(function () {
    fetchNotificationCount();
    setInterval(() => {
        fetchNotificationCount();
    }, 2000);

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
                                <div class="row notification-row" role="button" data-notification-id="${notification.notification_id}" data-notification-type="${notification.notification_type}">
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
                                    ${notification.isRead === 0 ? `<i class="fa-solid fa-circle text-danger fa-2xs glow-icon__declined glow-icon"></i>` : ``}
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

        console.log(notificationId);
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
                }
            }
        });

        if (notificationType === 'request_created') {
            
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