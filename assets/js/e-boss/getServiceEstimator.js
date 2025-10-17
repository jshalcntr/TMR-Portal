$(document).ready(function () {
    $("#service_type").on("change", function () {
        let serviceType = $(this).val();
        let position = (serviceType === "SERVICE BP") ? "41" : "40";

        $.ajax({
            url: "../../backend/e-boss/fetchServiceEstimator.php",
            type: "POST",
            data: { position: position },
            dataType: "json",
            success: function (response) {
                let options = '<option value="">-- Select --</option>';
                $.each(response, function (index, item) {
                    options += `<option value="${item.full_name}">${item.full_name}</option>`;
                });
                $("#service_estimator").html(options);
            }
        });
    });
});
