<div class="modal fade" id="editGroupDetailsModal" tabindex="-1" aria-labelledby="editGroupDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="editGroupDetailsModalLabel">Edit Group Details</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body">
                <form id="editGroupDetailsForm" class="container needs-validation" novalidate autocomplete="off">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="groupName_edit" class="col-form-label">Group Initials</label>
                                <input type="text" name="groupName" id="groupName_edit" class="form-control form-control-sm" minlength="3" maxlength="3" required>
                                <div class="invalid-feedback">
                                    Please input a valid Group Initials.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="groupNumber_edit" class="col-form-label">Group Number</label>
                                <input type="number" name="groupNumber" id="groupNumber_edit" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">
                                    Please input a valid Group Number.
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="groupId" id="groupId_edit">
                    <div class="row mt-2">
                        <div class="col">
                            <div class="d-flex justify-content-end actions-group">
                                <button class="btn btn-sm shadow-sm btn-primary" type="submit"><i class="fas fa-floppy-disk"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>