$(document).ready(function () {
    function populateUpdateNInquiryFields() {
        $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getAllMalls.php",
            success: function (response) {
                if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    })
                } else if (response.status === "success") {
                    const malls = response.data;
                    $("#mallDisplay_updateN").empty().append(`<option value="">--Select Mall--</option>`);
                    malls.forEach(mall => {
                        $("#mallDisplay_updateN").append(`<option value="${mall.mall_name}">${mall.mall_name}</option>`);
                    });
                }
            }
        })
        const provinces1 = $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://psgc.gitlab.io/api/provinces/"
        });

        const vehicles = $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getAllVehicles.php"
        });

        const provinces2 = $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://psgc.gitlab.io/api/provinces/"
        });

        // Return a promise that resolves when ALL 3 are done
        return $.when(provinces1, vehicles, provinces2).done((res1, resVehicles, res2) => {
            // res1, resVehicles, res2 each come as [data, status, xhr]

            // --- Populate first provinces ---
            const response1 = res1[0];
            $('#province_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Province--</option>`);
            $('#municipality_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);
            $('#barangay_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);

            $('#province_updateN').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);
            response1.forEach(province => {
                $('#province_updateN').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
            });

            // Select2 init
            $("#province_updateN, #municipality_updateN, #barangay_updateN").select2({
                placeholder: `--Select--`,
                width: '100%',
                dropdownParent: $('#updateInquiryNotificationModal')
            });

            // --- Populate vehicles ---
            const responseVehicles = resVehicles[0];
            if (responseVehicles.status === 'success') {
                $("#unitInquired_updateN").empty().append(`<option value="" hidden>--Select Vehicle--</option>`);
                responseVehicles.data.forEach(vehicle => {
                    $("#unitInquired_updateN").append(`<option value="${vehicle.vehicle_name}">${vehicle.vehicle_name}</option>`);
                });
            }

            // --- Populate second provinces (occupation) ---
            const response2 = res2[0];
            $('#occupationProvince_updateN').empty().append(`<option value="" selected hidden>--Select Province--</option>`);
            $('#occupationMunicipality_updateN').empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);
            $('#occupationBarangay_updateN').empty().append(`<option value="" selected hidden>--Select Barangay--</option>`);

            $('#occupationProvince_updateN').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);
            response2.forEach(province => {
                $('#occupationProvince_updateN').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
            });

            // Select2 init
            $("#occupationProvince_updateN, #occupationMunicipality_updateN, #occupationBarangay_updateN").select2({
                placeholder: `--Select--`,
                width: '100%',
                dropdownParent: $('#updateInquiryNotificationModal')
            });

        }).fail((xhr, status, error) => {
            console.error("populateUpdateNInquiryFields error:", error);
            Swal.fire({
                title: 'Error! ',
                text: 'An internal error occurred. Please contact MIS.',
                icon: 'error',
                confirmButtonColor: 'var(--bs-danger)'
            }).then(() => {
                console.log(error);
            });
        });

    }
    $("#updateInquiryNotificationBtn").on('click', function () {

        const inquiryId = $(this).data('inquiry-id');
        const historyId = $(this).data('history-id');

        populateUpdateNInquiryFields().then(() => {
            $.ajax({
                type: "GET",
                url: "../../backend/sales-management/getInquiryDetails.php",
                data: {
                    inquiryId: inquiryId
                },
                success: function (response) {
                    if (response.status === "success") {
                        const inquiryDetails = response.data[0];

                        const prospectType = inquiryDetails.prospect_type;
                        const customerFirstName = inquiryDetails.customer_firstname;
                        const customerMiddleName = inquiryDetails.customer_middlename;
                        const customerLastName = inquiryDetails.customer_lastname;
                        const province = inquiryDetails.province;
                        const municipality = inquiryDetails.municipality;
                        const barangay = inquiryDetails.barangay;
                        const street = inquiryDetails.street;
                        const contactNumber = inquiryDetails.contact_number;
                        const gender = inquiryDetails.gender;
                        const maritalStatus = inquiryDetails.marital_status;
                        const birthday = inquiryDetails.birthday;
                        const occupation = inquiryDetails.occupation;
                        const businessName = inquiryDetails.business_name;
                        const occupationProvince = inquiryDetails.occupation_province;
                        const occupationMunicipality = inquiryDetails.occupation_municipality;
                        const occupationBarangay = inquiryDetails.occupation_barangay;
                        const occupationStreet = inquiryDetails.occupation_street;
                        const businessCategory = inquiryDetails.business_category;
                        const businessSize = inquiryDetails.business_size;
                        const monthlyAverage = inquiryDetails.monthly_average;

                        const inquiryDate = inquiryDetails.inquiry_date;
                        const inquirySource = inquiryDetails.inquiry_source;
                        const inquirySourceType = inquiryDetails.inquiry_source_type;
                        const mallDisplay = inquiryDetails.mall;
                        const buyerType = inquiryDetails.buyer_type;
                        const unitInquired = inquiryDetails.unit_inquired;
                        const tamarawVariant = inquiryDetails.tamaraw_variant;
                        const transactionType = inquiryDetails.transaction_type;
                        const hasApplication = inquiryDetails.has_application === 1 ? "YES" : "NO";
                        const hasReservation = inquiryDetails.has_reservation === 1 ? "YES" : "NO";
                        const reservationDate = inquiryDetails.reservation_date;
                        const additionalUnit = inquiryDetails.additional_unit;
                        const tamarawSpecificUsage = inquiryDetails.tamaraw_specific_usage;
                        const buyerDecisionHold = inquiryDetails.buyer_decision_hold === 1 ? "YES" : "NO";
                        const buyerDecisionHoldReason = inquiryDetails.buyer_decision_hold_reason;
                        // const appointmentDate = inquiryDetails.appointment_date;
                        // const appointmentTime = inquiryDetails.appointment_time;

                        $("#inquiryId_updateN").val(inquiryId);
                        $("#historyId_updateN").val(historyId);
                        $("#currentProspectType_notification").text(prospectType);
                        $("#currentProspectTypeIcon_notification").removeClass("fa-fire fa-snowflake fa-mitten fa-person-circle-question");
                        $("#currentProspectTypeRow_notification").removeClass("text-danger text-warning text-info text-secondary");
                        if (prospectType === "HOT") {
                            $("#currentProspectTypeIcon_notification").addClass("fa-fire");
                            $("#currentProspectTypeRow_notification").addClass("text-danger");
                        } else if (prospectType === "WARM") {
                            $("#currentProspectTypeIcon_notification").addClass("fa-mitten");
                            $("#currentProspectTypeRow_notification").addClass("text-warning");
                        } else if (prospectType === "COLD") {
                            $("#currentProspectTypeIcon_notification").addClass("fa-snowflake");
                            $("#currentProspectTypeRow_notification").addClass("text-info");
                        } else if (prospectType === "LOST") {
                            $("#currentProspectTypeIcon_notification").addClass("fa-person-circle-question");
                            $("#currentProspectTypeRow_notification").addClass("text-secondary");
                        }
                        $("#customerFirstName_updateN").val(customerFirstName);
                        $("#customerMiddleName_updateN").val(customerMiddleName);
                        $("#customerLastName_updateN").val(customerLastName);
                        $("#province_updateN").val(province).trigger('change');
                        const provinceCode = $("#province_updateN").find(':selected').data('code');
                        const provinceType = $("#province_updateN").find(':selected').data('type');

                        let url = '';
                        if (provinceType === 'region' && provinceCode === 130000000) {
                            url = `https://psgc.gitlab.io/api/regions/${provinceCode}/cities-municipalities/`;
                        } else {
                            url = `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`;
                        }

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "json",
                            success: function (response) {
                                $('#municipality_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                                response.forEach(municipality => {
                                    $('#municipality_updateN').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                                });
                                $("#municipality_updateN").val(municipality).trigger('change');
                                const municipalityCode = $("#municipality_updateN").find(':selected').data('code');
                                $.ajax({
                                    type: "GET",
                                    url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
                                    dataType: "json",
                                    success: function (response) {
                                        $('#barangay_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                                        response.forEach(barangay => {
                                            $('#barangay_updateN').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                                        });
                                        $("#barangay_updateN").val(barangay);
                                    },
                                    error: function (xhr, status, error) {
                                        console.error('XHR : ', xhr.responseText);
                                        console.error('Status : ', status);
                                        console.error('AJAX error : ', error);
                                        Swal.fire({
                                            title: 'Error! ',
                                            text: 'An internal error occurred. Please contact MIS.',
                                            icon: 'error',
                                            confirmButtonColor: 'var(--bs-danger)'
                                        })
                                    }
                                });
                            },
                            error: function (xhr, status, error) {
                                console.error('XHR : ', xhr.responseText);
                                console.error('Status : ', status);
                                console.error('AJAX error : ', error);
                                Swal.fire({
                                    title: 'Error! ',
                                    text: 'An internal error occurred. Please contact MIS.',
                                    icon: 'error',
                                    confirmButtonColor: 'var(--bs-danger)'
                                })
                            }
                        });

                        $("#street_updateN").val(street);
                        $("#contactNumber_updateN").val(contactNumber);
                        if (gender === "MALE") {
                            $("#gender_male_updateN").prop('checked', true);
                        } else if (gender === "FEMALE") {
                            $("#gender_female_updateN").prop('checked', true);
                        } else if (gender === "LGBTQ+") {
                            $("#gender_lgbt_updateN").prop('checked', true);
                        }
                        if (maritalStatus !== "SINGLE" && maritalStatus !== "MARRIED" && maritalStatus !== "DIVORCED" && maritalStatus !== "SEPARATED" && maritalStatus !== "WIDOWED" && maritalStatus !== "ANNULED" && maritalStatus !== "") {
                            $("#maritalStatus_updateN").val("OTHERS").trigger('change');
                            $("#maritalStatusOtherInput_updateN").val(maritalStatus).trigger('change');
                        } else {
                            $("#maritalStatus_updateN").val(maritalStatus).trigger('change');
                        }
                        $("#birthday_updateN").val(birthday);
                        $("#occupation_updateN").val(occupation).trigger('change');
                        $("#businessName_updateN").val(businessName);

                        $(".occupationLabel_updateN").text("Occupation");
                        $("#businessCategoryRow_updateN, #businessSizeRow_updateN, #businessNameRow_updateN, #businessAddressRow_updateN, #additionalUnitRow_updateN").addClass("d-none");
                        $("#businessCategory_updateN, #businessSize_updateN, #businessName_updateN, #additionalUnit_updateN").prop("required", false);
                        if (occupation === "BUSINESS OWNER") {
                            $(".occupationLabel_updateN").text("Business");
                            $("#businessCategoryRow_updateN, #businessSizeRow_updateN, #businessNameRow_updateN, #businessAddressRow_updateN").removeClass("d-none");
                        } else if (occupation === "EMPLOYED" || occupation === "OFW/SEAMAN") {
                            $("#businessNameRow_updateN, #businessAddressRow_updateN").removeClass("d-none");
                            $(".occupationLabel_updateN").text("Employer");
                        } else if (occupation === "FREELANCER") {
                            $("#occupationProvince_updateN, #occupationMunicipality_updateN, #occupationBarangay_updateN").prop('required', false);
                        } else {
                            if (occupation === "FAMILY SUPPORT/GIFT/DONATION") {
                                $(".occupationLabel_updateN").text("Sponsor");
                            } else if (occupation === "PENSIONER") {
                                $(".occupationLabel_updateN").text("Pensioner");
                            }
                            $("#businessNameRow_updateN, #businessAddressRow_updateN").removeClass("d-none");
                        }
                        if (occupationProvince) {
                            $("#occupationProvince_updateN").val(occupationProvince).trigger('change');
                            const occupationProvinceCode = $(occupationProvince_updateN).find(':selected').data('code');
                            const occupationProvinceType = $(occupationProvince_updateN).find(':selected').data('type');

                            let url = '';
                            if (occupationProvinceType === 'region' && occupationProvinceCode === 130000000) {
                                url = `https://psgc.gitlab.io/api/regions/${occupationProvinceCode}/cities-municipalities/`;
                            } else {
                                url = `https://psgc.gitlab.io/api/provinces/${occupationProvinceCode}/cities-municipalities/`;
                            }

                            $.ajax({
                                type: "GET",
                                url: url,
                                dataType: "json",
                                success: function (response) {
                                    $('#occupationMunicipality_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                                    response.forEach(municipality => {
                                        $('#occupationMunicipality_updateN').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                                    });
                                    $("#occupationMunicipality_updateN").val(occupationMunicipality).trigger('change');
                                    const occupationMunicipalityCode = $(occupationMunicipality_updateN).find(':selected').data('code');
                                    $.ajax({
                                        type: "GET",
                                        url: `https://psgc.gitlab.io/api/cities-municipalities/${occupationMunicipalityCode}/barangays/`,
                                        dataType: "json",
                                        success: function (response) {
                                            $('#occupationBarangay_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);
                                            response.forEach(barangay => {
                                                $('#occupationBarangay_updateN').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                                            });
                                            $("#occupationBarangay_updateN").val(occupationBarangay);
                                        },
                                        error: function (xhr, status, error) {
                                            console.error('XHR : ', xhr.responseText);
                                            console.error('Status : ', status);
                                            console.error('AJAX error : ', error);
                                            Swal.fire({
                                                title: 'Error! ',
                                                text: 'An internal error occurred. Please contact MIS.',
                                                icon: 'error',
                                                confirmButtonColor: 'var(--bs-danger)'
                                            })
                                        }
                                    });
                                },
                                error: function (xhr, status, error) {
                                    console.error('XHR : ', xhr.responseText);
                                    console.error('Status : ', status);
                                    console.error('AJAX error : ', error);
                                    Swal.fire({
                                        title: 'Error! ',
                                        text: 'An internal error occurred. Please contact MIS.',
                                        icon: 'error',
                                        confirmButtonColor: 'var(--bs-danger)'
                                    })
                                }
                            });
                        }
                        $("#occupationStreet_updateN").val(occupationStreet);
                        $("#businessCategory_updateN").val(businessCategory);
                        $("#businessSize_updateN").val(businessSize);
                        $("#monthlyAverage_updateN").val(monthlyAverage);

                        $("#inquiryDate_updateN").val(inquiryDate);
                        $("#inquirySource_updateN").val(inquirySource).trigger('change');
                        if (inquirySource === "FACE TO FACE") {
                            $("#f2fSource_updateN").val(inquirySourceType).trigger('change');
                        } else if (inquirySource === "ONLINE") {
                            $("#onlineSource_updateN").val(inquirySourceType).trigger('change');
                        }
                        $("#f2fSource_updateN").val(inquirySourceType);
                        $("#onlineSource_updateN").val(inquirySourceType);

                        $("#mallDisplay_updateN").val(mallDisplay);
                        if (buyerType === "FIRST-TIME") {
                            $("#buyerType_first_updateN").prop('checked', true);
                        } else if (buyerType === "REPLACEMENT") {
                            $("#buyerType_replacement_updateN").prop('checked', true);
                        } else if (buyerType === "ADDITIONAL") {
                            $("#buyerType_additional_updateN").prop('checked', true);
                        }
                        $("#unitInquired_updateN").val(unitInquired).trigger('change');
                        $("#tamarawVariant_updateN").val(tamarawVariant);
                        $("#transactionType_updateN").val(transactionType);
                        if (hasApplication === "YES") {
                            $("#hasApplication_yes_updateN").prop('checked', true).trigger('change');
                        } else if (hasApplication === "NO") {
                            $("#hasApplication_no_updateN").prop('checked', true).trigger('change');
                        }
                        if (hasReservation === "YES") {
                            $("#hasReservation_yes_updateN").prop('checked', true).trigger('change');
                        } else if (hasReservation === "NO") {
                            $("#hasReservation_no_updateN").prop('checked', true).trigger('change');
                        }
                        $("#reservationDate_updateN").val(reservationDate);
                        $("#additionalUnit_updateN").val(additionalUnit);
                        $("#tamarawSpecificUsage_updateN").val(tamarawSpecificUsage);
                        if (buyerDecisionHold === "YES") {
                            $("#buyerDecisionHold_yes_updateN").prop('checked', true).trigger('change');
                        } else if (buyerDecisionHold === "NO") {
                            $("#buyerDecisionHold_no_updateN").prop('checked', true).trigger('change');
                        }
                        $("#buyerDecisionHoldReason_updateN").val(buyerDecisionHoldReason);
                        // $("#appointmentDate_updateN").val(appointmentDate);
                        // $("#appointmentTime_updateN").val(appointmentTime);

                        if (maritalStatus === "OTHERS") {
                            $("#maritalStatusOthersRow_updateN").removeClass("d-none");
                            $("#maritalStatusOtherInput_updateN").prop("required", true).focus();
                        } else {
                            $("#maritalStatusOthersRow_updateN").addClass("d-none");
                            $("#maritalStatusOtherInput_updateN").prop("required", false).removeClass("is-invalid");
                        }
                    } else if (response.status === "internal-error") {
                        Swal.fire({
                            title: 'Error! ' + response.message,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        });
                    }
                }
            }).then(() => {
                $("#customerFirstName_updateN").prop("disabled", true);
                $("#customerMiddleName_updateN").prop("disabled", true);
                $("#customerLastName_updateN").prop("disabled", true);
                $("#province_updateN").prop("disabled", true);
                $("#municipality_updateN").prop("disabled", true);
                $("#barangay_updateN").prop("disabled", true);
                $("#street_updateN").prop("disabled", true);
                $("#contactNumber_updateN").prop("disabled", true);
                $("#gender_male_updateN").prop("disabled", true);
                $("#gender_female_updateN").prop("disabled", true);
                $("#gender_lgbt_updateN").prop("disabled", true);
                $("#inquiryDate_updateN").prop("disabled", true);
                $("#inquirySource_updateN").prop("disabled", true);
                $("#f2fSource_updateN").prop("disabled", true);
                $("#onlineSource_updateN").prop("disabled", true);
                $("#mallDisplay_updateN").prop("disabled", true);
            });
        });

    });
    $("#updateInquiryNotificationForm input[name='prospectType']").on('change', function () {
        if ($(this).val() === "LOST") {
            $("#maritalStatusRequired_updateN").addClass("d-none");
            $("#occupationRequired_updateN").addClass("d-none");
            $("#businessNameRequired_updateN").addClass("d-none");
            $("#occupationProvinceRequired_updateN").addClass("d-none");
            $("#occupationMunicipalityRequired_updateN").addClass("d-none");
            $("#occupationBarangayRequired_updateN").addClass("d-none");
            $("#businessCategoryRequired_updateN").addClass("d-none");
            $("#businessAddressRequired_updateN").addClass("d-none");
            $("#businessSizeRequired_updateN").addClass("d-none");
            $("#monthlyAverageRequired_updateN").addClass("d-none");
            $("#buyerTypeRequired_updateN").addClass("d-none");
            $("#transactionTypeRequired_updateN").addClass("d-none");
            $("#hasApplicationRequired_updateN").addClass("d-none");
            $("#hasReservationRequired_updateN").addClass("d-none");
            $("#reservationDateRequired_updateN").addClass("d-none");
            $("#additionalUnitRequired_updateN").addClass("d-none");
            $("#tamarawSpecificUsageRequired_updateN").addClass("d-none");
            $("#buyerDecisionHoldRequired_updateN").addClass("d-none");
            $("#buyerDecisionHoldReasonRequired_updateN").addClass("d-none");
            $("#unitInquiredRequired_updateN").addClass("d-none");
            $("#tamarawVariantRequired_updateN").addClass("d-none");
            $("#appointmentDateRequired_updateN").addClass("d-none");
            $("#appointmentTimeRequired_updateN").addClass("d-none");

            $("#maritalStatus_updateN").prop("required", false);
            $("#occupation_updateN").prop("required", false);
            $("#businessName_updateN").prop("required", false);
            $("#occupationProvince_updateN").prop("required", false);
            $("#occupationMunicipality_updateN").prop("required", false);
            $("#occupationBarangay_updateN").prop("required", false);
            $("#businessCategory_updateN").prop("required", false);
            $("#businessSize_updateN").prop("required", false);
            $("#monthlyAverage_updateN").prop("required", false);
            $("#transactionType_updateN").prop("required", false);
            $("#additionalUnit_updateN").prop("required", false);
            $("#tamarawVariant_updateN").prop("required", false);
            $("#tamarawSpecificUsage_updateN").prop("required", false);
            $("#buyerDecisionHoldReason_updateN").prop("required", false);
            $("#unitInquired_updateN").prop("required", false);
            $("#appointmentDate_updateN").prop("required", false);
            $("#appointmentTime_updateN").prop("required", false);
        } else if ($(this).val() === "COLD") {
            $("#maritalStatusRequired_updateN, #maritalStatusRequired_updateN").addClass("d-none");
            $("#occupationRequired_updateN").addClass("d-none");
            $("#businessNameRequired_updateN").addClass("d-none");
            $("#occupationProvinceRequired_updateN").addClass("d-none");
            $("#occupationMunicipalityRequired_updateN").addClass("d-none");
            $("#occupationBarangayRequired_updateN").addClass("d-none");
            $("#businessCategoryRequired_updateN").addClass("d-none");
            $("#businessAddressRequired_updateN").addClass("d-none");
            $("#businessSizeRequired_updateN").addClass("d-none");
            $("#monthlyAverageRequired_updateN").addClass("d-none");
            $("#buyerTypeRequired_updateN").addClass("d-none");
            $("#transactionTypeRequired_updateN").addClass("d-none");
            $("#hasApplicationRequired_updateN").addClass("d-none");
            $("#hasReservationRequired_updateN").addClass("d-none");
            $("#reservationDateRequired_updateN").addClass("d-none");
            $("#additionalUnitRequired_updateN").addClass("d-none");
            $("#tamarawSpecificUsageRequired_updateN").addClass("d-none");
            $("#buyerDecisionHoldRequired_updateN").addClass("d-none");
            $("#buyerDecisionHoldReasonRequired_updateN").addClass("d-none");
            $("#tamarawVariantRequired_updateN").addClass("d-none");
            $("#unitInquiredRequired_updateN").removeClass("d-none");
            $("#appointmentDateRequired_updateN").removeClass("d-none");
            $("#appointmentTimeRequired_updateN").removeClass("d-none");

            $("#maritalStatus_updateN").prop("required", false);
            $("#occupation_updateN").prop("required", false);
            $("#businessName_updateN").prop("required", false);
            $("#occupationProvince_updateN").prop("required", false);
            $("#occupationMunicipality_updateN").prop("required", false);
            $("#occupationBarangay_updateN").prop("required", false);
            $("#businessCategory_updateN").prop("required", false);
            $("#businessSize_updateN").prop("required", false);
            $("#monthlyAverage_updateN").prop("required", false);
            $("#transactionType_updateN").prop("required", false);
            $("#additionalUnit_updateN").prop("required", false);
            $("#tamarawVariant_updateN").prop("required", false);
            $("#tamarawSpecificUsage_updateN").prop("required", false);
            $("#buyerDecisionHoldReason_updateN").prop("required", false);
            $("#unitInquired_updateN").prop("required", true);
            $("#appointmentDate_updateN").prop("required", true);
            $("#appointmentTime_updateN").prop("required", true);
        } else {
            $("#maritalStatusRequired_updateN").removeClass("d-none");
            $("#occupationRequired_updateN").removeClass("d-none");
            $("#businessNameRequired_updateN").removeClass("d-none");
            $("#occupationProvinceRequired_updateN").removeClass("d-none");
            $("#occupationMunicipalityRequired_updateN").removeClass("d-none");
            $("#occupationBarangayRequired_updateN").removeClass("d-none");
            $("#businessCategoryRequired_updateN").removeClass("d-none");
            $("#businessAddressRequired_updateN").removeClass("d-none");
            $("#businessSizeRequired_updateN").removeClass("d-none");
            $("#monthlyAverageRequired_updateN").removeClass("d-none");
            $("#buyerTypeRequired_updateN").removeClass("d-none");
            $("#transactionTypeRequired_updateN").removeClass("d-none");
            $("#hasApplicationRequired_updateN").removeClass("d-none");
            $("#hasReservationRequired_updateN").removeClass("d-none");
            $("#reservationDateRequired_updateN").removeClass("d-none");
            $("#additionalUnitRequired_updateN").removeClass("d-none");
            $("#tamarawSpecificUsageRequired_updateN").removeClass("d-none");
            $("#buyerDecisionHoldRequired_updateN").removeClass("d-none");
            $("#buyerDecisionHoldReasonRequired_updateN").removeClass("d-none");
            $("#unitInquiredRequired_updateN").removeClass("d-none");
            $("#tamarawVariantRequired_updateN").removeClass("d-none");
            $("#appointmentDateRequired_updateN").removeClass("d-none");
            $("#appointmentTimeRequired_updateN").removeClass("d-none");

            $("#unitInquired_updateN").prop("required", true);
            $("#maritalStatus_updateN").prop("required", true);
            $("#occupation_updateN").prop("required", true);
            $("#businessName_updateN").prop("required", true);

            $("#monthlyAverage_updateN").prop("required", true);
            $("#transactionType_updateN").prop("required", true);
            $("#appointmentDate_updateN").prop("required", true);
            $("#appointmentTime_updateN").prop("required", true);

            if ($("#occupation_updateN").val() === "BUSINESS OWNER") {
                $("#businessCategory_updateN").prop("required", true);
                $("#businessSize_updateN").prop("required", true);
            }
            if ($("#occupation_updateN").val() !== "FREELANCER") {
                $("#occupationProvince_updateN").prop("required", true);
                $("#occupationMunicipality_updateN").prop("required", true);
                $("#occupationBarangay_updateN").prop("required", true);
            }
            if ($("#unitInquired_updateN").val() === "TAMARAW") {
                $("#tamarawSpecificUsage_updateN").prop("required", true);
                $("#tamarawVariant_updateN").prop("required", true);
            }
            if ($("#unitInquired_updateN").val() === "TAMARAW" && $("#occupation_updateN").val() === "BUSINESS OWNER") {
                $("#additionalUnit_updateN").prop("required", true);
            }
            if ($("#unitInquired_updateN").val() === "TAMARAW" && $("input[name='buyerDecisionHold']:checked").val() === "YES") {
                $("#buyerDecisionHoldReason_updateN").prop("required", true);

            }
        }
    });
    $("#province_updateN").on('change', function () {
        const provinceCode = $(this).find(':selected').data('code');
        const provinceType = $(this).find(':selected').data('type');

        let url = '';
        if (provinceType === 'region' && provinceCode === 130000000) {
            url = `https://psgc.gitlab.io/api/regions/${provinceCode}/cities-municipalities/`;
        } else {
            url = `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`;
        }

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                $('#municipality_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                response.forEach(municipality => {
                    $('#municipality_updateN').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                });
            },
            error: function (xhr, status, error) {
                console.error('XHR : ', xhr.responseText);
                console.error('Status : ', status);
                console.error('AJAX error : ', error);
                Swal.fire({
                    title: 'Error! ',
                    text: 'An internal error occurred. Please contact MIS.',
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                })
            }
        }).then(() => {
            $('#municipality_updateN').prop('disabled', true)
        })
    });
    $("#municipality_updateN").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#barangay_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                response.forEach(barangay => {
                    $('#barangay_updateN').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                });
            },
            error: function (xhr, status, error) {
                console.error('XHR : ', xhr.responseText);
                console.error('Status : ', status);
                console.error('AJAX error : ', error);
                Swal.fire({
                    title: 'Error! ',
                    text: 'An internal error occurred. Please contact MIS.',
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                })
            }
        }).then(() => {
            $('#barangay_updateN').prop('disabled', true)
        })
    });
    $("#occupationProvince_updateN").on('change', function () {
        const provinceCode = $(this).find(':selected').data('code');
        const provinceType = $(this).find(':selected').data('type');

        let url = '';
        if (provinceType === 'region' && provinceCode === 130000000) {
            url = `https://psgc.gitlab.io/api/regions/${provinceCode}/cities-municipalities/`;
        } else {
            url = `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`;
        }

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                $('#occupationMunicipality_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                response.forEach(municipality => {
                    $('#occupationMunicipality_updateN').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                });
            },
            error: function (xhr, status, error) {
                console.error('XHR : ', xhr.responseText);
                console.error('Status : ', status);
                console.error('AJAX error : ', error);
                Swal.fire({
                    title: 'Error! ',
                    text: 'An internal error occurred. Please contact MIS.',
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                })
            }
        });
    });
    $("#occupationMunicipality_updateN").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#occupationBarangay_updateN').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);
                response.forEach(barangay => {
                    $('#occupationBarangay_updateN').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                });
            },
            error: function (xhr, status, error) {
                console.error('XHR : ', xhr.responseText);
                console.error('Status : ', status);
                console.error('AJAX error : ', error);
                Swal.fire({
                    title: 'Error! ',
                    text: 'An internal error occurred. Please contact MIS.',
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                })
            }
        });
    });
    $(document).on("change", "#maritalStatus_updateN", function () {
        const othersGroup = $("#maritalStatusOthersRow_updateN");
        const othersInput = $("#maritalStatusOtherInput_updateN");
        const selected = $("#maritalStatus_updateN").val();
        if (selected === "OTHERS") {
            othersInput.val("");
            if (othersGroup.hasClass('d-none')) {
                othersGroup.removeClass("d-none");
                othersGroup.addClass("d-flex");
                othersInput.prop("required", true).focus();
            }
        } else {
            if (othersGroup.hasClass('d-flex')) {
                othersGroup.addClass("d-none");
                othersGroup.removeClass("d-flex");
                othersInput.prop("required", false).removeClass("is-invalid");
            }
            othersInput.val($(this).val());
        }
    });
    $(document).on("change", "#occupation_updateN", function () {
        const val = $(this).val();
        const prospectType = $("input[name='prospectType']:checked").val();
        const unitInquired = $("#unitInquired_updateN").val();

        $(".occupationLabel").text("Occupation");
        $("#businessCategoryRow_updateN, #businessSizeRow_updateN, #businessNameRow_updateN, #businessAddressRow_updateN, #additionalUnitRow_updateN").addClass("d-none");
        $("#businessCategory_updateN, #businessSize_updateN, #businessName_updateN, #additionalUnit_updateN").prop("required", false);

        if (prospectType !== "COLD" && prospectType !== "LOST") {
            $("#occupationProvince_updateN, #occupationMunicipality_updateN, #occupationBarangay_updateN").prop('required', true);
        }

        if (val === "BUSINESS OWNER") {
            $(".occupationLabel").text("Business");

            $("#businessCategoryRow_updateN, #businessSizeRow_updateN, #businessNameRow_updateN, #businessAddressRow_updateN")
                .removeClass("d-none");

            if (prospectType !== "COLD" && prospectType !== "LOST") {
                $("#businessCategory_updateN, #businessSize_updateN").prop("required", true);
                $("#businessName_updateN").prop("required", true);
            }

            if (unitInquired === "TAMARAW") {
                $("#additionalUnitRow_updateN").removeClass("d-none");
                if (prospectType !== "COLD" && prospectType !== "LOST") {
                    $("#additionalUnit_updateN").prop("required", true);
                }
            }
        } else if (val === "EMPLOYED" || val === "OFW/SEAMAN") {
            $(".occupationLabel").text("Employer");

            $("#businessNameRow_updateN, #businessAddressRow_updateN").removeClass("d-none");
        } else if (val === "FREELANCER") {
            $("#occupationProvince_updateN, #occupationMunicipality_updateN, #occupationBarangay_updateN").prop('required', false);
        } else {
            if (val === "FAMILY SUPPORT/GIFT/DONATION") {
                $(".occupationLabel").text("Sponsor");
            } else if (val === "PENSIONER") {
                $(".occupationLabel").text("Pensioner");
            }

            $("#businessNameRow_updateN, #businessAddressRow_updateN").removeClass("d-none");
        }
    });

    $(document).on('change', '#inquirySource_updateN', function () {
        if ($(this).val() === "FACE TO FACE") {
            if ($("#f2fSourceRow_updateN").hasClass('d-none')) {
                $("#f2fSourceRow_updateN").removeClass('d-none');
                $("#f2fSource_updateN").prop('required', true);
            }
            if (!$("#onlineSourceRow_updateN").hasClass('d-none')) {
                $("#onlineSourceRow_updateN").addClass('d-none');
                $("#onlineSource_updateN").val("").trigger('change');
                $("#onlineSource_updateN").prop('required', false);
            }
        } else if ($(this).val() === "ONLINE") {
            if ($("#onlineSourceRow_updateN").hasClass('d-none')) {
                $("#onlineSourceRow_updateN").removeClass('d-none');
                $("#onlineSource_updateN").prop('required', true);
            }
            if (!$("#f2fSourceRow_updateN").hasClass('d-none')) {
                $("#f2fSourceRow_updateN").addClass('d-none');
                $("#f2fSource_updateN").val("").trigger('change');
                $("#f2fSource_updateN").prop('required', false);
            }
        }
    });
    $(document).on('change', '#f2fSource_updateN', function () {
        if ($(this).val() === "MALL DISPLAY") {
            if ($("#mallDisplayRow_updateN").hasClass('d-none')) {
                $("#mallDisplayRow_updateN").removeClass('d-none');
                $("#mallDisplay_updateN").prop('required', true);
            }
        } else {
            if (!$("#mallDisplayRow_updateN").hasClass('d-none')) {
                $("#mallDisplayRow_updateN").addClass('d-none');
                $("#mallDisplay_updateN").prop('required', false);
                $("#mallDisplay_updateN").val('');
            }
        }
    });
    $(document).on('change', '#unitInquired_updateN', function () {
        if ($(this).val() === "TAMARAW") {
            if ($("#tamarawVariantRow_updateN").hasClass('d-none')) {
                $("#tamarawVariantRow_updateN").removeClass('d-none');
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#tamarawVariant_updateN").prop('required', true);
                    $("#tamarawSpecificUsage_updateN").prop('required', true);
                }


                $("#tamarawSpecificUsageRow_updateN").removeClass("d-none");
                $("#buyerDecisionHoldRow_updateN").removeClass("d-none");
            }
            if ($("#occupation_updateN").val() === "BUSINESS OWNER") {
                $("#additionalUnitRow_updateN").removeClass("d-none");
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#additionalUnit_updateN").prop("required", true);
                }
            }
        } else {
            if (!$("#tamarawVariantRow_updateN").hasClass('d-none')) {
                $("#tamarawVariantRow_updateN").addClass('d-none');
                $("#tamarawVariant_updateN").prop('required', false);
                $("#tamarawVariant_updateN").val('');
                $("#tamarawVariant_updateN").prop('required', false);
                $("#tamarawSpecificUsage_updateN").prop('required', false);


                $("#additionalUnitRow_updateN").addClass("d-none");
                $("#additionalUnit_updateN").prop("required", false);
                $("#additionalUnit_updateN").val("");
                $("#tamarawSpecificUsageRow_updateN").addClass("d-none");
                $("#tamarawSpecificUsage_updateN").val("");
                $("#buyerDecisionHoldRow_updateN").addClass("d-none");
                $('#buyerDecisionHold_yes_updateN, #buyerDecisionHold_no_updateN').prop('checked', false).trigger('change');
            }
        }
    });
    $(document).on('change', '#hasReservation_yes_updateN, #hasReservation_no_updateN', function () {
        if ($(this).val() === "YES") {
            if ($("#reservationDateRow_updateN").hasClass('d-none')) {
                $("#reservationDateRow_updateN").removeClass('d-none');
                $("#reservationDate_updateN").prop("required", true);
            }
        } else if ($(this).val() === "NO") {
            if (!$("#reservationDateRow_updateN").hasClass('d-none')) {
                $("#reservationDateRow_updateN").addClass('d-none');
                $("#reservationDate_updateN").prop("required", false);
                $("#reservationDate_updateN").val("");
            }
        }
    });
    $(document).on('change', '#buyerDecisionHold_yes_updateN, #buyerDecisionHold_no_updateN', function () {
        if ($(this).val() === "YES") {
            if ($("#buyerDecisionHoldReasonRow_updateN").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonRow_updateN").removeClass('d-none');
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#buyerDecisionHoldReason_updateN").prop("required", true);
                }
            }
        } else if ($(this).val() === "NO") {
            if (!$("#buyerDecisionHoldReasonRow_updateN").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonRow_updateN").addClass('d-none');
                $("#buyerDecisionHoldReason_updateN").prop("required", false);
                $("#buyerDecisionHoldReason_updateN").val("");
            }
        }
    });

    let updateInquiryNotificationFormValidationTimeout;
    $("#updateInquiryNotificationForm").submit(function (e) {
        e.preventDefault();
        const historyId = $("#historyId_updateN").val();
        const formData = $(this).serialize();
        if (updateInquiryNotificationFormValidationTimeout) {
            clearTimeout(updateInquiryNotificationFormValidationTimeout);
        }
        $("#updateInquiryNotificationForm").removeClass("was-validated");

        let updateFirstValidity = !this.checkValidity();
        let updateSecondValidity = !$("#updateInquiryNotificationForm input[name='gender']:checked").val();
        let updateThirdValidity;
        let updateFourthValidity;

        if ($("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "LOST") {
            updateThirdValidity = !$("#updateInquiryNotificationForm input[name='buyerType']:checked").val() ||
                !$("#updateInquiryNotificationForm input[name='hasApplication']:checked").val() ||
                !$("#updateInquiryNotificationForm input[name='hasReservation']:checked").val();
            updateFourthValidity = $("#unitInquired_updateN").val() === "TAMARAW" &&
                !$("#updateInquiryNotificationForm input[name='buyerDecisionHold']:checked").val();
        } else {
            updateThirdValidity = false;
            updateFourthValidity = false;
        }

        if (updateFirstValidity || updateSecondValidity || updateThirdValidity || updateFourthValidity) {
            e.stopPropagation();
        } else {
            $.ajax({
                type: "POST",
                url: "../../backend/sales-management/updateInquiry.php",
                data: formData,
                success: function (response) {
                    if (response.status === "success") {
                        $.ajax({
                            type: "POST",
                            url: "../../backend/sales-management/toggleNotificationActivity.php",
                            data: {
                                historyId: historyId
                            },
                            success: function (response) {
                                if (response.status === "success") {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: `Inquiry Updated Successfully!`,
                                        icon: 'success',
                                        confirmButtonColor: 'var(--bs-success)'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: `${response.message}`,
                                        text: 'An internal error occurred. Please contact MIS.',
                                        icon: 'error',
                                        confirmButtonColor: 'var(--bs-danger)'
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            text: 'An internal error occurred. Please contact MIS.',
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        });
                    }
                }
            });
        }
        $(this).addClass('was-validated');
        if (!$("#updateInquiryNotificationForm input[name='prospectType']:checked").val()) {
            $(".prospectRadioGroup_updateN").addClass("radio-invalid");
        } else {
            $(".prospectRadioGroup_updateN").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryNotificationForm input[name='buyerType']:checked").val() && ($("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".buyerTypeRadioGroup_updateN").addClass("radio-invalid");
        } else {
            $(".buyerTypeRadioGroup_updateN").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryNotificationForm input[name='hasApplication']:checked").val() && ($("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".hasApplicationRadioGroup_updateN").addClass("radio-invalid");
        } else {
            $(".hasApplicationRadioGroup_updateN").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryNotificationForm input[name='hasReservation']:checked").val() && ($("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".hasReservationRadioGroup_updateN").addClass("radio-invalid");
        } else {
            $(".hasReservationRadioGroup_updateN").removeClass("radio-invalid");
        }
        if ($("#unitInquired_updateN").val() === "TAMARAW" && !$("#updateInquiryNotificationForm input[name='buyerDecisionHold']:checked").val() && ($("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryNotificationForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".buyerDecisionHoldRadioGroup_updateN").addClass("radio-invalid");
        } else {
            $(".buyerDecisionHoldRadioGroup_updateN").removeClass("radio-invalid");
        }
        updateInquiryNotificationFormValidationTimeout = setTimeout(() => {
            $("#updateInquiryNotificationForm").removeClass("was-validated");
            $(".prospectRadioGroup_updateN").removeClass("radio-invalid");
            $(".genderRadioGroup_updateN").removeClass("radio-invalid");
            $(".buyerTypeRadioGroup_updateN").removeClass("radio-invalid");
            $(".hasApplicationRadioGroup_updateN").removeClass("radio-invalid");
            $(".hasReservationRadioGroup_updateN").removeClass("radio-invalid");
            $(".buyerDecisionHoldRadioGroup_updateN").removeClass("radio-invalid");
        }, 3000);
    });

    $("#updateInquiryNotificationModal").on('hidden.bs.modal', function () {
        $("#viewInquiryDetailsNotificationModal").modal('show');
        $("#updateInquiryNotificationForm")[0].reset();
    });
});