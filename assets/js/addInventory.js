
$(document).ready(function () {
    let createInventoryValidationTimeout;

    $(".modalBtn").click(function (e) { 
        e.preventDefault();
        
        const modalId = $(this).data('bsTarget');

        if(modalId === "#createInventoryModal"){

            if(createInventoryValidationTimeout){
                clearTimeout(createInventoryValidationTimeout);
            }
            $("#createInventoryForm").removeClass('was-validated');3

            $("#itemType").val("");
            $("#itemName").val("");
            $("#itemBrand").val("");
            $("#itemModel").val("");
            $("#user").val("");
            $("#department").val("");
            $("#supplierName").val("");
            $("#serialNumber").val("");
            $("#price").val("");
            $("#status").val("");
            $("#remarks").val("");
        }
    });

    const createInventoryForm = $('#createInventoryForm');

    createInventoryForm.each(function() {
        $(this).submit(function (e) { 
            e.preventDefault();
            if(createInventoryValidationTimeout){
                clearTimeout(createInventoryValidationTimeout);
            }
            if(!this.checkValidity()){
                e.stopPropagation();
            }else{
                Swal.fire({
                    title: 'Add to Inventory?',
                    text: "Are you sure you want to add this inventory?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--bs-success)',
                    cancelButtonColor: 'var(--bs-danger)',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    console.log(result);
                    if (result.isConfirmed) {
                        const formData = $(this).serialize();
                        $.ajax({
                            type: 'POST',
                            url: '../../../backend/admin/inventory-management/addInventory.php',
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
                        })
                    }
                })
            }
            $(this).addClass('was-validated');
            createInventoryValidationTimeout = setTimeout(() => {
                $(this).removeClass('was-validated');
            }, 3000);
        });
    })
});