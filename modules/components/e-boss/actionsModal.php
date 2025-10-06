<!-- Update ETA Modal -->
<div class="modal fade" id="updateEtaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-calendar-plus"></i> <span id="etaModalTitle">Update ETA</span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="updateEtaForm">
                    <input type="hidden" id="etaRecordId" name="backorder_id">
                    <input type="hidden" id="etaType" name="eta_type">
                    <input type="hidden" id="confirmExtension" name="confirm_extension" value="false">

                    <div class="mb-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>ETA Extension</strong><br>
                            This will add 15 days to the current ETA. You can modify the date if needed.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="etaDate" class="form-label">New ETA Date</label>
                        <input type="date" class="form-control" id="etaDate" name="new_eta" required>
                        <div class="form-text">15 days will be added to the current ETA. You can modify this date.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="etaSubmitBtn">Update ETA</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Backorder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editFormContainer">
                <!-- AJAX-loaded edit form goes here -->
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Backorder Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewDetailsContainer">
                <!-- AJAX-loaded view goes here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
                <button type="button" class="btn btn-primary" id="printViewBtn" style="display: none;">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>