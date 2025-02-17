$(document).ready(function () {
    $("#exportInventoryModalBtn").on('click', function () {
        //! CHANGE ITEM TYPES VALUE
        // $('#itemType_export').find('option').not('[value="all"]').remove();
        // $('#itemType_export').val('all');

        // $.ajax({
        //     type: "GET",
        //     url: "../../backend/inventory-management/getItemTypes.php",
        //     dataType: "json",
        //     success: function (response) {
        //         console.log(response);
        //         if(response.status === 'internal-error'){
        //             Swal.fire({
        //                 title: 'Error!',
        //                 text: `${response.message}`,
        //                 icon: 'error',
        //                 confirmButtonColor: 'var(--bs-danger)'
        //             })
        //         }else{
        //             response.forEach((itemType) => {
        //                 $("#itemType_export").append(
        //                     $('<option>',{
        //                         value: itemType,
        //                         text: itemType
        //                     })
        //                 );
        //             })
        //         }
        //     }
        // });
        $("#exportInventoryForm")[0].reset();
        //! FETCH OLDEST DATE ACQUIRED
        $.ajax({
            type: "GET",
            url: "../../backend/inventory-management/getOldestDateAcquired.php",
            dataType: "json",
            success: function (response) {
                if (response.status === 'internal-error') {
                    Swal.fire({
                        title: 'Error!',
                        text: `${response.message}`,
                        icon: 'error',
                        confirmButtonColor: 'var(--bs-danger)'
                    })
                } else {
                    $('#dateFrom').attr('min', response);
                    $('#dateTo').attr('min', response);
                }
            }
        });
    });

    $("#all_itemType").on('change', function () {
        $('.item-checkbox').prop('checked', $(this).is(':checked'));
    });
    $(".item-checkbox").on('change', function () {
        if ($('.item-checkbox:checked').length !== $('.item-checkbox').length) {
            $("#all_itemType").prop('checked', false);
        } else {
            $("#all_itemType").prop('checked', true);
        }
    });
    $("#all_status").on('change', function () {
        $('.status-checkbox').prop('checked', $(this).is(':checked'));
    });
    $(".status-checkbox").on('change', function () {
        if ($('.status-checkbox:checked').length !== $('.status-checkbox').length) {
            $("#all_status").prop('checked', false);
        } else {
            $("#all_status").prop('checked', true);
        }
    });

    $("#dateFrom").on('change', function () {
        if ($(this).val() === '') {
            $.ajax({
                type: "GET",
                url: "../../backend/inventory-management/getOldestDateAcquired.php",
                dataType: "json",
                success: function (response) {
                    if (response.status === 'internal-error') {
                        Swal.fire({
                            title: 'Error!',
                            text: `${response.message}`,
                            icon: 'error',
                            confirmButtonColor: 'var(--bs-danger)'
                        })
                    } else {
                        $('#dateTo').attr('min', response);
                    }
                }
            });
        } else {
            $('#dateTo').attr('min', $(this).val());
        }
    });
    $("#dateTo").on('change', function () {
        if ($(this).val() === '') {
            let today = new Date();

            let formattedDate = today.getFullYear() + '-' +
                String(today.getMonth() + 1).padStart(2, '0') + '-' +
                String(today.getDate()).padStart(2, '0');
            $('#dateFrom').attr('max', formattedDate);
        } else {
            $('#dateFrom').attr('max', $(this).val());
        }
    });
    $("#exportAllDate").on('change', function () {
        if ($(this).is(':checked')) {
            $('#dateFrom').attr('disabled', true);
            $('#dateTo').attr('disabled', true);

            $('#dateFrom').val('');
            $('#dateTo').val('');
        } else {
            $('#dateFrom').attr('disabled', false);
            $('#dateTo').attr('disabled', false);
        }
    });

    $(".exportInventoryModalBtn").on('click', function () {
        $("#assetType_All").prop('checked', true);
        $("#itemType_export").val("all");
        $("#dateFrom").val("");
        $("#dateTo").val("");
        $("#exportAllDate").prop('checked', false);
    });
});