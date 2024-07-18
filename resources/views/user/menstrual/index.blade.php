@extends('layouts.app')
@section('page-title', 'Menstrual')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">

    <style>
        .card-title { font-size: 1rem !important; }
        .btn-sm i { font-size: 0.775rem !important; }

        #menstruation_period-error {
            margin-right: 1rem !important;
        }

        .datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
            cursor: not-allowed !important;
        }
    </style>
@endsection

@section('contents')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">Menstrual Data</h6>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#{{ Auth::user()->menstruation_status == 1 ? 'menstrualPeriodModal' : '404' }}" {{ Auth::user()->menstruation_status == 0 ? 'disabled' : '' }}>
                            <i class="btn-icon-prepend fa-solid fa-calendar-plus"></i> Add New Menstruation Period
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="menstrual_table" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Menstruation Date</th>
                                    <th>Remarks</th>
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

    @include('user.modal')

@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/user/menstrual_dt.js') }}"></script>

    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/user/menstruation_period_validation.js') }}"></script>
@endsection