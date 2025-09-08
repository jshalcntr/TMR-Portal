function validateRequiredFields(container) {
    let valid = true;
    container.find("input[required], select[required]").each(function () {
        const val = $(this).val()?.trim();
        if (!val) {
            $(this).addClass("is-invalid");
            valid = false;
            setTimeout(() => $(this).removeClass("is-invalid"), 3000);
        } else {
            $(this).removeClass("is-invalid");
        }
    });
    return valid;
}

function validateRadioGroup(container, name, groupClass) {
    const radioSelected = container.find(`input[name='${name}']:checked`).length > 0;
    const radioGroup = container.find(`.${groupClass}`);
    if (!radioSelected) {
        radioGroup.addClass("radio-invalid");
        container.find(".invalid-feedback").first().show();
        setTimeout(() => {
            radioGroup.removeClass("radio-invalid");
            container.find(".invalid-feedback").first().hide();
        }, 3000);
        return false;
    } else {
        radioGroup.removeClass("radio-invalid");
        container.find(".invalid-feedback").first().hide();
        return true;
    }
}

$(document).ready(function () {
    $("input[type='text'], textarea").on('input', function () {
        this.value = this.value.toUpperCase();
    });
    $(document).on('click', '.radio-column', function () {
        $(this).find(`input[type="radio"]`).prop('checked', true).trigger('change');
    });

    const steps = $(".form-step");
    let currentStep = 1;

    const stepValues = steps.map(function () {
        return parseInt($(this).data("step"));
    }).get();

    const minStep = Math.min(...stepValues);
    const maxStep = Math.max(...stepValues);

    function toggleSelect2Fields(...dropdowns) {
        dropdowns.forEach(id => {
            const name = id.replace("#", "");
            $(id).select2({
                placeholder: `--Select ${name.charAt(0).toUpperCase() + name.slice(1)}--`,
                width: '100%',
                dropdownParent: $('#createInquiryModal')
            });
        });
    }

    function showStep(index) {
        steps.toggleClass("d-none", true);
        $(`.form-step[data-step="${index}"]`).removeClass("d-none");
        if (index === 5) {
            toggleSelect2Fields('#province', '#municipality', '#barangay');
        };
        if (index === 18) {
            toggleSelect2Fields('#occupationProvince', '#occupationMunicipality', '#occupationBarangay');
        };
        $("#previousBtn").toggle(index > minStep);
        $("#nextBtn").toggle(index < maxStep);
        $("#reviewBtn").toggle(index === maxStep);
    }

    function validateStep(index) {
        const current = $(`.form-step[data-step="${index}"]`);
        let isValid = true;

        const validationMap = {
            1: () => validateRadioGroup(current, 'prospectType', 'prospectRadioGroup'),
            4: () => {
                let valid = validateRadioGroup(current, 'inquirySource', 'inquirySourceRadioGroup');
                if (valid) {
                    valid = validateRadioGroup(current, 'inquirySourceType', 'inquirySourceTypeRadioGroup') && validateRequiredFields(current);
                }
                return valid;
            },
            6: () => {
                const phoneInput = current.find("#contactNumber");
                const phPattern = /^(09\d{9}|\+639\d{9})$/;
                const valid = phPattern.test(phoneInput.val().trim());
                phoneInput.toggleClass("is-invalid", !valid);
                if (!valid) setTimeout(() => phoneInput.removeClass("is-invalid"), 3000);
                return valid;
            },
            7: () => validateRadioGroup(current, 'gender', 'genderRadioGroup'),
            8: () => {
                let valid = validateRadioGroup(current, 'maritalStatus', 'maritalStatusRadioGroup');
                const othersInput = $("#maritalStatusOtherInput");
                if ($("#maritalStatus_others").is(":checked")) {
                    othersInput.prop("required", true);
                    if (!othersInput[0].checkValidity()) {
                        othersInput[0].reportValidity();
                        valid = false;
                    }
                } else {
                    othersInput.prop("required", false);
                }
                return valid;
            },
            10: () => validateRadioGroup(current, 'buyerType', 'buyerTypeRadioGroup'),
            12: () => validateRadioGroup(current, 'tamarawVariant', 'tamarawVariantRadioGroup'),
            13: () => validateRadioGroup(current, 'transactionType', 'transactionTypeRadioGroup'),
            14: () => {
                // validateRadioGroup(current, 'hasApplication', 'hasApplicationRadioGroup') && validateRadioGroup(current, 'hasReservation', 'hasReservationRadioGroup');
                const isValidApp = validateRadioGroup(current, 'hasApplication', 'hasApplicationRadioGroup');
                const isValidRes = validateRadioGroup(current, 'hasReservation', 'hasReservationRadioGroup');
                return isValidApp && isValidRes;
            },
            16: () => {
                const occupation = current.find("input[name='occupation']:checked").val();
                const labelOne = occupation === "BUSINESS OWNER" ? "Business Name" : (occupation === "PENSIONER" ? "Provider Name" : (occupation === "FAMILY SUPPORTED/GIFT/DONATION" ? "Sponsor Name" : "Employer Name"));
                const labelTwo = occupation === "BUSINESS OWNER" ? "Complete Business Address" : (occupation === "FAMILY SUPPORTED/GIFT/DONATION" ? "Complete Sponsor Address" : "Complete Employer Address");

                $("#occupationHeaderOne").text(labelOne);
                $("#occupationHeaderTwo").text(labelTwo);
                $("#occupationFeedback").text(`Please provide a valid ${labelOne}.`);
                return validateRadioGroup(current, 'occupation', 'occupationRadioGroup')
            },
            19: () => validateRadioGroup(current, 'businessCategory', 'businessCategoryRadioGroup'),
            20: () => validateRadioGroup(current, 'monthlyAverage', 'monthlyAverageRadioGroup'),
            21: () => validateRadioGroup(current, 'businessSize', 'businessSizeRadioGroup'),
        };

        if (validationMap[index]) {
            isValid = validationMap[index]();
        } else {
            isValid = validateRequiredFields(current);
        }

        isValid = true;
        return isValid;
    }

    $("#nextBtn").click(() => {
        if (validateStep(currentStep)) {
            if ($(".form-step[data-step='1']").find("input[name='prospectType']:checked").val() === "COLD") {
                if (currentStep === 7) {
                    currentStep = 10;
                } else if (currentStep === 11) {
                    currentStep = 24;
                }
            }
            if (currentStep === 11 && $("#unitInquired").val() !== "TAMARAW") {
                currentStep++
                $("#additionalUnit").prop("required", false);
                $("#tamarawSpecificUsage").prop("required", false);
            } else if (currentStep === 11 && $("#unitInquired").val() === "TAMARAW") {
                $("#additionalUnit").prop("required", true);
                $("#tamarawSpecificUsage").prop("required", true);
            };
            if (currentStep === 14 && $(".form-step[data-step='14']").find("input[name='hasReservation']:checked").val() !== "YES") {
                currentStep++;
                $("#reservationDate").prop("required", false);
            } else if (currentStep === 14 && $(".form-step[data-step='14']").find("input[name='hasReservation']:checked").val() === "YES") {
                $("#reservationDate").prop("required", true);
            }
            if (currentStep === 16 && $(".form-step[data-step='16']").find("input[name='occupation']:checked").val() === "FREELANCER") {
                currentStep++;
                currentStep++;
            }
            if (currentStep === 17 && $(".form-step[data-step='16']").find("input[name='occupation']:checked").val() === "PENSIONER") {
                currentStep++;
            }
            if (currentStep === 18 && $(".form-step[data-step='16']").find("input[name='occupation']:checked").val() !== "BUSINESS OWNER") {
                currentStep++
            }
            if (currentStep === 20 && $(".form-step[data-step='16']").find("input[name='occupation']:checked").val() !== "BUSINESS OWNER") {
                currentStep++
                if ($("#unitInquired").val() === "TAMARAW") {
                    currentStep++;
                }
                if ($("#unitInquired").val() !== "TAMARAW") {
                    currentStep++;
                    currentStep++;
                    currentStep++;
                }
            }
            if (currentStep === 21 && $("#unitInquired").val() !== "TAMARAW") {
                currentStep++;
                currentStep++;
                currentStep++;
            }
            currentStep++;
            showStep(currentStep);
        }
    });

    $("#previousBtn").click(() => {
        if ($(".form-step[data-step='1']").find("input[name='prospectType']:checked").val() === "COLD") {
            if (currentStep === 25) {
                currentStep = 12;
            } else if (currentStep === 11) {
                currentStep = 8;
            }
        }
        if (currentStep === 13 && $("#unitInquired").val() !== "TAMARAW") {
            currentStep--;
        };
        if (currentStep === 16 && $(".form-step[data-step='14']").find("input[name='hasReservation']:checked").val() !== "YES") {
            currentStep--;
        };
        if (currentStep === 20 && $(".form-step[data-step='16']").find("input[name='occupation']:checked").val() !== "BUSINESS OWNER") {
            currentStep--;
            if ($(".form-step[data-step='16']").find("input[name='occupation']:checked").val() === "FREELANCER") {
                currentStep--;
                currentStep--;
            }
            if ($(".form-step[data-step='16']").find("input[name='occupation']:checked").val() === "PENSIONER") {
                currentStep--;
            }
        }
        if (currentStep === 22 && $(".form-step[data-step='16']").find("input[name='occupation']:checked").val() !== "BUSINESS OWNER") {
            currentStep--;
        }
        if (currentStep === 23 && $("#unitInquired").val() === "TAMARAW" && $(".form-step[data-step='16']").find("input[name='occupation']:checked").val() !== "BUSINESS OWNER") {
            currentStep--;
            currentStep--;
        }
        if (currentStep === 25 && $("#unitInquired").val() !== "TAMARAW") {
            currentStep--;
            currentStep--;
            currentStep--;
            if ($(".form-step[data-step='16']").find("input[name='occupation']:checked").val() !== "BUSINESS OWNER") {
                currentStep--;
            }
        }
        currentStep--;
        showStep(currentStep);
    });

    showStep(currentStep);

    $(document).on('change', 'input[name="inquirySource"]', function () {
        const selectedValue = $('input[name="inquirySource"]:checked').val();
        if (selectedValue === 'FACE TO FACE') {
            if ($("#f2fSource").hasClass('d-none')) {
                $("#f2fSource").removeClass('d-none');
            }
            if (!$("#onlineSource").hasClass('d-none')) {
                $("#onlineSource").addClass('d-none');
                // $("#onlineSource").val("");
            }
        } else if (selectedValue === 'ONLINE') {
            if ($("#onlineSource").hasClass('d-none')) {
                $("#onlineSource").removeClass('d-none');
            }
            if (!$("#f2fSource").hasClass('d-none')) {
                $("#f2fSource").addClass('d-none');
            }
        } else {
            if (!$("#f2fSource").hasClass('d-none')) {
                $("#f2fSource").addClass('d-none');
            }
            if (!$("#onlineSource").hasClass('d-none')) {
                $("#onlineSource").addClass('d-none');
            }
        }
        $('input[name="inquirySourceType"]:checked').prop('checked', false).trigger('change');
        if (!$("#mallDisplayGroup").hasClass("d-none")) {
            $("#mallDisplayGroup").addClass("d-none");
            $("#mallDisplay").prop("required", false);
        }
    });
    $(document).on('change', 'input[name="inquirySourceType"]', function () {
        const selectedValue = $('input[name="inquirySourceType"]:checked').val();
        if (selectedValue === "MALL DISPLAY") {
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
                        $("#mallDisplay").empty().append(`<option value="">--Select Mall--</option>`);
                        malls.forEach(mall => {
                            $("#mallDisplay").append(`<option value="${mall.mall_name}">${mall.mall_name}</option>`);
                        });
                    }
                }
            });
            if ($("#mallDisplayGroup").hasClass("d-none")) {
                $("#mallDisplayGroup").removeClass("d-none");
                $("#mallDisplay").prop("required", true);
            }
            const $modalBody = $(document).find('.custom-scrollable-body');
            $modalBody.animate({
                scrollTop: $modalBody[0].scrollHeight
            }, 500);
        } else {
            if (!$("#mallDisplayGroup").hasClass("d-none")) {
                $("#mallDisplayGroup").addClass("d-none");
                $("#mallDisplay").prop("required", false);
            }
        }
    });

    $("#createInquiryBtn").on('click', function (e) {
        $("#createInquiryForm")[0].reset();
        $("input[name='inquirySource']").trigger('change');
        $('input[name="inquirySourceType"]').trigger('change');
        $('#municipality').prop('disabled', true);
        $('#barangay').prop('disabled', true);
        $('#occupationMunicipality').prop('disabled', true);
        $('#occupationBarangay').prop('disabled', true);

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
                    $("#unitInquired").empty().append(`<option value="" disabled selected hidden>--Select Vehicle--</option>`);
                    vehicles.forEach(vehicle => {
                        $("#unitInquired").append(`<option value="${vehicle.vehicle_name}">${vehicle.vehicle_name}</option>`);
                    });

                }
            }
        });

        currentStep = 1;
        showStep(currentStep);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://psgc.gitlab.io/api/provinces/",
            success: function (response) {
                $('#province').empty().append(`<option value="" selected hidden>--Select Province--</option>`);
                $('#municipality').empty().append(`<option value="" selected hidden>--Select Municipality--</option>`);
                $('#barangay').empty().append(`<option value="" selected hidden>--Select Barangay--</option>`);

                $('#province').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);

                response.forEach(province => {
                    $('#province').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}" data-type="province">${province.name.toUpperCase()}</option>`);
                });

                toggleSelect2Fields('#province');
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An internal error occurred. Please contact MIS.',
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                });
            }
        });

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://psgc.gitlab.io/api/provinces/",
            success: function (response) {
                $('#occupationProvince').empty().append(`<option value="" selected hidden>--Select OccupationProvince--</option></option>`);
                $('#occupationMunicipality').empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                $('#occupationBarangay').empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);

                $('#occupationProvince').append(`<option value="NATIONAL CAPITAL REGION" data-code="130000000" data-type="region">NATIONAL CAPITAL REGION (NCR)</option>`);

                response.forEach(province => {
                    $('#occupationProvince').append(`<option value="${province.name.toUpperCase()}" data-code="${province.code}">${province.name.toUpperCase()}</option>`);
                });
                toggleSelect2Fields('#occupationProvince');
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

        $("#maritalStatusOtherGroup").addClass("d-none");
        $("#maritalStatusOtherInput").removeAttr("required").removeClass("is-invalid");
    });

    $("#province").on('change', function () {
        const provinceCode = $(this).find(':selected').data('code');
        const provinceType = $(this).find(':selected').data('type');
        $("#province_review").val($(this).val()).trigger('change');

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
                $('#municipality').prop('disabled', false).empty()
                    .append(`<option value="" selected hidden>--Select Municipality--</option>`);
                response.forEach(municipality => {
                    $('#municipality').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                });

                $('#municipality_review').prop('disabled', false).empty()
                    .append(`<option value="" selected hidden>--Select Municipality--</option>`);
                response.forEach(municipality => {
                    $('#municipality_review').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                });

                toggleSelect2Fields('#municipality');
            },
            error: function (xhr, status, error) {
                console.error('XHR : ', xhr.responseText);
                console.error('Status : ', status);
                console.error('AJAX error : ', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An internal error occurred. Please contact MIS.',
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                });
            }
        });
    });

    $("#municipality").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $("#municipality_review").val($(this).val()).trigger('change');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#barangay').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                response.forEach(barangay => {
                    $('#barangay').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                });
                $('#barangay_review').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                response.forEach(barangay => {
                    $('#barangay_review').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                });
                toggleSelect2Fields('#barangay');
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
    $("#barangay").on('change', function () {
        $("#barangay_review").val($(this).val()).trigger('change');
    });
    $("#occupationProvince").on('change', function () {
        const provinceCode = $(this).find(':selected').data('code');
        const provinceType = $(this).find(':selected').data('type');
        $("#occupationProvince_review").val($(this).val()).trigger('change');

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
                $('#occupationMunicipality').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationMunicipality--</option></option>`);
                response.forEach(municipality => {
                    $('#occupationMunicipality').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                });
                $('#occupationMunicipality_review').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                response.forEach(municipality => {
                    $('#occupationMunicipality_review').append(`<option value="${municipality.name.toUpperCase()}" data-code="${municipality.code}">${municipality.name.toUpperCase()}</option>`);
                });
                toggleSelect2Fields('#occupationMunicipality');
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
    $("#occupationMunicipality").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $("#occupationMunicipality_review").val($(this).val()).trigger('change');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#occupationBarangay').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select OccupationBarangay--</option></option>`);
                response.forEach(barangay => {
                    $('#occupationBarangay').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                });
                $('#occupationBarangay_review').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                response.forEach(barangay => {
                    $('#occupationBarangay_review').append(`<option value="${barangay.name.toUpperCase()}" data-code="${barangay.code}">${barangay.name.toUpperCase()}</option>`);
                });
                toggleSelect2Fields('#occupationBarangay');
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
    $("#occupationBarangay").on('change', function () {
        $("#occupationBarangay_review").val($(this).val()).trigger('change');
    });
    $(document).on("change", ".form-step[data-step='8'] input[type='radio']:checked", function () {
        const othersGroup = $("#maritalStatusOtherGroup");
        const othersInput = $("#maritalStatusOtherInput");
        const selected = $('.form-step[data-step="8"] input[type="radio"]:checked').val();
        if (selected === "OTHERS") {
            othersGroup.removeClass("d-none");
            othersInput.attr("required", true).focus();
        } else {
            othersInput.val("");
            othersGroup.addClass("d-none");
            othersInput.removeAttr("required").removeClass("is-invalid");
        }
    });
    $(document).on('change', 'input[name="buyerDecisionHold"]', function () {
        if ($(this).val() === "YES") {
            if ($("#buyerDecisionHoldReasonGroup").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonGroup").removeClass('d-none');
                $("#buyerDecisionHoldReason").attr("required", true).focus();
            }
        } else {
            if (!$("#buyerDecisionHoldReasonGroup").hasClass('d-none')) {
                $("#buyerDecisionHoldReasonGroup").addClass('d-none');
                $("#buyerDecisionHoldReason").removeAttr("required").removeClass("is-invalid");
            }
        }
    });
});