$(document).ready(function () {
    // Initialize DataTable
    const backordersTable = $('#serviceAdvisorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "../../backend/e-boss/getServiceAdvisorBackorders.php",
            type: "POST",
            error: function (xhr, error, thrown) {
                console.log('DataTables error: ', error);
                console.log('Error details: ', thrown);
                console.log('Server response: ', xhr.responseText);
            }
        },
        columns: [
            { data: "order_date" },
            { data: "ro_number" },
            { data: "customer_name" },
            { data: "order_no" },
            { data: "part_number" },
            { data: "part_name" },
            { data: "qty" },
            {
                data: "bo_price",
                render: function (data) {
                    return parseFloat(data).toLocaleString('en-PH', {
                        style: 'currency',
                        currency: 'PHP'
                    });
                }
            },
            {
                data: "total",
                render: function (data) {
                    return parseFloat(data).toLocaleString('en-PH', {
                        style: 'currency',
                        currency: 'PHP'
                    });
                }
            },
            { data: "eta_1" },
            { data: "eta_2" },
            { data: "eta_3" },
            { data: "aging" },
            {
                data: "order_status",
                render: function (data) {
                    let badgeClass = 'badge bg-secondary';
                    if (data === 'Delivered') {
                        badgeClass = 'badge bg-success';
                    } else if (data === 'Cancelled') {
                        badgeClass = 'badge bg-danger';
                    } else if (data === 'Order Processed at Source') {
                        badgeClass = 'badge bg-info';
                    }
                    return `<span class="${badgeClass}">${data}</span>`;
                }
            },
            { data: "service_type" },
            { data: "unit_model" },
            { data: "plate_no" },
            {
                data: null,
                render: function (data, type, row) {
                    let buttons = `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info viewBtn" data-id="${row.id}">
                                <i class="fa fa-eye fa-sm"></i>
                            </button>`;

                    if (row.order_status === 'Delivered' && !row.has_appointment) {
                        buttons += `
                            <button type="button" class="btn btn-sm btn-success scheduleBtn" data-id="${row.id}">
                                <i class="fa fa-calendar-plus fa-sm"></i>
                            </button>`;
                    }

                    buttons += `</div>`;
                    return buttons;
                }
            }
        ],
        order: [[0, 'desc']],
        createdRow: function (row, data) {
            // Add color coding based on ETA status
            if (data.rowClass) {
                $(row).addClass(data.rowClass);
            }
        },
        fixedColumns: {
            left: 3,  // Fix RO Number, Customer Name columns
            right: 1  // Fix Actions column
        },
        scrollX: true
    });

    // View Button Handler
    $(document).on("click", ".viewBtn", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "../../backend/e-boss/viewBackorders.php",
            type: "POST",
            data: { id: id },
            success: function (response) {
                $("#viewDetailsContainer").html(response);
                $("#viewModal").modal("show");
            }
        });
    });

    // Initialize Select2
    $('#backorderSelect').select2({
        placeholder: 'Select delivered backorders',
        ajax: {
            url: '../../backend/e-boss/getDeliveredBackorders.php',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        let appointmentInfo = item.appointment_date ?
                            ` (Scheduled: ${item.appointment_date} by ${item.scheduled_by})` :
                            ' (Not scheduled)';

                        return {
                            id: item.id,
                            text: `${item.ro_number} - ${item.customer_name} - ${item.part_name} - ${item.plate_no}${appointmentInfo}`,
                            appointment: item.appointment_date,
                            disabled: item.appointment_date !== null
                        };
                    })
                };
            },
            cache: true
        },
        templateResult: function (data) {
            if (!data.id) return data.text;

            let $element = $(`
                <div class="d-flex flex-column">
                    <strong>${data.text}</strong>
                    ${data.appointment ?
                    '<span class="text-success"><i class="fas fa-calendar-check"></i> Scheduled</span>' :
                    '<span class="text-warning"><i class="fas fa-calendar"></i> Not scheduled</span>'
                }
                </div>
            `);

            return $element;
        }
    });

    // Individual Schedule Button Handler
    $(document).on("click", ".scheduleBtn", function () {
        let id = $(this).data("id");
        $("#backorderId").val(id);

        // Set min date to today
        let today = new Date().toISOString().split('T')[0];
        $("#appointmentDate").attr('min', today);

        $("#appointmentModal").modal("show");
    });

    // Set min date for batch scheduling
    let today = new Date().toISOString().split('T')[0];
    $("#batchAppointmentDate").attr('min', today);

    // Appointment Form Submit Handler
    $("#appointmentForm").submit(function (e) {
        e.preventDefault();

        let $submitBtn = $("#submitAppointment");
        let originalText = $submitBtn.html();
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Scheduling...');

        $.ajax({
            url: "../../backend/e-boss/scheduleAppointment.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $("#appointmentModal").modal("hide");
                        backordersTable.ajax.reload(null, false);
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire("Error!", "Something went wrong.", "error");
            },
            complete: function () {
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Batch Appointment Form Submit Handler
    $("#batchAppointmentForm").submit(function (e) {
        e.preventDefault();

        let selectedBackorders = $('#backorderSelect').val();
        if (!selectedBackorders || selectedBackorders.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Please select at least one backorder"
            });
            return;
        }

        let $submitBtn = $("#submitBatchAppointment");
        let originalText = $submitBtn.html();
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Scheduling...');

        let formData = new FormData(this);
        formData.append('backorders', JSON.stringify(selectedBackorders));

        $.ajax({
            url: "../../backend/e-boss/batchScheduleAppointments.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $("#batchAppointmentModal").modal("hide");
                        $('#backorderSelect').val(null).trigger('change');
                        backordersTable.ajax.reload(null, false);
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message
                    });
                }
            },
            error: function (xhr) {
                let message = "Something went wrong.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire("Error!", message, "error");
            },
            complete: function () {
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});