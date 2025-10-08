$(document).ready(function () {
    $("#viewInquiryAlertsButton").on('click', function () {
        $("#inquiryAlertsList").empty();
        $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getAllNotifications.php",
            success: function (response) {
                if (response.status === 'internal-error') {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });

                    $("#inquiryAlertsList").append(`
                        <div class='row no-notification-row justify-content-center align-items-center'>
                            <p class='my-3 w-auto text-gray-500;'>No notification available</p>
                        </div>
                    `);
                } else if (response.status === 'success') {
                    const notifications = response.data;
                    if (notifications.length > 0) {
                        notifications.forEach((notification, index) => {
                            $("#inquiryAlertsList").append(`
                                <div class="card shadow py-1 inquiryNotificationCard" role="button">
                                    <div class="card-body py-2 px-3 d-flex align-items-center" style="gap: 12px;"
                                    data-history-id="${notification.history_id} 
                                    data-notification-id="${notification.notification_id}
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewInquiryDetailsNotificationModal">
                                        <i class="fas fa-envelope fa-2x ${notification.isRead === 0 ? 'text-primary' : 'text-gray-500'}"></i>
                                        <div class="text-primary font-weight-bold">
                                            <div class="text-s text-truncate">Follow-up appointment due.</div>
                                            <div class="text-xs text-gray-500">${formatDateTimeNotification(notification.appointment_datetime)}</div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        $("#inquiryAlertsList").append(`
                            <div class='row no-notification-row justify-content-center align-items-center'>
                                <p class='my-3 w-auto text-gray-500;'>No notification available</p>
                            </div>
                        `);
                    }
                }
            }
        });
    });
    fetchNotificationCount();
    setInterval(() => {
        fetchNotificationCount();
    }, 2000);
});

const formatDateTimeNotification = (datetime) => {
    const date = new Date(datetime.replace(" ", "T"));
    const month = new Intl.DateTimeFormat("en-US", { month: "long" }).format(date);
    const day = String(date.getDate()).padStart(2, "0");
    const year = date.getFullYear();
    let hours = date.getHours();
    const minutes = String(date.getMinutes()).padStart(2, "0");
    const ampm = hours >= 12 ? "pm" : "am";
    hours = hours % 12 || 12;
    return `${month} ${day}, ${year} @ ${hours}:${minutes} ${ampm}`;
}

const fetchNotificationCount = () => {
    $.ajax({
        type: "GET",
        url: "../../backend/sales-management/getNotificationCount.php",
        success: function (response) {
            if (response.status === 'success') {
                const notificationCount = response.data[0]['COUNT(*)'];
                console.log(notificationCount);
                $("#newAlertsCount").text(notificationCount < 10 ? notificationCount : '9+');
                if (notificationCount > 0) {
                    if ($("#newAlertsCount").hasClass('d-none')) {
                        $("#newAlertsCount").removeClass('d-none');
                        $("#newAlertsCount").addClass('d-flex');
                    }
                } else {
                    if (!$("#newAlertsCount").hasClass('d-none')) {
                        $("#newAlertsCount").addClass('d-none');
                        $("#newAlertsCount").removeClass('d-flex');
                    }
                }
            }
        }
    });
}