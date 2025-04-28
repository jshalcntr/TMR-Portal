$(document).ready(function () {
    let createSubprofilingValidationTimeout;
    $("#createSubprofilingForm").on("submit", function (e) {
        e.preventDefault();
        // console.log($(this).serialize());

        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            console.log("Goods");
        }
        $(this).addClass('was-validated');
        createInventoryValidationTimeout = setTimeout(() => {
            $(this).removeClass('was-validated');
        }, 3000);
    });
});