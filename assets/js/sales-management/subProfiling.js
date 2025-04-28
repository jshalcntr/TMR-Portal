$(document).ready(function () {
    // ! Hidden input fields for Work Nature
    $("#workNature").on('change', function () {
        const workNature = $(this).val();

        if (workNature === 'profession') {
            if ($("#professionRow").hasClass('d-none')) {
                $("#professionRow").removeClass('d-none');
                $("#profession").prop('required', true);

            }
            if (!$("#businessNatureRow").hasClass('d-none')) {
                $("#businessNatureRow").addClass('d-none');
                $("#jobDemoRow").addClass('d-none');
                $("#businessNatureRow").prop('required', false);
                $("#jobDemo").prop('required', false);

            }
        } else if (workNature === 'businessNature') {
            if ($("#businessNatureRow").hasClass('d-none')) {
                $("#businessNatureRow").removeClass('d-none');
                $("#jobDemoRow").removeClass('d-none');
                $("#businessNatureRow").prop('required', true);
                $("#jobDemo").prop('required', true);
            }
            if (!$("#professionRow").hasClass('d-none')) {
                $("#professionRow").addClass('d-none');
                $("#profession").prop('required', false);
            }
        } else if (workNature === 'both') {
            if ($("#professionRow").hasClass('d-none')) {
                $("#professionRow").removeClass('d-none');
                $("#profession").prop('required', true);
            }
            if ($("#businessNatureRow").hasClass('d-none')) {
                $("#businessNatureRow").removeClass('d-none');
                $("#jobDemoRow").removeClass('d-none');
                $("#businessNatureRow").prop('required', true);
                $("#jobDemo").prop('required', true);
            }
        } else if (workNature === 'notApp') {
            if (!$("#businessNatureRow").hasClass('d-none')) {
                $("#businessNatureRow").addClass('d-none');
                $("#jobDemoRow").addClass('d-none');
                $("#businessNatureRow").prop('required', false);
                $("#jobDemo").prop('required', false);
            }
            if (!$("#professionRow").hasClass('d-none')) {
                $("#professionRow").addClass('d-none');
                $("#profession").prop('required', false);
            }
        }
    });

    // ! Hidden input fields for Source of Sales
    $("#salesSource").on('change', function () {
        const salesSource = $(this).val();

        if (salesSource === 'referral') {
            if ($("#referralRow").hasClass('d-none')) {
                $("#referralRow").removeClass('d-none');
                $("#referralSource").prop('required', true);
            }
            if (!$("#repeatClientRow").hasClass('d-none')) {
                $("#repeatClientRow").addClass('d-none');
                $("#repeatClient").prop('required', false);

            }
            if (!$("#mallDisplayRow").hasClass('d-none')) {
                $("#mallDisplayRow").addClass('d-none');
                $("#mallDisplay").prop('required', false);
            }
        } else if (salesSource === 'repeat_client') {
            if ($("#repeatClientRow").hasClass('d-none')) {
                $("#repeatClientRow").removeClass('d-none');
                $("#repeatClient").prop('required', true);
            }
            if (!$("#referralRow").hasClass('d-none')) {
                $("#referralRow").addClass('d-none');
                $("#referralSource").prop('required', false);
            }
            if (!$("#mallDisplayRow").hasClass('d-none')) {
                $("#mallDisplayRow").addClass('d-none');
                $("#mallDisplay").prop('required', false);
            }
        } else if (salesSource === 'mall_display') {
            if ($("#mallDisplayRow").hasClass('d-none')) {
                $("#mallDisplayRow").removeClass('d-none');
                $("#mallDisplay").prop('required', true);
            }
            if (!$("#referralRow").hasClass('d-none')) {
                $("#referralRow").addClass('d-none');
                $("#referralSource").prop('required', false);
            }
            if (!$("#repeatClientRow").hasClass('d-none')) {
                $("#repeatClientRow").addClass('d-none');
                $("#repeatClient").prop('required', false);
            }
        } else {
            if (!$("#referralRow").hasClass('d-none')) {
                $("#referralRow").addClass('d-none');
                $("#referralSource").prop('required', false);
            }
            if (!$("#repeatClientRow").hasClass('d-none')) {
                $("#repeatClientRow").addClass('d-none');
                $("#repeatClient").prop('required', false);
            }
            if (!$("#mallDisplayRow").hasClass('d-none')) {
                $("#mallDisplayRow").addClass('d-none');
                $("#mallDisplay").prop('required', false);
            }
        }
    });

    // ! Hidden input fields for Manner of Release
    $("#releaseManner").on('change', function () {
        const mannerOfRelease = $(this).val();
        if (mannerOfRelease === 'technical') {
            if ($("#technicalRow").hasClass('d-none')) {
                $("#technicalRow").removeClass('d-none');
                $("#technicalReleaseDate").prop('required', true);
            }
        } else {
            if (!$("#technicalRow").hasClass('d-none')) {
                $("#technicalRow").addClass('d-none');
                $("#technicalReleaseDate").prop('required', false);
            }
        }
    });
});