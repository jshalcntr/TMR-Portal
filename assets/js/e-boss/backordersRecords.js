$(document).ready(function () {
    let table = $('#backordersRecordsTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '../../backend/e-boss/fetchBackorders.php',
            type: 'GET'
        },
        columns: [
            { data: 'ro_number' },
            { data: 'customer_name' },
            { data: 'order_date' },
            { data: 'aging' },
            { data: 'order_no' },
            { data: 'source' },
            { data: 'part_number' },
            { data: 'part_name' },
            { data: 'qty' },
            { data: 'bo_price' },
            { data: 'total' },
            { data: 'eta_1' },
            { data: 'eta_2' },
            { data: 'eta_3' },
            { data: 'order_type' },
            { data: 'service_type' },
            { data: 'service_estimator' },
            { data: 'unit_model' },
            { data: 'plate_no' },
            { data: 'remarks' },
            { data: 'status' },
            { data: 'action' }
        ],
        rowCallback: function (row, data) {
            if (data.rowClass) {
                $(row).addClass(data.rowClass);
            }
        },
        drawCallback: function (settings) {
            // copy row classes into fixed columns (append, don't overwrite)
            $('#backordersRecordsTable').find('tbody tr').each(function (i) {
                let mainRow = $(this);
                let customClasses = mainRow.attr('class').split(/\s+/);

                // apply to fixed left
                let leftRow = $('.dtfc-fixed-left tbody tr').eq(i);
                $.each(customClasses, function (idx, cls) {
                    if (cls && !leftRow.hasClass(cls)) {
                        leftRow.addClass(cls);
                    }
                });

                // apply to fixed right
                let rightRow = $('.dtfc-fixed-right tbody tr').eq(i);
                $.each(customClasses, function (idx, cls) {
                    if (cls && !rightRow.hasClass(cls)) {
                        rightRow.addClass(cls);
                    }
                });
            });
        },
        scrollX: true,
        fixedColumns: {
            left: 3,
            right: 1
        },
        order: [[2, 'desc']],
        responsive: true,
        pageLength: 25
    });


});
// Run after table draw
$('#backordersRecordsTable').on('shown.bs.dropdown', function (e) {
    let $menu = $(e.target).find('.dropdown-menu');
    $('body').append($menu.detach());  // move dropdown to body
    $menu.css({
        display: 'block',
        position: 'absolute',
        left: $(e.target).offset().left,
        top: $(e.target).offset().top + $(e.target).outerHeight(),
        zIndex: 20000
    });
}).on('hide.bs.dropdown', function (e) {
    let $menu = $(e.target).find('.dropdown-menu');
    $(e.target).append($menu.detach()); // put it back
    $menu.hide();
});
