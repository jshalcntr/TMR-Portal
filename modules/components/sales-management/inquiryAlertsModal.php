<div id="inquiryAlertsModal" class="modal fade" tabindex="-1" aria-labelledby="inquiryAlertsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="inquiryAlertsModalLabel">Notifications</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body" id="inquiryAlertsBody">
                <div class="row">
                    <div class="col-4">
                        <div id="inquiryAlertsList" class="scrollable-list">

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
</div>