<div class="modal fade" id="viewRequestModal" tabindex="-1" aria-labelledby="viewRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered moda-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="viewRequestModalLabel">Request</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-xl-4">
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <h5>Requested By:</h5>
                        </div>
                        <div class="row d-flex align-items-center ml-1">
                            <img id="requestedByPicture" src="" class="rounded-circle" style="aspect-ratio: 1/1; padding:0 !important; object-fit: cover; width: 50px !important;">
                            <p id="requestedBy" class="w-auto" style="margin: 0 !important;">Superadmin</p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <h5>Asset Number:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="faNumber" class="w-auto" style="margin: 0 !important;">TMRMIS00-0000</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Item Category:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="itemCategory" class="w-auto" style="margin: 0 !important;">NONE</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Computer Name:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="computerName" class="w-auto" style="margin: 0 !important;">TMR-MIS1</p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <h5>Request:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="requestType" class="w-auto" style="margin: 0 !important;">NONE</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Reason for request:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="requestReason" class="w-auto" style="margin: 0 !important;">NO REASON</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 justify-content-end" style="gap: 8px;">
                    <input type="hidden" name="requestSql" id="requestSql">
                    <button type="button" class="btn btn-sm shadow-sm btn-danger w-auto" id="declineRequestBtn"><i class="fas fa-xmark"></i> Decline</button>
                    <button type="button" class="btn btn-sm shadow-sm btn-primary w-auto" id="acceptRequestBtn"><i class="fas fa-check"></i> Accept</button>
                </div>
            </div>
        </div>
    </div>
</div>