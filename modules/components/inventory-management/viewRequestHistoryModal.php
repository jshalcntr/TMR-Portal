<div id="viewRequestHistoryModal" class="modal fade" tabindex="-1" aria-labelledby="viewRequestHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="viewRequestHistoryModalLabel">Request History | Asset #: <span id="assetNumber_request"></span></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-xl-3 d-flex flex-column align-items-center" style="gap: 8px;">
                <div class="d-flex justify-content-between align-items-center px-4">
                    <h3>Request History</h3>
                </div>
                <div class="table-responsive">
                    <table class="table" id="requestHistoryTable">
                        <thead>
                            <tr>
                                <th scope="col">Request</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Date & Time</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>