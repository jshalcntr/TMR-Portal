<div id="inquiryAlerts" class="modal fade" tabindex="-1" aria-labelledby="inquiryAlertsLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="inquiryAlertsLabel">Notifications</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row modal-body custom-scrollable-body" id="inquiryAlertsBody">
                <div class="col">
                    <div class="colxl-3">
                        <div class="card shadow py-1" role="button">
                            <div class="card-body py-2 px-3 d-flex align-items-center" style="gap: 12px;">
                                <i class="fas fa-envelope fa-2x text-gray-500"></i>
                                <div class="text-primary font-weight-bold">
                                    <div class="text-s text-truncate">Follow-up appointment due.</div>
                                    <div class="text-xs text-gray-500">July 9, 2025 @ 8:00 am</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-8" role="button">
                    <link rel="stylesheet" href="../../assets/css/custom/sales-management/inquiryCalendar.css">
                    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
                    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
                    <script src="../../assets/js/sales-management/inquiryCalendar.js"></script>
                    <div id="calendar" style="min-height: 600px; width: 100%;"></div>
                </div>

            </div>
        </div>
    </div>
</div>