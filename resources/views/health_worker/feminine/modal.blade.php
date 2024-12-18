
<div class="modal fade" id="newFeminineModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newFeminineLbl" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFeminineLbl">Register New Female</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Heads up!</h4>
                        <p>When you add a new female, this will automatically be assigned to you and will be listed to your female list.</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <form autocomplete="off" id="newFeminineForm" novalidate="novalidate">
                    @csrf
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter middle name (optional)" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-lg-8 col-sm-12 mb-3">
                                                        <label for="address" class="form-label">Address (your address)</label>
                                                        <!-- Input with datalist -->
                                                        <input type="text" id="address" name="address" list="addressOptions" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" value="{{ old('address') }}" placeholder="Type or select your address" oninput="handleInputCapitalize(event)" required>
                                                        
                                                        <!-- Datalist for address options -->
                                                        <datalist id="addressOptions">
                                                            <option value="Tarong Madridejos Cebu"></option>
                                                            <option value="Bunakan Madridejos Cebu"></option>
                                                            <option value="Kangwayan Madridejos Cebu"></option>
                                                            <option value="Kaongkod Madridejos Cebu"></option>
                                                            <option value="Kodia Madridejos Cebu"></option>
                                                            <option value="Maalat Madridejos Cebu"></option>
                                                            <option value="Malbago Madridejos Cebu"></option>
                                                            <option value="Mancilang Madridejos Cebu"></option>
                                                            <option value="Pili Madridejos Cebu"></option>
                                                            <option value="Poblacion Madridejos Cebu"></option>
                                                            <option value="San Agustin Madridejos Cebu"></option>
                                                            <option value="Tabagak Madridejos Cebu"></option>
                                                            <option value="Talangnan Madridejos Cebu"></option>
                                                            <option value="Tugas Madridejos Cebu"></option>
                                                        </datalist>

                                                        <!-- Display error message if validation fails -->
                                                        @if ($errors->has('address'))
                                                            <span class="invalid-feedback">
                                                                <strong>{{ $errors->first('address') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>

                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="birthdate">Birthdate</label>
                                    <div class="input-group date datepicker" id="birthdate_datepicker">
                                        <input type="text" id="birthdate" name="birthdate" class="form-control" placeholder="mm/dd/yyyy"><span class="input-group-addon" ><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            <!-- Alert for Verified or Valid Email -->
                                            <div class="alert alert-warning" role="alert">
                             <strong>Notice:</strong> Please ensure you are using a verified or valid email address. Email notifications may not be sent if an unverified email is used.
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email_address">Active Email</label>
                                    <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Enter an active email ex: juany@sample.com">
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="contact_no">Contact No. (Optional)</label>
                                    <div class="input-group">
                                        <span class="input-addon px-2 rounded-start-1 border border-end-0 d-flex align-items-center justify-content-center" id="basic-addon1">+63</span>
                                        <input type="text" id="contact_no" name="contact_no" class="form-control" placeholder="9123456789" oninput="formatPhoneNumber(this)" maxlength="10" pattern="[9]{1}[0-9]{9}">
                                    </div>
                                </div>
                            </div> -->

                            <div class="form-group">
                            <label for="menstruation_status">Menstruation Status</label>
                            <select name="menstruation_status" id="menstruation_status" name="menstruation_status" aria-describedby="menstruation_help">
                                <option value="1">Regular</option>
                                <option value="0">Irregular</option>
                            </select>
                            <div class="col-12 mt-2">
                                <small id="menstruation_help" class="form-text text-muted">
                                    <li><span class="font-weight-bold">Regular</span> - Menstruation is active and not pregnant</li>
                                    <li><span class="font-weight-bold">Irregular</span> - Menstruation is not active and might be pregnant</li>
                                </small>
                            </div>
                        </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="last_period_date" class="control-label">Last Recorded Period Date</label>
                            <div class="input-group date datepicker" id="last_period_datepicker">
                                <input type="text" id="last_period_date" name="last_period_date" class="form-control" autocomplete="off">
                                <span class="input-group-addon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </span>
                            </div>
                        </div>
                         <!-- Alert for Verified or Valid Email -->
                        <div class="alert alert-warning" role="alert">
                             <strong>Notice:</strong> Please ensure you add a remarks here if you add this user.
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="4" placeholder="Enter a remark (optional)"></textarea>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end">
                            <button type="submit" class="btn btn-success mr-2" id="submit_form_btn"><i class="fa-regular fa-circle-check"></i> Submit</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editFeminineModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newFeminineLbl" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFeminineLbl">Edit Female Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form autocomplete="off" id="editFeminineForm" novalidate="novalidate">
                    @csrf
                        <input type="hidden" id="edit_id">
                        <input type="hidden" id="edit_menstruation_period_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_first_name">First Name</label>
                                    <input type="text" class="form-control" id="edit_first_name" name="edit_first_name" placeholder="Enter first name" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="edit_middle_name" name="edit_middle_name" placeholder="Enter middle name (optional)" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="edit_last_name" name="edit_last_name" placeholder="Enter last name" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="edit_address">Address</label>
                                    <input type="text" class="form-control" id="edit_address" list="addressOptions" name="edit_address" placeholder="Enter address" oninput="handleInputCapitalize(event)">

                                        <!-- Datalist for address options -->
                                        <datalist id="addressOptions">
                                        <option value="Tarong Madridejos Cebu"></option>
                                        <option value="Bunakan Madridejos Cebu"></option>
                                        <option value="Kangwayan Madridejos Cebu"></option>
                                        <option value="Kaongkod Madridejos Cebu"></option>
                                        <option value="Kodia Madridejos Cebu"></option>
                                        <option value="Maalat Madridejos Cebu"></option>
                                        <option value="Malbago Madridejos Cebu"></option>
                                        <option value="Mancilang Madridejos Cebu"></option>
                                        <option value="Pili Madridejos Cebu"></option>
                                        <option value="Poblacion Madridejos Cebu"></option>
                                        <option value="San Agustin Madridejos Cebu"></option>
                                        <option value="Tabagak Madridejos Cebu"></option>
                                        <option value="Talangnan Madridejos Cebu"></option>
                                        <option value="Tugas Madridejos Cebu"></option>
                                        </datalist>
                                         <!-- Display error message if validation fails -->
                                           @if ($errors->has('edit_address'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('edit_address') }}</strong>
                                                </span>
                                           @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="edit_birthdate">Birthdate</label>
                                    <div class="input-group date datepicker" id="edit_birthdate_datepicker">
                                        <input type="text" id="edit_birthdate" name="edit_birthdate" class="form-control" placeholder="mm/dd/yyyy"><span class="input-group-addon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_email_address">Active Email</label>
                                    <input type="email" class="form-control" id="edit_email_address" name="edit_email_address" placeholder="Enter an active email ex: juany@sample.com" disabled>
                                </div>
                        </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_contact_no">Contact No.</label>
                                    <div class="input-group">
                                        <span class="input-addon px-2 rounded-start-1 border border-end-0 d-flex align-items-center justify-content-center" id="basic-addon1">+63</span>
                                        <input type="text" id="edit_contact_no" name="edit_contact_no" class="form-control" oninput="formatPhoneNumber(this)" maxlength="10" pattern="[9]{1}[0-9]{9}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_menstruation_status">Menstruation Status</label>
                            <select name="edit_menstruation_status" id="edit_menstruation_status" name="edit_menstruation_status" aria-describedby="edit_menstruation_help">
                                <option value="1">Regular</option>
                                <option value="0">Irregular</option>
                            </select>
                            <div class="col-12 mt-2">
                                <small id="edit_menstruation_help" class="form-text text-muted">
                                    <li><span class="font-weight-bold">Active</span> - Menstruation is active and not pregnant</li>
                                    <li><span class="font-weight-cold">Inactive</span> - Menstruation is not active and might be pregnant</li>
                                </small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_last_period_date" class="control-label">Last Recorded Period Date</label>
                            <div class="input-group date datepicker" id="edit_last_period_datepicker">
                                <input type="text" id="edit_last_period_date" name="edit_last_period_date" class="form-control" disabled><span class="input-group-addon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_remarks" class="control-label">Note for the current menstruation cycle</label>
                            <textarea class="form-control" name="edit_remarks" id="edit_remarks" rows="4" placeholder="Enter a remark (optional)" disabled></textarea>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end">
                            <button type="submit" class="btn btn-success mr-2" id="update_form_btn"><i class="fa-regular fa-circle-check"></i> Confirm Changes</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewFeminineModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="viewFeminineLbl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFeminineLbl">View Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="col-md-12 pb-2">
                    <div class="container">
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Name:</label>
                            <p class="text-muted" id="view_name"></p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Active Email:</label>
                            <p class="text-muted" id="view_email"></p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Contact No.:</label>
                            <p class="text-muted" id="view_contact_no"></p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Address:</label>
                            <p class="text-muted" id="view_address"></p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Birthdate:</label>
                            <p class="text-muted" id="view_birthdate"></p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Menstruation Status:</label>
                            <p class="text-muted ml-2" id="view_menstruation_status"></p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Account Status:</label>
                            <p class="text-muted ml-2" id="view_is_active"></p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Last Recorded Periods:</label>
                            <div class="ml-2" id="view_last_periods"></div>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Next Estimated Menstrual Date:</label>
                            <div class="text-muted ml-2" id="view_estimated_periods"></div>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Note for the current menstruation cycle:</label>
                            <div class="text-muted ml-2" id="view_remarks"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignFeminineModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="assignFeminineLbl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignFeminineLbl">Assign Female</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="col-md-12 pb-2">
                    <div class="form-group mt-3 mb-0">
                        <label>Select Unassigned Female</label>
                        <select id="assign_feminine" multiple="multiple" style="width: 100%;" aria-describedby="assign_help">
                            <option></option>
                        </select>
                        <small id="assign_help" class="form-text text-muted">You can select multiple feminine to assign under your care.</small>
                        <input type="hidden" id="health_worker_id" value="{{ Auth::user()->id }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="assign_btn"><i class="fa-regular fa-circle-check"></i> Assign</button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> Close</button>
            </div>
        </div>
    </div>
</div>
