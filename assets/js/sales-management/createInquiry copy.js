$(document).ready(function () {
    $(document).on('click', '.radio-column', function () {
        $(this).find(`input[type="radio"]`).prop('checked', true).trigger('change');
    });

    let currentStep = 1;

    const steps = $(".form-step");
    const stepValues = steps.map(function () {
        return parseInt($(this).data("step"));
    }).get();
    const maxStep = Math.max(...stepValues);

    function showStep(index) {
        steps.each(function () {
            const step = parseInt($(this).data("step"));
            $(this).toggleClass("d-none", step !== index);
        });

        if (index === 5) {
            $('#province').select2({
                placeholder: "--Select Province--",
                width: '100%',
                dropdownParent: $('#createInquiryModal')
            });
            $('#municipality').select2({
                placeholder: "--Select Municipality--",
                width: '100%',
                dropdownParent: $('#createInquiryModal')
            });
            $('#barangay').select2({
                placeholder: "--Select Barangay--",
                width: '100%',
                dropdownParent: $('#createInquiryModal')
            });
        }

        $("#previousBtn").toggle(index > Math.min(...stepValues));
        $("#nextBtn").toggle(index < maxStep);
    }

    function validateStep(index) {
        const current = $(`.form-step[data-step="${index}"]`);
        let isValid = true;

        current.find("input[required], select[required]").each(function () {
            if (!this.value.trim()) {
                $(this).addClass("is-invalid");
                setTimeout(() => {
                    $(this).removeClass("is-invalid");
                }, 3000);
                isValid = false;
            } else {
                $(this).removeClass("is-invalid");
            }
        });

        if (index === 1) {
            const selected = current.find("input[name='prospectType']:checked").length > 0;
            const radioGroups = current.find(".prospectRadioGroup");

            if (!selected) {
                radioGroups.addClass("radio-invalid");

                current.find(".invalid-feedback").show();

                setTimeout(() => {
                    radioGroups.removeClass("radio-invalid");
                    current.find(".invalid-feedback").hide();
                }, 3000);

                isValid = false;
            } else {
                radioGroups.removeClass("radio-invalid");
                current.find(".invalid-feedback").hide();
            }
        }
        if (index === 4) {
            const selected1 = current.find("input[name='inquirySource']:checked").length > 0;
            const radioGroups1 = current.find(".inquirySourceRadioGroup");

            if (!selected1) {
                radioGroups1.addClass("radio-invalid");

                current.find(".invalid-feedback").show();

                setTimeout(() => {
                    radioGroups1.removeClass("radio-invalid");
                    current.find(".invalid-feedback").hide();
                }, 3000);

                isValid = false;
            } else {
                radioGroups1.removeClass("radio-invalid");
                current.find(".invalid-feedback").hide();

                const selected2 = current.find("input[name='inquirySourceType']:checked").length > 0;
                const radioGroups2 = current.find(".inquirySourceTypeRadioGroup");
                if (!selected2) {
                    radioGroups2.addClass("radio-invalid");

                    current.find(".invalid-feedback").show();

                    setTimeout(() => {
                        radioGroups2.removeClass("radio-invalid");
                        current.find(".invalid-feedback").hide();
                    }, 3000);

                    isValid = false;
                } else {
                    radioGroups2.removeClass("radio-invalid");
                    current.find(".invalid-feedback").hide();
                }
            }
        }
        if (index === 6) {
            const phoneInput = current.find("#contactNumber");
            const phoneVal = phoneInput.val().trim();

            const phPattern = /^(09\d{9}|\+639\d{9})$/;

            if (!phPattern.test(phoneVal)) {
                phoneInput.addClass("is-invalid");
                setTimeout(() => {
                    phoneInput.removeClass("is-invalid");
                }, 3000);
                isValid = false;
            } else {
                phoneInput.removeClass("is-invalid");
            }
        }
        if (index === 7) {
            const selected = current.find("input[name='gender']:checked").length > 0;
            const radioGroups = current.find(".genderRadioGroup");

            if (!selected) {
                radioGroups.addClass("radio-invalid");

                current.find(".invalid-feedback").show();

                setTimeout(() => {
                    radioGroups.removeClass("radio-invalid");
                    current.find(".invalid-feedback").hide();
                }, 3000);

                isValid = false;
            } else {
                radioGroups.removeClass("radio-invalid");
                current.find(".invalid-feedback").hide();
            }
        }
        if (index === 8) {
            const selected = current.find("input[name='maritalStatus']:checked").length > 0;
            const radioGroups = current.find(".maritalStatusRadioGroup");

            if (!selected) {
                radioGroups.addClass("radio-invalid");
                current.find(".invalid-feedback").first().show();
                isValid = false;

                setTimeout(() => {
                    radioGroups.removeClass("radio-invalid");
                    current.find(".invalid-feedback").first().hide();
                }, 3000);
            } else {
                radioGroups.removeClass("radio-invalid");
                current.find(".invalid-feedback").first().hide();

                const othersInput = $("#maritalStatusOtherInput");

                if ($("#maritalStatus_others").is(":checked")) {
                    othersInput.prop("required", true);
                    if (!othersInput[0].checkValidity()) {
                        othersInput[0].reportValidity();
                        isValid = false;
                    }
                } else {
                    othersInput.prop("required", false);
                }
            }
        }

        // isValid = true;
        return isValid;
    }

    $("#nextBtn").click(function () {
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
        }
    });

    $("#previousBtn").click(function () {
        currentStep--;
        showStep(currentStep);
    });

    showStep(currentStep);

    $(document).on('change', 'input[name="inquirySource"]', function () {
        const selectedValue = $('input[name="inquirySource"]:checked').val();
        if (selectedValue === 'Face To Face') {
            if ($("#f2fSource").hasClass('d-none')) {
                $("#f2fSource").removeClass('d-none');
            }
            if (!$("#onlineSource").hasClass('d-none')) {
                $("#onlineSource").addClass('d-none');
            }
        } else if (selectedValue === 'Online') {
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
        if (selectedValue === "Mall Display") {
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


        currentStep = 1;
        showStep(currentStep);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://psgc.gitlab.io/api/provinces/",
            success: function (response) {
                $('#province').empty().append(`<option value="" selected hidden>--Select Province--</option></option>`);
                $('#municipality').empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                $('#barangay').empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                response.forEach(province => {
                    $('#province').append(`<option value="${province.name}" data-code="${province.code}">${province.name}</option>`);
                });
                $('#province').select2({
                    placeholder: "--Select Province--",
                    width: '100%',
                    dropdownParent: $('#createInquiryModal')
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
    });
    $("#province").on('change', function () {
        const provinceCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`,
            dataType: "json",
            success: function (response) {
                $('#municipality').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Municipality--</option></option>`);
                response.forEach(municipality => {
                    $('#municipality').append(`<option value="${municipality.name}" data-code="${municipality.code}">${municipality.name}</option>`);
                });
                $('#municipality').select2({
                    placeholder: "--Select Municipality--",
                    width: '100%',
                    dropdownParent: $('#createInquiryModal')
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
    $("#municipality").on('change', function () {
        const municipalityCode = $(this).find(':selected').data('code');
        $.ajax({
            type: "GET",
            url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
            dataType: "json",
            success: function (response) {
                $('#barangay').prop('disabled', false).empty().append(`<option value="" selected hidden>--Select Barangay--</option></option>`);
                response.forEach(barangay => {
                    $('#barangay').append(`<option value="${barangay.name}" data-code="${barangay.code}">${barangay.name}</option>`);
                });
                $('#barangay').select2({
                    placeholder: "--Select Barangay--",
                    width: '100%',
                    dropdownParent: $('#createInquiryModal')
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
    $(document).on("change", "input[name='maritalStatus']", function () {
        const selected = $("input[name='maritalStatus']:checked").val();

        if (selected === "Others") {
            $("#maritalStatusOtherGroup").removeClass("d-none");
            $("#maritalStatusOtherInput").attr("required", true).focus();
        } else {
            $("#maritalStatusOtherGroup").addClass("d-none");
            $("#maritalStatusOtherInput").removeAttr("required").removeClass("is-invalid");
        }
    });
});