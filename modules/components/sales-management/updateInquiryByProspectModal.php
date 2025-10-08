<div class="modal fade" id="updateInquiryByProspectModal" tabindex="-1" aria-labelledby="updateInquiryByProspectModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <form id="updateInquiryByProspectForm" class="needs-validation w-100" novalidate>
            <div class="modal-content">
                <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="updateInquiryByProspectModalLabel">Update Inquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row modal-body custom-scrollable-body">
                    <div class="col">
                        <div class="row">
                            <h3 class="text-center">Customer Details</h3>
                        </div>
                        <div class="row">
                            <p class="mb-0">Current Prospect Type:</p>
                            <div id="currentProspectTypeRow_byProspect" class="row">
                                <h4 class="col">
                                    <i class="fa-solid fa-snowflake" id="currentProspectTypeIcon_byProspect"></i>
                                    <span id="currentProspectType_byProspect"></span>
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">New Prospect Type <span class="text-danger">*</span></p>
                            <div class="row justify-content-center align-items-center">
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup_updateBP">
                                    <input type="radio" name="prospectType" id="prospectType_hot_updateBP" value="HOT">
                                    <label for="prospectType_hot_updateBP" class="mb-0 flex-grow-1">HOT</label>
                                </div>
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup_updateBP">
                                    <input type="radio" name="prospectType" id="prospectType_warm_updateBP" value="WARM">
                                    <label for="prospectType_warm_updateBP" class="mb-0 flex-grow-1">WARM</label>
                                </div>
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup_updateBP">
                                    <input type="radio" name="prospectType" id="prospectType_cold_updateBP" value="COLD">
                                    <label for="prospectType_cold_updateBP" class="mb-0 flex-grow-1">COLD</label>
                                </div>
                                <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup_updateBP">
                                    <input type="radio" name="prospectType" id="prospectType_lost_updateBP" value="LOST">
                                    <label for="prospectType_lost_updateBP" class="mb-0 flex-grow-1">LOST</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Customer Name</p>
                            <div class="row justify-content-center align-items-center">
                                <div class="col form-group">
                                    <label for="customerFirstName_updateBP">First Name <span class="text-danger" id="customerFirstNameRequired_updateBP">*</span></label>
                                    <input type="text" name="customerFirstName" id="customerFirstName_updateBP" class="form-control form-control-sm" required>
                                </div>
                                <div class="col form-group">
                                    <label for="customerMiddleName_updateBP">Middle Name</label>
                                    <input type="text" name="customerMiddleName" id="customerMiddleName_updateBP" class="form-control form-control-sm">
                                </div>
                                <div class="col form-group">
                                    <label for="customerLastName_updateBP">Last Name <span class="text-danger" id="customerLastNameRequired_updateBP">*</span></label>
                                    <input type="text" name="customerLastName" id="customerLastName_updateBP" class="form-control form-control-sm" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Client Address <span class="text-danger">*</span></p>
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="province_updateBP" class="mb-0 flex-grow-1">Province <span class="text-danger">*</span></label>
                                    <select name="province" id="province_updateBP" class="form-select form-select-sm" required></select>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="municipality_updateBP" class="mb-0 flex-grow-1">Municipality <span class="text-danger">*</span></label>
                                    <select name="municipality" id="municipality_updateBP" class="form-select form-select-sm" disabled required></select>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="barangay_updateBP" class="mb-0 flex-grow-1">Barangay <span class="text-danger">*</span></label>
                                    <select name="barangay" id="barangay_updateBP" class="form-select form-select-sm" disabled required></select>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <label for="street_updateBP" class="mb-0 flex-grow-1">Street Address</label>
                                <input type="text" name="street" id="street_updateBP" class="form-control form-control-sm">
                                </input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row justify-content-center align-items-center">
                                <label for="contactNumber_updateBP" class="form-label">Client Contact Number <span class="text-danger">*</span></label>
                                <input
                                    type="tel"
                                    name="contactNumber"
                                    id="contactNumber_updateBP"
                                    class="form-control form-control-sm"
                                    required
                                    pattern="^(09\d{9}|\+639\d{9})$"
                                    placeholder="Enter a valid Philippine mobile number (e.g., 09XXXXXXXXX or +639XXXXXXXXX)">
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Client Gender <span class="text-danger">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup_updateBP">
                                    <input type="radio" name="gender" id="gender_male_updateBP" value="MALE">
                                    <label for="gender_male_updateBP" class="mb-0 flex-grow-1">MALE</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup_updateBP">
                                    <input type="radio" name="gender" id="gender_female_updateBP" value="FEMALE">
                                    <label for="gender_female_updateBP" class="mb-0 flex-grow-1">FEMALE</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup_updateBP">
                                    <input type="radio" name="gender" id="gender_lgbt_updateBP" value="LGBTQ+">
                                    <label for="gender_lgbt_updateBP" class="mb-0 flex-grow-1">LGBTQ+</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="maritalStatus_updateBP" class="form-label">Marital Status <span class="text-danger" id="maritalStatusRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select class="form-select form-select-sm" name="maritalStatus" id="maritalStatus_updateBP" required>
                                    <option selected disabled value="" hidden>--Select Marital Status--</option>
                                    <option value="SINGLE">SINGLE</option>
                                    <option value="MARRIED">MARRIED</option>
                                    <option value="DIVORCED">DIVORCED</option>
                                    <option value="SEPARATED">SEPARATED</option>
                                    <option value="WIDOWED">WIDOWED</option>
                                    <option value="ANNULED">ANNULED</option>
                                    <option value="OTHERS">OTHERS</option>
                                </select>
                            </div>
                            <div class="row d-none form-group gap-1" id="maritalStatusOthersRow_updateBP">
                                <label for="maritalStatusOtherInput_updateBP" class="form-label">Please Specify <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="maritalStatusOtherInput_updateBP"
                                    name="maritalStatus"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <label for="birthday_updateBP" class="form-label">Date of Birth <span class="text-danger" id="birthdayRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="birthday" id="birthday_updateBP" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row">
                            <label for="occupation_updateBP" class="form-label">Occupation <span class="text-danger" id="occupationRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="occupation" id="occupation_updateBP" class="form-select form-select-sm" required>
                                    <option selected disabled value="" hidden>--Select Occupation--</option>
                                    <option value="BUSINESS OWNER">BUSINESS OWNER</option>
                                    <option value="EMPLOYED">EMPLOYED</option>
                                    <option value="OFW/SEAMAN">OFW/SEAMAN</option>
                                    <option value="PENSIONER">PENSIONER</option>
                                    <option value="UNEMPLOYED/REMITTANCE RECEIVER">UNEMPLOYED/REMITTANCE RECEIVER</option>
                                    <option value="FREELANCER">FREELANCER</option>
                                    <option value="FAMILY SUPPORT/GIFT/DONATION">FAMILY SUPPORT/GIFT/DONATION</option>
                                    <option value="TNVS (GRAB, LALAMOVE, JOYRIDE, ETC.)">TNVS (GRAB, LALAMOVE, JOYRIDE, ETC.)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="businessNameRow_updateBP">
                            <label for="businessName_updateBP" class="form-label"><span class="occupationLabel_updateBP">Occupation</span> Name <span class="text-danger" id="businessNameRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="businessName" id="businessName_updateBP" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row d-none" id="businessAddressRow_updateBP">
                            <label for="businessAddress_updateBP" class="form-label"><span class="occupationLabel_updateBP">Occupation</span> Address <span class="text-danger" id="businessAddressRequired_updateBP">*</span></label>
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationProvince_updateBP" class="mb-0 flex-grow-1">Province <span class="text-danger" id="occupationProvinceRequired_updateBP">*</span></label>
                                    <select name="occupationProvince" id="occupationProvince_updateBP" class="form-select form-select-sm" required></select>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationMunicipality_updateBP" class="mb-0 flex-grow-1">Municipality <span class="text-danger" id="occupationMunicipalityRequired_updateBP">*</span></label>
                                    <select name="occupationMunicipality" id="occupationMunicipality_updateBP" class="form-select form-select-sm" disabled required></select>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="occupationBarangay_updateBP" class="mb-0 flex-grow-1">Barangay <span class="text-danger" id="occupationBarangayRequired_updateBP">*</span></label>
                                    <select name="occupationBarangay" id="occupationBarangay_updateBP" class="form-select form-select-sm" disabled required></select>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <label for="occupationStreet_updateBP" class="mb-0 flex-grow-1">Street Address</label>
                                <input type="text" name="occupationStreet" id="occupationStreet_updateBP" class="form-control form-control-sm">
                                </input>
                            </div>
                        </div>
                        <div class="row d-none" id="businessCategoryRow_updateBP">
                            <label for="businessCategory_updateBP" class="form-label">Business Category <span class="text-danger" id="businessCategoryRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="businessCategory" id="businessCategory_updateBP" class="form-select form-select-sm">
                                    <option selected disabled value="" hidden>--Select Business Category--</option>
                                    <option value="AGRICULTURE">AGRICULTURE (POULTRY RAISING, HOG RAISING, VEGETABLE FARMING, DAIRY FARMING, RICE CULTIVATION, AND AQUACULTURE, ETC.)</option>
                                    <option value="BPO">BPO (CONCENTRIX PHIL., TELEPERFORMANCE PHILS., ACCENTURE, ETC.)</option>
                                    <option value="CLINIC">CLINIC (MyHEALTH CLINIC, DERMATOLOGY, DENTAL CLINIC, OB-GYN, PEDIATRICS, ETC.)</option>
                                    <option value="CONSTRUCTION">CONSTRUCTION (DMCI, MEGAWIDE CONSTRUCTION CORPORATION, WILCON DEPOT, HOLCIM PHILS., CONTRACTOR, ARCHITECT, ENGINEER, DPWH, ETC.)</option>
                                    <option value="ENTERPRISE">ENTERPRISE (OWNER OF SAN MIGUEL CORP., AYALA CORP., SM INVESTMENTS CORP., PLDT/SMART COMMUNICATIONS, METRO OIL PHILS., ETC.)</option>
                                    <option value="E-COMMERCE">E-COMMERCE (ONLINE SELLING, SHOPEE, LAZADA, WALTERMART DELIVERY, ETC.)</option>
                                    <option value="FOOD SERVICES">FOOD SERVICES (FAST FOOD CHAIN, RESTAURANT, COFFEE SHOP, CATERING, FOOD VENDORS, ETC.)</option>
                                    <option value="GENERAL MERCHANDISE">GENERAL MERCHANDISE (HOUSEHOLD GOODS, CLOTHING, BASIC ELECTRONICS, TOILETRIES, SCHOOL SUPPLIES, SMALL TOOLS AND SOMETIMES SNACK OR GROCERIES ETC.)</option>
                                    <option value="GENERAL SERVICES">GENERAL SERVICES (JANITORIAL AND CLEANING SERVICES, PEST CONTROL, APPLIANCE REPAIR, SECURE AND MANPOWER SERVICES, ETC.)</option>
                                    <option value="GOVERNMENT">GOVERNMENT (LGU, GOVERNMENT AGENCIES, LTO, COMELEC, PNP, AFP, TEACHER, ETC.)</option>
                                    <option value="HOSPITALITY/TOURISM/TRAVEL">HOSPITALITY/TOURISM/TRAVEL (HOTEL, RESORT, AIRBNB, WELLNESS, TRAVEL AGENCIES, ETC.)</option>
                                    <option value="LANDSCAPING">LANDSCAPING (OFFERS GARDEN DESIGN, ETC.)</option>
                                    <option value="LOGISTIC">LOGISTIC (LBC, 2GO, TRANSFORTIFY, FOOD PANDA, JT EXPRESS, CARGO, ETC.)</option>
                                    <option value="MANUFACTURING">MANUFACTURING (FOOD AND BEVERAGE PRODUCTION, SAN MIGUEL CORPORATION, TOYOTA MOTOR PHILS., ETC.)</option>
                                    <option value="PHARMA/HEALTHCARE">PHARMA/HEALTHCAARE (UNILAB, MERCURY DRUG CORP., RITEMED, PFIZER, FDA PHILIPS., DOH, ETC.)</option>
                                    <option value="RENTAL">RENTAL (APARTMENT, COMMERCIAL SPACES, VEHICLE, CHAIRS AND TABLES, SOUND SYSTEM, CONCRETE MIXERS, ETC.)</option>
                                    <option value="RETAILS SHOP">RETAILS SHOP (GOODS, CLOTHING, ACCESSORIES, DRY GOODS, COSMETICS, SCHOOL AND OFFICE SUPPLIES, ETC.)</option>
                                    <option value="IT/TECHNOLOGY">IT/TECHNOLOGY (ACCENTURE PHILS., POINTWEST TECHONOLOGIES, IMB PHILS., SOFTWARE ETC.)</option>
                                    <option value="TRADING">TRADING (A TRADING BUSNESS BUYS PRODUCTS AND RESELLS THEM AT A PROFIT ETIHTER LOCALLY OR INTERNATIONALLY)</option>
                                    <option value="TRANSPORTATION">TRANSPORTATION (PASSENGER TRANSPORT, CARGO & LOGISTICS TRANSPORT SHUTTLE, SEA, ETC.)</option>
                                    <option value="TRUCKING">TRUCKING (A TRUCKING BUSINESS PROVIDES TRANSPORTAIONG OF GOODS USING TRUCKS)</option>
                                    <option value="UTILITIES">UTILITIES (WATER, ELECTRICAL, CABLE, WI-FI)</option>
                                    <option value="WHOLESALE">WHOLESALE (A WHOLESALE BUSINESS BUYS PRODUCTS IN A LARGE QUANTITIES FROM MANUFACTURERS OR SUPPLIERS AND RESELLS THEM IN BULK, NOT INDIVIDUALLY)</option>
                                    <option value="WHOLESALE/RETAIL">WHOLESALE/RETAIL (A WHOLESALE AND RETAIL BUSINESS OPERATES ON TWO LEVELS: WHOLESALE & RETAIL)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="businessSizeRow_updateBP">
                            <label for="businessSize_updateBP" class="form-label">Business Size <span class="text-danger" id="businessSizeRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="businessSize" id="businessSize_updateBP" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Business Size--</option>
                                    <option value="MICRO">MICRO (1-9 EMPLOYEES)</option>
                                    <option value="SMALL">SMALL (10-99 EMPLOYEES)</option>
                                    <option value="MEDIUM">MEDIUM (100-199 EMPLOYEES)</option>
                                    <option value="LARGE">LARGE (200 & Above EMPLOYEES)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="monthlyAverage_updateBP" class="form-label">Monthly Average <span class="text-danger" id="monthlyAverageRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="monthlyAverage" id="monthlyAverage_updateBP" class="form-select form-select-sm" required>
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
                            <label for="inquiryDate_updateBP" class="form-label">Date of Inquiry <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="inquiryDate" id="inquiryDate_updateBP" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row">
                            <label for="inquirySource_updateBP" class="form-label">Source of Inquiry <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySource" id="inquirySource_updateBP" class="form-select form-select-sm" required>
                                    <option value="" hidden selected disabled>--Select Source--</option>
                                    <option value="FACE TO FACE">FACE TO FACE</option>
                                    <option value="ONLINE">ONLINE</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="f2fSourceRow_updateBP">
                            <label for="f2fSource_updateBP" class="form-label">Face To Face Inquiry Source <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySourceType" id="f2fSource_updateBP" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Source--</option>
                                    <option value="SHOWROOM WALK-IN">SHOWROOM WALK-IN</option>
                                    <option value="MALL DISPLAY">MALL DISPLAY</option>
                                    <option value="SATURATION">SATURATION</option>
                                    <option value="BANK DISPLAY">BANK DISPLAY</option>
                                    <option value="REPEAT">REPEAT</option>
                                    <option value="PHONE-IN">PHONE-IN</option>
                                    <option value="ATTACK LIST (UIO)">ATTACK LIST (UIO)</option>
                                    <option value="GOYOKIKI">GOYOKIKI</option>
                                    <option value="CLIENT FROM SERVICE/PARTS/INSURANCE">CLIENT FROM SERVICE/PARTS/INSURANCE</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="onlineSourceRow_updateBP">
                            <label for="onlineSource_updateBP" class="form-label">Online Inquiry Source <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="inquirySourceType" id="onlineSource_updateBP" class="form-select form-select-sm">
                                    <option value="" hidden selected disabled>--Select Source--</option>
                                    <option value="TMR FB PAGE (TOYOTA MARILAO BULACAN INC.)">TMR FB PAGE (TOYOTA MARILAO BULACAN INC.)</option>
                                    <option value="MP FB PAGE (MP-TOYOTA MARILAO)">MP FB PAGE (MP-TOYOTA MARILAO)</option>
                                    <option value="GROUP FB PAGE (GRM-TOYOTA MARILAO)">GROUP FB PAGE (GRM-TOYOTA MARILAO)</option>
                                    <option value="PERSONAL FACEBOOK">PERSONAL FACEBOOK</option>
                                    <option value="TIKTOK">TIKTOK</option>
                                    <option value="INSTAGRAM">INSTAGRAM</option>
                                    <option value="YOUTUBE">YOUTUBE</option>
                                    <option value="PHILGEPS">PHILGEPS</option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="mallDisplayRow_updateBP">
                            <label for="mallDisplay_updateBP" class="form-label">Mall Display <span class="text-danger">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="mallDisplay" id="mallDisplay_updateBP" class="form-select form-select-sm">

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Buyer Type <span class="text-danger" id="buyerTypeRequired_updateBP">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup_updateBP">
                                    <input type="radio" name="buyerType" id="buyerType_first_updateBP" value="FIRST-TIME">
                                    <label for="buyerType_first_updateBP" class="mb-0 flex-grow-1">FIRST-TIME</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup_updateBP">
                                    <input type="radio" name="buyerType" id="buyerType_replacement_updateBP" value="REPLACEMENT">
                                    <label for="buyerType_replacement_updateBP" class="mb-0 flex-grow-1">REPLACEMENT</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup_updateBP">
                                    <input type="radio" name="buyerType" id="buyerType_additional_updateBP" value="ADDITIONAL">
                                    <label for="buyerType_additional_updateBP" class="mb-0 flex-grow-1">ADDITIONAL</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="unitInquired_updateBP" class="form-label">Unit Inquired <span class="text-danger" id="unitInquiredRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="unitInquired" id="unitInquired_updateBP" class=" form-select form-select-sm" required></select>
                            </div>
                        </div>
                        <div class="row d-none" id="tamarawVariantRow_updateBP">
                            <label for="tamarawVariant_updateBP" class="form-label">Tamaraw Variant <span class="text-danger" id="tamarawVariantRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <select name="tamarawVariant" id="tamarawVariant_updateBP" class="form-select form-select-sm">
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
                            <label for="transactionType_updateBP" class="form-label">Trasnsaction Type <span class="text-danger" id="transactionTypeRequired_updateBP">*</span></label>
                            <div class="row d-flex gap-2">
                                <select name="transactionType" id="transactionType_updateBP" class="form-select form-select-sm" required>
                                    <option value="" hidden selected disabled>--Select Transaction Type--</option>
                                    <option value="FINANCING">FINANCING</option>
                                    <option value="BANK PO">BANK PO</option>
                                    <option value="CASH">CASH</option>
                                    <option value="COMPANY PO">COMPANY PO</option>
                                    <option value="GOVERNMENT PO">GOVERNMENT PO</option>
                                    <option value="KINTO">KINTO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">With Application <span class="text-danger" id="hasApplicationRequired_updateBP">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup_updateBP">
                                    <input type="radio" name="hasApplication" id="hasApplication_yes_updateBP" value="YES">
                                    <label for="hasApplication_yes_updateBP" class="mb-0 flex-grow-1">YES</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup_updateBP">
                                    <input type="radio" name="hasApplication" id="hasApplication_no_updateBP" value="NO">
                                    <label for="hasApplication_no_updateBP" class="mb-0 flex-grow-1">NO</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">With Reservation <span class="text-danger" id="hasReservationRequired_updateBP">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasReservationRadioGroup_updateBP">
                                    <input type="radio" name="hasReservation" id="hasReservation_yes_updateBP" value="YES">
                                    <label for="hasReservation_yes_updateBP" class="mb-0 flex-grow-1">YES</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasReservationRadioGroup_updateBP">
                                    <input type="radio" name="hasReservation" id="hasReservation_no_updateBP" value="NO">
                                    <label for="hasReservation_no_updateBP" class="mb-0 flex-grow-1">NO</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="reservationDateRow_updateBP">
                            <label for="reservationDate_updateBP" class="form-label">Date of Reservation <span class="text-danger" id="reservationDateRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="date" name="reservationDate" id="reservationDate_updateBP" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row d-none" id="additionalUnitRow_updateBP">
                            <label for="additionalUnit_updateBP" class="form-label">Additional Unit Currently used for Business <span class="text-danger" id="additionalUnitRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="additionalUnit" id="additionalUnit_updateBP" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row d-none" id="tamarawSpecificUsageRow_updateBP">
                            <label for="tamarawSpecificUsage_updateBP" class="form-label">Specific Purpose or Usage of Tamaraw <span class="text-danger" id="tamarawSpecificUsageRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="tamarawSpecificUsage" id="tamarawSpecificUsage_updateBP" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row d-none" id="buyerDecisionHoldRow_updateBP">
                            <p class="form-label">Buyer's Decision on hold? <span class="text-danger" id="buyerDecisionHoldRequired_updateBP">*</span></p>
                            <div class="row d-flex form-group gap-2">
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup_updateBP">
                                    <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_yes_updateBP" value="YES">
                                    <label for="buyerDecisionHold_yes_updateBP" class="mb-0 flex-grow-1">YES</label>
                                </div>
                                <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup_updateBP">
                                    <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_no_updateBP" value="NO">
                                    <label for="buyerDecisionHold_no_updateBP" class="mb-0 flex-grow-1">NO</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="buyerDecisionHoldReasonRow_updateBP">
                            <label for="buyerDecisionHoldReason_updateBP" class="form-label">Reason why the client's buying decision is on hold <span class="text-danger" id="buyerDecisionHoldReasonRequired_updateBP">*</span></label>
                            <div class="row d-flex form-group gap-2">
                                <input type="text" name="buyerDecisionHoldReason" id="buyerDecisionHoldReason_updateBP" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <p class="form-label">Set an Appointment (For the next call)</p>
                            <div class="row d-flex form-group gap-2">
                                <label for="appointmentDate_updateBP">New Appintment Date <span class="text-danger" id="appointmentDateRequired_updateBP">*</span></label>
                                <input type="date" name="appointmentDate" id="appointmentDate_updateBP" class="form-control form-control-sm" required>
                            </div>
                            <div class="row d-flex form-group gap-2">
                                <label for="appointmentTime_updateBP" class="mb-0 flex-grow-1">New Appointment Time <span class="text-danger" id="appointmentTimeRequired_updateBP">*</span></label>
                                <select name="appointmentTime" id="appointmentTime_updateBP" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>--Select Time--</option>
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
                <input type="hidden" name="inquiryId" id="inquiryId_updateBP">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-memo-circle-check"></i> Save Inquiry</button>
                </div>
            </div>
        </form>
    </div>
</div>