$(document).ready(function () {
    let editInventoryValidationTimeout;
    $(document).on('click','.viewInventoryBtn', function (e) {
        e.preventDefault();
        if(!$("#itemType_edit").prop('disabled')) {
            toggleEditModal();
        }
        if(editInventoryValidationTimeout){
            clearTimeout(editInventoryValidationTimeout);
        }
        $("#editInventoryForm").removeClass('was-validated');

        const queriedId = $(this).data('inventory-id');
        console.log(queriedId);

        $.ajax({
            type: "GET",
            url: "../../../backend/admin/inventory-management/getInventory.php",
            data: {
                id: queriedId
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
                    
                    const inventoryData = response.data[0];
                    console.log(response);
                    
                    $("#assetNumber_edit").text((inventoryData.fa_number) ? inventoryData.fa_number : "Non-Fixed Asset");
                    $("#itemType_edit").val(inventoryData.item_type);
                    $("#itemName_edit").val(inventoryData.item_name);
                    $("#itemBrand_edit").val(inventoryData.brand);
                    $("#itemModel_edit").val(inventoryData.model);
                    $("#user_edit").val(inventoryData.user);
                    $("#department_edit").val(inventoryData.department);
                    $("#dateAcquired_edit").val(inventoryData.date_acquired);
                    $("#supplierName_edit").val(inventoryData.supplier);
                    $("#serialNumber_edit").val(inventoryData.serial_number);
                    $("#status_edit").val(inventoryData.status);
                    $("#price_edit").val(inventoryData.price);
                    $("#remarks_edit").val(inventoryData.remarks);
                    $("#id_edit").val(queriedId);
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log(xhr.responseText);
            }
        });
    });

    const toggleEditModal = () => {
        $("#itemType_edit").prop('disabled', !$("#itemType_edit").prop('disabled'));
        $("#itemName_edit").prop('disabled', !$("#itemName_edit").prop('disabled'));
        $("#itemBrand_edit").prop('disabled', !$("#itemBrand_edit").prop('disabled'));
        $("#itemModel_edit").prop('disabled', !$("#itemModel_edit").prop('disabled'));
        $("#user_edit").prop('disabled', !$("#user_edit").prop('disabled'));
        $("#department_edit").prop('disabled', !$("#department_edit").prop('disabled'));
        $("#dateAcquired_edit").prop('disabled', !$("#dateAcquired_edit").prop('disabled'));
        $("#supplierName_edit").prop('disabled', !$("#supplierName_edit").prop('disabled'));
        $("#serialNumber_edit").prop('disabled', !$("#serialNumber_edit").prop('disabled'));
        $("#status_edit").prop('disabled', !$("#status_edit").prop('disabled'));
        $("#price_edit").prop('disabled', !$("#price_edit").prop('disabled'));
        $("#remarks_edit").prop('disabled', !$("#remarks_edit").prop('disabled'));

        $("#viewActionsRow").toggleClass('d-flex');
        $("#viewActionsRow").toggleClass('d-none');
        $("#editActionsRow").toggleClass('d-flex');
        $("#editActionsRow").toggleClass('d-none');
    }
    $("#editButton").on('click', function () {
        toggleEditModal();
    });
    $("#cancelButton").on('click', function () {
        toggleEditModal();

        const queriedId = $("#id_edit").val();

        $.ajax({
            type: "GET",
            url: "../../../backend/admin/inventory-management/getInventory.php",
            data: {
                id: queriedId
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
                    
                    const inventoryData = response.data[0];
                    console.log(inventoryData);
                    
                    $("#assetNumber_edit").text((inventoryData.fa_number) ? inventoryData.fa_number : "Non-Fixed Asset");
                    $("#itemType_edit").val(inventoryData.item_type);
                    $("#itemName_edit").val(inventoryData.item_name);
                    $("#itemBrand_edit").val(inventoryData.brand);
                    $("#itemModel_edit").val(inventoryData.model);
                    $("#user_edit").val(inventoryData.user);
                    $("#department_edit").val(inventoryData.department);
                    $("#dateAcquired_edit").val(inventoryData.date_acquired);
                    $("#supplierName_edit").val(inventoryData.supplier);
                    $("#serialNumber_edit").val(inventoryData.serial_number);
                    $("#status_edit").val(inventoryData.status);
                    $("#price_edit").val(inventoryData.price);
                    $("#remarks_edit").val(inventoryData.remarks);
                    $("#id_edit").val(queriedId);
                }
            }
        });
    });

    const editInventoryForm = $("#editInventoryForm");

    editInventoryForm.each(function () {
        $(this).submit(function (e) { 
            e.preventDefault();
            if(editInventoryValidationTimeout){
                clearTimeout(editInventoryValidationTimeout);
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
                    console.log(result.isConfirmed);
                    if(result.isConfirmed) {
                        const formData = $(this).serialize();
                        $.ajax({
                            type: "POST",
                            url: "../../../backend/admin/inventory-management/editInventory.php",
                            data: formData,
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
            $(this).addClass('was-validated');
            editInventoryValidationTimeout = setTimeout(() => {
                $(this).removeClass('was-validated');
            }, 3000);
        });
    })
});