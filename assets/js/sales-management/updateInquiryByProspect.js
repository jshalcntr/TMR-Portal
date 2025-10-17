$(document).ready(function () {
    function populateUpdateBPInquiryFields() {
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
                    $("#mallDisplay_updateBP").empty().append(`<option value="">--Select Mall--</option>`);
                    malls.forEach(mall => {
                        $("#mallDisplay_updateBP").append(`<option value="${mall.mall_name}">${mall.mall_name}</option>`);
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
            $('#province_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Province--</option>`);
            $('#municipality_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);
            $('#barangay_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);

            $('#province_updateBP').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);
            response1.forEach(province => {
                $('#province_updateBP').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
            });

            // Select2 init
            $("#province_updateBP, #municipality_updateBP, #barangay_updateBP").select2({
                placeholder: `--Select--`,
                width: '100%',
                dropdownParent: $('#updateInquiryByProspectModal')
            });

            // --- Populate vehicles ---
            const responseVehicles = resVehicles[0];
            if (responseVehicles.status === 'success') {
                $("#unitInquired_updateBP").empty().append(`<option value="" hidden>--Select Vehicle--</option>`);
                responseVehicles.data.forEach(vehicle => {
                    $("#unitInquired_updateBP").append(`<option value="${vehicle.vehicle_name}">${vehicle.vehicle_name}</option>`);
                });
            }

            // --- Populate second provinces (occupation) ---
            const response2 = res2[0];
            $('#occupationProvince_updateBP').empty().append(`<option value="" selected hidden>--Select Province--</option>`);
            $('#occupationMunicipality_updateBP').empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);
            $('#occupationBarangay_updateBP').empty().append(`<option value="" selected hidden>--Select Barangay--</option>`);

            $('#occupationProvince_updateBP').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);
            response2.forEach(province => {
                $('#occupationProvince_updateBP').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
            });

            // Select2 init
            $("#occupationProvince_updateBP, #occupationMunicipality_updateBP, #occupationBarangay_updateBP").select2({
                placeholder: `--Select--`,
                width: '100%',
                dropdownParent: $('#updateInquiryByProspectModal')
            });

        }).fail((xhr, status, error) => {
            console.error("populateUpdateBPInquiryFields error:", error);
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
    $("#updateInquiryByProspectBtn").on('click', function () {

        const inquiryId = $(this).data('inquiry-id');

        populateUpdateBPInquiryFields().then(() => {
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

                        $("#inquiryId_updateBP").val(inquiryId);
                        $("#currentProspectType_byProspect").text(prospectType);
                        $("#currentProspectTypeIcon_byProspect").removeClass("fa-fire fa-snowflake fa-mitten fa-person-circle-question");
                        $("#currentProspectTypeRow_byProspect").removeClass("text-danger text-warning text-info text-secondary");
                        if (prospectType === "HOT") {
                            $("#currentProspectTypeIcon_byProspect").addClass("fa-fire");
                            $("#currentProspectTypeRow_byProspect").addClass("text-danger");
                        } else if (prospectType === "WARM") {
                            $("#currentProspectTypeIcon_byProspect").addClass("fa-mitten");
                            $("#currentProspectTypeRow_byProspect").addClass("text-warning");
                        } else if (prospectType === "COLD") {
                            $("#currentProspectTypeIcon_byProspect").addClass("fa-snowflake");
                            $("#currentProspectTypeRow_byProspect").addClass("text-info");
                        } else if (prospectType === "LOST") {
                            $("#currentProspectTypeIcon_byProspect").addClass("fa-person-circle-question");
                            $("#currentProspectTypeRow_byProspect").addClass("text-secondary");
                        }
                        $("#customerFirstName_updateBP").val(customerFirstName);
                        $("#customerMiddleName_updateBP").val(customerMiddleName);
                        $("#customerLastName_updateBP").val(customerLastName);
                        $("#province_updateBP").val(province).trigger('change');
                        const provinceCode = $("#province_updateBP").find(':selected').data('code');
                        const provinceType = $("#province_updateBP").find(':selected').data('type');

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
                                $('#municipality_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                                response.forEach(municipality => {
                                    $('#municipality_updateBP').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                                });
                                $("#municipality_updateBP").val(municipality).trigger('change');
                                const municipalityCode = $("#municipality_updateBP").find(':selected').data('code');
                                $.ajax({
                                    type: "GET",
                                    url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
                                    dataType: "json",
                                    success: function (response) {
                                        $('#barangay_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                                        response.forEach(barangay => {
                                            $('#barangay_updateBP').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                                        });
                                        $("#barangay_updateBP").val(barangay);
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

                        $("#street_updateBP").val(street);
                        $("#contactNumber_updateBP").val(contactNumber);
                        if (gender === "MALE") {
                            $("#gender_male_updateBP").prop('checked', true);
                        } else if (gender === "FEMALE") {
                            $("#gender_female_updateBP").prop('checked', true);
                        } else if (gender === "LGBTQ+") {
                            $("#gender_lgbt_updateBP").prop('checked', true);
                        }
                        if (maritalStatus !== "SINGLE" && maritalStatus !== "MARRIED" && maritalStatus !== "DIVORCED" && maritalStatus !== "SEPARATED" && maritalStatus !== "WIDOWED" && maritalStatus !== "ANNULED" && maritalStatus !== "") {
                            $("#maritalStatus_updateBP").val("OTHERS").trigger('change');
                            $("#maritalStatusOtherInput_updateBP").val(maritalStatus).trigger('change');
                        } else {
                            $("#maritalStatus_updateBP").val(maritalStatus).trigger('change');
                        }
                        $("#birthday_updateBP").val(birthday);
                        $("#occupation_updateBP").val(occupation).trigger('change');
                        $("#businessName_updateBP").val(businessName);

                        $(".occupationLabel_updateBP").text("Occupation");
                        $("#businessCategoryRow_updateBP, #businessSizeRow_updateBP, #businessNameRow_updateBP, #businessAddressRow_updateBP, #additionalUnitRow_updateBP").addClass("d-none");
                        $("#businessCategory_updateBP, #businessSize_updateBP, #businessName_updateBP, #additionalUnit_updateBP").prop("required", false);
                        if (occupation === "BUSINESS OWNER") {
                            $(".occupationLabel_updateBP").text("Business");
                            $("#businessCategoryRow_updateBP, #businessSizeRow_updateBP, #businessNameRow_updateBP, #businessAddressRow_updateBP").removeClass("d-none");
                        } else if (occupation === "EMPLOYED" || occupation === "OFW/SEAMAN") {
                            $("#businessNameRow_updateBP, #businessAddressRow_updateBP").removeClass("d-none");
                            $(".occupationLabel_updateBP").text("Employer");
                        } else if (occupation === "FREELANCER") {
                            $("#occupationProvince_updateBP, #occupationMunicipality_updateBP, #occupationBarangay_updateBP").prop('required', false);
                        } else {
                            if (occupation === "FAMILY SUPPORT/GIFT/DONATION") {
                                $(".occupationLabel_updateBP").text("Sponsor");
                            } else if (occupation === "PENSIONER") {
                                $(".occupationLabel_updateBP").text("Pensioner");
                            }
                            $("#businessNameRow_updateBP, #businessAddressRow_updateBP").removeClass("d-none");
                        }
                        if (occupationProvince) {
                            $("#occupationProvince_updateBP").val(occupationProvince).trigger('change');
                            const occupationProvinceCode = $(occupationProvince_updateBP).find(':selected').data('code');
                            const occupationProvinceType = $(occupationProvince_updateBP).find(':selected').data('type');

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
                                    $('#occupationMunicipality_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                                    response.forEach(municipality => {
                                        $('#occupationMunicipality_updateBP').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                                    });
                                    $("#occupationMunicipality_updateBP").val(occupationMunicipality).trigger('change');
                                    const occupationMunicipalityCode = $(occupationMunicipality_updateBP).find(':selected').data('code');
                                    $.ajax({
                                        type: "GET",
                                        url: `https://psgc.gitlab.io/api/cities-municipalities/${occupationMunicipalityCode}/barangays/`,
                                        dataType: "json",
                                        success: function (response) {
                                            $('#occupationBarangay_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);
                                            response.forEach(barangay => {
                                                $('#occupationBarangay_updateBP').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                                            });
                                            $("#occupationBarangay_updateBP").val(occupationBarangay);
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
                        $("#occupationStreet_updateBP").val(occupationStreet);
                        $("#businessCategory_updateBP").val(businessCategory);
                        $("#businessSize_updateBP").val(businessSize);
                        $("#monthlyAverage_updateBP").val(monthlyAverage);

                        $("#inquiryDate_updateBP").val(inquiryDate);
                        $("#inquirySource_updateBP").val(inquirySource).trigger('change');
                        if (inquirySource === "FACE TO FACE") {
                            $("#f2fSource_updateBP").val(inquirySourceType).trigger('change');
                        } else if (inquirySource === "ONLINE") {
                            $("#onlineSource_updateBP").val(inquirySourceType).trigger('change');
                        }
                        $("#f2fSource_updateBP").val(inquirySourceType);
                        $("#onlineSource_updateBP").val(inquirySourceType);

                        $("#mallDisplay_updateBP").val(mallDisplay);
                        if (buyerType === "FIRST-TIME") {
                            $("#buyerType_first_updateBP").prop('checked', true);
                        } else if (buyerType === "REPLACEMENT") {
                            $("#buyerType_replacement_updateBP").prop('checked', true);
                        } else if (buyerType === "ADDITIONAL") {
                            $("#buyerType_additional_updateBP").prop('checked', true);
                        }
                        $("#unitInquired_updateBP").val(unitInquired).trigger('change');
                        $("#tamarawVariant_updateBP").val(tamarawVariant);
                        $("#transactionType_updateBP").val(transactionType);
                        if (hasApplication === "YES") {
                            $("#hasApplication_yes_updateBP").prop('checked', true).trigger('change');
                        } else if (hasApplication === "NO") {
                            $("#hasApplication_no_updateBP").prop('checked', true).trigger('change');
                        }
                        if (hasReservation === "YES") {
                            $("#hasReservation_yes_updateBP").prop('checked', true).trigger('change');
                        } else if (hasReservation === "NO") {
                            $("#hasReservation_no_updateBP").prop('checked', true).trigger('change');
                        }
                        $("#reservationDate_updateBP").val(reservationDate);
                        $("#additionalUnit_updateBP").val(additionalUnit);
                        $("#tamarawSpecificUsage_updateBP").val(tamarawSpecificUsage);
                        if (buyerDecisionHold === "YES") {
                            $("#buyerDecisionHold_yes_updateBP").prop('checked', true).trigger('change');
                        } else if (buyerDecisionHold === "NO") {
                            $("#buyerDecisionHold_no_updateBP").prop('checked', true).trigger('change');
                        }
                        $("#buyerDecisionHoldReason_updateBP").val(buyerDecisionHoldReason);
                        // $("#appointmentDate_updateBP").val(appointmentDate);
                        // $("#appointmentTime_updateBP").val(appointmentTime);

                        if (maritalStatus === "OTHERS") {
                            $("#maritalStatusOthersRow_updateBP").removeClass("d-none");
                            $("#maritalStatusOtherInput_updateBP").prop("required", true).focus();
                        } else {
                            $("#maritalStatusOthersRow_updateBP").addClass("d-none");
                            $("#maritalStatusOtherInput_updateBP").prop("required", false).removeClass("is-invalid");
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
                $("#customerFirstName_updateBP").prop("disabled", true);
                $("#customerMiddleName_updateBP").prop("disabled", true);
                $("#customerLastName_updateBP").prop("disabled", true);
                $("#province_updateBP").prop("disabled", true);
                $("#municipality_updateBP").prop("disabled", true);
                $("#barangay_updateBP").prop("disabled", true);
                $("#street_updateBP").prop("disabled", true);
                $("#contactNumber_updateBP").prop("disabled", true);
                $("#gender_male_updateBP").prop("disabled", true);
                $("#gender_female_updateBP").prop("disabled", true);
                $("#gender_lgbt_updateBP").prop("disabled", true);
                $("#inquiryDate_updateBP").prop("disabled", true);
                $("#inquirySource_updateBP").prop("disabled", true);
                $("#f2fSource_updateBP").prop("disabled", true);
                $("#onlineSource_updateBP").prop("disabled", true);
                $("#mallDisplay_updateBP").prop("disabled", true);
            });
        });

    });
    $("#updateInquiryByProspectForm input[name='prospectType']").on('change', function () {
        if ($(this).val() === "LOST") {
            $("#maritalStatusRequired_updateBP").addClass("d-none");
            $("#birthdayRequired_updateBP").addClass("d-none");
            $("#occupationRequired_updateBP").addClass("d-none");
            $("#businessNameRequired_updateBP").addClass("d-none");
            $("#occupationProvinceRequired_updateBP").addClass("d-none");
            $("#occupationMunicipalityRequired_updateBP").addClass("d-none");
            $("#occupationBarangayRequired_updateBP").addClass("d-none");
            $("#businessCategoryRequired_updateBP").addClass("d-none");
            $("#businessAddressRequired_updateBP").addClass("d-none");
            $("#businessSizeRequired_updateBP").addClass("d-none");
            $("#monthlyAverageRequired_updateBP").addClass("d-none");
            $("#buyerTypeRequired_updateBP").addClass("d-none");
            $("#transactionTypeRequired_updateBP").addClass("d-none");
            $("#hasApplicationRequired_updateBP").addClass("d-none");
            $("#hasReservationRequired_updateBP").addClass("d-none");
            $("#reservationDateRequired_updateBP").addClass("d-none");
            $("#additionalUnitRequired_updateBP").addClass("d-none");
            $("#tamarawSpecificUsageRequired_updateBP").addClass("d-none");
            $("#buyerDecisionHoldRequired_updateBP").addClass("d-none");
            $("#buyerDecisionHoldReasonRequired_updateBP").addClass("d-none");
            $("#unitInquiredRequired_updateBP").addClass("d-none");
            $("#tamarawVariantRequired_updateBP").addClass("d-none");
            $("#appointmentDateRequired_updateBP").addClass("d-none");
            $("#appointmentTimeRequired_updateBP").addClass("d-none");

            $("#maritalStatus_updateBP").prop("required", false);
            $("#birthday_updateBP").prop("required", false);
            $("#occupation_updateBP").prop("required", false);
            $("#businessName_updateBP").prop("required", false);
            $("#occupationProvince_updateBP").prop("required", false);
            $("#occupationMunicipality_updateBP").prop("required", false);
            $("#occupationBarangay_updateBP").prop("required", false);
            $("#businessCategory_updateBP").prop("required", false);
            $("#businessSize_updateBP").prop("required", false);
            $("#monthlyAverage_updateBP").prop("required", false);
            $("#transactionType_updateBP").prop("required", false);
            $("#additionalUnit_updateBP").prop("required", false);
            $("#tamarawVariant_updateBP").prop("required", false);
            $("#tamarawSpecificUsage_updateBP").prop("required", false);
            $("#buyerDecisionHoldReason_updateBP").prop("required", false);
            $("#unitInquired_updateBP").prop("required", false);
            $("#appointmentDate_updateBP").prop("required", false);
            $("#appointmentTime_updateBP").prop("required", false);
        } else if ($(this).val() === "COLD") {
            $("#maritalStatusRequired_updateBP, #maritalStatusRequired_updateBP").addClass("d-none");
            $("#birthdayRequired_updateBP").addClass("d-none");
            $("#occupationRequired_updateBP").addClass("d-none");
            $("#businessNameRequired_updateBP").addClass("d-none");
            $("#occupationProvinceRequired_updateBP").addClass("d-none");
            $("#occupationMunicipalityRequired_updateBP").addClass("d-none");
            $("#occupationBarangayRequired_updateBP").addClass("d-none");
            $("#businessCategoryRequired_updateBP").addClass("d-none");
            $("#businessAddressRequired_updateBP").addClass("d-none");
            $("#businessSizeRequired_updateBP").addClass("d-none");
            $("#monthlyAverageRequired_updateBP").addClass("d-none");
            $("#buyerTypeRequired_updateBP").addClass("d-none");
            $("#transactionTypeRequired_updateBP").addClass("d-none");
            $("#hasApplicationRequired_updateBP").addClass("d-none");
            $("#hasReservationRequired_updateBP").addClass("d-none");
            $("#reservationDateRequired_updateBP").addClass("d-none");
            $("#additionalUnitRequired_updateBP").addClass("d-none");
            $("#tamarawSpecificUsageRequired_updateBP").addClass("d-none");
            $("#buyerDecisionHoldRequired_updateBP").addClass("d-none");
            $("#buyerDecisionHoldReasonRequired_updateBP").addClass("d-none");
            $("#tamarawVariantRequired_updateBP").addClass("d-none");
            $("#unitInquiredRequired_updateBP").removeClass("d-none");
            $("#appointmentDateRequired_updateBP").removeClass("d-none");
            $("#appointmentTimeRequired_updateBP").removeClass("d-none");

            $("#maritalStatus_updateBP").prop("required", false);
            $("#birthday_updateBP").prop("required", false);
            $("#occupation_updateBP").prop("required", false);
            $("#businessName_updateBP").prop("required", false);
            $("#occupationProvince_updateBP").prop("required", false);
            $("#occupationMunicipality_updateBP").prop("required", false);
            $("#occupationBarangay_updateBP").prop("required", false);
            $("#businessCategory_updateBP").prop("required", false);
            $("#businessSize_updateBP").prop("required", false);
            $("#monthlyAverage_updateBP").prop("required", false);
            $("#transactionType_updateBP").prop("required", false);
            $("#additionalUnit_updateBP").prop("required", false);
            $("#tamarawVariant_updateBP").prop("required", false);
            $("#tamarawSpecificUsage_updateBP").prop("required", false);
            $("#buyerDecisionHoldReason_updateBP").prop("required", false);
            $("#unitInquired_updateBP").prop("required", true);
            $("#appointmentDate_updateBP").prop("required", true);
            $("#appointmentTime_updateBP").prop("required", true);
        } else {
            $("#maritalStatusRequired_updateBP").removeClass("d-none");
            $("#birthdayRequired_updateBP").removeClass("d-none");
            $("#occupationRequired_updateBP").removeClass("d-none");
            $("#businessNameRequired_updateBP").removeClass("d-none");
            $("#occupationProvinceRequired_updateBP").removeClass("d-none");
            $("#occupationMunicipalityRequired_updateBP").removeClass("d-none");
            $("#occupationBarangayRequired_updateBP").removeClass("d-none");
            $("#businessCategoryRequired_updateBP").removeClass("d-none");
            $("#businessAddressRequired_updateBP").removeClass("d-none");
            $("#businessSizeRequired_updateBP").removeClass("d-none");
            $("#monthlyAverageRequired_updateBP").removeClass("d-none");
            $("#buyerTypeRequired_updateBP").removeClass("d-none");
            $("#transactionTypeRequired_updateBP").removeClass("d-none");
            $("#hasApplicationRequired_updateBP").removeClass("d-none");
            $("#hasReservationRequired_updateBP").removeClass("d-none");
            $("#reservationDateRequired_updateBP").removeClass("d-none");
            $("#additionalUnitRequired_updateBP").removeClass("d-none");
            $("#tamarawSpecificUsageRequired_updateBP").removeClass("d-none");
            $("#buyerDecisionHoldRequired_updateBP").removeClass("d-none");
            $("#buyerDecisionHoldReasonRequired_updateBP").removeClass("d-none");
            $("#unitInquiredRequired_updateBP").removeClass("d-none");
            $("#tamarawVariantRequired_updateBP").removeClass("d-none");
            $("#appointmentDateRequired_updateBP").removeClass("d-none");
            $("#appointmentTimeRequired_updateBP").removeClass("d-none");

            $("#unitInquired_updateBP").prop("required", true);
            $("#maritalStatus_updateBP").prop("required", true);
            $("#birthday_updateBP").prop("required", true);
            $("#occupation_updateBP").prop("required", true);
            $("#businessName_updateBP").prop("required", true);

            $("#monthlyAverage_updateBP").prop("required", true);
            $("#transactionType_updateBP").prop("required", true);
            $("#appointmentDate_updateBP").prop("required", true);
            $("#appointmentTime_updateBP").prop("required", true);

            if ($("#occupation_updateBP").val() === "BUSINESS OWNER") {
                $("#businessCategory_updateBP").prop("required", true);
                $("#businessSize_updateBP").prop("required", true);
            }
            if ($("#occupation_updateBP").val() !== "FREELANCER") {
                $("#occupationProvince_updateBP").prop("required", true);
                $("#occupationMunicipality_updateBP").prop("required", true);
                $("#occupationBarangay_updateBP").prop("required", true);
            }
            if ($("#unitInquired_updateBP").val() === "TAMARAW") {
                $("#tamarawSpecificUsage_updateBP").prop("required", true);
                $("#tamarawVariant_updateBP").prop("required", true);
            }
            if ($("#unitInquired_updateBP").val() === "TAMARAW" && $("#occupation_updateBP").val() === "BUSINESS OWNER") {
                $("#additionalUnit_updateBP").prop("required", true);
            }
            if ($("#unitInquired_updateBP").val() === "TAMARAW" && $("input[name='buyerDecisionHold']:checked").val() === "YES") {
                $("#buyerDecisionHoldReason_updateBP").prop("required", true);

            }
        }
    });
    $("#province_updateBP").on('change', function () {
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
                $('#municipality_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                response.forEach(municipality => {
                    $('#municipality_updateBP').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
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
            $('#municipality_updateBP').prop('disabled', true)
        })
    });
    $("#municipality_updateBP").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#barangay_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                response.forEach(barangay => {
                    $('#barangay_updateBP').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
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
            $('#barangay_updateBP').prop('disabled', true)
        })
    });
    $("#occupationProvince_updateBP").on('change', function () {
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
                $('#occupationMunicipality_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                response.forEach(municipality => {
                    $('#occupationMunicipality_updateBP').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
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
    $("#occupationMunicipality_updateBP").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#occupationBarangay_updateBP').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);
                response.forEach(barangay => {
                    $('#occupationBarangay_updateBP').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
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
    $(document).on("change", "#maritalStatus_updateBP", function () {
        const othersGroup = $("#maritalStatusOthersRow_updateBP");
        const othersInput = $("#maritalStatusOtherInput_updateBP");
        const selected = $("#maritalStatus_updateBP").val();
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
    $(document).on("change", "#occupation_updateBP", function () {
        const val = $(this).val();
        const prospectType = $("input[name='prospectType']:checked").val();
        const unitInquired = $("#unitInquired_updateBP").val();

        $(".occupationLabel").text("Occupation");
        $("#businessCategoryRow_updateBP, #businessSizeRow_updateBP, #businessNameRow_updateBP, #businessAddressRow_updateBP, #additionalUnitRow_updateBP").addClass("d-none");
        $("#businessCategory_updateBP, #businessSize_updateBP, #businessName_updateBP, #additionalUnit_updateBP").prop("required", false);

        if (prospectType !== "COLD" && prospectType !== "LOST") {
            $("#occupationProvince_updateBP, #occupationMunicipality_updateBP, #occupationBarangay_updateBP").prop('required', true);
        }

        if (val === "BUSINESS OWNER") {
            $(".occupationLabel").text("Business");

            $("#businessCategoryRow_updateBP, #businessSizeRow_updateBP, #businessNameRow_updateBP, #businessAddressRow_updateBP")
                .removeClass("d-none");

            if (prospectType !== "COLD" && prospectType !== "LOST") {
                $("#businessCategory_updateBP, #businessSize_updateBP").prop("required", true);
                $("#businessName_updateBP").prop("required", true);
            }

            if (unitInquired === "TAMARAW") {
                $("#additionalUnitRow_updateBP").removeClass("d-none");
                if (prospectType !== "COLD" && prospectType !== "LOST") {
                    $("#additionalUnit_updateBP").prop("required", true);
                }
            }
        } else if (val === "EMPLOYED" || val === "OFW/SEAMAN") {
            $(".occupationLabel").text("Employer");

            $("#businessNameRow_updateBP, #businessAddressRow_updateBP").removeClass("d-none");
        } else if (val === "FREELANCER") {
            $("#occupationProvince_updateBP, #occupationMunicipality_updateBP, #occupationBarangay_updateBP").prop('required', false);
        } else {
            if (val === "FAMILY SUPPORT/GIFT/DONATION") {
                $(".occupationLabel").text("Sponsor");
            } else if (val === "PENSIONER") {
                $(".occupationLabel").text("Pensioner");
            }

            $("#businessNameRow_updateBP, #businessAddressRow_updateBP").removeClass("d-none");
        }
    });

    $(document).on('change', '#inquirySource_updateBP', function () {
        if ($(this).val() === "FACE TO FACE") {
            if ($("#f2fSourceRow_updateBP").hasClass('d-none')) {
                $("#f2fSourceRow_updateBP").removeClass('d-none');
                $("#f2fSource_updateBP").prop('required', true);
            }
            if (!$("#onlineSourceRow_updateBP").hasClass('d-none')) {
                $("#onlineSourceRow_updateBP").addClass('d-none');
                $("#onlineSource_updateBP").val("").trigger('change');
                $("#onlineSource_updateBP").prop('required', false);
            }
        } else if ($(this).val() === "ONLINE") {
            if ($("#onlineSourceRow_updateBP").hasClass('d-none')) {
                $("#onlineSourceRow_updateBP").removeClass('d-none');
                $("#onlineSource_updateBP").prop('required', true);
            }
            if (!$("#f2fSourceRow_updateBP").hasClass('d-none')) {
                $("#f2fSourceRow_updateBP").addClass('d-none');
                $("#f2fSource_updateBP").val("").trigger('change');
                $("#f2fSource_updateBP").prop('required', false);
            }
        }
    });
    $(document).on('change', '#f2fSource_updateBP', function () {
        if ($(this).val() === "MALL DISPLAY") {
            if ($("#mallDisplayRow_updateBP").hasClass('d-none')) {
                $("#mallDisplayRow_updateBP").removeClass('d-none');
                $("#mallDisplay_updateBP").prop('required', true);
            }
        } else {
            if (!$("#mallDisplayRow_updateBP").hasClass('d-none')) {
                $("#mallDisplayRow_updateBP").addClass('d-none');
                $("#mallDisplay_updateBP").prop('required', false);
                $("#mallDisplay_updateBP").val('');
            }
        }
    });
    $(document).on('change', '#unitInquired_updateBP', function () {
        if ($(this).val() === "TAMARAW") {
            if ($("#tamarawVariantRow_updateBP").hasClass('d-none')) {
                $("#tamarawVariantRow_updateBP").removeClass('d-none');
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#tamarawVariant_updateBP").prop('required', true);
                    $("#tamarawSpecificUsage_updateBP").prop('required', true);
                }


                $("#tamarawSpecificUsageRow_updateBP").removeClass("d-none");
                $("#buyerDecisionHoldRow_updateBP").removeClass("d-none");
            }
            if ($("#occupation_updateBP").val() === "BUSINESS OWNER") {
                $("#additionalUnitRow_updateBP").removeClass("d-none");
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#additionalUnit_updateBP").prop("required", true);
                }
            }
        } else {
            if (!$("#tamarawVariantRow_updateBP").hasClass('d-none')) {
                $("#tamarawVariantRow_updateBP").addClass('d-none');
                $("#tamarawVariant_updateBP").prop('required', false);
                $("#tamarawVariant_updateBP").val('');
                $("#tamarawVariant_updateBP").prop('required', false);
                $("#tamarawSpecificUsage_updateBP").prop('required', false);


                $("#additionalUnitRow_updateBP").addClass("d-none");
                $("#additionalUnit_updateBP").prop("required", false);
                $("#additionalUnit_updateBP").val("");
                $("#tamarawSpecificUsageRow_updateBP").addClass("d-none");
                $("#tamarawSpecificUsage_updateBP").val("");
                $("#buyerDecisionHoldRow_updateBP").addClass("d-none");
                $('#buyerDecisionHold_yes_updateBP, #buyerDecisionHold_no_updateBP').prop('checked', false).trigger('change');
            }
        }
    });
    $(document).on('change', '#hasReservation_yes_updateBP, #hasReservation_no_updateBP', function () {
        if ($(this).val() === "YES") {
            if ($("#reservationDateRow_updateBP").hasClass('d-none')) {
                $("#reservationDateRow_updateBP").removeClass('d-none');
                $("#reservationDate_updateBP").prop("required", true);
            }
        } else if ($(this).val() === "NO") {
            if (!$("#reservationDateRow_updateBP").hasClass('d-none')) {
                $("#reservationDateRow_updateBP").addClass('d-none');
                $("#reservationDate_updateBP").prop("required", false);
                $("#reservationDate_updateBP").val("");
            }
        }
    });
    $(document).on('change', '#buyerDecisionHold_yes_updateBP, #buyerDecisionHold_no_updateBP', function () {
        if ($(this).val() === "YES") {
            if ($("#buyerDecisionHoldReasonRow_updateBP").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonRow_updateBP").removeClass('d-none');
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#buyerDecisionHoldReason_updateBP").prop("required", true);
                }
            }
        } else if ($(this).val() === "NO") {
            if (!$("#buyerDecisionHoldReasonRow_updateBP").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonRow_updateBP").addClass('d-none');
                $("#buyerDecisionHoldReason_updateBP").prop("required", false);
                $("#buyerDecisionHoldReason_updateBP").val("");
            }
        }
    });

    let updateInquiryByProspectFormValidationTimeout;
    $("#updateInquiryByProspectForm").submit(function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        if (updateInquiryByProspectFormValidationTimeout) {
            clearTimeout(updateInquiryByProspectFormValidationTimeout);
        }
        $("#updateInquiryByProspectForm").removeClass("was-validated");

        let updateFirstValidity = !this.checkValidity();
        let updateSecondValidity = !$("#updateInquiryByProspectForm input[name='gender']:checked").val();
        let updateThirdValidity;
        let updateFourthValidity;

        if ($("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "LOST") {
            updateThirdValidity = !$("#updateInquiryByProspectForm input[name='buyerType']:checked").val() ||
                !$("#updateInquiryByProspectForm input[name='hasApplication']:checked").val() ||
                !$("#updateInquiryByProspectForm input[name='hasReservation']:checked").val();
            updateFourthValidity = $("#unitInquired_updateBP").val() === "TAMARAW" &&
                !$("#updateInquiryByProspectForm input[name='buyerDecisionHold']:checked").val();
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
                        Swal.fire({
                            title: 'Success!',
                            text: `${response.message}`,
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
        }
        $(this).addClass('was-validated');
        if (!$("#updateInquiryByProspectForm input[name='prospectType']:checked").val()) {
            $(".prospectRadioGroup_updateBP").addClass("radio-invalid");
        } else {
            $(".prospectRadioGroup_updateBP").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryByProspectForm input[name='buyerType']:checked").val() && ($("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".buyerTypeRadioGroup_updateBP").addClass("radio-invalid");
        } else {
            $(".buyerTypeRadioGroup_updateBP").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryByProspectForm input[name='hasApplication']:checked").val() && ($("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".hasApplicationRadioGroup_updateBP").addClass("radio-invalid");
        } else {
            $(".hasApplicationRadioGroup_updateBP").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryByProspectForm input[name='hasReservation']:checked").val() && ($("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".hasReservationRadioGroup_updateBP").addClass("radio-invalid");
        } else {
            $(".hasReservationRadioGroup_updateBP").removeClass("radio-invalid");
        }
        if ($("#unitInquired_updateBP").val() === "TAMARAW" && !$("#updateInquiryByProspectForm input[name='buyerDecisionHold']:checked").val() && ($("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryByProspectForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".buyerDecisionHoldRadioGroup_updateBP").addClass("radio-invalid");
        } else {
            $(".buyerDecisionHoldRadioGroup_updateBP").removeClass("radio-invalid");
        }
        updateInquiryByProspectFormValidationTimeout = setTimeout(() => {
            $("#updateInquiryByProspectForm").removeClass("was-validated");
            $(".prospectRadioGroup_updateBP").removeClass("radio-invalid");
            $(".genderRadioGroup_updateBP").removeClass("radio-invalid");
            $(".buyerTypeRadioGroup_updateBP").removeClass("radio-invalid");
            $(".hasApplicationRadioGroup_updateBP").removeClass("radio-invalid");
            $(".hasReservationRadioGroup_updateBP").removeClass("radio-invalid");
            $(".buyerDecisionHoldRadioGroup_updateBP").removeClass("radio-invalid");
        }, 3000);
    });

    $("#updateInquiryByProspectModal").on('hidden.bs.modal', function () {
        $("#viewInquiryDetailsByProspectModal").modal('show');
        $("#updateInquiryByProspectForm")[0].reset();
    });
});