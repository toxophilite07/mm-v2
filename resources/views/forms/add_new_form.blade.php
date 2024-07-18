<form autocomplete="off" id="newFeminineForm" novalidate="novalidate">
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
        <label for="menstruation_status">Menstruation Status</label>
        <select name="menstruation_status" id="menstruation_status" name="menstruation_status" aria-describedby="menstruation_help">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
        <div class="col-12 mt-2">
            <small id="menstruation_help" class="form-text text-muted">
                <li><span class="font-weight-bold">Active</span> - Menstruation is active and not pregnant</li>
                <li><span class="font-weight-bold">Inactive</span> - Menstruation is not active and might be pregnant</li>
            </small>
        </div>
    </div>
    <div class="form-group">
        <label for="last_period_date" class="control-label">Last Recorded Period Date</label>
        <div class="input-group date datepicker" id="last_period_datepicker">
            <input type="text" id="last_period_date" name="last_period_date" class="form-control"><span class="input-group-addon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
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