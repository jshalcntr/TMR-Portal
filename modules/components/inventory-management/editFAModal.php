<div id="editFAModal" class="modal fade" tabindex="-1" aria-labelledby="editFAModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content px-3">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="editFAModalLabel">Edit FA Number</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFAForm" class="modal-body custom-scrollable-body p-xl-3" style="gap: 8px;" autocomplete="off" novalidate>
                <div class="row form-group">
                    <label for="newFA">Desired FA Number:</label>
                    <input type="text" id="newFA" name="newFA" class="form-control form-control-sm" required>
                    <div class="invalid-feedback">Please enter a valid FA Number</div>
                </div>
                <div class="row form-group">
                    <label for="newFAReason">Reason for Changing:</label>
                    <textarea type="text" id="newFAReason" name="newFAReason" class="form-control form-control-sm" required></textarea>
                    <div class="invalid-feedback">Please enter a reason for changing the FA Number</div>
                </div>
                <div class="row form-group justify-content-end">
                    <button type="submit" class="btn btn-sm shadow-sm btn-primary w-auto align-self-end"><i class="fa-solid fa-paper-plane-top"></i> Send Request</button>
                </div>
            </form>
        </div>
    </div>
</div>