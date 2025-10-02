$(document).on('click', '.viewInquiryDetailsBtn', function () {
    const target = $(this).attr('data-bs-target');
    $(target).modal('show');
    $("#viewInquiriesModal").modal('hide');

    const inquiryId = $(this).data('inquiry-id');

    $.ajax({
        type: "GET",
        url: "../../backend/sales-management/getInquiryDetails.php",
        data: {
            inquiryId: inquiryId
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

                $("#customerId_details").text(customerId);
                $("#firstName_details").text(firstName);
                $("#middleName_details").text(middleName);
                $("#lastName_details").text(lastName);
                $("#gender_details").text(gender);
                $("#contactNumber_details").text(contactNumber);
                $("#streetAddress_details").text(streetAddress);
                $("#barangay_details").text(barangay);
                $("#municipality_details").text(municipality);
                $("#province_details").text(province);
                $("#maritalStatus_details").text(maritalStatus);
                $("#birthday_details").text(birthday);

                $("#occupation_details").text(occupation);
                $("#occupationName_details").text(businessName);
                $("#occupationStreetAddress_details").text(occupationStreetAddress);
                $("#occupationBarangay_details").text(occupationBarangay);
                $("#occupationMunicipality_details").text(occupationMunicipality);
                $("#occupationProvince_details").text(occupationProvince);
                $("#businessName_details").text(businessName);
                $("#businessCategory_details").text(businessCategory);
                $("#businessSize_details").text(businessSize);
                $("#monthlyAverage_details").text(monthlyAverage);

                $("#inquiryId_details").text(inquiryId);
                $("#updateInquiryBtn").data('inquiry-id', inquiryId)
                $("#prospectType_details").text(prospectType);
                $("#dateOfInquiry_details").text(dateOfInquiry);
                $("#inquirySource_details").text(inquirySource);
                $("#inquirySourceType_details").text(inquirySourceType);
                $("#mallSource_details").text(mallSource);
                $("#buyerType_details").text(buyerType);
                $("#unitInquired_details").text(unitInquired);
                $("#transactionType_details").text(transactionType);
                $("#hasApplication_details").text(hasApplication);
                $("#hasReservation_details").text(hasReservation);
                $("#reservationDate_details").text(reservationDate);
                $("#appointmentDateTime_details").text(appointmentDateTime);

                $("#tamarawVariant_details").text(tamarawVariant);
                $("#additionalUnitUsed_details").text(additionalUnit);
                $("#buyerDecisionOnHold_details").text(buyerDecisionHold);
                $("#reasonForHolding_details").text(buyerDecisionHoldReason);
                $("#specificUsage_details").text(specificUsage);

                if (unitInquired === "TAMARAW") {
                    if ($("#tamarawDetailsTable").hasClass("d-none")) {
                        $("#tamarawDetailsTable").removeClass("d-none");
                    }
                } else {
                    if (!$("#tamarawDetailsTable").hasClass("d-none")) {
                        $("#tamarawDetailsTable").addClass("d-none");
                    }
                }

                if (occupation === "Business Owner") {
                    if ($(".businessTableRow").hasClass("d-none")) {
                        $(".businessTableRow").removeClass("d-none");
                    }
                } else {
                    if (!$(".businessTableRow").hasClass("d-none")) {
                        $(".businessTableRow").addClass("d-none");
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
$("#viewInquiryDetailsModal").on('hidden.bs.modal', function () {
    if (!$("#updateInquiryModal").hasClass('show')) {
        $("#viewInquiriesModal").modal('show');
    }
});