$(document).ready(function () {
    $(document).on('click', '.viewDisposalModalBtn', function () {
        $.ajax({
            type: "GET",
            url: "../../backend/inventory-management/getDisposal.php",
            data: { inventoryId: $(this).data('inventory-id') },
            success: function (response) {
                console.log(response.data[0]);
                if (response.status === "internal-error") {
                    Swal.fire({
                        title: 'Error! ',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    });
                } else if (response.status === "success") {
                    const itemData = response.data[0];
                    $("#inventoryId_disposal").text(itemData.id);
                    $("#faNumber_disposal").text(itemData.fa_number === "" ? "Non-Fixed Asset" : itemData.fa_number);
                    $("#itemType_disposal").text(itemData.item_type);
                    $("#itemCategory_disposal").text(itemData.item_category);
                    $("#itemBrand_disposal").text(itemData.brand);
                    $("#itemModel_disposal").text(itemData.brand);
                    $("#itemSpecification_disposal").text(itemData.item_specification);
                    $("#user_disposal").text(itemData.user);
                    $("#computerName_disposal").text(itemData.computer_name);
                    $("#department_disposal").text(itemData.department);
                    $("#dateAcquired_disposal").text(convertToReadableDate(itemData.date_acquired));
                    $("#supplierName_disposal").text(itemData.supplier);
                    $("#serialNumber_disposal").text(itemData.serial_number);
                    $("#remarks_disposal").text(itemData.remarks);
                    $("#price_disposal").text(convertToPhp(itemData.price));
                }
            }
        });
    });
});