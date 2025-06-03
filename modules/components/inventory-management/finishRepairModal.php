<div class="modal fade" id="finishRepairModal" tabindex="-1" aria-labelledby="finishRepairModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="finishRepairModalLabel">Finish Repair</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body p-lg-4">
                <form class="container" id="finishRepairForm" autocomplete="off">
                    <div class="form-group mb-3">
                        <label for="date_repaired">Date Repaired</label>
                        <input type="date" id="date_repaired" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="repair_remarks">Remarks</label>
                        <textarea id="repair_remarks" class="form-control form-control-sm" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end action-column">
                        <button type="button" class="btn btn-sm shadow-sm btn-danger" data-bs-dismiss="modal"><i class="fas fa-xmark"></i> Close</button>
                        <button type="submit" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-check"></i> Finish</button>
                    </div>
            </div>
            <input type="hidden" name="repairId" id="repairId_finish">
            </form>
        </div>
    </div>
</div>