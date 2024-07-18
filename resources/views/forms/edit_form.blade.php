<form autocomplete="off" id="editFeminineForm" novalidate="novalidate">
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
        <label for="edit_menstruation_status">Menstruation Status</label>
        <select name="edit_menstruation_status" id="edit_menstruation_status" name="edit_menstruation_status" aria-describedby="edit_menstruation_help">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
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
            <input type="text" id="edit_last_period_date" name="edit_last_period_date" class="form-control"><span class="input-group-addon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
        </div>
    </div>
    <div class="form-group">
        <label for="edit_remarks" class="control-label">Remarks</label>
        <textarea class="form-control" name="edit_remarks" id="edit_remarks" rows="4" placeholder="Enter a remark (optional)"></textarea>
    </div>

    <div class="d-flex flex-wrap justify-content-end">
        <button type="submit" class="btn btn-success mr-2" id="update_form_btn"><i class="fa-regular fa-circle-check"></i> Confirm Changes</button>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> Cancel</button>
    </div>
</form>