<div class="modal fade" id="viewRequestModal" tabindex="-1" aria-labelledby="viewRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered moda-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="viewRequestModalLabel">Request</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body p-xl-4">
                <div class="col">
                    <div class="row mb-3">
                        <h5>Requested By:</h5>
                        <div class="col d-flex align-items-center ml-1 gap-2">
                            <img id="requestedByPicture" src="" class="rounded-circle" style="aspect-ratio: 1/1; padding:0 !important; object-fit: cover; width: 50px !important;">
                            <p id="requestedBy" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>

                </div>
                <table class="table table-bordered table-striped m-0">
                    <tbody>
                        <tr>
                            <th class="bg-light w-40">Asset Number</th>
                            <td><span id="faNumber"></span></td>
                        </tr>
                        <tr>
                            <th class="bg-light w-40">Item Category</th>
                            <td><span id="viewItemCategory"></span></td>
                        </tr>
                        <tr>
                            <th class="bg-light w-40">Computer Name</th>
                            <td><span id="viewComputerName"></span></td>
                        </tr>
                        <tr>
                            <th class="bg-light w-40">Request</th>
                            <td><span id="requestType"></span></td>
                        </tr>
                        <tr>
                            <th class="bg-light w-40">Reason for Request</th>
                            <td><span id="requestReason"></span></td>
                        </tr>
                        <tr id="newFaNumberColumn" class="d-none">
                            <th class="bg-light w-40">Requested FA Number</th>
                            <td><span id="newFaNumber"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-end" style="gap: 8px;">
                    <button type="button" class="btn btn-sm shadow-sm btn-danger w-auto" id="declineRequestBtn"><i class="fas fa-xmark"></i> Decline</button>
                    <button type="button" class="btn btn-sm shadow-sm btn-primary w-auto" id="acceptRequestBtn"><i class="fas fa-check"></i> Accept</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewRequestModalNotif" tabindex="-1" aria-labelledby="viewRequestModalNotifLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered moda-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="viewRequestModalNotifLabel">Request</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body p-xl-4">
                <div class="col">
                    <div class="row mb-3">
                        <h5>Requested By:</h5>
                        <div class="col d-flex align-items-center ml-1 gap-2">
                            <img id="requestedByPicture_N" src="" class="rounded-circle" style="aspect-ratio: 1/1; padding:0 !important; object-fit: cover; width: 50px !important;">
                            <p id="requestedBy_N" class="w-auto" style="margin: 0 !important;"></p>
                        </div>
                    </div>

                </div>
                <table class="table table-bordered table-striped m-0">
                    <tbody>
                        <tr>
                            <th class="bg-light w-40">Asset Number</th>
                            <td><span id="faNumber_N"></span></td>
                        </tr>
                        <tr>
                            <th class="bg-light w-40">Item Category</th>
                            <td><span id="viewItemCategory_N"></span></td>
                        </tr>
                        <tr>
                            <th class="bg-light w-40">Computer Name</th>
                            <td><span id="viewComputerName_N"></span></td>
                        </tr>
                        <tr>
                            <th class="bg-light w-40">Request</th>
                            <td><span id="requestType_N"></span></td>
                        </tr>
                        <tr>
                            <th class="bg-light w-40">Reason for Request</th>
                            <td><span id="requestReason_N"></span></td>
                        </tr>
                        <tr id="newFaNumberColumn_N" class="d-none">
                            <th class="bg-light w-40">Requested FA Number</th>
                            <td><span id="newFaNumber_N"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-end" style="gap: 8px;" id="requestAction_N">
                    <button type="button" class="btn btn-sm shadow-sm btn-danger w-auto" id="declineRequestBtn_N"><i class="fas fa-xmark"></i> Decline</button>
                    <button type="button" class="btn btn-sm shadow-sm btn-primary w-auto" id="acceptRequestBtn_N"><i class="fas fa-check"></i> Accept</button>
                </div>
            </div>
        </div>
    </div>
</div>