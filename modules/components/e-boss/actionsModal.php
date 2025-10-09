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

                    <!-- Current ETA Info Section -->
                    <div class="mb-3" id="currentEtaInfo">
                        <!-- Dynamically populated by JavaScript -->
                    </div>

                    <div class="mb-3">
                        <label for="etaDate" class="form-label">
                            <i class="fas fa-calendar-alt"></i> New ETA Date
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="date"
                                class="form-control"
                                id="etaDate"
                                name="new_eta"
                                required
                                min=""
                                max="">
                            <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="document.getElementById('etaDate').value = ''">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            Select a date between today and 90 days from now
                        </div>
                    </div>

                    <!-- Progressive Enhancement - Additional Info -->
                    <div class="mb-3">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 0%;"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="90"
                                id="etaDaysProgress">
                            </div>
                        </div>
                        <small class="text-muted" id="etaDaysInfo">
                            Selected: 0 days from today (Max: 90 days)
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="etaSubmitBtn">
                            <i class="fas fa-save"></i> Update ETA
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add this script after your modal -->
<script>
    document.getElementById('etaDate').addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        const diffTime = Math.abs(selectedDate - today);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        // Update progress bar
        const percentage = Math.min((diffDays / 90) * 100, 100);
        document.getElementById('etaDaysProgress').style.width = percentage + '%';
        document.getElementById('etaDaysProgress').setAttribute('aria-valuenow', diffDays);

        // Update days info text
        document.getElementById('etaDaysInfo').textContent =
            `Selected: ${diffDays} days from today (Max: 90 days)`;
    });

    // Set min date to today and max date to 90 days from now
    const today = new Date();
    const maxDate = new Date();
    maxDate.setDate(today.getDate() + 90);

    document.getElementById('etaDate').min = today.toISOString().split('T')[0];
    document.getElementById('etaDate').max = maxDate.toISOString().split('T')[0];
</script>

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