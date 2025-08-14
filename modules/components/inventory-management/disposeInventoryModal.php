<div class="modal fade" id="disposeInventoryModal" tabindex="-1" aria-labelledby="disposeInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <form id="addToDisposalForm" autocomplete="off">
                <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                    <h3 class="modal-title" id="disposeInventoryModalLabel">Add to Disposal</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-scrollable-body p-lg-4">
                    <div class="form-group mb-3">
                        <label for="repair_remarks">Remarks</label>
                        <textarea id="repair_remarks" class="form-control form-control-sm" name="remarks"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end action-column">
                        <button type="button" class="btn btn-sm shadow-sm btn-danger" data-bs-dismiss="modal"><i class="fas fa-xmark"></i> Close</button>
                        <button type="submit" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-trash-plus"></i> Add To Disposal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>