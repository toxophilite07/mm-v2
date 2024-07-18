@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_card.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user_dashboard.css') }}">
@endsection

@section('contents')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
    <h4 id="greeting" class="mb-3 mb-md-0">Good morning {{ Auth::user()->first_name }}!</h4>
</div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-toggle="modal" data-target="#{{ Auth::user()->menstruation_status == 1 ? 'menstrualPeriodModal' : '404' }}" {{ Auth::user()->menstruation_status == 0 ? 'disabled' : '' }} >
                <i class="btn-icon-prepend fa-solid fa-file-circle-plus"></i>
                Add New Menstruation Period
            </button>
        </div>
    </div>

    <div class="stretch-card">
        <div class="row flex-grow">
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-blue shadow-sm">
                    <div class="inner">
                        <h3 id="menstruation_period_count">{{ count($menstruation_period_list) }}</h3>
                        <p>Recorded Period Dates</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-calendar-week"></i>
                    </div>
                    <a href="{{ URL::to('user/menstrual') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-green shadow-sm">
                    <div class="inner">
                        <h3 id="latest_period_date" class="{{ count($menstruation_period_list) !== 0 ?: 'font-weight-light' }}">{{ count($menstruation_period_list) !== 0 ? date('F j, Y', strtotime($menstruation_period_list->first()->menstruation_date)) : 'No recorded data yet' }}</h3>
                        <p>Last Period Date</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-heart-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="stretch-card mt-3">
        <div class="row flex-grow">
            <div class="col-12 col-lg-8">
                <div class="card" id="calendar_card">
                    <div class="card-body">
                        <div id="fullcalendar"></div>
                    </div>
                </div>
                <div id="no_record"></div>
            </div>
            <div class="col-lg-4 d-none d-md-block">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-4">Previous Cycle and Timeline</h6>
                        <div id="external-events" class="external-events">
                            <div id="external-events-listing" class="{{ count($menstruation_period_list) != 0 ?: 'hidden' }}">
                                <p class="mb-1">Next Estimated Menstrual Date</p>
                                <div class="fc-event estimated_period ml-2">&bull; {{ date('F j, Y', strtotime($estimated_next_period)) }}</div>

                                <p class="mb-1">Previous Menstrual Dates</p>
                                @foreach($menstruation_period_list->take(5) as $menstruation_period)
                                    <div class="fc-event previous_periods ml-2">&bull; {{ date('F j, Y', strtotime($menstruation_period->menstruation_date)) }}</div>
                                @endforeach
                            </div>
                        </div>
                        <p class="mb-1 timeline_no_record {{ count($menstruation_period_list) == 0 ?: 'hidden' }}">No menstrual period recorded yet</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.modal')
@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/user/menstruation_period_validation.js') }}"></script>

    <script src="{{ asset('assets/template/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/template/vendors/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/fullcalendar/fullcalendar.min.js') }}"></script>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const greetingElement = document.getElementById('greeting');
    const currentTime = new Date().getHours();
    let greeting = 'Good morning';

    if (currentTime >= 6 && currentTime < 12) {
        greeting = 'Good morning';
    } else if (currentTime >= 12 && currentTime < 18) {
        greeting = 'Good afternoon';
    } else {
        greeting = 'Good evening';
    }

    const userName = '{{ Auth::user()->first_name }}';
    greetingElement.textContent = `${greeting} ${userName} welcome back!👋`;
});
</script>