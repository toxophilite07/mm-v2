@extends('layouts.app')
@section('page-title', 'Assigned Feminine List')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/feminine_list.css') }}">
@endsection
<style>
    .pdf-button:hover {
    background-color: #ff4d4d; /* Change to a lighter shade of red or any color you prefer */
    border-color: #ff4dec; /* Change to match the background color */
    color: white; /* Change text color if needed */
}

</style>
@section('contents')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex align-items-baseline mb-md-3" style="margin-bottom: 0 !important;">
                  <h6 class="card-title flex-grow-1 mb-0">Assigned Feminine List</h6>
                   <button type="button" class="btn btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#assignFeminineModal">
                     <i class="fa-solid fa-user-tag"></i> Assign Feminine
                   </button>
                   <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#newFeminineModal">
                     <i class="fa-solid fa-plus"></i> Add New Feminine
                   </button>
                   <button type="button" class="btn btn-sm btn-danger pdf-button" data-toggle="modal" data-target="#">
                     <i class="fa-solid fa-print"></i> PDF
                   </button>
                </div>


                  <p class="card-description mb-4 mt-2">This is your assigned feminine list, other feminine that are not under your care or assigned to you will not be displayed here.</p>
                    <div class="table-responsive">
                        <table id="feminine_table" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Menstruation Status</th>
                                    <th>Account Status</th>
                                    <th>Estimated Menstrual Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('health_worker.feminine.modal')

@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/select2/select2.min.js') }}"></script>
    
    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/health_worker/new_feminine.js') }}"></script>
    <script src="{{ asset('assets/js/health_worker/edit_feminine.js') }}"></script>

    <script src="{{ asset('assets/js/health_worker/feminine_dt.js') }}"></script>
@endsection