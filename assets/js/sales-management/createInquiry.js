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

        $("#previousBtn").toggle(index > Math.min(...stepValues));
        $("#nextBtn").toggle(index < maxStep);
    }

    function validateStep(index) {
        const current = $(`.form-step[data-step="${index}"]`);
        let isValid = true;

        // current.find("input[required]").each(function () {
        //     if (!this.value.trim()) {
        //         $(this).addClass("is-invalid");
        //         setTimeout(() => {
        //             $(this).removeClass("is-invalid");
        //         }, 3000);
        //         isValid = false;
        //     } else {
        //         $(this).removeClass("is-invalid");
        //     }
        // });

        // if (index === 1) {
        //     const selected = current.find("input[name='prospectType']:checked").length > 0;
        //     const radioGroups = current.find(".prospectRadioGroup");

        //     if (!selected) {
        //         radioGroups.addClass("radio-invalid");

        //         current.find(".invalid-feedback").show();

        //         setTimeout(() => {
        //             radioGroups.removeClass("radio-invalid");
        //             current.find(".invalid-feedback").hide();
        //         }, 3000);

        //         isValid = false;
        //     } else {
        //         radioGroups.removeClass("radio-invalid");
        //         current.find(".invalid-feedback").hide();
        //     }
        // }

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
        console.log("Inquiry Source changed to:", selectedValue);
    });
});