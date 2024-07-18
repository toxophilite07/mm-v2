@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_card.css') }}">

    <style>
        #status_chart, #yearly_period {
            width: 100%;
            height: 430px;
        }
    </style>
@endsection

@section('contents')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 id="greeting" class="mb-3 mb-md-0">Welcome back {{ Auth::user()->last_name }}!</h4>
        </div>
    </div>

    <div class="stretch-card">
        <div class="row flex-grow">
            <div class="col-lg-3 col-sm-6">
                <div class="card-box  shadow-sm" style="background-color: #FD5DA8;">
                    <div class="inner">
                        <h3 id="assigned_feminine_count">{{ $assign_feminine_count }}</h3>
                        <p>Assigned Feminine</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-tag"></i>
                    </div>
                    <a href="{{ URL::to('health-worker/feminine-list') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-green shadow-sm">
                    <div class="inner">
                        <h3 id="active_feminine_count">{{ $count['active_feminine_count'] }}</h3>
                        <p>Active Period</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <a href="{{ URL::to('health-worker/feminine-list') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-cyan shadow-sm">
                    <div class="inner">
                        <h3 id="inactive_feminine_count">{{ $count['inactive_feminine_count'] }}</h3>
                        <p>Inactive Peroid</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-tag"></i>
                    </div>
                    <a href="{{ URL::to('health-worker/feminine-list') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

        <!-- <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Feminine Status Chart</h5>
                    <div id="status_chart"></div>
                </div>
            </div>
        </div>
    </div> -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('assets/amcharts/amcharts.com_lib_5_index.js') }}"></script>
    <script src="{{ asset('assets/amcharts/amcharts.com_lib_5_percent.js') }}"></script>
    <script src="{{ asset('assets/amcharts/amcharts.com_lib_5_xy.js') }}"></script>
    <script src="{{ asset('assets/amcharts/amcharts.com_lib_5_themes_Animated.js') }}"></script>

    <script src="{{ asset('assets/js/health_worker/pie_chart.js') }}"></script>
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
    greetingElement.textContent = `${greeting} ${userName} welcome back! 👋`;
});
</script>