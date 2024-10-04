@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_card.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ai.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
@include('components.chatbox')
@section('contents')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 id="greeting" class="mb-3 mb-md-0">Good morning {{ Auth::user()->first_name }}!</h4>
    <!--Monitoring BHW name here!-->
    <div class="mt-4">
    <h6>Monitored by: 
    @if($health_worker)
    {{ $health_worker->health_worker_full_name }}
    @else
    {{ 'No health worker assigned' }}
    @endif
</h6>

    <br>
</div>
   </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
         <!-- <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-toggle="modal" data-target="#{{ Auth::user()->menstruation_status == 1 ? 'menstrualPeriodModal' : '404' }}" {{ Auth::user()->menstruation_status == 0 ? 'disabled' : '' }} >
                <i class="btn-icon-prepend fa-solid fa-file-circle-plus"></i>
                Add New Menstruation Period
            </button> -->
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" 
            data-toggle="modal" 
            data-target="#{{ Auth::user()->menstruation_status == 1 && count($menstruation_period_list) === 0 ? 'menstrualPeriodModal' : '404' }}" 
            {{ Auth::user()->menstruation_status == 0 || count($menstruation_period_list) !== 0 ? 'disabled' : '' }}>
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
            <div class="col-lg-4 d-md-block">
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

  
  <!-- <button class="floating-icon" onclick="toggleChatbox()">
        <i class="fa-solid fa-robot"></i>
    </button>

     <div class="chatbox" id="chatbox">
        <div class="chatbox-header">
            <span>AI Chatbox</span>
            <button onclick="closeChatbox()"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="chatbox-body" id="chatbox-body">
            < Chat content will go here 
            <div class="chat-message ai-response">Welcome! How can I assist you today?</div>
        </div>
        <div class="chatbox-footer">
            <input type="text" id="chatbox-input" placeholder="Type a message..." onkeypress="handleKeyPress(event)">
            <button onclick="sendMessage()"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
    </div> --> 
@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/user/menstruation_period_validation.js') }}"></script>
    <script src="{{ asset('assets/js/user/ai.js') }}"></script>
    <script src="{{ asset('assets/js/user/new_period_alerttt.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/fullcalendar/fullcalendar.min.js') }}"></script>
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

@if($reminder_needed)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Reminder',
            text: "Your estimated period date is today. Has your period started?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Send an AJAX request to automatically add the period record
                fetch('/user/auto-add-period', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        menstruation_period: '{{ $estimated_next_period }}',
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Your period has been recorded.',
                            icon: 'success'
                        }).then(() => {
                            location.reload(); // Refresh the page to update the data
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                });
            } else {
                Swal.fire('Reminder', "We'll remind you later.", 'info');
            }
        });
    });
</script>
@endif

@endsection
