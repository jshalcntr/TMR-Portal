$(document).ready(function () {
    function populateInquiryFields() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://psgc.gitlab.io/api/provinces/",
            success: function (response) {
                $('#province_review').empty().append(`<option value="" selected hidden>--Select Province--</option></option>`);
                $('#municipality_review').empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                $('#barangay_review').empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);

                $('#province_review').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);

                response.forEach(province => {
                    $('#province_review').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
                });

                $("#province_review").select2({
                    placeholder: `--Select Province--`,
                    width: '100%',
                    dropdownParent: $('#reviewInquiryModal')
                });
                $("#municipality_review").select2({
                    placeholder: `--Select Municipality--`,
                    width: '100%',
                    dropdownParent: $('#reviewInquiryModal')
                });
                $("#barangay_review").select2({
                    placeholder: `--Select Barangay--`,
                    width: '100%',
                    dropdownParent: $('#reviewInquiryModal')
                });
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.error('AJAX error:', error);
                Swal.fire({
                    title: 'Error! ',
                    text: 'An internal error occurred. Please contact MIS.',
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                })
            }
        });

        $.ajax({
            type: "GET",
            url: "../../backend/sales-management/getAllVehicles.php",
            success: function (response) {
                if (response.status === 'internal-error') {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });
                } else if (response.status === 'success') {
                    const vehicles = response.data;
                    $("#unitInquired_review").empty().append(`<option value="" hidden>--Select Vehicle--</option>`);
                    vehicles.forEach(vehicle => {
                        $("#unitInquired_review").append(`<option value="${vehicle.vehicle_name}">${vehicle.vehicle_name}</option>`);
                    });

                }
            }
        });

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://psgc.gitlab.io/api/provinces/",
            success: function (response) {
                $('#occupationProvince_review').empty().append(`<option value="" selected hidden>--Select Province--</option></option>`);
                $('#occupationMunicipality_review').empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                $('#occupationBarangay_review').empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);

                $('#occupationProvince_review').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);

                response.forEach(province => {
                    $('#occupationProvince_review').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
                });
                $("#occupationProvince_review").select2({
                    placeholder: `--Select Province--`,
                    width: '100%',
                    dropdownParent: $('#reviewInquiryModal')
                });
                $("#occupationMunicipality_review").select2({
                    placeholder: `--Select Municipality--`,
                    width: '100%',
                    dropdownParent: $('#reviewInquiryModal')
                });
                $("#occupationBarangay_review").select2({
                    placeholder: `--Select Barangay--`,
                    width: '100%',
                    dropdownParent: $('#reviewInquiryModal')
                });
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.error('AJAX error:', error);
                Swal.fire({
                    title: 'Error! ',
                    text: 'An internal error occurred. Please contact MIS.',
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                })
            }
        });
    }
    function migrateInquiryData() {
        const prospectType = $('input[name="prospectType"]:checked').val();
        const customerFirstName = $("#customerFirstName").val();
        const customerMiddleName = $("#customerMiddleName").val();
        const customerLastName = $("#customerLastName").val();
        const street = $("#street").val();
        const contactNumber = $("#contactNumber").val();
        const gender = $('input[name="gender"]:checked').val();
        const maritalStatus = $('input[name="maritalStatus"]:checked').val();
        const maritalStatusOther = $("#maritalStatusOtherInput").val();
        const birthday = $("#birthday").val();
        const occupation = $('input[name="occupation"]:checked').val();
        const businessName = $("#businessName").val();
        const occupationStreet = $("#occupationStreet").val();
        const businessCategory = $('input[name="businessCategory"]:checked').val();
        const businessSize = $('input[name="businessSize"]:checked').val();
        const monthlyAverage = $('input[name="monthlyAverage"]:checked').val();

        const inquiryDate = $('#inquiryDate').val();
        const inquirySource = $('input[name="inquirySource"]:checked').val();
        const inquirySourceType = $('input[name="inquirySourceType"]:checked').val();
        const mallDisplay = $("#mallDisplay").val();
        const buyerType = $('input[name="buyerType"]:checked').val();
        const unitInquired = $("#unitInquired").val();
        const tamarawVariant = $('input[name="tamarawVariant"]:checked').val();
        const transactionType = $('input[name="transactionType"]:checked').val();
        const hasApplication = $('input[name="hasApplication"]:checked').val();
        const hasReservation = $('input[name="hasReservation"]:checked').val();
        const reservationDate = $('#reservationDate').val();
        const additionalUnit = $("#additionalUnit").val();
        const tamarawSpecificUsage = $("#tamarawSpecificUsage").val();
        const buyerDecisionHold = $('input[name="buyerDecisionHold"]:checked').val();
        const buyerDecisionHoldReason = $("#buyerDecisionHoldReason").val();
        const appointmentDate = $("#appointmentDate").val();
        const appointmentTime = $("#appointmentTime").val();

        // console.log(
        //     `
        //     Create Form Data

        //     prospectType: ${prospectType}
        //     customerFirstName: ${customerFirstName}
        //     customerMiddleName: ${customerMiddleName}
        //     customerLastName: ${customerLastName}
        //     street: ${street}
        //     contactNumber: ${contactNumber}
        //     gender: ${gender}
        //     maritalStatus: ${maritalStatus}
        //     maritalStatusOther: ${maritalStatusOther}
        //     birthday: ${birthday}
        //     occupation: ${occupation}
        //     businessName: ${businessName}
        //     occupationStreet: ${occupationStreet}
        //     businessCategory: ${businessCategory}
        //     businessSize: ${businessSize}
        //     monthlyAverage: ${monthlyAverage}

        //     inquiryDate: ${inquiryDate}
        //     inquirySource: ${inquirySource}
        //     inquirySourceType: ${inquirySourceType}
        //     mallDisplay: ${mallDisplay}
        //     buyerType: ${buyerType}
        //     unitInquired: ${unitInquired}
        //     tamarawVariant: ${tamarawVariant}
        //     transactionType: ${transactionType}
        //     hasApplication: ${hasApplication}
        //     hasReservation: ${hasReservation}
        //     reservationDate: ${reservationDate}
        //     additionalUnit: ${additionalUnit}
        //     tamarawSpecificUsage: ${tamarawSpecificUsage}
        //     buyerDecisionHold: ${buyerDecisionHold}
        //     buyerDecisionHoldReason: ${buyerDecisionHoldReason}
        //     appointmentDate: ${appointmentDate}
        //     appointmentTime: ${appointmentTime}
        //     `
        // );

        if (prospectType === "HOT") {
            $("#prospectType_hot_review").prop('checked', true);
        } else if (prospectType === "WARM") {
            $("#prospectType_warm_review").prop('checked', true);
        } else if (prospectType === "COLD") {
            $("#prospectType_cold_review").prop('checked', true);
        }
        $("#customerFirstName_review").val(customerFirstName);
        $("#customerMiddleName_review").val(customerMiddleName);
        $("#customerLastName_review").val(customerLastName);
        $("#street_review").val(street);
        $("#contactNumber_review").val(contactNumber);
        if (gender === "MALE") {
            $("#gender_male_review").prop('checked', true);
        } else if (gender === "FEMALE") {
            $("#gender_female_review").prop('checked', true);
        } else if (gender === "LGBTQ+") {
            $("#gender_lgbt_review").prop('checked', true);
        }
        $("#maritalStatus_review").val(maritalStatus).trigger('change');
        $("#maritalStatusOtherInput_review").val(maritalStatusOther === null || maritalStatusOther === "" ? maritalStatus : maritalStatusOther);
        $("#birthday_review").val(birthday);
        $("#occupation_review").val(occupation).trigger('change');
        $("#businessName_review").val(businessName);
        $("#occupationStreet_review").val(occupationStreet);
        $("#businessCategory_review").val(businessCategory);
        $("#businessSize_review").val(businessSize);
        $("#monthlyAverage_review").val(monthlyAverage);

        $("#inquiryDate_review").val(inquiryDate);
        $("#inquirySource_review").val(inquirySource).trigger('change');
        if (inquirySource === "FACE TO FACE") {
            $("#f2fSource_review").val(inquirySourceType).trigger('change');
        } else if (inquirySource === "ONLINE") {
            $("#onlineSource_review").val(inquirySourceType).trigger('change');
        }
        $("#f2fSource_review").val(inquirySourceType);
        $("#onlineSource_review").val(inquirySourceType);
        $("#mallDisplay_review").val(mallDisplay);
        if (buyerType === "FIRST-TIME") {
            $("#buyerType_first_review").prop('checked', true);
        } else if (buyerType === "REPLACEMENT") {
            $("#buyerType_replacement_review").prop('checked', true);
        } else if (buyerType === "ADDITIONAL") {
            $("#buyerType_additional_review").prop('checked', true);
        }
        $("#unitInquired_review").val(unitInquired).trigger('change');
        $("#tamarawVariant_review").val(tamarawVariant);
        $("#transactionType_review").val(transactionType);
        if (hasApplication === "YES") {
            $("#hasApplication_yes_review").prop('checked', true).trigger('change');
        } else if (hasApplication === "NO") {
            $("#hasApplication_no_review").prop('checked', true).trigger('change');
        }
        if (hasReservation === "YES") {
            $("#hasReservation_yes_review").prop('checked', true).trigger('change');
        } else if (hasReservation === "NO") {
            $("#hasReservation_no_review").prop('checked', true).trigger('change');
        }
        $("#reservationDate_review").val(reservationDate);
        $("#additionalUnit_review").val(additionalUnit);
        $("#tamarawSpecificUsage_review").val(tamarawSpecificUsage);
        if (buyerDecisionHold === "YES") {
            $("#buyerDecisionHold_yes_review").prop('checked', true).trigger('change');
        } else if (buyerDecisionHold === "NO") {
            $("#buyerDecisionHold_no_review").prop('checked', true).trigger('change');
        }
        $("#buyerDecisionHoldReason_review").val(buyerDecisionHoldReason);
        $("#appointmentDate_review").val(appointmentDate);
        $("#appointmentTime_review").val(appointmentTime);

        if (maritalStatus === "OTHERS") {
            $("#maritalStatusOtherGroup_review").removeClass("d-none");
            $("#maritalStatusOtherInput_review").attr("required", true).focus();
        } else {
            $("#maritalStatusOtherGroup_review").addClass("d-none");
            $("#maritalStatusOtherInput_review").removeAttr("required").removeClass("is-invalid");
        }
    }

    populateInquiryFields();

    $("#province_review").on('change', function () {
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
                $('#municipality_review').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                response.forEach(municipality => {
                    $('#municipality_review').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
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
    $("#municipality_review").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#barangay_review').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                response.forEach(barangay => {
                    $('#barangay_review').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
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
    $("#occupationProvince_review").on('change', function () {
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
                $('#occupationMunicipality_review').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                response.forEach(municipality => {
                    $('#occupationMunicipality_review').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
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
    $("#occupationMunicipality_review").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#occupationBarangay_review').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);
                response.forEach(barangay => {
                    $('#occupationBarangay_review').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
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
    $(document).on("change", "#maritalStatus_review", function () {
        const othersGroup = $("#maritalStatusOthersRow_review");
        const othersInput = $("#maritalStatusOtherInput_review");
        const selected = $("#maritalStatus_review").val();
        if (selected === "Others") {
            othersInput.val("");
            if (othersGroup.hasClass('d-none')) {
                othersGroup.removeClass("d-none");
                othersGroup.addClass("d-flex");
                othersInput.attr("required", true).focus();
            }
        } else {
            if (othersGroup.hasClass('d-flex')) {
                othersGroup.addClass("d-none");
                othersGroup.removeClass("d-flex");
                othersInput.removeAttr("required").removeClass("is-invalid");
            }
            othersInput.val($(this).val());
        }
    });
    $(document).on("change", "#occupation_review", function () {
        if ($(this).val() === "BUSINESS OWNER") {
            $(".occupationLabel").text("Business");
            if ($("#businessCategoryRow_review").hasClass("d-none")) {
                $("#businessCategoryRow_review").removeClass("d-none");
                $("#businessSizeRow_review").removeClass("d-none");
                $("#businessCategory_review").attr("required", true);
                $("#businessSize_review").attr("required", true);
            }
            if ($("#businessNameRow_review").hasClass('d-none')) {
                $("#businessNameRow_review").removeClass('d-none');
                $("#businessAddressRow_review").removeClass('d-none');
                $("#businessName_review").attr("required", false).focus();
            }
        } else if ($(this).val() === "EMPLOYED") {
            $(".occupationLabel").text("Employer");
            if (!$("#businessCategoryRow_review").hasClass("d-none")) {
                $("#businessCategoryRow_review").addClass("d-none");
                $("#businessSizeRow_review").addClass("d-none");
                $("#businessCategory_review").removeAttr("required");
                $("#businessSize_review").removeAttr("required");
            }
            if ($("#businessNameRow_review").hasClass('d-none')) {
                $("#businessNameRow_review").removeClass('d-none');
                $("#businessAddressRow_review").removeClass('d-none');
                $("#businessName_review").attr("required", false).focus();
            }
        } else if ($(this).val() === "FREELANCER") {
            if (!$("#businessCategoryRow_review").hasClass("d-none")) {
                $("#businessCategoryRow_review").addClass("d-none");
                $("#businessSizeRow_review").addClass("d-none");
                $("#businessCategory_review").removeAttr("required");
                $("#businessSize_review").removeAttr("required");
            }
            if (!$("#businessNameRow_review").hasClass('d-none')) {
                $("#businessNameRow_review").addClass('d-none');
                $("#businessAddressRow_review").addClass('d-none');
                $("#businessName_review").attr("required", true).focus();
            }
        } else {
            $(".occupationLabel").text("Occupation");
            if ($(this).val() === "FAMILY SUPPORT/GIFT/DONATION") {
                $(".occupationLabel").text("Sponsor");
            } else if ($(this).val() === "PENSIONER") {
                $(".occupationLabel").text("Pensioner");
            }
            if (!$("#businessCategoryRow_review").hasClass("d-none")) {
                $("#businessCategoryRow_review").addClass("d-none");
                $("#businessSizeRow_review").addClass("d-none");
                $("#businessCategory_review").removeAttr("required");
                $("#businessSize_review").removeAttr("required");
            }
            if ($("#businessNameRow_review").hasClass('d-none')) {
                $("#businessNameRow_review").removeClass('d-none');
                $("#businessAddressRow_review").removeClass('d-none');
                $("#businessName_review").attr("required", false).focus();
            }
        }
    });
    $(document).on('change', '#inquirySource_review', function () {
        if ($(this).val() === "FACE TO FACE") {
            if ($("#f2fSourceRow_review").hasClass('d-none')) {
                $("#f2fSourceRow_review").removeClass('d-none');
            }
            if (!$("#onlineSourceRow_review").hasClass('d-none')) {
                $("#onlineSourceRow_review").addClass('d-none');
                $("#onlineSource_review").val("").trigger('change');
            }
        } else if ($(this).val() === "ONLINE") {
            if ($("#onlineSourceRow_review").hasClass('d-none')) {
                $("#onlineSourceRow_review").removeClass('d-none');
            }
            if (!$("#f2fSourceRow_review").hasClass('d-none')) {
                $("#f2fSourceRow_review").addClass('d-none');
                $("#f2fSource_review").val("").trigger('change');
            }
        }
    });
    $(document).on('change', '#f2fSource_review', function () {
        if ($(this).val() === "MALL DISPLAY") {
            if ($("#mallDisplayRow_review").hasClass('d-none')) {
                $("#mallDisplayRow_review").removeClass('d-none');
                $("#mallDisplay_review").attr('required', true);
            }
        } else {
            if (!$("#mallDisplayRow_review").hasClass('d-none')) {
                $("#mallDisplayRow_review").addClass('d-none');
                $("#mallDisplay_review").removeAttr('required');
                $("#mallDisplay_review").val('');
            }
        }
    });
    $(document).on('change', '#unitInquired_review', function () {
        if ($(this).val() === "TAMARAW") {
            if ($("#tamarawVariantRow_review").hasClass('d-none')) {
                $("#tamarawVariantRow_review").removeClass('d-none');
                $("#tamarawVariant_review").attr('required', true);

                $("#additionalUnitRow_review").removeClass("d-none");
                $("#tamarawSpecificUsageRow_review").removeClass("d-none");
                $("#buyerDecisionHoldRow_review").removeClass("d-none");
            }
        } else {
            if (!$("#tamarawVariantRow_review").hasClass('d-none')) {
                $("#tamarawVariantRow_review").addClass('d-none');
                $("#tamarawVariant_review").removeAttr('required');
                $("#tamarawVariant_review").val('');

                $("#additionalUnitRow_review").addClass("d-none");
                $("#additionalUnit_review").val("");
                $("#tamarawSpecificUsageRow_review").addClass("d-none");
                $("#tamarawSpecificUsage_review").val("");
                $("#buyerDecisionHoldRow_review").addClass("d-none");
                $('#buyerDecisionHold_yes_review, #buyerDecisionHold_no_review').prop('checked', false).trigger('change');
            }
        }
    });
    $(document).on('change', '#hasReservation_yes_review, #hasReservation_no_review', function () {
        if ($(this).val() === "YES") {
            if ($("#reservationDateRow_review").hasClass('d-none')) {
                $("#reservationDateRow_review").removeClass('d-none');
                $("#reservationDate_review").attr("required", true);
            }
        } else if ($(this).val() === "NO") {
            if (!$("#reservationDateRow_review").hasClass('d-none')) {
                $("#reservationDateRow_review").addClass('d-none');
                $("#reservationDate_review").removeAttr("required");
                $("#reservationDate_review").val("");
            }
        }
    });
    $(document).on('change', '#buyerDecisionHold_yes_review, #buyerDecisionHold_no_review', function () {
        if ($(this).val() === "YES") {
            if ($("#buyerDecisionHoldReasonRow_review").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonRow_review").removeClass('d-none');
                $("#buyerDecisionHoldReason_review").attr("required", true);
            }
        } else if ($(this).val() === "NO") {
            if (!$("#buyerDecisionHoldReasonRow_review").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonRow_review").addClass('d-none');
                $("#buyerDecisionHoldReason_review").removeAttr("required");
                $("#buyerDecisionHoldReason_review").val("");
            }
        }
    });

    $("#reviewInquiryForm").submit(function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "../../backend/sales-management/createInquiry.php",
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
                            $("#reviewInquiryModal").modal('hide');
                            // Reset Other Modal that has Tables
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
    });

    $("#reviewBtn").on('click', function () {
        if (validateRequiredFields($(".form-step[data-step='25']"))) {
            migrateInquiryData();
            $("#createInquiryModal").modal('hide');
            $("#reviewInquiryModal").modal('show');
        }
    });
    $("#previousBtn_review").on('click', function () {
        $("#createInquiryModal").modal('show');
        $("#reviewInquiryModal").modal('hide');
    });
    // populateInquiryFields();
});