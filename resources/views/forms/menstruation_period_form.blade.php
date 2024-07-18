<form autocomplete="off" id="menstrualPeriodForm" novalidate="novalidate">
    <input type="hidden" id="id" value="{{ Auth::user()->id }}">
    <input type="hidden" id="menstruation_period_id">
    <input type="hidden" id="form_action">
    <div class="form-group">
        <label for="menstruation_period" class="control-label">Menstruation Period Date</label>
        <div class="input-group date datepicker" id="menstruation_period_datepicker">
            <input type="text" id="menstruation_period" name="menstruation_period" class="form-control"><span class="input-group-addon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>
        </div>
    </div>
    <div class="form-group">
        <label for="remarks" class="control-label">Remarks</label>
        <textarea class="form-control" name="remarks" id="remarks" rows="4" placeholder="Enter a remark (optional)"></textarea>
    </div>

    <div class="d-flex flex-wrap justify-content-end">
        <button type="submit" class="btn btn-success mr-2" id="submit_menstruation_period_btn"><i class="fa-regular fa-circle-check"></i> Submit Record</button>
        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> Cancel</button>
    </div>
</form>