@extends('layouts.app')
@section('page-title', 'Account Settings')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">

    <style>
        .card-title { font-size: 1rem !important; }
        .btn-sm i { font-size: 0.775rem !important; }
    </style>
@endsection

@section('contents')

    <div class="row">
        <div class="col-12">
            <div class="alert alert-icon-primary" role="alert">
                <p>
                    <i class="m-0" data-feather="alert-circle"></i>
                    <strong>Information:</strong>
                </p>
                Only the verfied accounts can be interacted on this list
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">Account List</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="feminine_account_table" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Active Email</th>
                                    <th>User Role</th>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/template/vendors/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/admin/account_settings.js') }}"></script>

<script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endsection