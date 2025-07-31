<div class="modal fade" id="addToGroupModal" tabindex="-1" aria-labelledby="addToGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="addToGroupModalLabel">Add to Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body">
                <form id="addToGroupForm" class="container needs-validation" novalidate>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="member" class="form-label">Team Member</label>
                            <select name="member" id="member" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Team Member--</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Team Member.
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="group" class="form-label">Group</label>
                            <select name="group" id="group" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Group--</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Group.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add to Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>