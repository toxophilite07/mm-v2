<div class="modal fade" id="newHealthWorkerModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newHealthWorkerLbl" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newHealthWorkerLbl">Register New Health Worker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form autocomplete="off" id="newHealthWorkerForm" novalidate="novalidate">
                        <input type="hidden" class="action" value="0">
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
                            <div class="col-lg-8 col-sm-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="birthdate">Birthdate</label>
                                    <div class="input-group date datepicker" id="birthdate_datepicker">
                                        <input type="text" id="birthdate" name="birthdate" class="form-control"><span class="input-group-addon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email_address">Active Email</label>
                                    <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Enter an active email ex: juany@sample.com">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="contact_no">Contact No.</label>
                                    <div class="input-group">
                                        <span class="input-addon px-2 rounded-start-1 border border-end-0 d-flex align-items-center justify-content-center" id="basic-addon1">+63</span>
                                        <input type="text" id="contact_no" name="contact_no" class="form-control" placeholder="9123456789" oninput="formatPhoneNumber(this)" maxlength="10" pattern="[9]{1}[0-9]{9}">
                                    </div>
                                </div>
                            </div>
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

<div class="modal fade" id="editHealthWorkerModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editHealthWorkerLbl" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHealthWorkerLbl">Edit Health Worker Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form autocomplete="off" id="editHealthWorkerForm" novalidate="novalidate">
                        <input type="hidden" class="action" value="1">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="edit_first_name">First Name</label>
                                    <input type="text" class="form-control" id="edit_first_name" name="edit_first_name" placeholder="Enter first name" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="edit_middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="edit_middle_name" name="edit_middle_name" placeholder="Enter middle name (optional)" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="edit_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="edit_last_name" name="edit_last_name" placeholder="Enter last name" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                                <div class="form-group">
                                    <label for="edit_address">Address</label>
                                    <input type="text" class="form-control" id="edit_address" name="edit_address" placeholder="Enter address" oninput="handleInputCapitalize(event)">
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="edit_birthdate">Birthdate</label>
                                    <div class="input-group date datepicker" id="edit_birthdate_datepicker">
                                        <input type="text" id="edit_birthdate" name="edit_birthdate" class="form-control"><span class="input-group-addon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="edit_email_address">Active Email</label>
                                    <input type="email" class="form-control" id="edit_email_address" name="edit_email_address" placeholder="Enter an active email ex: juany@sample.com">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="edit_contact_no">Contact No.</label>
                                    <div class="input-group">
                                        <span class="input-addon px-2 rounded-start-1 border border-end-0 d-flex align-items-center justify-content-center" id="basic-addon1">+63</span>
                                        <input type="text" id="edit_contact_no" name="edit_contact_no" class="form-control" placeholder="9123456789" oninput="formatPhoneNumber(this)" maxlength="10" pattern="[9]{1}[0-9]{9}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_remarks" class="control-label">Remarks</label>
                            <textarea class="form-control" name="edit_remarks" id="edit_remarks" rows="4" placeholder="Enter a remark (optional)"></textarea>
                        </div>
                        <input type="hidden" id="edit_id">
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

<div class="modal fade" id="viewHealthWorkerModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="viewHealthWorkerLbl" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewHealthWorkerLbl">View Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-lg-7 pb-2">
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
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Account Status:</label>
                                <p class="text-muted ml-2" id="view_is_active"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 pb-2">
                        <div class="alert alert-icon-secondary mt-3 mb-0" role="alert">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Assigned Feminine List:</label>
                            <div id="view_feminnine_assign"></div>
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
                <h5 class="modal-title" id="assignFeminineLbl">Assign Feminine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="col-md-12 pb-2">
                    <div class="form-group mt-3">
                        <label class="mb-0">Health Worker Name:</label>
                        <p class="text-muted" id="display_health_worker_name"></p>
                    </div>
                    <div class="form-group mt-3 mb-0">
                        <label>Assign Feminine</label>
                        <select id="assign_feminine" multiple="multiple" style="width: 100%;" aria-describedby="assign_help">
                            <option></option>
                        </select>
                        <small id="assign_help" class="form-text text-muted">You can select multiple feminine to assign to this health worker.</small>
                        <input type="hidden" id="health_worker_id">
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