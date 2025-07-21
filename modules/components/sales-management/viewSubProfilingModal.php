<div class="modal fade" id="viewSubProfilingModal" tabindex="-1" aria-labelledby="viewSubProfilingModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="viewSubProfilingModalLabel">Sub Profiling Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body custom-scrollable-body px-5">
                <form id="editSubprofilingForm" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row justify-content-center align-items-center">
                        <label for="clientFirstName_view" class="col-form-label">Client Name</label>
                        <div class="col form-group">
                            <input type="text" name="clientFirstName" id="clientFirstName_view" class="form-control form-control-sm" placeholder="First Name" required disabled>
                            <div class="invalid-feedback">Please input first name</div>
                        </div>
                        <div class="col form-group">
                            <input type="text" name="clientMiddleName" id="clientMiddleName_view" class="form-control form-control-sm" placeholder="Middle Name" required disabled>
                            <div class="invalid-feedback">Please input middle name</div>
                        </div>
                        <div class="col form-group">
                            <input type="text" name="clientLastName" id="clientLastName_view" class="form-control form-control-sm" placeholder="Last Name" required disabled>
                            <div class="invalid-feedback">Please input last name</div>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="csNumber_view" class="col-form-label">Conduction Sticker Number</label>
                            <input type="text" name="csNumber" id="csNumber_view" class="form-control form-control-sm">
                        </div>
                        <div class="col form-group">
                            <label for="inquiryDate_view" class="col-form-label">Date of Inquiry</label>
                            <input type="date" name="inquiryDate" id="inquiryDate_view" class="form-control form-control-sm" required disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="phone_view" class="form-label">Contact Number</label>
                            <input type="tel" id="phone_view" name="phone" class="form-control form-control-sm" placeholder="09XXXXXXXXX" pattern="\d{11}" required title="Phone number must be exactly 11 digits" required disabled>
                        </div>
                        <div class="col form-group">
                            <label for="birthDate_view" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control form-control-sm" id="birthDate_view" name="birthDate" required disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="gender_view" class="form-label">Gender</label>
                            <select name="gender" id="gender_view" class="form-select form-select-sm" required disabled>
                                <option value="" selected hidden>--Select Gender--</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="LGBT+">LGBT+</option>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="maritalStatus_view" class="form-label">Marital Status</label>
                            <select name="maritalStatus" id="maritalStatus_view" class="form-select form-select-sm" required disabled>
                                <option value="" selected hidden>--Select Marital Status--</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Separated">Separated</option>
                                <option value="Widow">Widow</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="jobLevel_view" class="form-label">Job Level</label>
                            <select name="jobLevel" id="jobLevel_view" class="form-select form-select-sm" required title="Address where the client works or where their business is located" required disabled>
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
                            <label for="workNature_view" class="form-label">Occupation/Business</label>
                            <select name="workNature" id="workNature_view" class="form-select form-select-sm" required disabled>
                                <option value="" selected hidden>--Select Profession or Business--</option>
                                <option value="Profession">Profession</option>
                                <option value="Business">Business</option>
                                <option value="Both">Profession and Business (if both apply)</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                    </div>
                    <div id="professionRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="profession_view" class="form-label">Profession</label>
                            <input type="text" id="profession_view" name="Profession" class="form-control form-control-sm" placeholder="Ex. Teacher, Doctor, Accountant" title="If OFW, put what kind of job he/she have">
                        </div>
                    </div>
                    <div id="businessNatureRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="businessNature_view" class="form-label">Business Nature</label>
                            <select name="businessNature" id="businessNature_view" class="form-select form-select-sm">
                                <option value="" selected hidden>--Select Business Type--</option>
                                <option value="Agricultural">Agricultural</option>
                                <option value="Automotive">Automotive</option>
                                <option value="BPO">BPO</option>
                                <option value="Clinic">Clinic</option>
                                <option value="Construction">Construction</option>
                                <option value="Employed">Employed/No Business</option>
                                <option value="Enterprise">Enterprise</option>
                                <option value="Ecommerce">E-Commerce</option>
                                <option value="Food Services">Food Services</option>
                                <option value="General Merchandise">General Merchandise</option>
                                <option value="General Services">General Services</option>
                                <option value="Government">Government</option>
                                <option value="Hospital">Hospital/Tourism</option>
                                <option value="IT/TECH">IT/Tech</option>
                                <option value="Landscaping">Landscaping</option>
                                <option value="Logistics">Logistics</option>
                                <option value="Manufacturing">Manufacturing</option>
                                <option value="Healthcare">Pharmacy/Healthcare</option>
                                <option value="Rental">Rental</option>
                                <option value="Retail Shop">Retail Shop</option>
                                <option value="Trading">Trading</option>
                                <option value="Transportation">Transportation or Grab</option>
                                <option value="Travel">Travel</option>
                                <option value="Trucking">Trucking</option>
                                <option value="Utility Services">Utility Services</option>
                                <option value="Wholesale">Wholesale</option>
                            </select>
                        </div>
                    </div>
                    <div id="jobDemoRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="jobDemo_view" class="form-label">Job Demographics</label>
                            <input type="text" id="jobDemo_view" name="Job Demographics" class="form-control form-control-sm" placeholder="Town and Province only">
                        </div>
                    </div>
                    <div id="businessSizeRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="businessSize_view" class="form-label">Business Size Classification</label>
                            <select name="businessSize" id="businessSize_view" class="form-select form-select-sm">
                                <option value="" selected hidden>--Select Business Size Classification--</option>
                                <option value="Micro Enterprise">Micro Enterprise (1-9 Employees)</option>
                                <option value="Small Enterprise">Small Enterprise (10-99 Employees)</option>
                                <option value="Medium Enterprise">Medium Enterprise (100-199 Employees)</option>
                                <option value="Large Enterprise">Large Enterprise (200+ Employees)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="tamarawRelease_view" class="form-label">For TAMARAW Release</label>
                            <input type="text" id="tamarawRelease_view" name="Tamaraw Release" class="form-control form-control-sm" placeholder="Note N/A if not TAMARAW release" required title="Please indicate vehicles currently owned. Ex. Toyota Hilux, Mitsubishi L300, Isuzu Traviz, etc." required disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">

                        <div class="col form-group">
                            <label for="householdIncome_view" class="form-label">Average Household Income</label>
                            <select name="householdIncome" id="householdIncome_view" class="form-select form-select-sm" required title="Combined borrower & Co-borrower" required disabled>
                                <option value="" selected hidden>--Select Average Household Income--</option>
                                <option value="50k and below">50k and below</option>
                                <option value="51k-60k">51k-60k</option>
                                <option value="61k-70k">61k-70k</option>
                                <option value="71k-80k">71k-80k</option>
                                <option value="81k-90k">81k-90k</option>
                                <option value="91k-100k">91k-100k</option>
                                <option value="101k-400k">101k-400k</option>
                                <option value="401k-500k">401k-500k</option>
                                <option value="501k and up">501k and up</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="salesSource_view" class="form-label">Source of Sales</label>
                            <select name="salesSource" id="salesSource_view" class="form-select form-select-sm" required disabled>
                                <option value="" selected hidden>--Select Source of Sales--</option>
                                <option value="Referral">Referral</option>
                                <option value="Repeat Client">Repeat Client</option>
                                <option value="Mall Display">Mall Display</option>
                                <option value="Walk-in">Walk-in</option>
                                <option value="Call-in">Call-in</option>
                                <option value="Saturation">Saturation</option>
                                <option value="Satellite">Satellite</option>
                                <option value="Office Sale">Office Sale</option>
                                <option value="Personal Facebook">Personal Facebook</option>
                                <option value="Group Facebook Page">Group Facebook Page</option>
                                <option value="TMR Facebook Page">TMR Facebook Page</option>
                                <option value="Instagram">Instagram (Personal Account)</option>
                                <option value="TMR Instagram">TMR Instragram</option>
                                <option value="TMR Tiktok">TMR Tiktok</option>
                                <option value="Youtube">Youtube</option>
                            </select>
                        </div>
                    </div>
                    <div id="referralRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="referralSource_view" class="form-label">Who referred the client?</label>
                            <input type="text" id="referralSource_view" name="Referral Source" class="form-control form-control-sm" placeholder="Enter name of referrer">
                        </div>
                    </div>
                    <div id="repeatClientRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="repeatClient_view" class="form-label">Indicate 1st year of release</label>
                            <input type="text" id="repeatClient_view" name="Repeat Client" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div id="mallDisplayRow" class="row justify-content-center align-items-center d-none">
                        <div class="col form-group">
                            <label for="mallDisplay_view" class="form-label">Indicate what mall</label>
                            <input type="text" id="mallDisplay_view" name="Mall Display" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="releaseManner_view" class="form-label">Manner of Release</label>
                            <select name="releaseManner" id="releaseManner_view" class="form-select form-select-sm" required disabled>
                                <option value="" selected hidden>--Select Manner of Release--</option>
                                <option value="Actual">Actual</option>
                                <option value="Technical">Technical</option>
                                <option value="Unit Preparation">Unit Preparation</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="releaseDate_view" class="form-label">Release Date</label>
                            <input type="date" class="form-control form-control-sm" id="releaseDate_view" name="releaseDate" required disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="releaseMode_view" class="form-label">Mode of Release</label>
                            <select name="releaseMode" id="releaseMode_view" class="form-select form-select-sm" required disabled>
                                <option value="" selected hidden>--Select Mode of Release--</option>
                                <option value="Pick-Up">Pick-Up</option>
                                <option value="Deliver">Deliver</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="reservationMode_view" class="form-label">Mode of Reservation</label>
                            <select name="reservationMode" id="reservationMode_view" class="form-select form-select-sm" required title="(if NO RESERVATION, full DP agad, considered as DEALER)" required disabled>
                                <option value="" selected hidden>--Select Mode of Reservation--</option>
                                <option value="Online">Online</option>
                                <option value="Dealer">Dealer</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="far_view" class="form-label">F.A.R.</label>
                            <select name="far" id="far_view" class="form-select form-select-sm" required disabled>
                                <option value="" selected hidden>--Select F.A.R.--</option>
                                <option value="First Time">First Time</option>
                                <option value="Additional Unit">Additional Unit</option>
                                <option value="Replacement">Replacement (with trade-in)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col form-group">
                            <label for="customerPreference_view" class="form-label">Customer Preference for Accessories</label>
                            <select name="customerPreference" id="customerPreference_view" class="form-select form-select-sm" required disabled>
                                <option value="" selected hidden>--Select Customer Preference for Accessories--</option>
                                <option value="Safety">Safety</option>
                                <option value="Looks">Looks</option>
                                <option value="Lifestyle">Lifestyle</option>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="tintShade_view" class="form-label">Shade of Tint</label>
                            <input type="text" name="tintShade" id="tintShade_view" class="form-control form-control-sm" required disabled>
                            <div class="invalid-feedback">Please input shade of tint</div>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="id_view">
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
                </form>
            </div>
        </div>
    </div>
</div>