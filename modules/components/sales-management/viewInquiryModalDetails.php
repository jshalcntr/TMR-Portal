<div class="modal fade" id="viewInquiryModalDetails" tabindex="-1" aria-labelledby="viewInquiryModalDetailsLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <form id="viewInquiryModalDetails" class="needs-validation w-100" novalidate>
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="viewInquiryModalDetailsLabel">View Inquiry</h5>
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
                                    <input type="radio" name="prospectType" id="prospectType_hot_view" value="Hot" required readonly>
                                    <label for="prospectType_hot_view" class="mb-0 flex-grow-1">HOT (WITHIN 1 WEEK TO 2 MONTHS)</label>
                                </div>
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup">
                                    <input type="radio" name="prospectType" id="prospectType_warm_view" value="Warm" required readonly>
                                    <label for="prospectType_warm_view" class="mb-0 flex-grow-1">WARM (WITHIN 2 TO 5 MONTHS)</label>
                                </div>
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup">
                                    <input type="radio" name="prospectType" id="prospectType_cold_view" value="Cold" required readonly>
                                    <label for="prospectType_cold_view" class="mb-0 flex-grow-1">COLD (6 MONTHS AND ABOVE)</label>
                                </div>
                                <div class="invalid-feedback">Please select a Prospect Type.</div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Customer Name</p>
                            <div class="row justify-content-center align-items-center">
                                <div class="col form-group">
                                    <label for="customerFirstName_view">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customerFirstName" id="customerFirstName_view" class="form-control form-control-sm" required readonly>
                                    <div class="invalid-feedback">Please provide a valid First Name.</div>
                                </div>
                                <div class="col form-group">
                                    <label for="customerMiddleName_view">Middle Name</label>
                                    <input type="text" name="customerMiddleName" id="customerMiddleName_view" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col form-group">
                                    <label for="customerLastName_view">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customerLastName" id="customerLastName_view" class="form-control form-control-sm" required readonly>
                                    <div class="invalid-feedback">Please provide a valid Last Name.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Client Address <span class="text-danger">*</span></p>
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="province_view" class="mb-0 flex-grow-1">Province <span class="text-danger">*</span></label>
                                    <select name="province" id="province_view" class="form-select form-select-sm" required disabled>
                                        <!-- Populated dynamically -->
                                    </select>
                                    <div class="invalid-feedback">Please select a Province.</div>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="municipality_view" class="mb-0 flex-grow-1">Municipality <span class="text-danger">*</span></label>
                                    <select name="municipality" id="municipality_view" class="form-select form-select-sm" disabled required>
                                        <!-- Populated dynamically -->
                                    </select>
                                    <div class="invalid-feedback">Please select a Municipality.</div>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="barangay_view" class="mb-0 flex-grow-1">Barangay <span class="text-danger">*</span></label>
                                    <select name="barangay" id="barangay_view" class="form-select form-select-sm" disabled required>
                                        <!-- Populated dynamically -->
                                    </select>
                                    <div class="invalid-feedback">Please select a Barangay.</div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <label for="street_view" class="mb-0 flex-grow-1">Street Address</label>
                                <input type="text" name="street" id="street_view" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row justify-content-center align-items-center">
                                <label for="contactNumber_view" class="form-label">Client Contact Number <span class="text-danger">*</span></label>
                                <input
                                    type="tel"
                                    name="contactNumber"
                                    id="contactNumber_view"
                                    class="form-control form-control-sm"
                                    required
                                    pattern="^(09\d{9}|\+639\d{9})$"
                                    placeholder="Enter a valid Philippine mobile number (e.g., 09XXXXXXXXX or +639XXXXXXXXX)"
                                    readonly>
                                <div class="invalid-feedback">Please provide a valid Contact Number.</div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Client Gender <span class="text-danger">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup">
                                    <input type="radio" name="gender" id="gender_male_view" value="Male" disabled>
                                    <label for="gender_male_view" class="mb-0 flex-grow-1">Male</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup">
                                    <input type="radio" name="gender" id="gender_female_view" value="Female" disabled>
                                    <label for="gender_female_view" class="mb-0 flex-grow-1">Female</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup">
                                    <input type="radio" name="gender" id="gender_lgbt_view" value="LGBT" disabled>
                                    <label for="gender_lgbt_view" class="mb-0 flex-grow-1">LGBT</label>
                                </div>
                                <div class="invalid-feedback">Please select a Gender.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="maritalStatus_view" class="form-label">Marital Status <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select class="form-select form-select-sm" name="maritalStatus" id="maritalStatus_view" disabled>
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
                            <div class="row d-flex form-group gap-1" id="maritalStatusOthersGroup">
                                <label for="maritalStatusOtherInput_view" class="form-label">Please Specify <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="maritalStatusOtherInput"
                                    name="maritalStatusOther_view"
                                    class="form-control form-control-sm"
                                    readonly>
                                <div class="invalid-feedback">Please specify your marital status.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="birthday_view" class="form-label">Date of Birth</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="birthday" id="birthday_view" class="form-control form-control-sm" readonly>
                                <div class="invalid-feedback">Please provide a valid Date of Birth.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="occupation_view" class="form-label">Occupation</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="occupation" id="occupation_view" class="form-select form-select-sm" disabled>
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
                            <label for="businessName_view" class="form-label" id="occupationHeaderOne">Business Name</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="businessName" id="businessName_view" class="form-control form-control-sm" readonly>
                                <div class="invalid-feedback" id="occupationFeedback">Please provide a valid Business Name.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="businessAddress_view" class="form-label">Business Address</label>
                            <div class="row d-flex form-group gap-2">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationProvince_view" class="mb-0 flex-grow-1">Province <span class="text-danger">*</span></label>
                                    <select name="occupationProvince" id="occupationProvince_view" class="form-select form-select-sm" disabled required>
                                        <!-- Populated dynamically -->
                                    </select>
                                    <div class="invalid-feedback">Please select a Province.</div>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationMunicipality_view" class="mb-0 flex-grow-1">Municipality <span class="text-danger">*</span></label>
                                    <select name="occupationMunicipality" id="occupationMunicipality_view" class="form-select form-select-sm" disabled required>
                                        <!-- Populated dynamically -->
                                    </select>
                                    <div class="invalid-feedback">Please select a Municipality.</div>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationBarangay_view" class="mb-0 flex-grow-1">Barangay <span class="text-danger">*</span></label>
                                    <select name="occupationBarangay" id="occupationBarangay_view" class="form-select form-select-sm" disabled required>
                                        <!-- Populated dynamically -->
                                    </select>
                                    <div class="invalid-feedback">Please select a Barangay.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="businessCategory_view" class="form-label">Business Category</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="businessCategory" id="businessCategory_view" class="form-select form-select-sm" disabled>
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
                        <div class="row">
                            <label for="businessSize_view" class="form-label">Business Size</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="businessSize" id="businessSize_view" class="form-select form-select-sm" disabled>
                                    <option value="Micro">Micro (1-9 Employees)</option>
                                    <option value="Small">Small (10-99 Employees)</option>
                                    <option value="Medium">Medium (100-199 Employees)</option>
                                    <option value="Large">Large (200 & Above Employees)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="monthlyAverage_view" class="form-label">Monthly Average</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="monthlyAverage" id="monthlyAverage_view" class="form-select form-select-sm" disabled>
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
                            <label for="inquiryDate_view" class="form-label">Date of Inquiry <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="inquiryDate" id="inquiryDate_view" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label for="inquirySource_view" class="form-label">Source of Inquiry <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySource" id="inquirySource_view" class="form-select form-select-sm" disabled>
                                    <option value="Face To Face">Face To Face</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="f2fSource_view" class="form-label">Face To Face Inquiry Source <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySourceType" id="f2fSource_view" class="form-select form-select-sm" disabled>
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
                        <div class="row">
                            <label for="onlineSource_view" class="form-label">Online Inquiry Source <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySourceType" id="onlineSource_view" class="form-select form-select-sm" disabled>
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
                        <div class="row">
                            <label for="mallDisplay_view" class="form-label">Mall Display <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="mallDisplay" id="mallDisplay_view" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Buyer Type <span class="text-danger">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                    <input type="radio" name="buyerType" id="buyerType_first_view" value="First-Time" disabled>
                                    <label for="buyerType_first_view" class="mb-0 flex-grow-1">First-Time</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                    <input type="radio" name="buyerType" id="buyerType_replacement_view" value="Replacement" disabled>
                                    <label for="buyerType_replacement_view" class="mb-0 flex-grow-1">Replacement</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup">
                                    <input type="radio" name="buyerType" id="buyerType_additional_view" value="Additional" disabled>
                                    <label for="buyerType_additional_view" class="mb-0 flex-grow-1">Additional</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="unitInquired_view" class="form-label">Unit Inquired <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="unitInquired" id="unitInquired_view" class="form-select form-select-sm" disabled required>
                                    <!-- Populated dynamically -->
                                </select>
                                <div class="invalid-feedback">Please provide a valid Unit Inquired.</div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="tamarawVariant_view" class="form-label">Tamaraw Variant</label>
                            <div class="row d-flex form-group gap-2">
                                <select name="tamarawVariant" id="tamarawVariant_view" class="form-select form-select-sm" disabled>
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
                            <label for="transactionType_view" class="form-label">Transaction Type</label>
                            <div class="row d-flex gap-2">
                                <select name="transactionType" id="transactionType_view" class="form-select form-select-sm" disabled>
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
                                    <input type="radio" name="hasApplication" id="hasApplication_yes_view" value="Yes" disabled>
                                    <label for="hasApplication_yes_view" class="mb-0 flex-grow-1">Yes</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup">
                                    <input type="radio" name="hasApplication" id="hasApplication_no_view" value="No" disabled>
                                    <label for="hasApplication_no_view" class="mb-0 flex-grow-1">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">With Reservation</p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasReservationRadioGroup">
                                    <input type="radio" name="hasReservation" id="hasReservation_yes_view" value="Yes" disabled>
                                    <label for="hasReservation_yes_view" class="mb-0 flex-grow-1">Yes</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasReservationRadioGroup">
                                    <input type="radio" name="hasReservation" id="hasReservation_no_view" value="No" disabled>
                                    <label for="hasReservation_no_view" class="mb-0 flex-grow-1">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="reservationDate_view" class="form-label">Date of Reservation</label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="reservationDate" id="reservationDate_view" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Buyer's Decision on hold?</p>
                            <div class="d-flex gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup">
                                    <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_yes_view" value="Yes" disabled>
                                    <label for="buyerDecisionHold_yes_view" class="mb-0 flex-grow-1">Yes</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup">
                                    <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_no_view" value="No" disabled>
                                    <label for="buyerDecisionHold_no_view" class="mb-0 flex-grow-1">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="buyerDecisionHoldReason_view" class="form-label">Reason why the client's buying decision is on hold</label>
                            <div class="d-flex gap-2">
                                <input type="text" name="buyerDecisionHoldReason" id="buyerDecisionHoldReason_view" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Set an Appointment (For the next call)</p>
                            <div class="d-flex gap-2">
                                <label for="appointmentDate_view">Appointment Date</label>
                                <input type="date" name="appointmentDate" id="appointmentDate_view" class="form-control form-control-sm" readonly>
                            </div>
                            <div class="d-flex gap-2">
                                <label for="appointmentTime_view" class="mb-0 flex-grow-1">Appointment Time</label>
                                <select name="appointmentTime" id="appointmentTime_view" class="form-select form-select-sm" disabled>
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
                    <div class="row action-row">
                        <div class="col d-flex justify-content-end align-items-end action-column" id="viewActionsRow">
                            <button type="button" class="btn btn-sm shadow-sm btn-primary" id="editButton">
                                <i class="fas fa-pencil"></i> Edit
                            </button>
                        </div>
                        <div class="col d-none justify-content-end align-items-end action-column gap-2" id="editActionsRow">
                            <button type="button" class="btn btn-sm shadow-sm btn-danger" id="cancelButton">
                                <i class="fas fa-ban"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-sm shadow-sm btn-primary" id="saveButton">
                                <i class="fa-regular fa-floppy-disk"></i> Save
                            </button>
                        </div>
                    </div>
                </div>

                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-backward-step"></i> Previous</button>
                    <button type="submit" class="btn btn-primary" disabled><i class="fa-solid fa-memo-pad"></i> Save Inquiry</button>
                </div> -->
            </div>
        </form>
    </div>
</div>