$(document).ready(function () {
    $("#service_type").on("change", function () {
        let serviceType = $(this).val();
        let position = (serviceType === "SERVICE BP") ? "SE" : "SA";

        $.ajax({
            url: "../../backend/e-boss/fetchServiceEstimator.php",
            type: "POST",
            data: { position: position },
            dataType: "json",
            success: function (response) {
                let options = '<option value="">-- Select --</option>';
                $.each(response, function (index, item) {
                    options += `<option value="${item.fullname}">${item.fullname}</option>`;
                });
                $("#service_estimator").html(options);
            }
        });
    });
});
