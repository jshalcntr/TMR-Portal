<div class="modal fade" id="moveMemberModal" tabindex="-1" aria-labelledby="moveMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="moveMemberModalLabel">Move Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="moveMemberForm" class="container needs-validation" novalidate>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="member_move" class="form-label">Team Member</label>
                            <input type="text" name="member" id="member_move" class="form-control form-control-sm" required disabled></input>
                            <div class="invalid-feedback">
                                Please select a Team Member.
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="group_move" class="form-label">Group</label>
                            <select name="group" id="group_move" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Group--</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Group.
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="accountId" id="accountId_move">
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-up-down-left-right"></i> Move Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>