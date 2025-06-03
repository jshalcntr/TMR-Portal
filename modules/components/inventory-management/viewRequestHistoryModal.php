<div id="viewRequestHistoryModal" class="modal fade" tabindex="-1" aria-labelledby="viewRequestHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="viewRequestHistoryModalLabel">Request History</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body" style="gap: 8px;">
                <div class="table-responsive mb-3">
                    <table class="table table-bordered" id="requestHistoryTable" style="width:100%">
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