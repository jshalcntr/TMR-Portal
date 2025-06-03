<div class="modal fade" id="exportInventoryModal" tabindex="-1" aria-labelledby="exportInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="exportInventoryModalLabel">Export File</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body p-lg-3">
                <form class="container" id="exportInventoryForm" method="POST" action="../../backend/inventory-management/exportInventory.php" autocomplete="off">
                    <div class="row">
                        <div class="col">
                            <h3 class="h5">Choose Asset Type</h3>
                            <div class="form-check mb-1">
                                <input type="radio" name="assetType_export" id="assetType_All" class="form-check-input" value="all" checked>
                                <label for="assetType_All" class="form-check-label">All Assets</label>
                            </div>
                            <div class="form-check mb-1">
                                <input type="radio" name="assetType_export" id="assetType_FA" class="form-check-input" value="fa">
                                <label for="assetType_FA" class="form-check-label">Fixed Assets Only</label>
                            </div>
                            <div class="form-check mb-1">
                                <input type="radio" name="assetType_export" id="assetType_nonFA" class="form-check-input" value="nonFa">
                                <label for="assetType_nonFA" class="form-check-label">Non-Fixed Assets Only</label>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col">
                            <label class="h5" for="itemType_export">Choose Item Type</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check mb-1 d-flex align-items-center">
                                <input type="checkbox" name="itemType_export[]" id="all_itemType" class="form-check-input" value="all">
                                <label for="all_itemType" class="form-check-label">Select All</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-1 d-flex align-items-center">
                                <input type="checkbox" name="itemType_export[]" id="comSystem_itemType" class="form-check-input item-checkbox" value="Computer System">
                                <label for="comSystem_itemType" class="form-check-label">Computer System</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-1 d-flex align-items-center">
                                <input type="checkbox" name="itemType_export[]" id="comHardware_itemType" class="form-check-input item-checkbox" value="Computer Hardware">
                                <label for="comHardware_itemType" class="form-check-label">Computer Hardware</label>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="form-check mb-1 d-flex align-items-center">
                                <input type="checkbox" name="itemType_export[]" id="comPeripherals_itemType" class="form-check-input item-checkbox" value="Computer Peripherals">
                                <label for="comPeripherals_itemType" class="form-check-label">Computer Peripherals</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-1 d-flex align-items-center">
                                <input type="checkbox" name="itemType_export[]" id="networkPeripherals_itemType" class="form-check-input item-checkbox" value="Network Peripherals">
                                <label for="networkPeripherals_itemType" class="form-check-label">Network Peripherals</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-1 d-flex align-items-center">
                                <input type="checkbox" name="itemType_export[]" id="avDevices_itemType" class="form-check-input item-checkbox" value="Audio & Visual Devices">
                                <label for="avDevices_itemType" class="form-check-label">Audio & Visual Devices</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-1 d-flex align-items-center">
                                <input type="checkbox" name="itemType_export[]" id="misTools_itemType" class="form-check-input item-checkbox" value="MIS Tools">
                                <label for="misTools_itemType" class="form-check-label">MIS Tools</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="h5" for="status_export">Choose Status</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check mb-1">
                                <input type="checkbox" name="all_status" id="all_status" class="form-check-input" value="all">
                                <label for="all_status" class="form-check-label">Select All</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-1">
                                <input type="checkbox" name="status_export[]" id="active_status" class="form-check-input status-checkbox" value="Active">
                                <label for="active_status" class="form-check-label">Active</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-1">
                                <input type="checkbox" name="status_export[]" id="repaired_status" class="form-check-input status-checkbox" value="Repaired">
                                <label for="repaired_status" class="form-check-label">Repaired</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check mb-1">
                                <input type="checkbox" name="status_export[]" id="under_repair_status" class="form-check-input status-checkbox" value="Under Repair">
                                <label for="under_repair_status" class="form-check-label">Under Repair</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb1">
                                <input type="checkbox" name="status_export[]" id="retired_status" class="form-check-input status-checkbox" value="Retired">
                                <label for="retired_status" class="form-check-label">Retired</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb1">
                                <input type="checkbox" name="status_export[]" id="disposed_status" class="form-check-input status-checkbox" value="Disposed">
                                <label for="disposed_status" class="form-check-label">Disposed</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="h5">Choose Date</label>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dateFrom" class="col-form-label">Acquired From</label>
                                <input type="date" name="dateFrom" id="dateFrom" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dateTo" class="col-form-label">Aquired To</label>
                                <input type="date" name="dateTo" id="dateTo" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check mb-1">
                                <input type="checkbox" name="exportAllDate" id="exportAllDate" class="form-check-input" value="1">
                                <label for="exportAllDate" class="form-check-label">Disregard Date Acquired</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm shadow-sm btn-lg btn-primary">
                                <i class="fas fa-download"></i> Export Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>