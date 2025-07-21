<div class="modal fade" id="reviewInquiryModal" tabindex="-1" aria-labelledby="reviewInquiryModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <form id="reviewInquiryForm" class="needs-validation w-100" novalidate>
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="reviewInquiryModalLabel">Review Inquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row modal-body custom-scrollable-body">
                    <div class="col">
                        <div class="row">
                            <h3 class="text-center">Customer Details</h3>
                        </div>
                        <div class="row">
                            <p class="form-label">Prospect Type <span class="text-danger">*</span></p>
                            <div class="row justify-content-center align-items-center">
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup">
                                    <input type="radio" name="prospectType" id="prospectType_hot_review" value="Hot">
                                    <label for="prospectType_hot_review" class="mb-0 flex-grow-1">HOT (WITHIN 1 WEEK TO 2 MONTHS)</label>
                                </div>
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup">
                                    <input type="radio" name="prospectType" id="prospectType_warm_review" value="Warm">
                                    <label for="prospectType_warm_review" class="mb-0 flex-grow-1">WARM (WITHIN 2 TO 5 MONTHS)</label>
                                </div>
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup">
                                    <input type="radio" name="prospectType" id="prospectType_cold_review" value="Cold">
                                    <label for="prospectType_cold_review" class="mb-0 flex-grow-1">COLD (6 MONTHS AND ABOVE)</label>
                                </div>
                                <div class="invalid-feedback">
                                    Please select a Prospect Type.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Customer Name</p>
                            <div class="row justify-content-center align-items-center">
                                <div class="col form-group">
                                    <label for="customerFirstName_review">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customerFirstName" id="customerFirstName_review" class="form-control form-control-sm" required>
                                    <div class="invalid-feedback">Please provide a valid First Name.</div>
                                </div>
                                <div class="col form-group">
                                    <label for="customerMiddleName_review">Middle Name</label>
                                    <input type="text" name="customerMiddleName" id="customerMiddleName_review" class="form-control form-control-sm">
                                </div>
                                <div class="col form-group">
                                    <label for="customerLastName_review">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customerLastName" id="customerLastName_review" class="form-control form-control-sm" required>
                                    <div class="invalid-feedback">Please provide a valid Last Name.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Client Address <span class="text-danger">*</span></p>
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="province_review" class="mb-0 flex-grow-1">Province <span class="text-danger">*</span></label>
                                    <select name="province" id="province_review" class="form-select form-select-sm" required></select>
                                    <div class="invalid-feedback">Please select a Province.</div>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="municipality_review" class="mb-0 flex-grow-1">Municipality <span class="text-danger">*</span></label>
                                    <select name="municipality" id="municipality_review" class="form-select form-select-sm" disabled required></select>
                                    <div class="invalid-feedback">Please select a Municipality.</div>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="barangay_review" class="mb-0 flex-grow-1">Barangay <span class="text-danger">*</span></label>
                                    <select name="barangay" id="barangay_review" class="form-select form-select-sm" disabled required></select>
                                    <div class="invalid-feedback">Please select a Barangay.</div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <label for="street_review" class="mb-0 flex-grow-1">Street Address</label>
                                <input type="text" name="street" id="street_review" class="form-control form-control-sm">
                                </input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row justify-content-center align-items-center">
                                <label for="contactNumber_review" class="form-label">Client Contact Number <span class="text-danger">*</span></label>
                                <input
                                    type="tel"
                                    name="contactNumber"
                                    id="contactNumber_review"
                                    class="form-control form-control-sm"
                                    required
                                    pattern="^(09\d{9}|\+639\d{9})$"
                                    placeholder="Enter a valid Philippine mobile number (e.g., 09XXXXXXXXX or +639XXXXXXXXX)">
                                <div class="invalid-feedback">Please provide a valid Contact Number.</div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Client Gender <span class="text-danger">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup">
                                    <input type="radio" name="gender" id="gender_male_review" value="Male">
                                    <label for="gender_male_review" class="mb-0 flex-grow-1">Male</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup">
                                    <input type="radio" name="gender" id="gender_female_review" value="Female">
                                    <label for="gender_female_review" class="mb-0 flex-grow-1">Female</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup">
                                    <input type="radio" name="gender" id="gender_lgbt_review" value="LGBT">
                                    <label for="gender_lgbt_review" class="mb-0 flex-grow-1">LGBT</label>
                                </div>
                                <div class="invalid-feedback">Please select a Gender.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="maritalStatus_review" class="form-label">Marital Status <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select class="form-select form-select-sm" name="maritalStatus" id="maritalStatus_review">
                                    <option selected disabled value="" hidden>--Select Marital Status--</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Separated">Separated</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Annuled">Annuled</option>
                                    <option value="Others">Others</option>
                                </select>
                                <div class="invalid-feedback">Please select a Marital Status.</div>
                            </div>
                            <div class="row d-none form-group gap-1" id="maritalStatusOthersRow_review">
                                <label for="maritalStatusOtherInput_review" class="form-label">Please Specify <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="maritalStatusOtherInput_review"
                                    name="maritalStatus"
                                    class="form-control form-control-sm">
                                <div class="invalid-feedback">Please specify your marital status.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="birthday_review" class="form-label">Date of Birth</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="birthday" id="birthday_review" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please provide a valid Date of Birth.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="occupation_review" class="form-label">Occupation</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="occupation" id="occupation_review" class="form-select form-select-sm">
                                    <option selected disabled value="" hidden>--Select Occupation--</option>
                                    <option value="Business Owner">Business Owner</option>
                                    <option value="Employed">Employed</option>
                                    <option value="OFW/Seaman">OFW/Seaman</option>
                                    <option value="Pensioner">Pensioner</option>
                                    <option value="Unemploye/Remittance Receiver">Unemploye/Remittance Receiver</option>
                                    <option value="Freelancer">Freelancer</option>
                                    <option value="Family Support/Gift/Donation">Family Support/Gift/Donation</option>
                                    <option value="TNVS (Grab, Lalamove, Joyride, etc.)">TNVS (Grab, Lalamove, Joyride, etc.)</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">Please select an Occupation.</div>
                        </div>
                        <div class="row">
                            <label for="businessName_review" class="form-label"><span class="occupationLabel">Occupation</span> Name</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="businessName" id="businessName_review" class="form-control form-control-sm" required>
                                <div class="invalid-feedback" id="occupationFeedback">Please provide a valid Business Name.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="businessAddress_review" class="form-label"><span class="occupationLabel">Occupation</span> Address</label>
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationProvince_review" class="mb-0 flex-grow-1">Province <span class="text-danger">*</span></label>
                                    <select name="occupationProvince" id="occupationProvince_review" class="form-select form-select-sm" required></select>
                                    <div class="invalid-feedback">Please select a Province.</div>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationMunicipality_review" class="mb-0 flex-grow-1">Municipality <span class="text-danger">*</span></label>
                                    <select name="occupationMunicipality" id="occupationMunicipality_review" class="form-select form-select-sm" disabled required></select>
                                    <div class="invalid-feedback">Please select a Municipality.</div>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationBarangay_review" class="mb-0 flex-grow-1">Barangay <span class="text-danger">*</span></label>
                                    <select name="occupationBarangay" id="occupationBarangay_review" class="form-select form-select-sm" disabled required></select>
                                    <div class="invalid-feedback">Please select a Barangay.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="businessCategoryRow_review">
                            <label for="businessCategory_review" class="form-label">Business Category</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="businessCategory" id="businessCategory_review" class="form-select form-select-sm">
                                    <option selected disabled value="" hidden>--Select Business Category--</option>
                                    <option value="Agriculture">AGRICULTURE (POULTRY RAISING, HOG RAISING, VEGETABLE FARMING, DAIRY FARMING, RICE CULTIVATION, AND AUACULTURE. ETC.)</option>
                                    <option value="BPO">BPO (CONCENTRIX PHIL., TELEPERFORMANCE PHILS., ACCENTURE, ETC.)</option>
                                    <option value="Clinic">CLINIC (MyHEALTH CLINIC, DERMATOLOGY, DENTAL CLINIC, OB-GYN, PEDIATRICS, ETC.)</option>
                                    <option value="Construction">CONSTRUCTION (DMCI, MEGAWIDE CONSTRUCTION CORPORATION, WILCON DEPOT, HOLCIM PHILS., CONTRACTOR, ARCHITECT, ENGINEER, DPWH, ETC.)</option>
                                    <option value="Enterprise">ENTERPRISE (OWNER OF SAN MIGUEL CORP., AYALA CORP., SM INVESTMENTS CORP., PLDT/SMART COMMUNICATIONS, METRO OIL PHILS., ETC.)</option>
                                    <option value="E-Commerce">E-COMMERCE (ONLINE SELLING-SHOPEE, LAZADA, WALTERMART DELIVERY, ETC.)</option>
                                    <option value="Food Services">FOOD SERVICES (FAST FOOD CHIN, RESTAURANT, COFFEE SHOP, CATERING, FOOD VENDORS, ETC.)</option>
                                    <option value="General Merchandise">GENERAL MERCHANDISE (HOUSEHOLD GOODS, CLOTHING, BASIC ELECTRONICS, TOILETRIES, SCHOOL SUPPLIES, SMALL TOOLS AND SOMETIMES SNACK OR GROCERIES ETC.)</option>
                                    <option value="General Services">GENERAL SERVICES (JANITORIAL AND CLEANING SERVICES, PEST CONTROL, APPLIANCE REPAIR, SECURE AND MANPOWER SERVICES, ETC.)</option>
                                    <option value="Government">GOVERNMENT (LGU, GOVERNMENT AGENCIES, LTO, COMELEC, PNP, AFP TEACHER, ETC.)</option>
                                    <option value="Hospitality/Tourism/Travel">HOSPITALITY/TOURISM/TRAVEL (HOTEL, RESPORT, AIRBNB, WELLNESS, TRAVEL AGENCIES, ETC.)</option>
                                    <option value="Landscaping">LANDSCAPING (OFFERS GARDEN DESIGN, ETC.)</option>
                                    <option value="Logistic">LOGISTIC (LBC, 2GO, TRANSFORTIFY, FOOD PANDA, JT EXPRESS, CARGO, ETC.)</option>
                                    <option value="Manufacturing">MANUFACTURING (FOOD AND BEVERAGE PRODUCTION, SAN MIGUEL CORPORATION, TOYOTA MOTOR PHILS., ETC.)</option>
                                    <option value="Pharma/Healthcare">PHARMA/HEALTHCAARE (UNILAB, MERCURY DRUG CORP., RITEMED, PFIZER, FDA PHILIPS., DOH, ETC.)</option>
                                    <option value="Rental">RENTAL (APARTMENT, COMMERCIAL SPACES, VEHICLE, CHAIRS AND TABLES, SOUND SYSTEM, CONCRETE MIXERS, ETC.)</option>
                                    <option value="Retails Shop">RETAILS SHOP (GOODS, CLOTHING, ACCESSORIES, DRY GOODS, COSMETICS, SCHOOL AND OFFICE SUPPLIES, ETC.)</option>
                                    <option value="IT/Technology">IT/TECHNOLOGY (ACCENTURE PHILS., POINTWEST TECHONOLOGIES, IMB PHILS., SOFTWARE ETC.)</option>
                                    <option value="Trading">TRADING (A TRADING BUSNESS BUYS PRODUCTS AND RESELLS THEM A)T A PROFIT ETIHTER LOCALLY OR INTERNATIONALLY</option>
                                    <option value="Transportation">TRANSPORTATION (PASSENGER TRANSPORT, CARGO & LOGISTICS TRANSPORT SHUTTLE, SEA, ETC.)</option>
                                    <option value="Trucking">TRUCKING (A TRUCKING BUSINESS PROVIDES TRANSPORTAIONG OF GOODS USING TRUCKS)</option>
                                    <option value="Utilities">UTILITIES (WATER, ELECTRICAL, CABLE, WIFI)</option>
                                    <option value="Wholesale">WHOLESALE (A WHOLESALE BUSINESS BUYS PRODUCTS IN A LARGE QUANTITIES FROM MANUFACTURERS OR SUPPLIERS AND RESELLS THEM IN BULK, NOT INDIVIDUALLY)</option>
                                    <option value="Wholesale/Retail">WHOLESALE/RETAIL (A WHOLESALE AND RETAIL BUSINESS OPERATES ON TWO LEVELS: WHOLESALE & RETAIL)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="businessSizeRow_review">
                            <label for="businessSize_review" class="form-label">Business Size</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="businessSize" id="businessSize_review" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Business Size--</option>
                                    <option value="Micro">Micro (1-9 Employees)</option>
                                    <option value="Small">Small (10-99 Employees)</option>
                                    <option value="Medium">Medium (100-199 Employees)</option>
                                    <option value="Large">Large (200 & Above Employees)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="monthlyAverage_review" class="form-label">Monthly Average</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="monthlyAverage" id="monthlyAverage_review" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Monthly Average--</option>
                                    <option value="50K and Below">50K AND BELOW</option>
                                    <option value="51K to 60K">51K TO 60K</option>
                                    <option value="61K to 70K">61K TO 70K</option>
                                    <option value="71K to 80K">71K TO 80K</option>
                                    <option value="81K to 90K">81K TO 90K</option>
                                    <option value="91K to 100K">91K TO 100K</option>
                                    <option value="101K to 200K">101K TO 200K</option>
                                    <option value="201K to 300K">201K TO 300K</option>
                                    <option value="301K to 400K">301K TO 400K</option>
                                    <option value="401K to 500K">401K TO 500K</option>
                                    <option value="501K and Above">501K AND ABOVE</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h3 class="text-center">Inquiry Details</h3>
                        </div>
                        <div class="row">
                            <label for="inquiryDate_review" class="form-label">Date of Inquiry <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="inquiryDate" id="inquiryDate_review" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <label for="inquirySource_review" class="form-label">Source of Inquiry <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySource" id="inquirySource_review" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Source--</option>
                                    <option value="Face To Face">Face To Face</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="f2fSourceRow_review">
                            <label for="f2fSource_review" class="form-label">Face To Face Inquiry Source <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySourceType" id="f2fSource_review" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Source--</option>
                                    <option value="Showroom Walk-In">Showroom Walk-In</option>
                                    <option value="Mall Display">Mall Display</option>
                                    <option value="Saturation">Saturation</option>
                                    <option value="Bank Display">Bank Display</option>
                                    <option value="Repeat">Repeat</option>
                                    <option value="Phone-In">Phone-In</option>
                                    <option value="Attack List (UIO)">Attack List (UIO)</option>
                                    <option value="Goyokiki">Goyokiki</option>
                                    <option value="Client From Service/Parts/Insurance">Client From Service/Parts/Insurance</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="onlineSourceRow_review">
                            <label for="onlineSource_review" class="form-label">Online Inquiry Source <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySourceType" id="onlineSource_review" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Source--</option>
                                    <option value="TMR FB PAGE (Toyota Marilao Bulacan Inc.)">TMR FB PAGE (Toyota Marilao Bulacan Inc.)</option>
                                    <option value="MP FB Page (MP-Toyota Marilao)">MP FB Page (MP-Toyota Marilao)</option>
                                    <option value="Group FB Page (GRM-Toyota Marilao)">Group FB Page (GRM-Toyota Marilao)</option>
                                    <option value="Personal Facebook">Personal Facebook</option>
                                    <option value="TikTok">TikTok</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="YouTube">YouTube</option>
                                    <option value="PhilGeps">PhilGeps</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="mallDisplayRow_review">
                            <label for="mallDisplay_review" class="form-label">Mall Display <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="mallDisplay" id="mallDisplay_review" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Buyer Type <span class="text-danger">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                    <input type="radio" name="buyerType" id="buyerType_first_review" value="First-Time">
                                    <label for="buyerType_first_review" class="mb-0 flex-grow-1">First-Time</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                    <input type="radio" name="buyerType" id="buyerType_replacement_review" value="Replacement">
                                    <label for="buyerType_replacement_review" class="mb-0 flex-grow-1">Replacement</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                    <input type="radio" name="buyerType" id="buyerType_additional_review" value="Additional">
                                    <label for="buyerType_additional_review" class="mb-0 flex-grow-1">Additional</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="unitInquired_review" class="form-label">Unit Inquired <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="unitInquired" id="unitInquired_review" class=" form-select form-select-sm" required></select>
                                <div class="invalid-feedback">Please provide a valid Unit Inquired.</div>
                            </div>
                        </div>
                        <div class="row d-none" id="tamarawVariantRow_review">
                            <label for="tamarawVariant_review" class="form-label">Tamaraw Variant</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="tamarawVariant" id="tamarawVariant_review" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Tamaraw Variant--</option>
                                    <option value="GL DROP SIDE HI AT (LONG WHEEL BASE-DIESEL)">GL DROP SIDE HI AT (LONG WHEEL BASE-DIESEL)</option>
                                    <option value="UTILITY VAN FX MT (LONG WHEEL BASE-DIESEL)">UTILITY VAN FX MT (LONG WHEEL BASE-DIESEL)</option>
                                    <option value="DROPSIDE STANDARD MT (LONG WHEEL BASE-DIESEL)">DROPSIDE STANDARD MT (LONG WHEEL BASE-DIESEL)</option>
                                    <option value="ALUMINUM CARGO MT (LONG WHEEL BASE-DIESEL)">ALUMINUM CARGO MT (LONG WHEEL BASE-DIESEL)</option>
                                    <option value="UTILITY VAN FX MT (SHORT WHEEL BASE-DIESEL)">UTILITY VAN FX MT (SHORT WHEEL BASE-DIESEL)</option>
                                    <option value="DROPSIDE STANDARD MT (SHORT WHEEL BASE-DIESEL)">DROPSIDE STANDARD MT (SHORT WHEEL BASE-DIESEL)</option>
                                    <option value="ALUMINUM CARGO MT (SHORT WHEEL BASE-DIESEL)">ALUMINUM CARGO MT (SHORT WHEEL BASE-DIESEL)</option>
                                    <option value="FOOD TRUCK MT (LONG WHEEL BASE-DIESEL)">FOOD TRUCK MT (LONG WHEEL BASE-DIESEL)</option>
                                    <option value="MOBILE STORE MT (LONG WHEEL BASE-DIESEL)">MOBILE STORE MT (LONG WHEEL BASE-DIESEL)</option>
                                    <option value="WING VAN MT (LONG WHEEL BASE-DIESEL)">WING VAN MT (LONG WHEEL BASE-DIESEL)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="transactionType_review" class="form-label">Trasnsaction Type</label>
                            <div class="row d-flex gap-2">
                                <select name="transactionType" id="transactionType_review" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Transaction Type--</option>
                                    <option value="Financing">Financing</option>
                                    <option value="Bank PO">Bank PO</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Company PO">Company PO</option>
                                    <option value="Government PO">Government PO</option>
                                    <option value="Kinto">Kinto</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">With Application</p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup">
                                    <input type="radio" name="hasApplication" id="hasApplication_yes_review" value="Yes">
                                    <label for="hasApplication_yes_review" class="mb-0 flex-grow-1">Yes</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup">
                                    <input type="radio" name="hasApplication" id="hasApplication_no_review" value="No">
                                    <label for="hasApplication_no_review" class="mb-0 flex-grow-1">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">With Reservation</p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasReservationRadioGroup">
                                    <input type="radio" name="hasReservation" id="hasReservation_yes_review" value="Yes">
                                    <label for="hasReservation_yes_review" class="mb-0 flex-grow-1">Yes</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasReservationRadioGroup">
                                    <input type="radio" name="hasReservation" id="hasReservation_no_review" value="No">
                                    <label for="hasReservation_no_review" class="mb-0 flex-grow-1">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="reservationDateRow_review">
                            <label for="reservationDate_review" class="form-label">Date of Reservation</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="reservationDate" id="reservationDate_review" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row d-none" id="additionalUnitRow_review">
                            <label for="additionalUnit_review" class="form-label">Additional Unit Currently used for Business</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="additionalUnit" id="additionalUnit_review" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row d-none" id="tamarawSpecificUsageRow_review">
                            <label for="tamarawSpecificUsage_review" class="form-label">Specific Purpose or Usage of Tamaraw</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="tamarawSpecificUsage" id="tamarawSpecificUsage_review" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row d-none" id="buyerDecisionHoldRow_review">
                            <p class="form-label">Buyer's Decision on hold?</p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup">
                                    <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_yes_review" value="Yes">
                                    <label for="buyerDecisionHold_yes_review" class="mb-0 flex-grow-1">Yes</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup">
                                    <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_no_review" value="No">
                                    <label for="buyerDecisionHold_no_review" class="mb-0 flex-grow-1">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="buyerDecisionHoldReasonRow_review">
                            <label for="buyerDecisionHoldReason_review" class="form-label">Reason why the client's buying decision is on hold</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="buyerDecisionHoldReason" id="buyerDecisionHoldReason_review" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Set an Appointment (For the next call)</p>
                            <div class="row d-flex form-group gap-2">
                                <label for="appointmentDate_review">Appintment Date</label>
                                <input type="date" name="appointmentDate" id="appointmentDate_review" class="form-control form-control-sm">
                            </div>
                            <div class="row d-flex form-group gap-2">
                                <label for="appointmentTime_review" class="mb-0 flex-grow-1">Appointment Time</label>
                                <select name="appointmentTime" id="appointmentTime_review" class="form-select form-select-sm">
                                    <option value="" disabled selected>-- Select Time --</option>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="previousBtn_review"><i class="fa-solid fa-backward-step"></i> Previous</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-memo-pad"></i> Save Inquiry</button>
                </div>
            </div>
        </form>
    </div>
</div>