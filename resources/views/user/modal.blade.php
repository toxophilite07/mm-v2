<div class="modal fade" id="menstrualPeriodModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newMenstruationPeriodLbl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenstruationPeriodLbl">Menstruation Period</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    @include('forms.menstruation_period_form')
                </div>
            </div>
        </div>
    </div>
</div>