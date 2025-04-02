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
                            <p id="requestedBy" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <h5>Asset Number:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="faNumber" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Item Category:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="viewItemCategory" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Computer Name:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="viewComputerName" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <h5>Request:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="requestType" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                    <div id="newFaNumberColumn" class="col d-none">
                        <div class="row">
                            <h5>Requested FA Number:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="newFaNumber" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Reason for request:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="requestReason" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 justify-content-end" style="gap: 8px;">
                    <button type="button" class="btn btn-sm shadow-sm btn-danger w-auto" id="declineRequestBtn"><i class="fas fa-xmark"></i> Decline</button>
                    <button type="button" class="btn btn-sm shadow-sm btn-primary w-auto" id="acceptRequestBtn"><i class="fas fa-check"></i> Accept</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewRequestModalNotif" tabindex="-1" aria-labelledby="viewRequestModalNotifLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered moda-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="viewRequestModalNotifLabel">Request</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-xl-4">
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <h5>Requested By:</h5>
                        </div>
                        <div class="row d-flex align-items-center ml-1">
                            <img id="requestedByPicture_N" src="" class="rounded-circle" style="aspect-ratio: 1/1; padding:0 !important; object-fit: cover; width: 50px !important;">
                            <p id="requestedBy_N" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <h5>Asset Number:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="faNumber_N" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Item Category:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="viewItemCategory_N" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Computer Name:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="viewComputerName_N" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <h5>Request:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="requestType_N" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                    <div id="newFaNumberColumn_N" class="col d-none">
                        <div class="row">
                            <h5>Requested FA Number:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="newFaNumber_N" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>Reason for request:</h5>
                        </div>
                        <div class="row ml-1">
                            <p id="requestReason_N" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 justify-content-end" style="gap: 8px;" id="requestAction_N">
                    <button type="button" class="btn btn-sm shadow-sm btn-danger w-auto" id="declineRequestBtn_N"><i class="fas fa-xmark"></i> Decline</button>
                    <button type="button" class="btn btn-sm shadow-sm btn-primary w-auto" id="acceptRequestBtn_N"><i class="fas fa-check"></i> Accept</button>
                </div>
            </div>
        </div>
    </div>
</div>