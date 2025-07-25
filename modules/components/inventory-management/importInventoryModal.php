<div class="modal fade" id="importInventoryModal" tabindex="-1" aria-labelledby="importInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="importInventoryModalLabel">Import File</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body p-lg-3">
                <form class="container" id="importInventoryForm" enctype="multipart/form-data" autocomplete="off">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="file-upload-contain">
                                <label for="importFile" id="dragZone" class="custom-upload-dropzone d-flex align-items-center justify-content-center flex-column p-xl-5">
                                    <i class="fas fa-cloud-arrow-up fa-3x" id="droppingLogo"></i>
                                    <p class="h2">Drag and Drop File Here</p>
                                </label>
                                <input type="file" id="importFile" name="importFile" accept=".csv, .xls, .xlsx" class="d-none">
                                <div id="filePreview" class="d-none align-items-center justify-content-center p-xl-5">
                                    <i class="fas fa-table fa-2x text-info mr-1"></i>
                                    <p class="h5 mb-0" id="fileName">No File Selected</p>
                                    <i class="fas fa-trash text-danger" id="removeFileBtn"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="actionGroup">
                        <div class="col d-flex justify-content-end align-items-end">
                            <button type="submit" class="btn-sm shadow-sm btn btn-primary"><i class="fas fa-floppy-disk"></i> Import</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>