$(document).ready(function () {
    // Wait a bit to ensure DOM is fully loaded
    setTimeout(function () {
        // Check if table exists
        if ($('#backordersRecordsTable').length === 0) {
            console.error('Table #backordersRecordsTable not found');
            return;
        }

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#backordersRecordsTable')) {
            console.log('DataTable already initialized');
            return;
        }

        let table;
        try {
            table = $('#backordersRecordsTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '../../backend/e-boss/fetchDeliveredBackorders.php',
                    type: 'GET',
                    error: function (xhr, error, thrown) {
                        console.error('DataTable AJAX error:', error, thrown);
                        alert('Error loading data: ' + error);
                    }
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return '<input type="checkbox" class="row-checkbox" value="' + row.id + '">';
                        }
                    },
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
                    { data: 'appointment_date' },
                    {
                        data: 'appointment_time',
                        render: function (data) {
                            return data || '';
                        }
                    },
                    {
                        data: 'appointment_remarks',
                        render: function (data) {
                            return data || '';
                        }
                    },
                    {
                        data: 'scheduled_by',
                        render: function (data) {
                            return data || '';
                        }
                    },
                    { data: 'service_estimator' },
                    { data: 'unit_model' },
                    { data: 'plate_no' },
                    { data: 'unit_status' },
                    { data: 'remarks' },
                    { data: 'order_status' },
                    { data: 'delivery_date' },
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
                    left: 4,
                    right: 1
                },
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '50px'
                    },
                    {
                        targets: -1, // Last column (action)
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[2, 'desc']],
                responsive: true,
                pageLength: 25
            });
        } catch (error) {
            console.error('DataTable initialization error:', error);
            alert('Error initializing table: ' + error.message);
            return;
        }

        // Export functionality
        $('#exportBtn').on('click', function () {
            let exportUrl = '../../backend/e-boss/exportDeliveredBackorders.php';

            // Create temporary link and trigger download
            let link = document.createElement('a');
            link.href = exportUrl;
            link.download = 'delivered_backorders_export_' + new Date().toISOString().slice(0, 19).replace(/:/g, '-') + '.xlsx';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Bulk operations functionality
        let selectedItems = [];

        // Select all checkbox
        $('#selectAll').on('change', function () {
            let isChecked = $(this).is(':checked');
            $('.row-checkbox').prop('checked', isChecked);
            updateBulkOperations();
        });

        // Individual row checkboxes
        $(document).on('change', '.row-checkbox', function () {
            updateBulkOperations();
        });

        function updateBulkOperations() {
            selectedItems = [];
            $('.row-checkbox:checked').each(function () {
                selectedItems.push($(this).val());
            });

            $('#selectedCount').text(selectedItems.length);

            if (selectedItems.length > 0) {
                $('#bulkOperations').show();
            } else {
                $('#bulkOperations').hide();
            }

            // Update select all checkbox
            let totalCheckboxes = $('.row-checkbox').length;
            let checkedCheckboxes = $('.row-checkbox:checked').length;
            $('#selectAll').prop('checked', totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes);
        }

        // Bulk restore
        $('#bulkRestoreBtn').on('click', function () {
            if (selectedItems.length === 0) return;

            Swal.fire({
                title: 'Restore Selected Items',
                text: `Are you sure you want to restore ${selectedItems.length} item(s) back to pending status?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Restore',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    performBulkOperation('restore', selectedItems);
                }
            });
        });

        // Bulk delete
        $('#bulkDeleteBtn').on('click', function () {
            if (selectedItems.length === 0) return;

            Swal.fire({
                title: 'Delete Selected Items',
                text: `Are you sure you want to delete ${selectedItems.length} item(s)?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    performBulkOperation('delete', selectedItems);
                }
            });
        });

        function performBulkOperation(action, ids) {
            $.ajax({
                url: '../../backend/e-boss/bulkDeliveredOperations.php',
                type: 'POST',
                data: {
                    action: action,
                    ids: ids
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            timer: 3000
                        });
                        table.ajax.reload();
                        selectedItems = [];
                        updateBulkOperations();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while processing the request.',
                        icon: 'error'
                    });
                }
            });
        }

    }, 100); // End of setTimeout
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
