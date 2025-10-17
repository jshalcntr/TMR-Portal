<div class="modal fade" id="updateInquiryNotificationModal" tabindex="-1" aria-labelledby="updateInquiryNotificationModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <form id="updateInquiryNotificationForm" class="needs-validation w-100" novalidate>
            <div class="modal-content">
                <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="updateInquiryNotificationModalLabel">Update Inquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row modal-body custom-scrollable-body">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <h3 class="text-center">Customer Details</h3>
                            </div>
                            <div class="row">
                                <p class="mb-0">Current Prospect Type:</p>
                                <div id="currentProspectTypeRow_notification" class="row">
                                    <h4 class="col">
                                        <i class="fa-solid fa-snowflake" id="currentProspectTypeIcon_notification"></i>
                                        <span id="currentProspectType_notification"></span>
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <p class="form-label">New Prospect Type <span class="text-danger">*</span></p>
                                <div class="row justify-content-center align-items-center">
                                    <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup_updateN">
                                        <input type="radio" name="prospectType" id="prospectType_hot_updateN" value="HOT">
                                        <label for="prospectType_hot_updateN" class="mb-0 flex-grow-1">HOT</label>
                                    </div>
                                    <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup_updateN">
                                        <input type="radio" name="prospectType" id="prospectType_warm_updateN" value="WARM">
                                        <label for="prospectType_warm_updateN" class="mb-0 flex-grow-1">WARM</label>
                                    </div>
                                    <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup_updateN">
                                        <input type="radio" name="prospectType" id="prospectType_cold_updateN" value="COLD">
                                        <label for="prospectType_cold_updateN" class="mb-0 flex-grow-1">COLD</label>
                                    </div>
                                    <div class="justify-content-center align-items-center radio-column mb-2 py-1 d-flex gap-2 prospectRadioGroup_updateN">
                                        <input type="radio" name="prospectType" id="prospectType_lost_updateN" value="LOST">
                                        <label for="prospectType_lost_updateN" class="mb-0 flex-grow-1">LOST</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="form-label">Customer Name</p>
                                <div class="row justify-content-center align-items-center">
                                    <div class="col form-group">
                                        <label for="customerFirstName_updateN">First Name <span class="text-danger" id="customerFirstNameRequired_updateN">*</span></label>
                                        <input type="text" name="customerFirstName" id="customerFirstName_updateN" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col form-group">
                                        <label for="customerMiddleName_updateN">Middle Name</label>
                                        <input type="text" name="customerMiddleName" id="customerMiddleName_updateN" class="form-control form-control-sm">
                                    </div>
                                    <div class="col form-group">
                                        <label for="customerLastName_updateN">Last Name <span class="text-danger" id="customerLastNameRequired_updateN">*</span></label>
                                        <input type="text" name="customerLastName" id="customerLastName_updateN" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="form-label">Client Address <span class="text-danger">*</span></p>
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col-12 col-md-4 form-group">
                                        <label for="province_updateN" class="mb-0 flex-grow-1">Province <span class="text-danger">*</span></label>
                                        <select name="province" id="province_updateN" class="form-select form-select-sm" required></select>
                                    </div>
                                    <div class="col-12 col-md-4 form-group">
                                        <label for="municipality_updateN" class="mb-0 flex-grow-1">Municipality <span class="text-danger">*</span></label>
                                        <select name="municipality" id="municipality_updateN" class="form-select form-select-sm" disabled required></select>
                                    </div>
                                    <div class="col-12 col-md-4 form-group">
                                        <label for="barangay_updateN" class="mb-0 flex-grow-1">Barangay <span class="text-danger">*</span></label>
                                        <select name="barangay" id="barangay_updateN" class="form-select form-select-sm" disabled required></select>
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center">
                                    <label for="street_updateN" class="mb-0 flex-grow-1">Street Address</label>
                                    <input type="text" name="street" id="street_updateN" class="form-control form-control-sm">
                                    </input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row justify-content-center align-items-center">
                                    <label for="contactNumber_updateN" class="form-label">Client Contact Number <span class="text-danger">*</span></label>
                                    <input
                                        type="tel"
                                        name="contactNumber"
                                        id="contactNumber_updateN"
                                        class="form-control form-control-sm"
                                        required
                                        pattern="^(09\d{9}|\+639\d{9})$"
                                        placeholder="Enter a valid Philippine mobile number (e.g., 09XXXXXXXXX or +639XXXXXXXXX)">
                                </div>
                            </div>
                            <div class="row">
                                <p class="form-label">Client Gender <span class="text-danger">*</span></p>
                                <div class="row d-flex form-group gap-2">
                                    <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup_updateN">
                                        <input type="radio" name="gender" id="gender_male_updateN" value="MALE">
                                        <label for="gender_male_updateN" class="mb-0 flex-grow-1">MALE</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup_updateN">
                                        <input type="radio" name="gender" id="gender_female_updateN" value="FEMALE">
                                        <label for="gender_female_updateN" class="mb-0 flex-grow-1">FEMALE</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column py-1 d-flex gap-2 genderRadioGroup_updateN">
                                        <input type="radio" name="gender" id="gender_lgbt_updateN" value="LGBTQ+">
                                        <label for="gender_lgbt_updateN" class="mb-0 flex-grow-1">LGBTQ+</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="maritalStatus_updateN" class="form-label">Marital Status <span class="text-danger" id="maritalStatusRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select class="form-select form-select-sm" name="maritalStatus" id="maritalStatus_updateN" required>
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
                                <div class="row d-none form-group gap-1" id="maritalStatusOthersRow_updateN">
                                    <label for="maritalStatusOtherInput_updateN" class="form-label">Please Specify <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="maritalStatusOtherInput_updateN"
                                        name="maritalStatus"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <label for="birthday_updateN" class="form-label">Date of Birth</label>
                                <div class="row d-flex form-group gap-2">
                                    <input type="date" name="birthday" id="birthday_updateN" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <label for="occupation_updateN" class="form-label">Occupation <span class="text-danger" id="occupationRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="occupation" id="occupation_updateN" class="form-select form-select-sm" required>
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
                            <div class="row d-none" id="businessNameRow_updateN">
                                <label for="businessName_updateN" class="form-label"><span class="occupationLabel_updateN">Occupation</span> Name <span class="text-danger" id="businessNameRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <input type="text" name="businessName" id="businessName_updateN" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="row d-none" id="businessAddressRow_updateN">
                                <label for="businessAddress_updateN" class="form-label"><span class="occupationLabel_updateN">Occupation</span> Address <span class="text-danger" id="businessAddressRequired_updateN">*</span></label>
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col-12 col-md-4 form-group">
                                        <label for="occupationProvince_updateN" class="mb-0 flex-grow-1">Province <span class="text-danger" id="occupationProvinceRequired_updateN">*</span></label>
                                        <select name="occupationProvince" id="occupationProvince_updateN" class="form-select form-select-sm" required></select>
                                    </div>
                                    <div class="col-12 col-md-4 form-group">
                                        <label for="occupationMunicipality_updateN" class="mb-0 flex-grow-1">Municipality <span class="text-danger" id="occupationMunicipalityRequired_updateN">*</span></label>
                                        <select name="occupationMunicipality" id="occupationMunicipality_updateN" class="form-select form-select-sm" disabled required></select>
                                    </div>
                                    <div class="col-12 col-md-4 form-group">
                                        <label for="occupationBarangay_updateN" class="mb-0 flex-grow-1">Barangay <span class="text-danger" id="occupationBarangayRequired_updateN">*</span></label>
                                        <select name="occupationBarangay" id="occupationBarangay_updateN" class="form-select form-select-sm" disabled required></select>
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center">
                                    <label for="occupationStreet_updateN" class="mb-0 flex-grow-1">Street Address</label>
                                    <input type="text" name="occupationStreet" id="occupationStreet_updateN" class="form-control form-control-sm">
                                    </input>
                                </div>
                            </div>
                            <div class="row d-none" id="businessCategoryRow_updateN">
                                <label for="businessCategory_updateN" class="form-label">Business Category <span class="text-danger" id="businessCategoryRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="businessCategory" id="businessCategory_updateN" class="form-select form-select-sm">
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
                            <div class="row d-none" id="businessSizeRow_updateN">
                                <label for="businessSize_updateN" class="form-label">Business Size <span class="text-danger" id="businessSizeRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="businessSize" id="businessSize_updateN" class="form-select form-select-sm">
                                        <option value="" hidden selected disabled>--Select Business Size--</option>
                                        <option value="MICRO">MICRO (1-9 EMPLOYEES)</option>
                                        <option value="SMALL">SMALL (10-99 EMPLOYEES)</option>
                                        <option value="MEDIUM">MEDIUM (100-199 EMPLOYEES)</option>
                                        <option value="LARGE">LARGE (200 & Above EMPLOYEES)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="monthlyAverage_updateN" class="form-label">Monthly Average <span class="text-danger" id="monthlyAverageRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="monthlyAverage" id="monthlyAverage_updateN" class="form-select form-select-sm" required>
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
                                <label for="inquiryDate_updateN" class="form-label">Date of Inquiry <span class="text-danger">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <input type="date" name="inquiryDate" id="inquiryDate_updateN" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="row">
                                <label for="inquirySource_updateN" class="form-label">Source of Inquiry <span class="text-danger">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="inquirySource" id="inquirySource_updateN" class="form-select form-select-sm" required>
                                        <option value="" hidden selected disabled>--Select Source--</option>
                                        <option value="FACE TO FACE">FACE TO FACE</option>
                                        <option value="ONLINE">ONLINE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-none" id="f2fSourceRow_updateN">
                                <label for="f2fSource_updateN" class="form-label">Face To Face Inquiry Source <span class="text-danger">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="inquirySourceType" id="f2fSource_updateN" class="form-select form-select-sm">
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
                            <div class="row d-none" id="onlineSourceRow_updateN">
                                <label for="onlineSource_updateN" class="form-label">Online Inquiry Source <span class="text-danger">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="inquirySourceType" id="onlineSource_updateN" class="form-select form-select-sm">
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
                            <div class="row d-none" id="mallDisplayRow_updateN">
                                <label for="mallDisplay_updateN" class="form-label">Mall Display <span class="text-danger">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="mallDisplay" id="mallDisplay_updateN" class="form-select form-select-sm">

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <p class="form-label">Buyer Type <span class="text-danger" id="buyerTypeRequired_updateN">*</span></p>
                                <div class="row d-flex form-group gap-2">
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup_updateN">
                                        <input type="radio" name="buyerType" id="buyerType_first_updateN" value="FIRST-TIME">
                                        <label for="buyerType_first_updateN" class="mb-0 flex-grow-1">FIRST-TIME</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup_updateN">
                                        <input type="radio" name="buyerType" id="buyerType_replacement_updateN" value="REPLACEMENT">
                                        <label for="buyerType_replacement_updateN" class="mb-0 flex-grow-1">REPLACEMENT</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerTypeRadioGroup_updateN">
                                        <input type="radio" name="buyerType" id="buyerType_additional_updateN" value="ADDITIONAL">
                                        <label for="buyerType_additional_updateN" class="mb-0 flex-grow-1">ADDITIONAL</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="unitInquired_updateN" class="form-label">Unit Inquired <span class="text-danger" id="unitInquiredRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="unitInquired" id="unitInquired_updateN" class=" form-select form-select-sm" required></select>
                                </div>
                            </div>
                            <div class="row d-none" id="tamarawVariantRow_updateN">
                                <label for="tamarawVariant_updateN" class="form-label">Tamaraw Variant <span class="text-danger" id="tamarawVariantRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <select name="tamarawVariant" id="tamarawVariant_updateN" class="form-select form-select-sm">
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
                                <label for="transactionType_updateN" class="form-label">Trasnsaction Type <span class="text-danger" id="transactionTypeRequired_updateN">*</span></label>
                                <div class="row d-flex gap-2">
                                    <select name="transactionType" id="transactionType_updateN" class="form-select form-select-sm" required>
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
                                <p class="form-label">With Application <span class="text-danger" id="hasApplicationRequired_updateN">*</span></p>
                                <div class="row d-flex form-group gap-2">
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup_updateN">
                                        <input type="radio" name="hasApplication" id="hasApplication_yes_updateN" value="YES">
                                        <label for="hasApplication_yes_updateN" class="mb-0 flex-grow-1">YES</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasApplicationRadioGroup_updateN">
                                        <input type="radio" name="hasApplication" id="hasApplication_no_updateN" value="NO">
                                        <label for="hasApplication_no_updateN" class="mb-0 flex-grow-1">NO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="form-label">With Reservation <span class="text-danger" id="hasReservationRequired_updateN">*</span></p>
                                <div class="row d-flex form-group gap-2">
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasReservationRadioGroup_updateN">
                                        <input type="radio" name="hasReservation" id="hasReservation_yes_updateN" value="YES">
                                        <label for="hasReservation_yes_updateN" class="mb-0 flex-grow-1">YES</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 hasReservationRadioGroup_updateN">
                                        <input type="radio" name="hasReservation" id="hasReservation_no_updateN" value="NO">
                                        <label for="hasReservation_no_updateN" class="mb-0 flex-grow-1">NO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none" id="reservationDateRow_updateN">
                                <label for="reservationDate_updateN" class="form-label">Date of Reservation <span class="text-danger" id="reservationDateRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <input type="date" name="reservationDate" id="reservationDate_updateN" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row d-none" id="additionalUnitRow_updateN">
                                <label for="additionalUnit_updateN" class="form-label">Additional Unit Currently used for Business <span class="text-danger" id="additionalUnitRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <input type="text" name="additionalUnit" id="additionalUnit_updateN" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row d-none" id="tamarawSpecificUsageRow_updateN">
                                <label for="tamarawSpecificUsage_updateN" class="form-label">Specific Purpose or Usage of Tamaraw <span class="text-danger" id="tamarawSpecificUsageRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <input type="text" name="tamarawSpecificUsage" id="tamarawSpecificUsage_updateN" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row d-none" id="buyerDecisionHoldRow_updateN">
                                <p class="form-label">Buyer's Decision on hold? <span class="text-danger" id="buyerDecisionHoldRequired_updateN">*</span></p>
                                <div class="row d-flex form-group gap-2">
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup_updateN">
                                        <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_yes_updateN" value="YES">
                                        <label for="buyerDecisionHold_yes_updateN" class="mb-0 flex-grow-1">YES</label>
                                    </div>
                                    <div class="col justify-content-center align-items-center radio-column py-1 pr-0 d-flex gap-2 buyerDecisionHoldRadioGroup_updateN">
                                        <input type="radio" name="buyerDecisionHold" id="buyerDecisionHold_no_updateN" value="NO">
                                        <label for="buyerDecisionHold_no_updateN" class="mb-0 flex-grow-1">NO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none" id="buyerDecisionHoldReasonRow_updateN">
                                <label for="buyerDecisionHoldReason_updateN" class="form-label">Reason why the client's buying decision is on hold <span class="text-danger" id="buyerDecisionHoldReasonRequired_updateN">*</span></label>
                                <div class="row d-flex form-group gap-2">
                                    <input type="text" name="buyerDecisionHoldReason" id="buyerDecisionHoldReason_updateN" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <p class="form-label">Schedule Next Call</p>
                                <div class="row d-flex form-group gap-2">
                                    <label for="appointmentDate_updateN">Next Call Date <span class="text-danger" id="appointmentDateRequired_updateN">*</span></label>
                                    <input type="date" name="appointmentDate" id="appointmentDate_updateN" class="form-control form-control-sm" required>
                                </div>
                                <div class="row d-flex form-group gap-2">
                                    <label for="appointmentTime_updateN" class="mb-0 flex-grow-1">Next Call Time <span class="text-danger" id="appointmentTimeRequired_updateN">*</span></label>
                                    <select name="appointmentTime" id="appointmentTime_updateN" class="form-select form-select-sm" required>
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
                </div>
                <input type="hidden" name="inquiryId" id="inquiryId_updateN">
                <input type="hidden" name="historyId" id="historyId_updateN">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-memo-circle-check"></i> Save Inquiry</button>
                </div>
            </div>
        </form>
    </div>
</div>