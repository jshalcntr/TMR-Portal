<div id="unretireModal" class="modal fade" tabindex="-1" aria-labelledby="unretireModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content px-3">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="unretireModalLabel">Request to Unretire</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="unretireForm" class="modal-body p-xl-3" style="gap: 8px;" autocomplete="off" novalidate>
                <div class="row form-group">
                    <label for="unretireReason">Reason for Unretire:</label>
                    <textarea type="text" id="unretireReason" name="unretireReason" class="form-control form-control-sm" required></textarea>
                    <div class="invalid-feedback">Please enter a reason for unretiring the item</div>
                </div>
                <div class="row form-group justify-content-end">
                    <button type="submit" class="btn btn-sm shadow-sm btn-primary w-auto align-self-end"><i class="fa-solid fa-paper-plane-top"></i> Send Request</button>
                </div>
            </form>
        </div>
    </div>
</div>