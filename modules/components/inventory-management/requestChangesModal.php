<div id="requestChangesModal" class="modal fade" tabindex="-1" aria-labelledby="requestChangesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h6 class="modal-title" id="requestChangesModalLabel">Request Changes | Asset #: <span id="assetNumber_request"></span></h6>
                <div class="header-actions d-flex align-items-center" style="gap: 8px;">
                    <button type="button" class="btn btn-circle shadow-sm btn-light text-primary" id="viewRequestHistoryBtn" role="button" data-bs-placement="bottom" title="Requests History" data-bs-target="#viewRequestHistoryModal" data-bs-toggle="tooltip"><i class="fa-solid fa-rectangle-history"></i></button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body custom-scrollable-body p-xl-3 d-flex flex-column align-items-center" style="gap: 8px;">
                <div class="row">
                    <button type="button" class="btn btn-warning shadow-sm" id="editFABtn" data-bs-toggle="modal" data-bs-target="#editFAModal" style="width: fit-content;"><i class="fas fa-money-check-pen"></i> Edit FA Number</button>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-danger shadow-sm" id="absoluteDeleteBtn" data-bs-toggle="modal" data-bs-target="#absoluteDeleteModal" style="width: fit-content;"><i class="fas fa-trash-can-list"></i> Absolute Deletion</button>
                </div>
                <div class="row d-none" id="retiredActionsRow2">
                    <button type="button" class="btn btn-info shadow-sm" id="unretireBtn" data-bs-toggle="modal" data-bs-target="#unretireModal" style="width: fit-content;"><i class="fas fa-clock-rotate-left"></i> Unretire</button>
                </div>
            </div>
        </div>
    </div>
</div>