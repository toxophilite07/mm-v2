<div class="modal fade" id="newFeminineModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newFeminineLbl" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFeminineLbl">Register New Feminine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    @include('forms.add_new_form')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editFeminineModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="newFeminineLbl" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFeminineLbl">Edit Feminine Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    @include('forms.edit_form')
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
                    @include('admin.feminine.view')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> Close</button>
            </div>
        </div>
    </div>
</div>