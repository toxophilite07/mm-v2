<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <!-- <img class="img-fluid" alt="logo" src="{{ asset('assets/images/blood.jpg') }}" /> -->
        <ul class="navbar-nav">
            <!-- ADMIN NEW PERIOD ADDED NOTIF -->
            @if(Auth::user()->user_role_id == 1)
                <li class="nav-item dropdown nav-notifications">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="calendar"></i>
                        @if(count($new_period_notification) != 0)
                            <div class="indicator" id="period_notification_indicator">
                                <div class="circle"></div>
                            </div>
                        @endif
                    </a>
                    <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            @if(count($new_period_notification) != 0)
                                <p class="mb-0 font-weight-medium period_notification_count">{{ count($new_period_notification) }} New Menstrual Period Recorded</p>
                            @else
                                <p class="mb-0 font-weight-medium period_notification_count">No Notifications</p>
                            @endif
                        </div>
                        <div class="dropdown-body" id="period_notification_container">
                            @if(count($new_period_notification) != 0)
                                @foreach($new_period_notification as $new_period)
                                    <a href="{{ URL::to('admin/feminine-list') }}?p={{ $new_period->user_id }}" id="period_notification_body_{{ $new_period->user_id }}" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="user-plus"></i>
                                        </div>
                                        <div class="content">
                                            <p>{{ $new_period->first_name.' '.$new_period->last_name }}</p>
                                            <p class="sub-text text-muted">New Record: {{ $new_period->formatted_menstruation_date }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="icon">
                                        <i data-feather="coffee"></i>
                                    </div>
                                    <div class="content">
                                        <p>No notifications have a coffee</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </li>
                <!-- ADMIN NEW CREATE ACCOUNT NOTIF -->
                @if(Auth::user()->user_role_id == 1)
                    <li class="nav-item dropdown nav-notifications">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="bell"></i>
                            @if(count($new_notification ?? []) > 0 || count($new_health_worker_notification ?? []) > 0)
                                <div class="indicator" id="notification_indicator">
                                    <div class="circle"></div>
                                </div>
                            @endif
                        </a>
                        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                @if(count($new_notification ?? []) > 0 || count($new_health_worker_notification ?? []) > 0)
                                    <p class="mb-0 font-weight-medium notification_count">
                                        {{ count($new_notification ?? []) + count($new_health_worker_notification ?? []) }} New Notifications
                                    </p>
                                @else
                                    <p class="mb-0 font-weight-medium notification_count">No Notifications</p>
                                @endif
                            </div>
                            <div class="dropdown-body" id="notification_container">
                                @forelse($new_notification ?? [] as $notification)
                                    <a href="{{ URL::to('admin/feminine-list') }}?q={{ $notification->id }}" id="notification_body_{{ $notification->id }}" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="user-plus"></i>
                                        </div>
                                        <div class="content">
                                            <p>{{ $notification->first_name.' '.$notification->last_name }}</p>
                                            <p class="sub-text text-muted">Female user for verification</p>
                                        </div>
                                    </a>
                                @empty
                                    <!-- Handle empty feminine notifications -->
                                @endforelse

                                @forelse($new_health_worker_notification ?? [] as $notification)
                                    <a href="{{ URL::to('admin/health-worker') }}?q={{ $notification->id }}" id="notification_body_hw_{{ $notification->id }}" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="user-plus"></i>
                                        </div>
                                        <div class="content">
                                            <p>{{ $notification->first_name.' '.$notification->last_name }}</p>
                                            <p class="sub-text text-muted">Health worker for verification</p>
                                        </div>
                                    </a>
                                @empty
                                    <!-- Handle empty health worker notifications -->
                                @endforelse

                                @if(count($new_notification ?? []) == 0 && count($new_health_worker_notification ?? []) == 0)
                                    <a href="javascript:;" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="coffee"></i>
                                        </div>
                                        <div class="content">
                                            <p>No notifications, have a coffee</p>
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <!-- Optional: Add a "View all" link if needed -->
                            <!--
                            <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                <a href="{{ URL::to('admin/all-notifications') }}">View all</a>
                            </div>
                            -->
                        </div>
                    </li>
                @endif
  
            @endif

            <!-- BHW NEW PERIOD ADDED NOTIF -->
            @if(Auth::user()->user_role_id == 3)
                <li class="nav-item dropdown nav-notifications">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="calendar"></i>
                        @if(count($new_period_notification) != 0)
                            <div class="indicator" id="period_notification_indicator">
                                <div class="circle"></div>
                            </div>
                        @endif
                    </a>
                    <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            @if(count($new_period_notification) != 0)
                                <p class="mb-0 font-weight-medium period_notification_count">{{ count($new_period_notification) }} New Menstrual Period Recorded</p>
                            @else
                                <p class="mb-0 font-weight-medium period_notification_count">No Notifications</p>
                            @endif
                        </div>
                        <div class="dropdown-body" id="period_notification_container">
                            @if(count($new_period_notification) != 0)
                                @foreach($new_period_notification as $new_period)
                                    <a href="{{ URL::to('health-worker/feminine-list') }}?p={{ $new_period->user_id }}" id="period_notification_body_{{ $new_period->user_id }}" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="user-plus"></i>
                                        </div>
                                        <div class="content">
                                            <p>{{ $new_period->first_name.' '.$new_period->last_name }}</p>
                                            <p class="sub-text text-muted">New Record: {{ $new_period->formatted_menstruation_date }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="icon">
                                        <i data-feather="coffee"></i>
                                    </div>
                                    <div class="content">
                                        <p>No notifications have a coffee</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </li>
            @endif

                <!--  DROPDOWN PROFILE-->
            <!-- ADMIN  -->
            @if(Auth::user()->user_role_id == 1)
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i data-feather="user"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <img src="{{ asset('assets/images/user-avatar.png') }}" alt="">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0">{{ Auth::user()->username ?? (Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name) }}</p>
                            <p class="email text-muted mb-3">{{ Auth::user()->email ?? '+63'.(Auth::user()->contact_no) }}</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <!-- <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link w-100" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li> -->
                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
                                    <i class="link-icon" data-feather="log-out"></i>
                                    <span class="link-title">Log Out</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            @endif
            <!-- FEMALE USER -->
             @if(Auth::user()->user_role_id == 2)
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i data-feather="user"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <img src="{{ asset('assets/images/user.png') }}" alt="">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0">{{ Auth::user()->username ?? (Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name) }}</p>
                            <p class="email text-muted mb-3">{{ Auth::user()->email ?? '+63'.(Auth::user()->contact_no) }}</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <!-- <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link w-100" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li> -->
                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
                                    <i class="link-icon" data-feather="log-out"></i>
                                    <span class="link-title">Log Out</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            @endif
            <!-- BHW -->
            @if(Auth::user()->user_role_id == 3)
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i data-feather="user"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <img src="{{ asset('assets/images/bh-avatar.png') }}" alt="">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0">{{ Auth::user()->username ?? (Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name) }}</p>
                            <p class="email text-muted mb-3">{{ Auth::user()->email ?? '+63'.(Auth::user()->contact_no) }}</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <!-- <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link w-100" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li> -->
                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
                                    <i class="link-icon" data-feather="log-out"></i>
                                    <span class="link-title">Log Out</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            @endif
        </ul>
    </div>
</nav>

<script>
   function confirmLogout() {
    Swal.fire({
        title: 'Confirm Logout',
        text: "Are you sure you want to logout?",
        imageUrl: 'https://i.ibb.co/vQ4p98t/question.png', // Custom icon URL
        imageWidth: 100,  // Adjust the width as needed
        imageHeight: 100, // Adjust the height as needed
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}
</script>