$(document).ready(function () {
    $(document).on('click', '#repairButton', function () {
        $("#repairItemForm").removeClass('was-validated');
        $("#repairItemModal").modal({
            backdrop: true,
            keyboard: true
        }).modal('show');
        
        $("#viewInventoryModal").css('z-index', '1040').modal('hide');
        $("#repairDate").attr('min', $("#dateAcquired_edit").val())
    });

    $('#repairItemModal').on('hidden.bs.modal', function () {
        $("#viewInventoryModal").css('z-index', '1050').modal({
            backdrop: true,
            keyboard: true
        }).modal('show');
    });

    let repairItemValidationTimeout;

    $("#repairItemForm").submit(function (e) { 
        e.preventDefault();
        
        if(repairItemValidationTimeout){
            clearTimeout(repairItemValidationTimeout);
        }
        if(!this.checkValidity()){
            e.stopPropagation();
        }else{
            const formData = $(this).serialize();

            const inventoryId = $("#id_edit").val();

            const fullData = `${formData}&inventoryId=${encodeURIComponent(inventoryId)}`;

            $.ajax({
                type: "POST",
                url: "../../../backend/admin/inventory-management/addRepair.php",
                data: fullData,
                success: function (response) {
                    if(response.status === 'internal-error'){
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        })
                    }else if(response.status === 'success'){
                        Swal.fire({
                            title: 'Success!',
                            text: `${response.message}`,
                            icon: 'success',
                            confirmButtonColor: 'var(--bs-success)'
                        }).then(() => {
                            window.location.reload();
                        })
                    }
                }
            });
        }
        $(this).addClass('was-validated');
        repairItemValidationTimeout = setTimeout(() => {
            $(this).removeClass('was-validated');
        }, 3000);
    });

    const toggleEditRepairButton = () => {
        $("#repairDescription_edit").prop('disabled', !$("#repairDescription_edit").prop('disabled'));
        $("#gatepassNumber_edit").prop('disabled', !$("#gatepassNumber_edit").prop('disabled'));
        $("#repairDate_edit").prop('disabled', !$("#repairDate_edit").prop('disabled'));

        $("#viewRepairButtonGroup").toggleClass('d-flex');
        $("#viewRepairButtonGroup").toggleClass('d-none');
        $("#editRepairButtonGroup").toggleClass('d-flex');
        $("#editRepairButtonGroup").toggleClass('d-none');
    }

    $("#editRepairButton").on('click', function () {
        toggleEditRepairButton();
    });
    $("#cancelEditRepairButton").on('click', function () {
        toggleEditRepairButton();
    });

    let editRepairValidationTimeout;

    $("#editRepairItemForm").submit(function (e) { 
        e.preventDefault();
        
        if(editRepairValidationTimeout){
            clearTimeout(editRepairValidationTimeout);
        }
        if(!this.checkValidity()){
            e.stopPropagation();
        }else{
            Swal.fire({
                title: "Edit Inventory?",
                text: "Are you sure you want to edit this inventory?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-success)',
                cancelButtonColor: 'var(--bs-danger)',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if(result.isConfirmed) {
                    const formData = $(this).serialize();

                    const inventoryId = $("#id_edit").val();

                    const fullData = `${formData}&inventoryId=${encodeURIComponent(inventoryId)}`;

                    $.ajax({
                        type: "POST",
                        url: "../../../backend/admin/inventory-management/editRepair.php",
                        data: fullData,
                        success: function(response) {
                            if(response.status === 'success'){
                                Swal.fire({
                                    title: 'Success!',
                                    text: `${response.message}`,
                                    icon: 'success',
                                    confirmButtonColor: 'var(--bs-success)'
                                }).then(()=>{
                                    window.location.reload();
                                })
                            }else if(response.status === 'internal-error'){
                                Swal.fire({
                                    title: 'Error!',
                                    text: `${response.message}`,
                                    icon: 'error',
                                    confirmButtonColor: 'var(--bs-danger)'
                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            console.log(status);
                            console.log(error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An internal error occurred. Please contact MIS.',
                                icon: 'error',
                                confirmButtonColor: 'var(--bs-danger)'
                            })
                        }
                    });
                }
            })
            
        }
    });
    $("#finishRepairButton").on('click', function () {
        Swal.fire({
            title: "Finish Repair?",
            text: "Are you sure you want to finish this Repair?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-success)',
            cancelButtonColor: 'var(--bs-danger)',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../../../backend/admin/inventory-management/finishRepair.php",
                    data: {
                        repairId: $("#repairId_edit").val(),
                        inventoryId: $("#id_edit").val()
                    },
                    success: function(response) {
                        if(response.status === 'success'){
                            Swal.fire({
                                title: 'Success!',
                                text: `${response.message}`,
                                icon: 'success',
                                confirmButtonColor: 'var(--bs-success)'
                            }).then(()=>{
                                window.location.reload();
                            })
                        }else if(response.status === 'internal-error'){
                            Swal.fire({
                                title: 'Error!',
                                text: `${response.message}`,
                                icon: 'error',
                                confirmButtonColor: 'var(--bs-danger)'
                            })
                        }
                    },    
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        console.log(status);
                        console.log(error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An internal error occurred. Please contact MIS.',
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        })
                    }
                });
            }
        })
    });
    $("#cancelEditRepairButton").on('click', function () {
        $.ajax({
            type: "GET",
            url: "../../../backend/admin/inventory-management/getRepair.php",
            data: {
                repairId: $("#repairId_edit").val()
            },
            success: function (response) {
                if(response.status === "internal-error"){
                    Swal.fire({
                        title: 'Error!',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });
                }else{
                    const repairData = response.data[0];
                    $("#repairDescription_edit").val(repairData.repair_description);
                    $("#gatepassNumber_edit").val(repairData.gatepass_number);
                    $("#repairDate_edit").val(repairData.start_date);
                }
            }
        });
    });
});