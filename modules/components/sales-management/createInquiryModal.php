<div class="modal fade" id="createInquiryModal" tabindex="-1" aria-labelledby="createInquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <form id="createInquiryForm" class="needs-validation w-100" novalidate>
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="createInquiryModalLabel">Create Inquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-scrollable-body">
                    <div class="form-step" data-step="1">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Prospect Type</h3>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 prospectRadioGroup">
                            <input type="radio" name="prospectType" id="prospectType_hot" value="Hot">
                            <label for="prospectType_hot" class="mb-0 flex-grow-1">HOT (WITHNIN 1 WEEK TO 2 MONTHS)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 prospectRadioGroup">
                            <input type="radio" name="prospectType" id="prospectType_warm" value="Warm">
                            <label for="prospectType_warm" class="mb-0 flex-grow-1">WARM (WITHNIN 2 TO 5 MONTHS)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 prospectRadioGroup">
                            <input type="radio" name="prospectType" id="prospectType_cold" value="Cold">
                            <label for="prospectType_cold" class="mb-0 flex-grow-1">COLD (6 MONTHS AND ABOVE)</label>
                        </div>
                        <div class="invalid-feedback">
                            Please select a prospect type before continuing.
                        </div>
                    </div>
                    <div class="form-step d-none" data-step="2">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Customer Name</h3>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <label for="customerFirstName">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="customerFirstName" id="customerFirstName" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please provide a valid first name.</div>
                            </div>
                            <div class="col form-group">
                                <label for="customerMiddleName">Middle Name</label>
                                <input type="text" name="customerMiddleName" id="customerMiddleName" class="form-control form-control-sm">
                            </div>
                            <div class="col form-group">
                                <label for="customerLastName">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="customerLastName" id="customerLastName" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please provide a valid last name.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step d-none" data-step="3">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Date of Inquiry</h3>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <label for="inquiryDate">Date of Inquiry</label>
                                <input type="date" name="inquiryDate" id="inquiryDate" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please provide a valid inquiry date.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step d-none" data-step="4">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Source of Inquiry</h3>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceRadioGroup">
                            <input type="radio" name="inquirySource" id="inquirySource_f2f" value="Face To Face">
                            <label for="inquirySource_f2f" class="mb-0 flex-grow-1">Face To Face</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceRadioGroup">
                            <input type="radio" name="inquirySource" id="inquirySource_online" value="Online">
                            <label for="inquirySource_online" class="mb-0 flex-grow-1">Online</label>
                        </div>
                        <div class="" id="f2fSource">
                            <div class="row justify-content-center align-items-center">
                                <h3 class="text-center">Face To Face Inquiry Source</h3>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_showroom" value="Showroom Walk-In">
                                <label for="inquirySourceType_showroom" class="mb-0 flex-grow-1">Showroom Walk-In</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_mall" value="Mall Display">
                                <label for="inquirySourceType_mall" class="mb-0 flex-grow-1">Mall Display</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_saturation" value="Saturation">
                                <label for="inquirySourceType_saturation" class="mb-0 flex-grow-1">Saturation</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_bankDisplay" value="Bank Display">
                                <label for="inquirySourceType_bankDisplay" class="mb-0 flex-grow-1">Bank Display</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_repeat" value="Repeat">
                                <label for="inquirySourceType_repeat" class="mb-0 flex-grow-1">Repeat</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_referral" value="Referral">
                                <label for="inquirySourceType_referral" class="mb-0 flex-grow-1">Referral</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_phone" value="Phone-In">
                                <label for="inquirySourceType_phone" class="mb-0 flex-grow-1">Phone-In</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_attackList" value="Attack List (UIO)">
                                <label for="inquirySourceType_attackList" class="mb-0 flex-grow-1">Attack List (UIO)</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_goyokiki" value="Goyokiki">
                                <label for="inquirySourceType_goyokiki" class="mb-0 flex-grow-1">Goyokiki</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-2 d-flex gap-2 inquirySourceTypeRadioGroup">
                                <input type="radio" name="inquirySourceType" id="inquirySourceType_hansaClient" value="Client From Service/Parts/Insurance">
                                <label for="inquirySourceType_hansaClient" class="mb-0 flex-grow-1">Client From Service/Parts/Insurance</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" id="previousBtn"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-sm btn-primary" id="nextBtn">Next <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>