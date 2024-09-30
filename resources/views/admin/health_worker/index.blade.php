@extends('layouts.app')
@section('page-title', 'Health Worker List')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    
    <style>
        .card-title {
            font-size: 1rem!important
        }
        .btn-sm i {
            font-size: .775rem!important
        }
        #birthdate-error {
            margin-right: 1rem!important
        }
        .datepicker table tr td.disabled,
        .datepicker table tr td.disabled:hover {
            cursor: not-allowed!important
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            font-size: .825rem !important;
            border-radius: 2px;
        }

        .remove_assign { margin-top: 0.20rem; }

        p[class*="assigned_"] { 
            padding: 0.2rem 0.4rem;
        }
        p[class*="assigned_"]:hover { 
            background: #f6f8fb; 
            border-radius: 2px;
        }

        #contact_no-error { width: 100% !important }
    </style>
@endsection

@section('contents')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">Health Worker List</h6>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newHealthWorkerModal"><i class="fa-solid fa-plus"></i> Add New Health Worker</button>
                    </div>
                    <div class="table-responsive">
                        <table id="hw_table" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Account Status</th>
                                    <th>Assigning Feminine</th>
                                    <th>Account Status</th>
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
    
    @include('admin.health_worker.modal')

@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/select2/select2.min.js') }}"></script>

    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/health_worker.js') }}"></script>
@endsection