<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mentrual Monitoring App :: @yield('page-title') ::</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/blood.jpg') }}">

    <link rel="stylesheet" href="{{ asset('assets/template/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom_datepicker_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/css/demo_1/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.2.1-web/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/izitoast/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/sweetalert2/sweetalert2.min.css') }}">

    <style>
        .table-responsive table { width: 100% !important }
        .hidden { display: none !important }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .swal2-cancel {
            color: #212529 !important;
            background-color: #ececec !important;
            border-color: #ececec !important;
        }
        
        .swal2-cancel:hover {
            color: #212529 !important;
            background-color: #d9d9d9 !important;
            border-color: lightgray !important;
        }

        .sidebar .sidebar-header .sidebar-brand { font-size: 24px; }
        .sidebar .sidebar-header { padding: 18px; }

        .navbar .navbar-content .navbar-nav .nav-item.nav-apps .dropdown-menu .dropdown-body, .navbar .navbar-content .navbar-nav .nav-item.nav-notifications .dropdown-menu .dropdown-body, .navbar .navbar-content .navbar-nav .nav-item.nav-messages .dropdown-menu .dropdown-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .swal2-popup .swal2-styled:focus {
            box-shadow: none !important;
        }
    </style>

    @yield('styles')
</head>
<body>

    <div class="main-wrapper">
        @if(Auth::user()->user_role_id == 1)
            @include('layouts.admin_sidebar')
        @elseif(Auth::user()->user_role_id == 3)
            @include('layouts.health_worker_sidebar')
        @else
            @include('layouts.user_sidebar')
        @endif

        <div class="page-wrapper">
            @include('layouts.upper_navbar')

            <div class="page-content">
                @yield('contents')
            </div>

            <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
                <p class="text-muted text-center text-md-left">Copyright © {{ date('Y') }} <a href="#" target="_self">MCC</a>. All rights reserved</p>
                <p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Powered by: MCC Dev Team</p>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/template/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/template.js') }}"></script>
    <script src="{{ asset('assets/template/js/datepicker.js') }}"></script>

    <script src="{{ asset('assets/izitoast/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/template/vendors/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        function handleInputCapitalize(e) {
            let inputValue = e.target.value;
            let words = inputValue.split(" ");
            for (let i = 0; i < words.length; i++) {
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
            }
            inputValue = words.join(" ");
            e.target.value = inputValue;
        }
        function formatPhoneNumber(input) {
            let phoneNumber = input.value.replace(/\D/g, '');
            if (phoneNumber.charAt(0) && phoneNumber.charAt(0) !== '9') {
                phoneNumber = '9' + phoneNumber.substring(0, 9);
            }
            if (phoneNumber.length > 10) {
                phoneNumber = phoneNumber.substring(0, 10);
            }
            input.value = phoneNumber;
        }
    </script>

    @yield('scripts')
</body>
</html>