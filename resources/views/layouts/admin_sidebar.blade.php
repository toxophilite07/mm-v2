<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ URL::to('admin/dashboard') }}" class="sidebar-brand" onclick="showLoading();">M<small>enstrual</small> <span class="font-weight-bold">M<small>onitoring</small></span></a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ URL::to('admin/dashboard') }}" class="nav-link" onclick="showLoading();">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">General</li>
            <li class="nav-item">
                <a href="{{ URL::to('admin/feminine-list') }}" class="nav-link" onclick="showLoading();">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Female Residence List</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ URL::to('admin/health-worker') }}" class="nav-link" onclick="showLoading();">
                    <i class="link-icon" data-feather="smile"></i>
                    <span class="link-title">Health Worker</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ URL::to('admin/calendar') }}" class="nav-link" onclick="showLoading();">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Calendar</span>
                </a>
            </li>
            <li class="nav-item nav-category">Configuration</li>
            <li class="nav-item">
                <a href="{{ URL::to('admin/account-settings') }}" class="nav-link" onclick="showLoading();">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">Account</span>
                </a>
            </li>
                        <!-- <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="link-icon" data-feather="log-out"></i>
                    <span class="link-title">Log Out</span>
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
</nav>


<div id="loadingIndicator" style="display: none;">
    <div class="spinner"></div>
    <h4>Please wait...</h4>
</div>

<style>
    /* Spinner Styles */
    #loadingIndicator {
        position: fixed; /* Fixed positioning */
        top: 50%; /* Center vertically */
        left: 50%; /* Center horizontally */
        transform: translate(-50%, -50%); /* Move back by half the width and height */
        display: flex; /* Use flexbox for alignment */
        flex-direction: column; /* Stack spinner and text vertically */
        align-items: center; /* Center items horizontally */
        justify-content: center; /* Center items vertically */
        z-index: 1000; /* Ensure it's on top */
        border-radius: 10px; /* Rounded corners */
        padding: 20px; /* Padding around content */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Shadow effect for depth */
        width: 80%; /* Responsive width */
        max-width: 300px; /* Maximum width for larger screens */
        text-align: center; /* Center text inside */
        background: white; /* No background */
    }

    .spinner {
        border: 8px solid #f3f3f3; /* Light grey */
        border-top: 8px solid #3498db; /* Blue */
        border-radius: 50%; /* Round spinner */
        width: 50px; /* Adjust size for mobile */
        height: 50px; /* Adjust size for mobile */
        animation: spin 1s linear infinite; /* Spinner animation */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Styles */
    @media (max-width: 600px) {
        .spinner {
            width: 40px; /* Smaller spinner for mobile */
            height: 40px; /* Smaller spinner for mobile */
        }

        #loadingIndicator {
            width: 70%; /* Adjust width for mobile */
            padding: 15px; /* Adjust padding for smaller screens */
        }
    }
</style>



<script>
function showLoading() {
    document.getElementById('loadingIndicator').style.display = 'flex'; // Show loading indicator
}

function hideLoading() {
    document.getElementById('loadingIndicator').style.display = 'none'; // Hide loading indicator
}
    function confirmLogout() {
        Swal.fire({
            title: 'Confirm Logout',
            text: "Are you sure you want to logout?",
            icon: 'warning',
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


