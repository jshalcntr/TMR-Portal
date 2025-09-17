<div class="modal fade" id="createInquiryModal" tabindex="-1" aria-labelledby="createInquiryModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <form id="createInquiryForm" class="needs-validation w-100" novalidate autocomplete="off">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="createInquiryModalLabel">Create Inquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-scrollable-body">
                    <div class="form-step" data-step="1">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Prospect Type <span class="text-danger">*</span> </h3>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 prospectRadioGroup">
                            <input type="radio" name="prospectType" id="prospectType_hot" value="HOT">
                            <label for="prospectType_hot" class="mb-0 flex-grow-1">HOT (WITHIN 1 WEEK TO 2 MONTHS)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 prospectRadioGroup">
                            <input type="radio" name="prospectType" id="prospectType_warm" value="WARM">
                            <label for="prospectType_warm" class="mb-0 flex-grow-1">WARM (WITHIN 2 TO 5 MONTHS)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 prospectRadioGroup">
                            <input type="radio" name="prospectType" id="prospectType_cold" value="COLD">
                            <label for="prospectType_cold" class="mb-0 flex-grow-1">COLD (6 MONTHS AND ABOVE)</label>
                        </div>
                        <div class="invalid-feedback">
                            Please select a Prospect Type.
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
                                <div class="invalid-feedback">Please provide a valid First Name.</div>
                            </div>
                            <div class="col form-group">
                                <label for="customerMiddleName">Middle Name</label>
                                <input type="text" name="customerMiddleName" id="customerMiddleName" class="form-control form-control-sm">
                            </div>
                            <div class="col form-group">
                                <label for="customerLastName">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="customerLastName" id="customerLastName" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please provide a valid Last Name.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step d-none" data-step="3">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Date of Inquiry <span class="text-danger">*</span></h3>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <input type="date" name="inquiryDate" id="inquiryDate" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please provide a valid Inquiry Date.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step d-none" data-step="4">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Source of Inquiry <span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex form-group gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceRadioGroup">
                                <input type="radio" name="inquirySource" id="inquirySource_f2f" value="FACE TO FACE">
                                <label for="inquirySource_f2f" class="mb-0 flex-grow-1">FACE TO FACE</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceRadioGroup">
                                <input type="radio" name="inquirySource" id="inquirySource_online" value="ONLINE">
                                <label for="inquirySource_online" class="mb-0 flex-grow-1">ONLINE</label>
                            </div>
                            <div class="invalid-feedback">Please select an Inquiry Source.</div>
                        </div>
                        <div class="form-group">
                            <div class="d-none gap-2" id="f2fSource">
                                <div class="row justify-content-center align-items-center">
                                    <h3 class="text-center">Face To Face Inquiry Source <span class="text-danger">*</span></h3>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_showroom" value="SHOWROOM WALK-IN">
                                        <label for="inquirySourceType_showroom" class="mb-0 flex-grow-1">SHOWROOM WALK-IN</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_mall" value="MALL DISPLAY">
                                        <label for="inquirySourceType_mall" class="mb-0 flex-grow-1">MALL DISPLAY</label>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_saturation" value="SATURATION">
                                        <label for="inquirySourceType_saturation" class="mb-0 flex-grow-1">SATURATION</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_bankDisplay" value="BANK DISPLAY">
                                        <label for="inquirySourceType_bankDisplay" class="mb-0 flex-grow-1">BANK DISPLAY</label>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_repeat" value="REPEAT">
                                        <label for="inquirySourceType_repeat" class="mb-0 flex-grow-1">REPEAT</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_referral" value="REFERRAL">
                                        <label for="inquirySourceType_referral" class="mb-0 flex-grow-1">REFERRAL</label>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_phone" value="PHONE-IN">
                                        <label for="inquirySourceType_phone" class="mb-0 flex-grow-1">PHONE-IN</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_attackList" value="ATTACK LIST (UIO)">
                                        <label for="inquirySourceType_attackList" class="mb-0 flex-grow-1">ATTACK LIST (UIO)</label>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_goyokiki" value="GOYOKIKI">
                                        <label for="inquirySourceType_goyokiki" class="mb-0 flex-grow-1">GOYOKIKI</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_hansaClient" value="CLIENT FROM SERVICE/PARTS/INSURANCE">
                                        <label for="inquirySourceType_hansaClient" class="mb-0 flex-grow-1">CLIENT FROM SERVICE/PARTS/INSURANCE</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none" id="onlineSource">
                                <div class="row justify-content-center align-items-center">
                                    <h3 class="text-center">Online Inquiry Source <span class="text-danger">*</span></h3>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_tmrFb" value="TMR FB PAGE (TOYOTA MARILAO BULACAN INC.)">
                                        <label for="inquirySourceType_tmrFb" class="mb-0 flex-grow-1">TMR FB PAGE (TOYOTA MARILAO BULACAN INC.)</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_mpFb" value="MP FB PAGE (MP-TOYOTA MARILAO)">
                                        <label for="inquirySourceType_mpFb" class="mb-0 flex-grow-1">MP FB PAGE (MP-TOYOTA MARILAO)</label>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_grmFb" value="GROUP FB PAGE (GRM-TOYOTA MARILAO)">
                                        <label for="inquirySourceType_grmFb" class="mb-0 flex-grow-1">GROUP FB PAGE (GRM-TOYOTA MARILAO)</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_personalFb" value="PERSONAL FACEBOOK">
                                        <label for="inquirySourceType_personalFb" class="mb-0 flex-grow-1">PERSONAL FACEBOOK</label>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_tiktok" value="TIKTOK">
                                        <label for="inquirySourceType_tiktok" class="mb-0 flex-grow-1">TIKTOK</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_instagram" value="INSTAGRAM">
                                        <label for="inquirySourceType_instagram" class="mb-0 flex-grow-1">INSTAGRAM</label>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_youtube" value="YOUTUBE">
                                        <label for="inquirySourceType_youtube" class="mb-0 flex-grow-1">YOUTUBE</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 inquirySourceTypeRadioGroup">
                                        <input type="radio" name="inquirySourceType" id="inquirySourceType_philGeps" value="PHILGEPS">
                                        <label for="inquirySourceType_philGeps" class="mb-0 flex-grow-1">PHILGEPS</label>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please select an Inquiry Source.</div>
                        </div>
                        <div class="d-none" id="mallDisplayGroup">
                            <div class="row justify-content-center align-items-center">
                                <label class="h3 text-center" for="mallDisplay">Mall Display <span class="text-danger">*</span></label>
                            </div>
                            <div class="col form-group">
                                <select name="mallDisplay" id="mallDisplay" class="form-select form-select-sm">

                                </select>
                                <div class="invalid-feedback">Please select a Mall Display</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="5">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Client Address</h3>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-4 form-group">
                                <label for="province" class="mb-0 flex-grow-1">Province <span class="text-danger">*</span></label>
                                <select name="province" id="province" class="form-select form-select-sm" required></select>
                                <div class="invalid-feedback">Please select a Province.</div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="municipality" class="mb-0 flex-grow-1">Municipality <span class="text-danger">*</span></label>
                                <select name="municipality" id="municipality" class="form-select form-select-sm" disabled required></select>
                                <div class="invalid-feedback">Please select a Municipality.</div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="barangay" class="mb-0 flex-grow-1">Barangay <span class="text-danger">*</span></label>
                                <select name="barangay" id="barangay" class="form-select form-select-sm" disabled required></select>
                                <div class="invalid-feedback">Please select a Barangay.</div>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center px-2">
                            <label for="street" class="mb-0 flex-grow-1">Street Address</label>
                            <input type="text" name="street" id="street" class="form-control form-control-sm">
                            </input>
                        </div>
                    </div>
                    <div class="form-step" data-step="6">
                        <div class="row justify-content-center align-items-center">
                            <label for="contactNumber" class="h3 text-center">Client Contact Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <input
                                    type="tel"
                                    name="contactNumber"
                                    id="contactNumber"
                                    class="form-control form-control-sm"
                                    required
                                    pattern="^(09\d{9}|\+639\d{9})$"
                                    placeholder="Enter a valid Philippine mobile number (e.g., 09XXXXXXXXX or +639XXXXXXXXX)">
                                <div class="invalid-feedback">Please provide a valid Contact Number.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="7">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Client Gender <span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex form-group gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 genderRadioGroup">
                                <input type="radio" name="gender" id="gender_male" value="MALE">
                                <label for="gender_male" class="mb-0 flex-grow-1">MALE</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 genderRadioGroup">
                                <input type="radio" name="gender" id="gender_female" value="FEMALE">
                                <label for="gender_female" class="mb-0 flex-grow-1">FEMALE</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 genderRadioGroup">
                                <input type="radio" name="gender" id="gender_lgbt" value="LGBTQ+">
                                <label for="gender_lgbt" class="mb-0 flex-grow-1">LGBTQ+</label>
                            </div>
                            <div class="invalid-feedback">Please select a Gender.</div>
                        </div>
                    </div>
                    <div class="form-step" data-step="8">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Marital Status <span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 maritalStatusRadioGroup">
                                <input type="radio" name="maritalStatus" id="maritalStatus_single" value="SINGLE">
                                <label for="maritalStatus_single" class="mb-0 flex-grow-1">SINGLE</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 maritalStatusRadioGroup">
                                <input type="radio" name="maritalStatus" id="maritalStatus_married" value="MARRIED">
                                <label for="maritalStatus_married" class="mb-0 flex-grow-1">MARRIED</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 maritalStatusRadioGroup">
                                <input type="radio" name="maritalStatus" id="maritalStatus_divorced" value="DIVORCED">
                                <label for="maritalStatus_divorced" class="mb-0 flex-grow-1">DIVORCED</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 maritalStatusRadioGroup">
                                <input type="radio" name="maritalStatus" id="maritalStatus_separated" value="SEPARATED">
                                <label for="maritalStatus_separated" class="mb-0 flex-grow-1">SEPARATED</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 maritalStatusRadioGroup">
                                <input type="radio" name="maritalStatus" id="maritalStatus_widowed" value="WIDOWED">
                                <label for="maritalStatus_widowed" class="mb-0 flex-grow-1">WIDOWED</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 maritalStatusRadioGroup">
                                <input type="radio" name="maritalStatus" id="maritalStatus_annuled" value="ANNULED">
                                <label for="maritalStatus_annuled" class="mb-0 flex-grow-1">ANNULED</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 maritalStatusRadioGroup">
                                <input type="radio" name="maritalStatus" id="maritalStatus_others" value="OTHERS">
                                <label for="maritalStatus_others" class="mb-0 flex-grow-1">OTHERS</label>
                            </div>
                            <div class="col form-group d-none p-0" id="maritalStatusOtherGroup">
                                <input
                                    type="text"
                                    id="maritalStatusOtherInput"
                                    name="maritalStatusOther"
                                    class="form-control form-control-sm"
                                    placeholder="Please specify">
                                <div class="invalid-feedback">Please specify your marital status.</div>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please select a Marital Status.</div>
                    </div>
                    <div class="form-step" data-step="9">
                        <div class="row justify-content-center align-items-center">
                            <label for="birthday" class="h3 text-center">Date of Birth <span class="text-danger">*</span></label>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <input type="date" name="birthday" id="birthday" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please provide a valid Date of Birth.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="10">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Buyer Type <span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                <input type="radio" name="buyerType" id="buyerType_first" value="FIRST-TIME">
                                <label for="buyerType_first" class="mb-0 flex-grow-1">FIRST-TIME</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                <input type="radio" name="buyerType" id="buyerType_replacement" value="REPLACEMENT">
                                <label for="buyerType_replacement" class="mb-0 flex-grow-1">REPLACEMENT</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                <input type="radio" name="buyerType" id="buyerType_additional" value="ADDITIONAL">
                                <label for="buyerType_additional" class="mb-0 flex-grow-1">ADDITIONAL</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please select a Buyer Type.</div>
                    </div>
                    <div class="form-step" data-step="11">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Unit Inquired <span class="text-danger">*</span></h3>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <select name="unitInquired" id="unitInquired" class=" form-select form-select-sm" required></select>
                                <div class="invalid-feedback">Please provide a valid Unit Inquired.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="12">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Select TAMARAW variant<span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_glDropSide" value="GL DROP SIDE HI AT (LONG WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_glDropSide" class="mb-0 flex-grow-1">GL DROPSIDE HI AT (LONG WHEEL BASE-DIESEL)</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_utilityLong" value="UTILITY VAN FX MT (LONG WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_utilityLong" class="mb-0 flex-grow-1">UTILITY VAN FX MT (LONG WHEEL BASE-DIESEL)</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_dropsideLong" value="DROPSIDE STANDARD MT (LONG WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_dropsideLong" class="mb-0 flex-grow-1">DROPSIDE STANDARD MT (LONG WHEEL BASE-DIESEL)</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_aluminumLong" value="ALUMINUM CARGO MT (LONG WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_aluminumLong" class="mb-0 flex-grow-1">ALUMINUM CARGO MT (LONG WHEEL BASE-DIESEL)</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_utilityShort" value="UTILITY VAN FX MT (SHORT WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_utilityShort" class="mb-0 flex-grow-1">UTILITY VAN FX MT (SHORT WHEEL BASE-DIESEL)</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_dropsideShort" value="DROPSIDE STANDARD MT (SHORT WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_dropsideShort" class="mb-0 flex-grow-1">DROPSIDE STANDARD MT (SHORT WHEEL BASE-DIESEL)</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_aluminumShort" value="ALUMINUM CARGO MT (SHORT WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_aluminumShort" class="mb-0 flex-grow-1">ALUMINUM CARGO MT (SHORT WHEEL BASE-DIESEL)</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_foodTruck" value="FOOD TRUCK MT (LONG WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_foodTruck" class="mb-0 flex-grow-1">FOOD TRUCK MT (LONG WHEEL BASE-DIESEL)</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_mobileStore" value="MOBILE STORE MT (LONG WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_mobileStore" class="mb-0 flex-grow-1">MOBILE STORE MT (LONG WHEEL BASE-DIESEL)</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 tamarawVariantRadioGroup">
                                <input type="radio" name="tamarawVariant" id="tamarawVariant_wingVan" value="WING VAN MT (LONG WHEEL BASE-DIESEL)">
                                <label for="tamarawVariant_wingVan" class="mb-0 flex-grow-1">WING VAN MT (LONG WHEEL BASE-DIESEL)</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please select a Tamaraw Variant.</div>
                    </div>
                    <div class="form-step" data-step="13">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Transaction Type <span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 transactionTypeRadioGroup">
                                <input type="radio" name="transactionType" id="transactionType_financing" value="FINANCING">
                                <label for="transactionType_financing" class="mb-0 flex-grow-1">FINANCING</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 transactionTypeRadioGroup">
                                <input type="radio" name="transactionType" id="transactionType_bankPo" value="BANK PO">
                                <label for="transactionType_bankPo" class="mb-0 flex-grow-1">BANK PO</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 transactionTypeRadioGroup">
                                <input type="radio" name="transactionType" id="transactionType_cash" value="CASH">
                                <label for="transactionType_cash" class="mb-0 flex-grow-1">CASH</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 transactionTypeRadioGroup">
                                <input type="radio" name="transactionType" id="transactionType_companyPo" value="COMPANY PO">
                                <label for="transactionType_companyPo" class="mb-0 flex-grow-1">COMPANY PO</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 transactionTypeRadioGroup">
                                <input type="radio" name="transactionType" id="transactionType_governmentPo" value="GOVERNMENT PO">
                                <label for="transactionType_governmentPo" class="mb-0 flex-grow-1">GOVERNMENT PO</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 transactionTypeRadioGroup">
                                <input type="radio" name="transactionType" id="transactionType_kinto" value="KINTO">
                                <label for="transactionType_kinto" class="mb-0 flex-grow-1">KINTO</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="14">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">With Application?<span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup">
                                <input type="radio" name="hasApplication" id="hasApplication_yes" value="YES">
                                <label for="hasApplication_yes" class="mb-0 flex-grow-1">YES</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup">
                                <input type="radio" name="hasApplication" id="hasApplication_no" value="NO">
                                <label for="hasApplication_no" class="mb-0 flex-grow-1">NO</label>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">With Reservation?<span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 hasReservationRadioGroup">
                                <input type="radio" name="hasReservation" id="hasReservation_yes" value="YES">
                                <label for="hasReservation_yes" class="mb-0 flex-grow-1">YES</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 hasReservationRadioGroup">
                                <input type="radio" name="hasReservation" id="hasReservation_no" value="NO">
                                <label for="hasReservation_no" class="mb-0 flex-grow-1">NO</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="15">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Date of Reservation<span class="text-danger">*</span></h3>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <input type="date" name="reservationDate" id="reservationDate" class="form-control form-control-sm">
                                <div class="invalid-feedback">Please provide a valid Date of Reservation.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="16">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">Occupation<span class="text-danger">*</span></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 occupationRadioGroup">
                                <input type="radio" name="occupation" id="occupation_businessOwner" value="BUSINESS OWNER">
                                <label for="occupation_businessOwner" class="mb-0 flex-grow-1">BUSINESS OWNER</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 occupationRadioGroup">
                                <input type="radio" name="occupation" id="occupation_employed" value="EMPLOYED">
                                <label for="occupation_employed" class="mb-0 flex-grow-1">EMPLOYED</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 occupationRadioGroup">
                                <input type="radio" name="occupation" id="occupation_ofw" value="OFW/SEAMAN">
                                <label for="occupation_ofw" class="mb-0 flex-grow-1">OFW/SEAMAN</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 occupationRadioGroup">
                                <input type="radio" name="occupation" id="occupation_pensioner" value="PENSIONER">
                                <label for="occupation_pensioner" class="mb-0 flex-grow-1">PENSIONER</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 occupationRadioGroup">
                                <input type="radio" name="occupation" id="occupation_unemployed" value="UNEMPLOYED/REMITTANCE RECEIVER">
                                <label for="occupation_unemployed" class="mb-0 flex-grow-1">UNEMPLOYED/REMITTANCE RECEIVER</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 occupationRadioGroup">
                                <input type="radio" name="occupation" id="occupation_freelancer" value="FREELANCER">
                                <label for="occupation_freelancer" class="mb-0 flex-grow-1">FREELANCER</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 occupationRadioGroup">
                                <input type="radio" name="occupation" id="occupation_familySupported" value="FAMILY SUPPORTED/GIFT/DONATION">
                                <label for="occupation_familySupported" class="mb-0 flex-grow-1">FAMILY SUPPORTED/GIFT/DONATION</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 occupationRadioGroup">
                                <input type="radio" name="occupation" id="occupation_tnvs" value="TNVS (GRAB, LALAMOVE, JOYRIDE, ETC.)">
                                <label for="occupation_tnvs" class="mb-0 flex-grow-1">TNVS (GRAB, LALAMOVE, JOYRIDE, ETC.)</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="17">
                        <div class="row justify-content-center align-items-center">
                            <label for="businessName" class="h3 text-center">
                                <span id="occupationHeaderOne">Business Name</span>
                                <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <input type="text" name="businessName" id="businessName" class="form-control form-control-sm" required>
                                <div class="invalid-feedback" id="occupationFeedback">Please provide a valid Business Name.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="18">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">
                                <span id="occupationHeaderTwo">Complete Business Address</span>
                                <span class="text-danger">*</span>
                            </h3>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-4 form-group">
                                <label for="occupationProvince" class="mb-0 flex-grow-1">Province <span class="text-danger">*</span></label>
                                <select name="occupationProvince" id="occupationProvince" class="form-select form-select-sm" required></select>
                                <div class="invalid-feedback">Please select a Province.</div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="occupationMunicipality" class="mb-0 flex-grow-1">Municipality <span class="text-danger">*</span></label>
                                <select name="occupationMunicipality" id="occupationMunicipality" class="form-select form-select-sm" disabled required></select>
                                <div class="invalid-feedback">Please select a Municipality.</div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="occupationBarangay" class="mb-0 flex-grow-1">Barangay <span class="text-danger">*</span></label>
                                <select name="occupationBarangay" id="occupationBarangay" class="form-select form-select-sm" disabled required></select>
                                <div class="invalid-feedback">Please select a Barangay.</div>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center px-2">
                            <label for="occupationStreet" class="mb-0 flex-grow-1">Street Address</label>
                            <input type="text" name="occupationStreet" id="occupationStreet" class="form-control form-control-sm">
                            </input>
                        </div>
                    </div>
                    <div class="form-step" data-step="19">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">
                                <span id="occupationHeaderTwo">Business Category</span>
                                <span class="text-danger">*</span>
                            </h3>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_agriculture" value="AGRICULTURE">
                            <label for="businessCategory_agriculture" class="mb-0 flex-grow-1">AGRICULTURE (POULTRY RAISING, HOG RAISING, VEGETABLE FARMING, DAIRY FARMING, RICE CULTIVATION, AND AQUACULTURE, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_bpo" value="BPO">
                            <label for="businessCategory_bpo" class="mb-0 flex-grow-1">BPO (CONCENTRIX PHIL., TELEPERFORMANCE PHILS., ACCENTURE, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_clinic" value="CLINIC">
                            <label for="businessCategory_clinic" class="mb-0 flex-grow-1">CLINIC (MyHEALTH CLINIC, DERMATOLOGY, DENTAL CLINIC, OB-GYN, PEDIATRICS, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_construction" value="CONSTRUCTION">
                            <label for="businessCategory_construction" class="mb-0 flex-grow-1">CONSTRUCTION (DMCI, MEGAWIDE CONSTRUCTION CORPORATION, WILCON DEPOT, HOLCIM PHILS., CONTRACTOR, ARCHITECT, ENGINEER, DPWH, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_enterprise" value="ENTERPRISE">
                            <label for="businessCategory_enterprise" class="mb-0 flex-grow-1">ENTERPRISE (OWNER OF SAN MIGUEL CORP., AYALA CORP., SM INVESTMENTS CORP., PLDT/SMART COMMUNICATIONS, METRO OIL PHILS., ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_eCommerce" value="E-COMMERCE">
                            <label for="businessCategory_eCommerce" class="mb-0 flex-grow-1">E-COMMERCE (ONLINE SELLING, SHOPEE, LAZADA, WALTERMART DELIVERY, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_foodServices" value="FOOD SERVICES">
                            <label for="businessCategory_foodServices" class="mb-0 flex-grow-1">FOOD SERVICES (FAST FOOD CHAIN, RESTAURANT, COFFEE SHOP, CATERING, FOOD VENDORS, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_generalMerchandise" value="GENERAL MERCHANDISE">
                            <label for="businessCategory_generalMerchandise" class="mb-0 flex-grow-1">GENERAL MERCHANDISE (HOUSEHOLD GOODS, CLOTHING, BASIC ELECTRONICS, TOILETRIES, SCHOOL SUPPLIES, SMALL TOOLS AND SOMETIMES SNACK OR GROCERIES ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_generalServices" value="GENERAL SERVICES">
                            <label for="businessCategory_generalServices" class="mb-0 flex-grow-1">GENERAL SERVICES (JANITORIAL AND CLEANING SERVICES, PEST CONTROL, APPLIANCE REPAIR, SECURE AND MANPOWER SERVICES, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_government" value="GOVERNMENT">
                            <label for="businessCategory_government" class="mb-0 flex-grow-1">GOVERNMENT (LGU, GOVERNMENT AGENCIES, LTO, COMELEC, PNP, AFP, TEACHER, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_hrm" value="HOSPITALITY/TOURISM/TRAVEL">
                            <label for="businessCategory_hrm" class="mb-0 flex-grow-1">HOSPITALITY/TOURISM/TRAVEL (HOTEL, RESORT, AIRBNB, WELLNESS, TRAVEL AGENCIES, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_landscaping" value="LANDSCAPING">
                            <label for="businessCategory_landscaping" class="mb-0 flex-grow-1">LANDSCAPING (OFFERS GARDEN DESIGN, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_logistic" value="LOGISTIC">
                            <label for="businessCategory_logistic" class="mb-0 flex-grow-1">LOGISTIC (LBC, 2GO, TRANSFORTIFY, FOOD PANDA, JT EXPRESS, CARGO, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_manufacturing" value="MANUFACTURING">
                            <label for="businessCategory_manufacturing" class="mb-0 flex-grow-1">MANUFACTURING (FOOD AND BEVERAGE PRODUCTION, SAN MIGUEL CORPORATION, TOYOTA MOTOR PHILS., ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_healthcare" value="PHARMA/HEALTHCARE">
                            <label for="businessCategory_healthcare" class="mb-0 flex-grow-1">PHARMA/HEALTHCAARE (UNILAB, MERCURY DRUG CORP., RITEMED, PFIZER, FDA PHILIPS., DOH, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_rental" value="RENTAL">
                            <label for="businessCategory_rental" class="mb-0 flex-grow-1">RENTAL (APARTMENT, COMMERCIAL SPACES, VEHICLE, CHAIRS AND TABLES, SOUND SYSTEM, CONCRETE MIXERS, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_retailsShop" value="RETAILS SHOP">
                            <label for="businessCategory_retailsShop" class="mb-0 flex-grow-1">RETAILS SHOP (GOODS, CLOTHING, ACCESSORIES, DRY GOODS, COSMETICS, SCHOOL AND OFFICE SUPPLIES, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_technology" value="IT/TECHNOLOGY">
                            <label for="businessCategory_technology" class="mb-0 flex-grow-1">IT/TECHNOLOGY (ACCENTURE PHILS., POINTWEST TECHONOLOGIES, IMB PHILS., SOFTWARE ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_trading" value="TRADING">
                            <label for="businessCategory_trading" class="mb-0 flex-grow-1">TRADING (A TRADING BUSNESS BUYS PRODUCTS AND RESELLS THEM AT A PROFIT ETIHTER LOCALLY OR INTERNATIONALLY)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_transportation" value="TRANSPORTATION">
                            <label for="businessCategory_transportation" class="mb-0 flex-grow-1">TRANSPORTATION (PASSENGER TRANSPORT, CARGO & LOGISTICS TRANSPORT SHUTTLE, SEA, ETC.)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_trucking" value="TRUCKING">
                            <label for="businessCategory_trucking" class="mb-0 flex-grow-1">TRUCKING (A TRUCKING BUSINESS PROVIDES TRANSPORTATION OF GOODS USING TRUCKS)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_utilities" value="UTILITIES">
                            <label for="businessCategory_utilities" class="mb-0 flex-grow-1">UTILITIES (WATER, ELECTRICAL, CABLE, WI-FI)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_wholesale" value="WHOLESALE">
                            <label for="businessCategory_wholesale" class="mb-0 flex-grow-1">WHOLESALE (A WHOLESALE BUSINESS BUYS PRODUCTS IN A LARGE QUANTITIES FROM MANUFACTURERS OR SUPPLIERS AND RESELLS THEM IN BULK, NOT INDIVIDUALLY)</label>
                        </div>
                        <div class="col justify-content-center align-items-center radio-column mb-4 py-1 d-flex gap-2 businessCategoryRadioGroup">
                            <input type="radio" name="businessCategory" id="businessCategory_wholesaleRetail" value="WHOLESALE/RETAIL">
                            <label for="businessCategory_wholesaleRetail" class="mb-0 flex-grow-1">WHOLESALE/RETAIL (A WHOLESALE AND RETAIL BUSINESS OPERATES ON TWO LEVELS: WHOLESALE & RETAIL)</label>
                        </div>

                    </div>
                    <div class="form-step" data-step="20">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">
                                Monthly Average
                                <span class="text-danger">*</span>
                            </h3>
                            <div class="d-flex gap-2">
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_50K" value="50K and Below">
                                    <label for="monthlyAverage_50K" class="mb-0 flex-grow-1">50K AND BELOW</label>
                                </div>
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_50K" value="51K to 60K">
                                    <label for="monthlyAverage_51K" class="mb-0 flex-grow-1">51K TO 60K</label>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_61K" value="61K to 70K">
                                    <label for="monthlyAverage_61K" class="mb-0 flex-grow-1">61K TO 70K</label>
                                </div>
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_71K" value="71K to 80K">
                                    <label for="monthlyAverage_71K" class="mb-0 flex-grow-1">71K TO 80K</label>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_81K" value="81K to 90K">
                                    <label for="monthlyAverage_81K" class="mb-0 flex-grow-1">81K TO 90K</label>
                                </div>
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_91K" value="91K to 100K">
                                    <label for="monthlyAverage_91K" class="mb-0 flex-grow-1">91K TO 100K</label>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_101K" value="101K to 200K">
                                    <label for="monthlyAverage_101K" class="mb-0 flex-grow-1">101K TO 200K</label>
                                </div>
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_201K" value="201K to 300K">
                                    <label for="monthlyAverage_201K" class="mb-0 flex-grow-1">201K TO 300K</label>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_301K" value="301K to 400K">
                                    <label for="monthlyAverage_301K" class="mb-0 flex-grow-1">301K TO 400K</label>
                                </div>
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_401K" value="401K to 500K">
                                    <label for="monthlyAverage_401K" class="mb-0 flex-grow-1">401K TO 500K</label>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 monthlyAverageRadioGroup">
                                    <input type="radio" name="monthlyAverage" id="monthlyAverage_501K" value="501K and Above">
                                    <label for="monthlyAverage_501K" class="mb-0 flex-grow-1">501K AND ABOVE</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="21">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">
                                Business Size
                                <span class="text-danger">*</span>
                            </h3>
                            <div class="d-flex gap-2">
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 businessSizeRadioGroup">
                                    <input type="radio" name="businessSize" id="businessSize_micro" value="MICRO">
                                    <label for="businessSize_micro" class="mb-0 flex-grow-1">MICRO (1-9 EMPLOYEES)</label>
                                </div>
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 businessSizeRadioGroup">
                                    <input type="radio" name="businessSize" id="businessSize_small" value="SMALL">
                                    <label for="businessSize_small" class="mb-0 flex-grow-1">SMALL (10-99 EMPLOYEES)</label>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 businessSizeRadioGroup">
                                    <input type="radio" name="businessSize" id="businessSize_medium" value="MEDIUM">
                                    <label for="businessSize_medium" class="mb-0 flex-grow-1">MEDIUM (100-199 EMPLOYEES)</label>
                                </div>
                                <div class="col form-group col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 businessSizeRadioGroup">
                                    <input type="radio" name="businessSize" id="businessSize_large" value="LARGE">
                                    <label for="businessSize_large" class="mb-0 flex-grow-1">LARGE (200 & ABOVE EMPLOYEES)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="22">
                        <div class="row justify-content-center align-items-center">
                            <label for="additionalUnit" class="h3 text-center">
                                Additional Unit Currently used for Business <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group mb-0">
                                <input type="text" name="additionalUnit" id="additionalUnit" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <p>Input "N/A" if no unit is currently used for business.</p>
                        </div>
                    </div>
                    <div class="form-step" data-step="23">
                        <div class="row justify-content-center align-items-center">
                            <label for="tamarawSpecificUsage" class="h3 text-center">
                                Specific Purpose or usage of Tamaraw <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <input type="text" name="tamarawSpecificUsage" id="tamarawSpecificUsage" class="form-control form-control-sm">
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="24">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">
                                Is Buyer's Decision on hold?
                                <span class="text-danger">*</span>
                            </h3>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup">
                                <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_yes" value="YES">
                                <label for="buyerDecisionHold_yes" class="mb-0 flex-grow-1">YES</label>
                            </div>
                            <div class="col justify-content-center align-items-center radio-column mb-4 py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup">
                                <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_no" value="NO">
                                <label for="buyerDecisionHold_no" class="mb-0 flex-grow-1">NO</label>
                            </div>
                            <div class="invalid-feedback">Please select an option.</div>
                        </div>
                        <div id="buyerDecisionHoldReasonGroup" class="d-none">
                            <div class="row justify-content-center align-items-center">
                                <h3 class="text-center">
                                    Reason why the client's buying decision is on hold
                                    <span class="text-danger">*</span>
                                </h3>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col form-group">
                                    <input type="text" name="buyerDecisionHoldReason" id="buyerDecisionHoldReason" class="form-control form-control-sm">
                                    <div class="invalid-feedback">Please fill up this field.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" data-step="25">
                        <div class="row justify-content-center align-items-center">
                            <h3 class="text-center">
                                Set an Appointment (For the next call)<span class="text-danger">*</span>
                            </h3>
                        </div>

                        <!-- Date Picker -->
                        <div class="row justify-content-center align-items-center">
                            <div class="col form-group">
                                <label for="appointmentDate" class="mb-0 flex-grow-1">Appointment Date</label>
                                <input type="date" name="appointmentDate" id="appointmentDate" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please provide a valid Date.</div>
                            </div>
                        </div>

                        <!-- Time Picker -->
                        <div class="row justify-content-center align-items-center mt-2">
                            <div class="col form-group">
                                <label for="appointmentTime" class="mb-0 flex-grow-1">Appointment Time</label>
                                <select name="appointmentTime" id="appointmentTime" class="form-select form-select-sm" required>
                                    <option value="" hidden disabled selected>-- Select Time --</option>
                                    <!-- Morning -->
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <!-- Afternoon -->
                                    <option value="01:00 PM">01:00 PM</option>
                                    <option value="01:30 PM">01:30 PM</option>
                                    <option value="02:00 PM">02:00 PM</option>
                                    <option value="02:30 PM">02:30 PM</option>
                                    <option value="03:00 PM">03:00 PM</option>
                                    <option value="03:30 PM">03:30 PM</option>
                                    <option value="04:00 PM">04:00 PM</option>
                                    <option value="04:30 PM">04:30 PM</option>
                                    <option value="05:00 PM">05:00 PM</option>
                                    <option value="05:30 PM">05:30 PM</option>
                                </select>
                                <div class="invalid-feedback">Please select an option.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" id="previousBtn"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-sm btn-primary" id="nextBtn">Next <i class="fa-solid fa-arrow-right"></i></button>
                    <button type="button" class="btn btn-sm btn-primary" id="reviewBtn"><i class="fa-solid fa-magnifying-glass-arrows-rotate"></i> Review Inquiry</button>
                </div>
            </div>
        </form>
    </div>
</div>