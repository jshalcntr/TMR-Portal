$(document).ready(function () {
    function populateUpdateInquiryFields() {
        // $.ajax({
        //     type: "GET",
        //     url: "../../backend/sales-management/getAllMalls.php",
        //     success: function (response) {
        //         if (response.status === "internal-error") {
        //             Swal.fire({
        //                 title: 'Error! ',
        //                 text: `${response.message}`,
        //                 icon: 'error',
        //                 confirmButtonColor: 'var(--bs-danger)'
        //             })
        //         } else if (response.status === "success") {
        //             const malls = response.data;
        //             $("#mallDisplay_update").empty().append(`<option value="">--Select Mall--</option>`);
        //             malls.forEach(mall => {
        //                 $("#mallDisplay_update").append(`<option value="${mall.mall_name}">${mall.mall_name}</option>`);
        //             });
        //         }
        //     }
        // })
        // const provinces1 = $.ajax({
        //     type: "GET",
        //     dataType: "json",
        //     url: "https://psgc.gitlab.io/api/provinces/"
        // });

        const vehicles = $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getAllVehicles.php"
        });

        const provinces2 = $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://psgc.gitlab.io/api/provinces/"
        });

        return $.when(vehicles, provinces2).done((resVehicles, res2) => {

            // const response1 = res1[0];
            // $('#province_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Province--</option>`);
            // $('#municipality_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);
            // $('#barangay_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);

            // $('#province_update').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);
            // response1.forEach(province => {
            //     $('#province_update').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
            // });

            // $("#province_update, #municipality_update, #barangay_update").select2({
            //     placeholder: `--Select--`,
            //     width: '100%',
            //     dropdownParent: $('#updateInquiryModal')
            // });
            const responseVehicles = resVehicles[0];
            if (responseVehicles.status === 'success') {
                $("#unitInquired_update").empty().append(`<option value="" hidden>--Select Vehicle--</option>`);
                responseVehicles.data.forEach(vehicle => {
                    $("#unitInquired_update").append(`<option value="${vehicle.vehicle_name}">${vehicle.vehicle_name}</option>`);
                });
            }

            const response2 = res2[0];
            $('#occupationProvince_update').empty().append(`<option value="" selected hidden>--Select Province--</option>`);
            $('#occupationMunicipality_update').empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);
            $('#occupationBarangay_update').empty().append(`<option value="" selected hidden>--Select Barangay--</option>`);

            $('#occupationProvince_update').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);
            response2.forEach(province => {
                $('#occupationProvince_update').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
            });

            $("#occupationProvince_update, #occupationMunicipality_update, #occupationBarangay_update").select2({
                placeholder: `--Select--`,
                width: '100%',
                dropdownParent: $('#updateInquiryModal')
            });

        }).fail((xhr, status, error) => {
            console.error("populateUpdateInquiryFields error:", error);
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
    $("#updateInquiryBtn").on('click', function () {

        const inquiryId = $(this).data('inquiry-id');

        populateUpdateInquiryFields().then(() => {
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

                        $("#inquiryId_update").val(inquiryId);
                        $("#currentProspectType").text(prospectType);
                        $("#currentProspectTypeIcon").removeClass("fa-fire fa-snowflake fa-mitten fa-person-circle-question");
                        $("#currentProspectTypeRow").removeClass("text-danger text-warning text-info text-secondary");
                        if (prospectType === "HOT") {
                            $("#currentProspectTypeIcon").addClass("fa-fire");
                            $("#currentProspectTypeRow").addClass("text-danger");
                        } else if (prospectType === "WARM") {
                            $("#currentProspectTypeIcon").addClass("fa-mitten");
                            $("#currentProspectTypeRow").addClass("text-warning");
                        } else if (prospectType === "COLD") {
                            $("#currentProspectTypeIcon").addClass("fa-snowflake");
                            $("#currentProspectTypeRow").addClass("text-info");
                        } else if (prospectType === "LOST") {
                            $("#currentProspectTypeIcon").addClass("fa-person-circle-question");
                            $("#currentProspectTypeRow").addClass("text-secondary");
                        }
                        $("#customerFirstName_update").text(customerFirstName);
                        $("#customerMiddleName_update").text(customerMiddleName ? customerMiddleName : "-");
                        $("#customerLastName_update").text(customerLastName);
                        $("#province_update").text(province);
                        $("#municipality_update").text(municipality);
                        $("#barangay_update").text(barangay);
                        // const provinceCode = $("#province_update").find(':selected').data('code');
                        // const provinceType = $("#province_update").find(':selected').data('type');

                        // let url = '';
                        // if (provinceType === 'region' && provinceCode === 130000000) {
                        //     url = `https://psgc.gitlab.io/api/regions/${provinceCode}/cities-municipalities/`;
                        // } else {
                        //     url = `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`;
                        // }

                        // $.ajax({
                        //     type: "GET",
                        //     url: url,
                        //     dataType: "json",
                        //     success: function (response) {
                        //         $('#municipality_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                        //         response.forEach(municipality => {
                        //             $('#municipality_update').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                        //         });
                        //         const municipalityCode = $("#municipality_update").find(':selected').data('code');
                        //         $.ajax({
                        //             type: "GET",
                        //             url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
                        //             dataType: "json",
                        //             success: function (response) {
                        //                 $('#barangay_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                        //                 response.forEach(barangay => {
                        //                     $('#barangay_update').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                        //                 });
                        //             },
                        //             error: function (xhr, status, error) {
                        //                 console.error('XHR : ', xhr.responseText);
                        //                 console.error('Status : ', status);
                        //                 console.error('AJAX error : ', error);
                        //                 Swal.fire({
                        //                     title: 'Error! ',
                        //                     text: 'An internal error occurred. Please contact MIS.',
                        //                     icon: 'error',
                        //                     confirmButtonColor: 'var(--bs-danger)'
                        //                 })
                        //             }
                        //         });
                        //     },
                        //     error: function (xhr, status, error) {
                        //         console.error('XHR : ', xhr.responseText);
                        //         console.error('Status : ', status);
                        //         console.error('AJAX error : ', error);
                        //         Swal.fire({
                        //             title: 'Error! ',
                        //             text: 'An internal error occurred. Please contact MIS.',
                        //             icon: 'error',
                        //             confirmButtonColor: 'var(--bs-danger)'
                        //         })
                        //     }
                        // });

                        $("#street_update").text(street ? street : "-");
                        $("#contactNumber_update").text(contactNumber);
                        $("#gender_update").text(gender);
                        // if (gender === "MALE") {
                        //     $("#gender_male_update").prop('checked', true);
                        // } else if (gender === "FEMALE") {
                        //     $("#gender_female_update").prop('checked', true);
                        // } else if (gender === "LGBTQ+") {
                        //     $("#gender_lgbt_update").prop('checked', true);
                        // }
                        if (maritalStatus !== "SINGLE" && maritalStatus !== "MARRIED" && maritalStatus !== "DIVORCED" && maritalStatus !== "SEPARATED" && maritalStatus !== "WIDOWED" && maritalStatus !== "ANNULED" && maritalStatus !== "") {
                            $("#maritalStatus_update").val("OTHERS").trigger('change');
                            $("#maritalStatusOtherInput_update").val(maritalStatus).trigger('change');
                        } else {
                            $("#maritalStatus_update").val(maritalStatus).trigger('change');
                        }
                        $("#birthday_update").val(birthday);
                        $("#occupation_update").val(occupation).trigger('change');
                        $("#businessName_update").val(businessName);

                        $(".occupationLabel_update").text("Occupation");
                        $("#businessCategoryRow_update, #businessSizeRow_update, #businessNameRow_update, #businessAddressRow_update, #additionalUnitRow_update").addClass("d-none");
                        $("#businessCategory_update, #businessSize_update, #businessName_update, #additionalUnit_update").prop("required", false);
                        if (occupation === "BUSINESS OWNER") {
                            $(".occupationLabel_update").text("Business");
                            $("#businessCategoryRow_update, #businessSizeRow_update, #businessNameRow_update, #businessAddressRow_update").removeClass("d-none");
                        } else if (occupation === "EMPLOYED" || occupation === "OFW/SEAMAN") {
                            $("#businessNameRow_update, #businessAddressRow_update").removeClass("d-none");
                            $(".occupationLabel_update").text("Employer");
                        } else if (occupation === "FREELANCER") {
                            $("#occupationProvince_update, #occupationMunicipality_update, #occupationBarangay_update").prop('required', false);
                        } else {
                            if (occupation === "FAMILY SUPPORT/GIFT/DONATION") {
                                $(".occupationLabel_update").text("Sponsor");
                            } else if (occupation === "PENSIONER") {
                                $(".occupationLabel_update").text("Pensioner");
                            }
                            $("#businessNameRow_update, #businessAddressRow_update").removeClass("d-none");
                        }
                        if (occupationProvince) {
                            $("#occupationProvince_update").val(occupationProvince).trigger('change');
                            const occupationProvinceCode = $(occupationProvince_update).find(':selected').data('code');
                            const occupationProvinceType = $(occupationProvince_update).find(':selected').data('type');

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
                                    $('#occupationMunicipality_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                                    response.forEach(municipality => {
                                        $('#occupationMunicipality_update').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                                    });
                                    $("#occupationMunicipality_update").val(occupationMunicipality);
                                    if (occupationMunicipality) {
                                        $("#occupationMunicipality_update").trigger('change');
                                        const occupationMunicipalityCode = $(occupationMunicipality_update).find(':selected').data('code');
                                        $.ajax({
                                            type: "GET",
                                            url: `https://psgc.gitlab.io/api/cities-municipalities/${occupationMunicipalityCode}/barangays/`,
                                            dataType: "json",
                                            success: function (response) {
                                                $('#occupationBarangay_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);
                                                response.forEach(barangay => {
                                                    $('#occupationBarangay_update').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                                                });
                                                $("#occupationBarangay_update").val(occupationBarangay);
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
                        $("#occupationStreet_update").val(occupationStreet);
                        $("#businessCategory_update").val(businessCategory);
                        $("#businessSize_update").val(businessSize);
                        $("#monthlyAverage_update").val(monthlyAverage);

                        $("#inquiryDate_update").text(convertToReadableDate(inquiryDate));
                        $("#inquirySource_update").text(inquirySource);
                        if (inquirySource === "FACE TO FACE") {
                            $("#f2fSourceRow_update").removeClass('d-none');
                            $("#onlineSourceRow_update").addClass('d-none');
                            $("#f2fSource_update").text(inquirySourceType);
                            if (inquirySourceType === "MALL DISPLAY") {
                                $("#mallDisplayRow_update").removeClass("d-none");
                                $("#mallDisplay_update").text(mallDisplay);
                            } else {
                                $("#mallDisplayRow_update").addClass("d-none");
                            }
                        } else if (inquirySource === "ONLINE") {
                            $("#onlineSourceRow_update").removeClass('d-none');
                            $("#f2fSourceRow_update").addClass('d-none');
                            $("#f2fSourceRow_update").addClass('d-none');
                            $("#onlineSource_update").text(inquirySourceType);
                            $("#mallDisplayRow_update").addClass("d-none");
                        }
                        if (buyerType === "FIRST-TIME") {
                            $("#buyerType_first_update").prop('checked', true);
                        } else if (buyerType === "REPLACEMENT") {
                            $("#buyerType_replacement_update").prop('checked', true);
                        } else if (buyerType === "ADDITIONAL") {
                            $("#buyerType_additional_update").prop('checked', true);
                        }
                        $("#unitInquired_update").val(unitInquired).trigger('change');
                        $("#tamarawVariant_update").val(tamarawVariant);
                        $("#transactionType_update").val(transactionType);
                        if (hasApplication === "YES") {
                            $("#hasApplication_yes_update").prop('checked', true).trigger('change');
                        } else if (hasApplication === "NO") {
                            $("#hasApplication_no_update").prop('checked', true).trigger('change');
                        }
                        if (hasReservation === "YES") {
                            $("#hasReservation_yes_update").prop('checked', true).trigger('change');
                        } else if (hasReservation === "NO") {
                            $("#hasReservation_no_update").prop('checked', true).trigger('change');
                        }
                        $("#reservationDate_update").val(reservationDate);
                        $("#additionalUnit_update").val(additionalUnit);
                        $("#tamarawSpecificUsage_update").val(tamarawSpecificUsage);
                        if (buyerDecisionHold === "YES") {
                            $("#buyerDecisionHold_yes_update").prop('checked', true).trigger('change');
                        } else if (buyerDecisionHold === "NO") {
                            $("#buyerDecisionHold_no_update").prop('checked', true).trigger('change');
                        }
                        $("#buyerDecisionHoldReason_update").val(buyerDecisionHoldReason);
                        // $("#appointmentDate_update").val(appointmentDate);
                        // $("#appointmentTime_update").val(appointmentTime);

                        if (maritalStatus === "OTHERS") {
                            $("#maritalStatusOthersRow_update").removeClass("d-none");
                            $("#maritalStatusOtherInput_update").prop("required", true).focus();
                        } else {
                            $("#maritalStatusOthersRow_update").addClass("d-none");
                            $("#maritalStatusOtherInput_update").prop("required", false).removeClass("is-invalid");
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
                // $("#customerFirstName_update").prop("disabled", true);
                // $("#customerMiddleName_update").prop("disabled", true);
                // $("#customerLastName_update").prop("disabled", true);
                // $("#province_update").prop("disabled", true);
                // $("#municipality_update").prop("disabled", true);
                // $("#barangay_update").prop("disabled", true);
                // $("#street_update").prop("disabled", true);
                // $("#contactNumber_update").prop("disabled", true);
                // $("#gender_male_update").prop("disabled", true);
                // $("#gender_female_update").prop("disabled", true);
                // $("#gender_lgbt_update").prop("disabled", true);
                // $("#inquiryDate_update").prop("disabled", true);
                // $("#inquirySource_update").prop("disabled", true);
                // $("#f2fSource_update").prop("disabled", true);
                // $("#onlineSource_update").prop("disabled", true);
                // $("#mallDisplay_update").prop("disabled", true);
            });
        });

    });
    $("#updateInquiryForm input[name='prospectType']").on('change', function () {
        if ($(this).val() === "LOST") {
            $("#maritalStatusRequired_update").addClass("d-none");
            $("#occupationRequired_update").addClass("d-none");
            $("#businessNameRequired_update").addClass("d-none");
            $("#occupationProvinceRequired_update").addClass("d-none");
            $("#occupationMunicipalityRequired_update").addClass("d-none");
            $("#occupationBarangayRequired_update").addClass("d-none");
            $("#businessCategoryRequired_update").addClass("d-none");
            $("#businessAddressRequired_update").addClass("d-none");
            $("#businessSizeRequired_update").addClass("d-none");
            $("#monthlyAverageRequired_update").addClass("d-none");
            $("#buyerTypeRequired_update").addClass("d-none");
            $("#transactionTypeRequired_update").addClass("d-none");
            $("#hasApplicationRequired_update").addClass("d-none");
            $("#hasReservationRequired_update").addClass("d-none");
            $("#reservationDateRequired_update").addClass("d-none");
            $("#additionalUnitRequired_update").addClass("d-none");
            $("#tamarawSpecificUsageRequired_update").addClass("d-none");
            $("#buyerDecisionHoldRequired_update").addClass("d-none");
            $("#buyerDecisionHoldReasonRequired_update").addClass("d-none");
            $("#unitInquiredRequired_update").addClass("d-none");
            $("#tamarawVariantRequired_update").addClass("d-none");
            $("#appointmentDateRequired_update").addClass("d-none");
            $("#appointmentTimeRequired_update").addClass("d-none");

            $("#maritalStatus_update").prop("required", false);
            $("#occupation_update").prop("required", false);
            $("#businessName_update").prop("required", false);
            $("#occupationProvince_update").prop("required", false);
            $("#occupationMunicipality_update").prop("required", false);
            $("#occupationBarangay_update").prop("required", false);
            $("#businessCategory_update").prop("required", false);
            $("#businessSize_update").prop("required", false);
            $("#monthlyAverage_update").prop("required", false);
            $("#transactionType_update").prop("required", false);
            $("#additionalUnit_update").prop("required", false);
            $("#tamarawVariant_update").prop("required", false);
            $("#tamarawSpecificUsage_update").prop("required", false);
            $("#buyerDecisionHoldReason_update").prop("required", false);
            $("#unitInquired_update").prop("required", false);
            $("#appointmentDate_update").prop("required", false);
            $("#appointmentTime_update").prop("required", false);
        } else if ($(this).val() === "COLD") {
            $("#maritalStatusRequired_update, #maritalStatusRequired_update").addClass("d-none");
            $("#occupationRequired_update").addClass("d-none");
            $("#businessNameRequired_update").addClass("d-none");
            $("#occupationProvinceRequired_update").addClass("d-none");
            $("#occupationMunicipalityRequired_update").addClass("d-none");
            $("#occupationBarangayRequired_update").addClass("d-none");
            $("#businessCategoryRequired_update").addClass("d-none");
            $("#businessAddressRequired_update").addClass("d-none");
            $("#businessSizeRequired_update").addClass("d-none");
            $("#monthlyAverageRequired_update").addClass("d-none");
            $("#buyerTypeRequired_update").addClass("d-none");
            $("#transactionTypeRequired_update").addClass("d-none");
            $("#hasApplicationRequired_update").addClass("d-none");
            $("#hasReservationRequired_update").addClass("d-none");
            $("#reservationDateRequired_update").addClass("d-none");
            $("#additionalUnitRequired_update").addClass("d-none");
            $("#tamarawSpecificUsageRequired_update").addClass("d-none");
            $("#buyerDecisionHoldRequired_update").addClass("d-none");
            $("#buyerDecisionHoldReasonRequired_update").addClass("d-none");
            $("#tamarawVariantRequired_update").addClass("d-none");
            $("#unitInquiredRequired_update").removeClass("d-none");
            $("#appointmentDateRequired_update").removeClass("d-none");
            $("#appointmentTimeRequired_update").removeClass("d-none");

            $("#maritalStatus_update").prop("required", false);
            $("#occupation_update").prop("required", false);
            $("#businessName_update").prop("required", false);
            $("#occupationProvince_update").prop("required", false);
            $("#occupationMunicipality_update").prop("required", false);
            $("#occupationBarangay_update").prop("required", false);
            $("#businessCategory_update").prop("required", false);
            $("#businessSize_update").prop("required", false);
            $("#monthlyAverage_update").prop("required", false);
            $("#transactionType_update").prop("required", false);
            $("#additionalUnit_update").prop("required", false);
            $("#tamarawVariant_update").prop("required", false);
            $("#tamarawSpecificUsage_update").prop("required", false);
            $("#buyerDecisionHoldReason_update").prop("required", false);
            $("#unitInquired_update").prop("required", true);
            $("#appointmentDate_update").prop("required", true);
            $("#appointmentTime_update").prop("required", true);
        } else {
            $("#maritalStatusRequired_update").removeClass("d-none");
            $("#occupationRequired_update").removeClass("d-none");
            $("#businessNameRequired_update").removeClass("d-none");
            $("#occupationProvinceRequired_update").removeClass("d-none");
            $("#occupationMunicipalityRequired_update").removeClass("d-none");
            $("#occupationBarangayRequired_update").removeClass("d-none");
            $("#businessCategoryRequired_update").removeClass("d-none");
            $("#businessAddressRequired_update").removeClass("d-none");
            $("#businessSizeRequired_update").removeClass("d-none");
            $("#monthlyAverageRequired_update").removeClass("d-none");
            $("#buyerTypeRequired_update").removeClass("d-none");
            $("#transactionTypeRequired_update").removeClass("d-none");
            $("#hasApplicationRequired_update").removeClass("d-none");
            $("#hasReservationRequired_update").removeClass("d-none");
            $("#reservationDateRequired_update").removeClass("d-none");
            $("#additionalUnitRequired_update").removeClass("d-none");
            $("#tamarawSpecificUsageRequired_update").removeClass("d-none");
            $("#buyerDecisionHoldRequired_update").removeClass("d-none");
            $("#buyerDecisionHoldReasonRequired_update").removeClass("d-none");
            $("#unitInquiredRequired_update").removeClass("d-none");
            $("#tamarawVariantRequired_update").removeClass("d-none");
            $("#appointmentDateRequired_update").removeClass("d-none");
            $("#appointmentTimeRequired_update").removeClass("d-none");

            $("#unitInquired_update").prop("required", true);
            $("#maritalStatus_update").prop("required", true);
            $("#occupation_update").prop("required", true);
            $("#businessName_update").prop("required", true);

            $("#monthlyAverage_update").prop("required", true);
            $("#transactionType_update").prop("required", true);
            $("#appointmentDate_update").prop("required", true);
            $("#appointmentTime_update").prop("required", true);

            if ($("#occupation_update").val() === "BUSINESS OWNER") {
                $("#businessCategory_update").prop("required", true);
                $("#businessSize_update").prop("required", true);
            }
            if ($("#occupation_update").val() !== "FREELANCER") {
                $("#occupationProvince_update").prop("required", true);
                $("#occupationMunicipality_update").prop("required", true);
                $("#occupationBarangay_update").prop("required", true);
            }
            if ($("#unitInquired_update").val() === "TAMARAW") {
                $("#tamarawSpecificUsage_update").prop("required", true);
                $("#tamarawVariant_update").prop("required", true);
            }
            if ($("#unitInquired_update").val() === "TAMARAW" && $("#occupation_update").val() === "BUSINESS OWNER") {
                $("#additionalUnit_update").prop("required", true);
            }
            if ($("#unitInquired_update").val() === "TAMARAW" && $("input[name='buyerDecisionHold']:checked").val() === "YES") {
                $("#buyerDecisionHoldReason_update").prop("required", true);

            }
        }
    });
    $("#province_update").on('change', function () {
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
                $('#municipality_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                response.forEach(municipality => {
                    $('#municipality_update').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
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
            $('#municipality_update').prop('disabled', true)
        })
    });
    $("#municipality_update").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#barangay_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                response.forEach(barangay => {
                    $('#barangay_update').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
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
            $('#barangay_update').prop('disabled', true)
        })
    });
    $("#occupationProvince_update").on('change', function () {
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
                $('#occupationMunicipality_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                response.forEach(municipality => {
                    $('#occupationMunicipality_update').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
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
    $("#occupationMunicipality_update").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#occupationBarangay_update').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);
                response.forEach(barangay => {
                    $('#occupationBarangay_update').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
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
    $(document).on("change", "#maritalStatus_update", function () {
        const othersGroup = $("#maritalStatusOthersRow_update");
        const othersInput = $("#maritalStatusOtherInput_update");
        const selected = $("#maritalStatus_update").val();
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
    $(document).on("change", "#occupation_update", function () {
        const val = $(this).val();
        const prospectType = $("input[name='prospectType']:checked").val();
        const unitInquired = $("#unitInquired_update").val();

        $(".occupationLabel").text("Occupation");
        $("#businessCategoryRow_update, #businessSizeRow_update, #businessNameRow_update, #businessAddressRow_update, #additionalUnitRow_update").addClass("d-none");
        $("#businessCategory_update, #businessSize_update, #businessName_update, #additionalUnit_update").prop("required", false);

        if (prospectType !== "COLD" && prospectType !== "LOST") {
            $("#occupationProvince_update, #occupationMunicipality_update, #occupationBarangay_update").prop('required', true);
        }

        if (val === "BUSINESS OWNER") {
            $(".occupationLabel").text("Business");

            $("#businessCategoryRow_update, #businessSizeRow_update, #businessNameRow_update, #businessAddressRow_update")
                .removeClass("d-none");

            if (prospectType !== "COLD" && prospectType !== "LOST") {
                $("#businessCategory_update, #businessSize_update").prop("required", true);
                $("#businessName_update").prop("required", true);
            }

            if (unitInquired === "TAMARAW") {
                $("#additionalUnitRow_update").removeClass("d-none");
                if (prospectType !== "COLD" && prospectType !== "LOST") {
                    $("#additionalUnit_update").prop("required", true);
                }
            }
        } else if (val === "EMPLOYED" || val === "OFW/SEAMAN") {
            $(".occupationLabel").text("Employer");

            $("#businessNameRow_update, #businessAddressRow_update").removeClass("d-none");
        } else if (val === "FREELANCER") {
            $("#occupationProvince_update, #occupationMunicipality_update, #occupationBarangay_update").prop('required', false);
        } else {
            if (val === "FAMILY SUPPORT/GIFT/DONATION") {
                $(".occupationLabel").text("Sponsor");
            } else if (val === "PENSIONER") {
                $(".occupationLabel").text("Pensioner");
            }

            $("#businessNameRow_update, #businessAddressRow_update").removeClass("d-none");
        }
    });

    // $(document).on('change', '#inquirySource_update', function () {
    //     if ($(this).val() === "FACE TO FACE") {
    //         if ($("#f2fSourceRow_update").hasClass('d-none')) {
    //             $("#f2fSourceRow_update").removeClass('d-none');
    //             $("#f2fSource_update").prop('required', true);
    //         }
    //         if (!$("#onlineSourceRow_update").hasClass('d-none')) {
    //             $("#onlineSourceRow_update").addClass('d-none');
    //             $("#onlineSource_update").val("").trigger('change');
    //             $("#onlineSource_update").prop('required', false);
    //         }
    //     } else if ($(this).val() === "ONLINE") {
    //         if ($("#onlineSourceRow_update").hasClass('d-none')) {
    //             $("#onlineSourceRow_update").removeClass('d-none');
    //             $("#onlineSource_update").prop('required', true);
    //         }
    //         if (!$("#f2fSourceRow_update").hasClass('d-none')) {
    //             $("#f2fSourceRow_update").addClass('d-none');
    //             $("#f2fSource_update").val("").trigger('change');
    //             $("#f2fSource_update").prop('required', false);
    //         }
    //     }
    // });
    // $(document).on('change', '#f2fSource_update', function () {
    //     if ($(this).val() === "MALL DISPLAY") {
    //         if ($("#mallDisplayRow_update").hasClass('d-none')) {
    //             $("#mallDisplayRow_update").removeClass('d-none');
    //             $("#mallDisplay_update").prop('required', true);
    //         }
    //     } else {
    //         if (!$("#mallDisplayRow_update").hasClass('d-none')) {
    //             $("#mallDisplayRow_update").addClass('d-none');
    //             $("#mallDisplay_update").prop('required', false);
    //             $("#mallDisplay_update").val('');
    //         }
    //     }
    // });
    $(document).on('change', '#unitInquired_update', function () {
        if ($(this).val() === "TAMARAW") {
            if ($("#tamarawVariantRow_update").hasClass('d-none')) {
                $("#tamarawVariantRow_update").removeClass('d-none');
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#tamarawVariant_update").prop('required', true);
                    $("#tamarawSpecificUsage_update").prop('required', true);
                }


                $("#tamarawSpecificUsageRow_update").removeClass("d-none");
                $("#buyerDecisionHoldRow_update").removeClass("d-none");
            }
            if ($("#occupation_update").val() === "BUSINESS OWNER") {
                $("#additionalUnitRow_update").removeClass("d-none");
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#additionalUnit_update").prop("required", true);
                }
            }
        } else {
            if (!$("#tamarawVariantRow_update").hasClass('d-none')) {
                $("#tamarawVariantRow_update").addClass('d-none');
                $("#tamarawVariant_update").prop('required', false);
                $("#tamarawVariant_update").val('');
                $("#tamarawVariant_update").prop('required', false);
                $("#tamarawSpecificUsage_update").prop('required', false);


                $("#additionalUnitRow_update").addClass("d-none");
                $("#additionalUnit_update").prop("required", false);
                $("#additionalUnit_update").val("");
                $("#tamarawSpecificUsageRow_update").addClass("d-none");
                $("#tamarawSpecificUsage_update").val("");
                $("#buyerDecisionHoldRow_update").addClass("d-none");
                $('#buyerDecisionHold_yes_update, #buyerDecisionHold_no_update').prop('checked', false).trigger('change');
            }
        }
    });
    $(document).on('change', '#hasReservation_yes_update, #hasReservation_no_update', function () {
        if ($(this).val() === "YES") {
            if ($("#reservationDateRow_update").hasClass('d-none')) {
                $("#reservationDateRow_update").removeClass('d-none');
                $("#reservationDate_update").prop("required", true);
            }
        } else if ($(this).val() === "NO") {
            if (!$("#reservationDateRow_update").hasClass('d-none')) {
                $("#reservationDateRow_update").addClass('d-none');
                $("#reservationDate_update").prop("required", false);
                $("#reservationDate_update").val("");
            }
        }
    });
    $(document).on('change', '#buyerDecisionHold_yes_update, #buyerDecisionHold_no_update', function () {
        if ($(this).val() === "YES") {
            if ($("#buyerDecisionHoldReasonRow_update").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonRow_update").removeClass('d-none');
                if ($("input[name='prospectType']:checked").val() !== "COLD") {
                    $("#buyerDecisionHoldReason_update").prop("required", true);
                }
            }
        } else if ($(this).val() === "NO") {
            if (!$("#buyerDecisionHoldReasonRow_update").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonRow_update").addClass('d-none');
                $("#buyerDecisionHoldReason_update").prop("required", false);
                $("#buyerDecisionHoldReason_update").val("");
            }
        }
    });

    let updateInquiryFormValidationTimeout;
    $("#updateInquiryForm").submit(function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        // console.log(formData);
        if (updateInquiryFormValidationTimeout) {
            clearTimeout(updateInquiryFormValidationTimeout);
        }
        $("#updateInquiryForm").removeClass("was-validated");

        let updateFirstValidity = !this.checkValidity();
        let updateSecondValidity = false;
        let updateThirdValidity;
        let updateFourthValidity;

        if ($("#updateInquiryForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryForm input[name='prospectType']:checked").val() !== "LOST") {
            updateThirdValidity = !$("#updateInquiryForm input[name='buyerType']:checked").val() ||
                !$("#updateInquiryForm input[name='hasApplication']:checked").val() ||
                !$("#updateInquiryForm input[name='hasReservation']:checked").val();
            updateFourthValidity = $("#unitInquired_update").val() === "TAMARAW" &&
                !$("#updateInquiryForm input[name='buyerDecisionHold']:checked").val();
        } else {
            updateThirdValidity = false;
            updateFourthValidity = false;
        }

        if (updateFirstValidity || updateSecondValidity || updateThirdValidity || updateFourthValidity) {
            e.stopPropagation();
            console.log("Invalid");
            console.log(`
                1: ${updateFirstValidity}
                2: ${updateSecondValidity}
                3: ${updateThirdValidity}
                4: ${updateFourthValidity}
                `);
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
                                $("#updateInquiryModal").modal('hide');
                                setTimeout(() => {
                                    $("#viewInquiryDetailsModal").modal('hide');
                                    setTimeout(() => {
                                        $("#viewInquiriesModal").modal('hide');
                                    }, 1000)
                                }, 1000);
                                fetchInquiriesByProspectCount();
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
            console.log("Submitted");
        }
        $(this).addClass('was-validated');
        if (!$("#updateInquiryForm input[name='prospectType']:checked").val()) {
            $(".prospectRadioGroup_update").addClass("radio-invalid");
        } else {
            $(".prospectRadioGroup_update").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryForm input[name='buyerType']:checked").val() && ($("#updateInquiryForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".buyerTypeRadioGroup_update").addClass("radio-invalid");
        } else {
            $(".buyerTypeRadioGroup_update").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryForm input[name='hasApplication']:checked").val() && ($("#updateInquiryForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".hasApplicationRadioGroup_update").addClass("radio-invalid");
        } else {
            $(".hasApplicationRadioGroup_update").removeClass("radio-invalid");
        }
        if (!$("#updateInquiryForm input[name='hasReservation']:checked").val() && ($("#updateInquiryForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".hasReservationRadioGroup_update").addClass("radio-invalid");
        } else {
            $(".hasReservationRadioGroup_update").removeClass("radio-invalid");
        }
        if ($("#unitInquired_update").val() === "TAMARAW" && !$("#updateInquiryForm input[name='buyerDecisionHold']:checked").val() && ($("#updateInquiryForm input[name='prospectType']:checked").val() !== "COLD" && $("#updateInquiryForm input[name='prospectType']:checked").val() !== "LOST")) {
            $(".buyerDecisionHoldRadioGroup_update").addClass("radio-invalid");
        } else {
            $(".buyerDecisionHoldRadioGroup_update").removeClass("radio-invalid");
        }
        updateInquiryFormValidationTimeout = setTimeout(() => {
            $("#updateInquiryForm").removeClass("was-validated");
            $(".prospectRadioGroup_update").removeClass("radio-invalid");
            $(".genderRadioGroup_update").removeClass("radio-invalid");
            $(".buyerTypeRadioGroup_update").removeClass("radio-invalid");
            $(".hasApplicationRadioGroup_update").removeClass("radio-invalid");
            $(".hasReservationRadioGroup_update").removeClass("radio-invalid");
            $(".buyerDecisionHoldRadioGroup_update").removeClass("radio-invalid");
        }, 3000);
    });

    $("#updateInquiryModal").on('hidden.bs.modal', function () {
        $("#viewInquiryDetailsModal").modal('show');
        $("#updateInquiryForm")[0].reset();
    });
});