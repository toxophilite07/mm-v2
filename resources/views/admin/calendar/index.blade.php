@extends('layouts.app')
@section('page-title', 'Calendar')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/fullcalendar/fullcalendar.min.css') }}">

    <style>
        .fc-unthemed .fc-today {
            background: #f3f3fe !important;
        }
    </style>
@endsection

@section('contents')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">General Menstrual Calendar</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="alert alert-icon-primary" role="alert">
                <p>
                    <i class="m-0" data-feather="alert-circle"></i>
                    <strong>Information:</strong>
                </p>
                Displays all user's last recorded menstrual period in the calendar.
            </div>
        </div>
    </div>

    <div class="stretch-card mt-3">
        <div class="row flex-grow">
            <div class="col-12">
                <div class="card" id="calendar_card">
                    <div class="card-body">
                        <div id="fullcalendar"></div>
                    </div>
                </div>
                <div id="no_record"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/template/vendors/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/calendar.js') }}"></script>
@endsection