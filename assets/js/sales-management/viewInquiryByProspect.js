$(document).on('click', '.viewInquiryDetailsByProspectBtn', function () {
    const target = $(this).attr('data-bs-target');
    $(target).modal('show');
    $("#viewInquiriesByProspectModal").modal('hide');

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
                const lastName = inquiryDetails.lastname;
                const gender = inquiryDetails.gender;
                const contactNumber = inquiryDetails.contact_number;
                const streetAddress = inquiryDetails.street === "" ? "No Street Address" : inquiryDetails.street;
                const barangay = inquiryDetails.barangay;
                const municipality = inquiryDetails.municipality;
                const province = inquiryDetails.province;
                const maritalStatus = inquiryDetails.marital_status;
                const birthday = convertToReadableDate(inquiryDetails.birthday);

                const occupation = inquiryDetails.occupation;
                const occupationStreetAddress = inquiryDetails.occupation_street === "" ? "No Street Address" : inquiryDetails.occupation_street;
                const occupationBarangay = inquiryDetails.occupation_barangay;
                const occupationMunicipality = inquiryDetails.occupation_municipality;
                const occupationProvince = inquiryDetails.occupation_province;
                const businessName = inquiryDetails.business_name;
                const businessCategory = inquiryDetails.business_category;
                const businessSize = inquiryDetails.business_size;
                const monthlyAverage = inquiryDetails.monthly_average;

                const inquiryId = inquiryDetails.inquiry_id;
                const prospectType = inquiryDetails.prospect_type;
                const dateOfInquiry = convertToReadableDate(inquiryDetails.inquiry_date);
                const inquirySource = inquiryDetails.inquiry_source;
                const inquirySourceType = inquiryDetails.inquiry_source;
                const mallSource = inquiryDetails.mall === "" ? "No Mall" : inquiryDetails.mall;
                const buyerType = inquiryDetails.buyer_type;
                const unitInquired = inquiryDetails.unit_inquired;
                const transactionType = inquiryDetails.transaction_type;
                const hasApplication = inquiryDetails.has_application === 1 ? "Yes" : "No";
                const hasReservation = inquiryDetails.has_reservation === 1 ? "Yes" : "No";
                const reservationDate = inquiryDetails.reservation_date === "0000-00-00" ? "No Reservation" : convertToReadableDate(inquiryDetails.reservation_date);
                const appointmentDateTime = `${convertToReadableDate(inquiryDetails.appointment_date)} ${inquiryDetails.appointment_time}`;

                const tamarawVariant = inquiryDetails.tamaraw_variant;
                const additionalUnit = inquiryDetails.additional_unit;
                const buyerDecisionHold = inquiryDetails.buyer_decision_hold === 1 ? "Yes" : "No";
                const buyerDecisionHoldReason = inquiryDetails.buyer_decision_hold_reason === null ? "No Reason" : inquiryDetails.buyer_decision_hold_reason;
                const specificUsage = inquiryDetails.tamaraw_specific_usage;

                $("#customerId_details_byProspect").text(customerId);
                $("#firstName_details_byProspect").text(firstName);
                $("#middleName_details_byProspect").text(middleName);
                $("#lastName_details_byProspect").text(lastName);
                $("#gender_details_byProspect").text(gender);
                $("#contactNumber_details_byProspect").text(contactNumber);
                $("#streetAddress_details_byProspect").text(streetAddress);
                $("#barangay_details_byProspect").text(barangay);
                $("#municipality_details_byProspect").text(municipality);
                $("#province_details_byProspect").text(province);
                $("#maritalStatus_details_byProspect").text(maritalStatus);
                $("#birthday_details_byProspect").text(birthday);

                $("#occupation_details_byProspect").text(occupation);
                $("#occupationName_details_byProspect").text(businessName);
                $("#occupationStreetAddress_details_byProspect").text(occupationStreetAddress);
                $("#occupationBarangay_details_byProspect").text(occupationBarangay);
                $("#occupationMunicipality_details_byProspect").text(occupationMunicipality);
                $("#occupationProvince_details_byProspect").text(occupationProvince);
                $("#businessName_details_byProspect").text(businessName);
                $("#businessCategory_details_byProspect").text(businessCategory);
                $("#businessSize_details_byProspect").text(businessSize);
                $("#monthlyAverage_details_byProspect").text(monthlyAverage);

                $("#inquiryId_details_byProspect").text(inquiryId);
                $("#prospectType_details_byProspect").text(prospectType);
                $("#dateOfInquiry_details_byProspect").text(dateOfInquiry);
                $("#inquirySource_details_byProspect").text(inquirySource);
                $("#inquirySourceType_details_byProspect").text(inquirySourceType);
                $("#mallSource_details_byProspect").text(mallSource);
                $("#buyerType_details_byProspect").text(buyerType);
                $("#unitInquired_details_byProspect").text(unitInquired);
                $("#transactionType_details_byProspect").text(transactionType);
                $("#hasApplication_details_byProspect").text(hasApplication);
                $("#hasReservation_details_byProspect").text(hasReservation);
                $("#reservationDate_details_byProspect").text(reservationDate);
                $("#appointmentDateTime_details_byProspect").text(appointmentDateTime);

                $("#tamarawVariant_details_byProspect").text(tamarawVariant);
                $("#additionalUnitUsed_details_byProspect").text(additionalUnit);
                $("#buyerDecisionOnHold_details_byProspect").text(buyerDecisionHold);
                $("#reasonForHolding_details_byProspect").text(buyerDecisionHoldReason);
                $("#specificUsage_details_byProspect").text(specificUsage);

                if (unitInquired === "TAMARAW") {
                    console.log(unitInquired);
                    if ($("#tamarawDetailsByProspectTable").hasClass("d-none")) {
                        $("#tamarawDetailsByProspectTable").removeClass("d-none");
                    }
                } else {
                    if (!$("#tamarawDetailsByProspectTable").hasClass("d-none")) {
                        $("#tamarawDetailsByProspectTable").addClass("d-none");
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
$("#viewInquiryDetailsByProspectModal").on('hidden.bs.modal', function () {
    $("#viewInquiriesByProspectModal").modal('show');
});