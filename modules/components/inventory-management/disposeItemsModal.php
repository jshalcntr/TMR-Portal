<div class="modal fade" id="disposeItemsModal" tabindex="-1" aria-labelledby="disposeItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center px-4">
                <h3 class="modal-title" id="disposeItemsModalLabel">Dispose Items</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-scrollable-body">
                <form class="container" id="disposeItemsForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <h3 class="h3">Disposal Form: </h3>
                            </div>
                            <div class="file-upload-contain row">
                                <label for="disposalFormFile" id="dragZone" class="custom-upload-dropzone d-flex align-items-center justify-content-center flex-column p-xl-5">
                                    <i class="fas fa-cloud-arrow-up fa-3x" id="droppingLogo"></i>
                                    <p class="h2">Drag and Drop File Here</p>
                                </label>
                                <input type="file" id="disposalFormFile" name="disposalFormFile" accept=".pdf" class="d-none">
                                <div id="filePreview" class="d-none align-items-center justify-content-center p-xl-5">
                                    <i class="fas fa-file-pdf fa-2x text-info mr-1"></i>
                                    <p class="h5 mb-0" id="fileName">No File Selected</p>
                                    <i class="fas fa-trash text-danger" id="removeFileBtn"></i>
                                </div>
                                <div class="d-none justify-content-end align-items-end" id="actionGroup">
                                    <button type="submit" class="btn-sm shadow-sm btn btn-primary"><i class="fas fa-trash-can-list"></i> Dispose Items</button>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-3 table-responsive">
                            <table class="table small" id="disposableItemsTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Asset No.</th>
                                        <th>Item Type</th>
                                        <th>User</th>
                                        <th>Department</th>
                                    </tr>
                                </thead>
                            </table>
                            <input type="hidden" name="disposableItemIds" id="disposableItemIds" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>