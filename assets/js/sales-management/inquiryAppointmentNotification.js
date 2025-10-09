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
                                <div class="card shadow py-1 inquiryNotificationCard" role="button"
                                    data-history-id="${notification.history_id}" 
                                    data-notification-id="${notification.notification_id}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewInquiryDetailsNotificationModal">
                                    <div class="card-body py-2 px-3 d-flex align-items-center" style="gap: 12px;">
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
    $(document).on('click', '.inquiryNotificationCard', function () {
        const notificationId = $(this).data("notification-id");
        $.ajax({
            type: "POST",
            url: "../../backend/sales-management/toggleNotification.php",
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
                    fetchNotificationCount();
                }
            }
        });

        const historyId = $(this).data("history-id");
        $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getInquiryDetailsByHistory.php",
            data: {
                historyId: historyId
            },
            success: function (response) {
                if (response.status === "success") {
                    const inquiryDetails = response.data[0];

                    const customerId = inquiryDetails.customer_id;
                    const firstName = inquiryDetails.customer_firstname;
                    const middleName = inquiryDetails.customer_middlename;
                    const lastName = inquiryDetails.customer_lastname;
                    const gender = inquiryDetails.gender;
                    const contactNumber = inquiryDetails.contact_number;
                    const streetAddress = inquiryDetails.street === "" ? "NO STREET ADDRESS" : inquiryDetails.street;
                    const barangay = inquiryDetails.barangay;
                    const municipality = inquiryDetails.municipality;
                    const province = inquiryDetails.province;
                    const maritalStatus = inquiryDetails.marital_status;
                    const birthday = convertToReadableDate(inquiryDetails.birthday).toUpperCase();

                    const occupation = inquiryDetails.occupation;
                    const occupationStreetAddress = inquiryDetails.occupation_street === "" ? "NO STREET ADDRESS" : inquiryDetails.occupation_street;
                    const occupationBarangay = inquiryDetails.occupation_barangay;
                    const occupationMunicipality = inquiryDetails.occupation_municipality;
                    const occupationProvince = inquiryDetails.occupation_province;
                    const businessName = inquiryDetails.business_name;
                    const businessCategory = inquiryDetails.business_category;
                    const businessSize = inquiryDetails.business_size;
                    const monthlyAverage = inquiryDetails.monthly_average;

                    const inquiryId = inquiryDetails.inquiry_id;
                    const prospectType = inquiryDetails.prospect_type;
                    const dateOfInquiry = convertToReadableDate(inquiryDetails.inquiry_date).toUpperCase();
                    const inquirySource = inquiryDetails.inquiry_source;
                    const inquirySourceType = inquiryDetails.inquiry_source_type;
                    const mallSource = inquiryDetails.mall === "" ? "NO MALL" : inquiryDetails.mall;
                    const buyerType = inquiryDetails.buyer_type;
                    const unitInquired = inquiryDetails.unit_inquired;
                    const transactionType = inquiryDetails.transaction_type;
                    const hasApplication = inquiryDetails.has_application === 1 ? "YES" : "NO";
                    const hasReservation = inquiryDetails.has_reservation === 1 ? "YES" : "NO";
                    const reservationDate = inquiryDetails.reservation_date === "0000-00-00" ? "NO RESERVATION" : convertToReadableDate(inquiryDetails.reservation_date).toUpperCase();
                    const appointmentDateTime = `${convertToReadableDate(inquiryDetails.appointment_date).toUpperCase()} ${inquiryDetails.appointment_time}`;

                    const tamarawVariant = inquiryDetails.tamaraw_variant;
                    const additionalUnit = inquiryDetails.additional_unit;
                    const buyerDecisionHold = inquiryDetails.buyer_decision_hold === 1 ? "YES" : "NO";
                    const buyerDecisionHoldReason = inquiryDetails.buyer_decision_hold_reason === null ? "NO REASON" : inquiryDetails.buyer_decision_hold_reason;
                    const specificUsage = inquiryDetails.tamaraw_specific_usage;

                    $("#customerId_details_notification").text(customerId);
                    $("#firstName_details_notification").text(firstName);
                    $("#middleName_details_notification").text(middleName);
                    $("#lastName_details_notification").text(lastName);
                    $("#gender_details_notification").text(gender);
                    $("#contactNumber_details_notification").text(contactNumber);
                    $("#streetAddress_details_notification").text(streetAddress);
                    $("#barangay_details_notification").text(barangay);
                    $("#municipality_details_notification").text(municipality);
                    $("#province_details_notification").text(province);
                    $("#maritalStatus_details_notification").text(maritalStatus);
                    $("#birthday_details_notification").text(birthday);

                    $("#occupation_details_notification").text(occupation);
                    $("#occupationName_details_notification").text(businessName);
                    $("#occupationStreetAddress_details_notification").text(occupationStreetAddress);
                    $("#occupationBarangay_details_notification").text(occupationBarangay);
                    $("#occupationMunicipality_details_notification").text(occupationMunicipality);
                    $("#occupationProvince_details_notification").text(occupationProvince);
                    $("#businessName_details_notification").text(businessName);
                    $("#businessCategory_details_notification").text(businessCategory);
                    $("#businessSize_details_notification").text(businessSize);
                    $("#monthlyAverage_details_notification").text(monthlyAverage);

                    $("#inquiryId_details_notification").text(inquiryId);
                    $("#updateInquiryNotificationBtn").data('inquiry-id', inquiryId)
                    $("#prospectType_details_notification").text(prospectType);
                    $("#dateOfInquiry_details_notification").text(dateOfInquiry);
                    $("#inquirySource_details_notification").text(inquirySource);
                    $("#inquirySourceType_details_notification").text(inquirySourceType);
                    $("#mallSource_details_notification").text(mallSource);
                    $("#buyerType_details_notification").text(buyerType);
                    $("#unitInquired_details_notification").text(unitInquired);
                    $("#transactionType_details_notification").text(transactionType);
                    $("#hasApplication_details_notification").text(hasApplication);
                    $("#hasReservation_details_notification").text(hasReservation);
                    $("#reservationDate_details_notification").text(reservationDate);
                    $("#appointmentDateTime_details_notification").text(appointmentDateTime);

                    $("#tamarawVariant_details_notification").text(tamarawVariant);
                    $("#additionalUnitUsed_details_notification").text(additionalUnit);
                    $("#buyerDecisionOnHold_details_notification").text(buyerDecisionHold);
                    $("#reasonForHolding_details_notification").text(buyerDecisionHoldReason);
                    $("#specificUsage_details_notification").text(specificUsage);

                    if (unitInquired === "TAMARAW") {
                        if ($("#tamarawDetailsTable_notification").hasClass("d-none")) {
                            $("#tamarawDetailsTable_notification").removeClass("d-none");
                        }
                    } else {
                        if (!$("#tamarawDetailsTable_notification").hasClass("d-none")) {
                            $("#tamarawDetailsTable_notification").addClass("d-none");
                        }
                    }

                    if (occupation === "Business Owner") {
                        if ($(".businessTableRow_notification").hasClass("d-none")) {
                            $(".businessTableRow_notification").removeClass("d-none");
                        }
                    } else {
                        if (!$(".businessTableRow_notification").hasClass("d-none")) {
                            $(".businessTableRow_notification").addClass("d-none");
                        }
                    }
                } else if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error! ' + response.message,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });
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