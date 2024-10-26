@extends('layouts.app')
@section('page-title', 'Menstrual')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ai.css') }}">
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
@include('components.chatbox')
@section('contents')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-baseline mb-2 mb-md-3">
                    @csrf
                    <h6 class="card-title mb-2 mb-md-0">Menstrual Data</h6>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-toggle="modal" data-target="#{{ Auth::user()->menstruation_status == 1 ? 'menstrualPeriodModal' : '404' }}" {{ Auth::user()->menstruation_status == 0 ? 'disabled' : '' }}>
                        <i class="btn-icon-prepend fa-solid fa-calendar-plus me-2"></i>&nbsp;&nbsp;
                        <span>Add Early Menstruation Period</span>
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
    <!-- <button class="floating-icon" onclick="toggleChatbox()">
        <i class="fa-solid fa-robot"></i>
    </button>

    <div class="chatbox" id="chatbox">
        <div class="chatbox-header">
            <span>AI Chatbox</span>
            <button onclick="closeChatbox()">X</button>
        </div>
        <div class="chatbox-body" id="chatbox-body">
             Chat content will go here 
            <p>Welcome! How can I assist you today?</p>
        </div>
        <div class="chatbox-footer">
            <input type="text" id="chatbox-input" placeholder="Type a message...">
            <button onclick="sendMessage()"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
    </div> -->

@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/user/menstrual_dt.js') }}"></script>
    <script src="{{ asset('assets/js/user/ai.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/user/menstruation_period_validation.js') }}"></script>
@endsection