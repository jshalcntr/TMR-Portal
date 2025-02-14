$(document).ready(function () {
    $("#viewRequestHistoryBtn").click(function (e) {
        // $.ajax({
        //     type: "GET",
        //     url: "../../../backend/admin/inventory-management/getPersonalRequests.php",
        //     data: {
        //         inventoryId: queriedId
        //     },
        //     success: function (response) {
        //         if(response.status === 'internal-error'){
        //             Swal.fire({
        //                 title: 'Error! ',
        //                 text: `${response.message}`,
        //                 icon: 'error',
        //                 confirmButtonColor: 'var(--bs-danger)'
        //             });
        //         }else if(response.status === 'success'){
                    
        //         }
        //     }
        // });
        const requestTable = $('#requestHistoryTable').DataTable({
            ajax: {
                url: "../../../backend/admin/inventory-management/getPersonalRequests.php",
                type: "GET",
                data: function(d){
                    d.inventoryId = queriedId
                }
            }
        });
    });
});