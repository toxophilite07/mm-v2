@extends('layouts.app')
@section('page-title', 'Feminine List')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/feminine_list.css') }}">
@endsection

@section('contents')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">Feminine List</h6>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newFeminineModal"><i class="fa-solid fa-plus"></i> Add New Feminine</button>
                    </div>
                    <div class="table-responsive">
                        <table id="feminine_table" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Menstruation Status</th>
                                    <th>Assign Status</th>
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

    @include('admin.feminine.modal')

@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/select2/select2.min.js') }}"></script>

    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/form_validation.js') }}"></script>
    <script src="{{ asset('assets/js/edit_form_validation.js') }}"></script>
    <script src="{{ asset('assets/js/admin/feminine_list.js') }}"></script>
@endsection