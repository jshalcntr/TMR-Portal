<div class="modal fade" id="createSubProfilingModal" tabindex="-1" aria-labelledby="createSubProfilingModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg"> <!-- use modal-lg or modal-xl for bigger forms -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSubProfilingModalLabel">Sub Profiling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body custom-scrollable-body px-5">
                <form id="createSubprofilingForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row justify-content-center align-items-center">
                        <label for="clientFirstName" class="col-form-label">Client Name</label>
                        <div class="col form-group">
                            <input type="text" name="clientFirstName" id="clientFirstName" class="form-control form-control-sm" placeholder="First Name" required>
                            <div class="invalid-feedback">Please input first name</div>
                        </div>
                        <div class="col form-group">
                            <input type="text" name="clientMiddleName" id="clientMiddleName" class="form-control form-control-sm" placeholder="Middle Name" required>
                            <div class="invalid-feedback">Please input middle name</div>
                        </div>
                        <div class="col form-group">
                            <input type="text" name="clientLastName" id="client_last_name" class="form-control form-control-sm" placeholder="Last Name" required>
                            <div class="invalid-feedback">Please input last name</div>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="csNumber" class="col-form-label">Conduction Sticker Number</label>
                            <input type="text" name="csNumber" id="csNumber" class="form-control form-control-sm">
                        </div>
                        <div class="col form-group">
                            <label for="inquiryDate" class="col-form-label">Date of Inquiry</label>
                            <input type="date" name="inquiryDate" id="inquiryDate" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="phone" class="form-label">Contact Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control form-control-sm" placeholder="09XXXXXXXXX" pattern="\d{11}" required title="Phone number must be exactly 11 digits" required>
                        </div>
                        <div class="col form-group">
                            <label for="birthDate" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control form-control-sm" id="birthDate" name="birthDate" required>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Gender--</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="maritalStatus" class="form-label">Marital Status</label>
                            <select name="maritalStatus" id="maritalStatus" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Marital Status--</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="separated">Separated</option>
                                <option value="widow">Widow</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="jobLevel" class="form-label">Job Level</label>
                            <select name="jobLevel" id="jobLevel" class="form-select form-select-sm" required title="Address where the client works or where their business is located" required>
                                <option value="" selected hidden>--Select Job Level--</option>
                                <option value="Unemployed">Unemployed</option>
                                <option value="Junior Staff">Junior Staff</option>
                                <option value="Senior Staff">Senior Staff</option>
                                <option value="Supervisor">Supervisorial</option>
                                <option value="Assistant Manager">Assistant Manager</option>
                                <option value="Manager">Manager</option>
                                <option value="Senior Manager">Senior Manager</option>
                                <option value="Top Manager">Top Manager</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="workNature" class="form-label">Occupation/Business</label>
                            <select name="workNature" id="workNature" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Profession or Business--</option>
                                <option value="profession">Profession</option>
                                <option value="business">Business</option>
                                <option value="both">Profession and Business (if both apply)</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                    </div>
                    <div id="professionRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="profession" class="form-label">Profession</label>
                            <input type="text" id="profession" name="profession" class="form-control form-control-sm" placeholder="Ex. Teacher, Doctor, Accountant" title="If OFW, put what kind of job he/she have">
                        </div>
                    </div>
                    <div id="businessNatureRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="businessNature" class="form-label">Business Nature</label>
                            <select name="businessNature" id="businessNature" class="form-select form-select-sm">
                                <option value="" selected hidden>--Select Business Type--</option>
                                <option value="agricultural">Agricultural</option>
                                <option value="automotive">Automotive</option>
                                <option value="bpo">BPO</option>
                                <option value="clinic">Clinic</option>
                                <option value="construction">Construction</option>
                                <option value="employed">Employed/No Business</option>
                                <option value="enterprise">Enterprise</option>
                                <option value="ecommerce">E-Commerce</option>
                                <option value="foodServices">Food Services</option>
                                <option value="genMerchandise">General Merchandise</option>
                                <option value="genServices">General Services</option>
                                <option value="government">Government</option>
                                <option value="hospt">Hospital/Tourism</option>
                                <option value="tech">IT/Tech</option>
                                <option value="landscaping">Landscaping</option>
                                <option value="logistics">Logistics</option>
                                <option value="manufacturing">Manufacturing</option>
                                <option value="healthcare">Pharmacy/Healthcare</option>
                                <option value="rental">Rental</option>
                                <option value="retailShop">Retail Shop</option>
                                <option value="trading">Trading</option>
                                <option value="transpo">Transportation or Grab</option>
                                <option value="travel">Travel</option>
                                <option value="trucking">Trucking</option>
                                <option value="utilityServices">Utility Services</option>
                                <option value="wholesale">Wholesale</option>
                            </select>
                        </div>
                    </div>
                    <div id="jobDemoRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="jobDemo" class="form-label">Job Demographics</label>
                            <input type="text" id="jobDemo" name="jobDemo" class="form-control form-control-sm" placeholder="Town and Province only">
                        </div>
                    </div>
                    <div id="businessSizeRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="businessSize" class="form-label">Business Size Classification</label>
                            <select name="businessSize" id="businessSize" class="form-select form-select-sm">
                                <option value="" selected hidden>--Select Business Size Classification--</option>
                                <option value="microEntrep">Micro Enterprise (1-9 Employees)</option>
                                <option value="smallEntrep">Small Enterprise (10-99 Employees)</option>
                                <option value="mediumEntrep">Medium Enterprise (100-199 Employees)</option>
                                <option value="largeEntrep">Large Enterprise (200+ Employees)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="tamarawRelease" class="form-label">For TAMARAW Release</label>
                            <input type="text" id="tamarawRelease" name="tamarawRelease" class="form-control form-control-sm" placeholder="Note N/A if not TAMARAW release" required title="Please indicate vehicles currently owned. Ex. Toyota Hilux, Mitsubishi L300, Isuzu Traviz, etc." required>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="householdIncome" class="form-label">Average Household Income</label>
                            <select name="householdIncome" id="householdIncome" class="form-select form-select-sm" required title="Combined borrower & Co-borrower" required>
                                <option value="" selected hidden>--Select Average Household Income--</option>
                                <option value="option1">50k and below</option>
                                <option value="option2">50k-60k</option>
                                <option value="option3">70k-80k</option>
                                <option value="option4">90k-100k</option>
                                <option value="option5">110k-400k</option>
                                <option value="option6">500k and up</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="salesSource" class="form-label">Source of Sales</label>
                            <select name="salesSource" id="salesSource" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Source of Sales--</option>
                                <option value="referral">Referral</option>
                                <option value="repeat_client">Repeat Client</option>
                                <option value="mall_display">Mall Display</option>
                                <option value="walkIn">Walk-in</option>
                                <option value="callIn">Call-in</option>
                                <option value="saturation">Saturation</option>
                                <option value="satellite">Satellite</option>
                                <option value="officeSale">Office Sale</option>
                                <option value="personalFb">Personal Facebook</option>
                                <option value="fbPage">Group Facebook Page</option>
                                <option value="tmrFb">TMR Facebook Page</option>
                                <option value="instagram">Instagram (Personal Account)</option>
                                <option value="tmrIg">TMR Instragram</option>
                                <option value="tmrTiktok">TMR Tiktok</option>
                                <option value="youtube">Youtube</option>
                            </select>
                        </div>
                    </div>
                    <div id="referralRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="referralSource" class="form-label">Who referred the client?</label>
                            <input type="text" id="referralSource" name="referralSource" class="form-control form-control-sm" placeholder="Enter name of referrer">
                        </div>
                    </div>
                    <div id="repeatClientRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="repeatClient" class="form-label">Indicate 1st year of release</label>
                            <input type="text" id="repeatClient" name="repeatClient" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div id="mallDisplayRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="mallDisplay" class="form-label">Indicate what mall</label>
                            <input type="text" id="mallDisplay" name="mallDisplay" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="releaseManner" class="form-label">Manner of Release</label>
                            <select name="releaseManner" id="releaseManner" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Manner of Release--</option>
                                <option value="actual">Actual</option>
                                <option value="technical">Technical</option>
                                <option value="unitPrep">Unit Preparation</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="releaseDate" class="form-label">Release Date</label>
                            <input type="date" class="form-control form-control-sm" id="releaseDate" name="releaseDate" required>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="releaseMode" class="form-label">Mode of Release</label>
                            <select name="releaseMode" id="releaseMode" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Mode of Release--</option>
                                <option value="pickup">Pick-Up</option>
                                <option value="deliver">Deliver</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="reservationMode" class="form-label">Mode of Reservation</label>
                            <select name="reservationMode" id="reservationMode" class="form-select form-select-sm" required title="(if NO RESERVATION, full DP agad, considered as DEALER)" required>
                                <option value="" selected hidden>--Select Mode of Reservation--</option>
                                <option value="online">Online</option>
                                <option value="dealer">Dealer</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="far" class="form-label">F.A.R.</label>
                            <select name="far" id="far" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select F.A.R.--</option>
                                <option value="firstTime">First Time</option>
                                <option value="additionalUnit">Additional Unit</option>
                                <option value="replacement">Replacement (with trade-in)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="customerPreference" class="form-label">Customer Preference for Accessories</label>
                            <select name="customerPreference" id="customerPreference" class="form-select form-select-sm" required>
                                <option value="" selected hidden>--Select Customer Preference for Accessories--</option>
                                <option value="safety">Safety</option>
                                <option value="looks">Looks</option>
                                <option value="lifestlye">Lifestyle</option>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="tintShade" class="form-label">Shade of Tint</label>
                            <input type="text" name="tintShade" id="tintShade" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please input shade of tint</div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>