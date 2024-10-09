<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menstrual Monitoring App :: Forgot Password ::</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/auth/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/blood.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/izitoast/iziToast.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .form-control { border-radius: 2px !important; }
        .btn-primary {
            background-color: #F6A5BB;
            border: none;
        }
        .floating-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
            transition: box-shadow 0.3s ease-in-out;
        }

        .floating-shadow:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 12px 40px rgba(0, 0, 0, 0.8);
        }
        .btn-primary.no-hover:hover {
            background-color: #F6A5BB; /* Default Bootstrap primary color */
            border-color: #0d6efd; /* Default Bootstrap primary color */
        }
        .card {
            margin-top: 40px !important;
            margin-bottom: 40px !important;
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 75%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body style="background-color: #FFD6D1;">
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                @if(Route::has('login'))
                                    <p class="text-center fw-bolder mb-2 h4">Reset Password</p>
                                    <p class="text-center mb-4">Enter a new password for your account.</p>
                                    <form action="{{ URL::to('reset-password') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                        <div class="mb-4 password-container">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                                            <i class="fas fa-eye-slash toggle-password" id="togglePassword" onclick="togglePasswordVisibility()"></i>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mb-4 password-container">
                                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" required>
                                            <i class="fas fa-eye-slash toggle-password" id="togglePasswordConfirmation" onclick="togglePasswordConfirmationVisibility()"></i>

                                            @if ($errors->has('password_confirmation'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 py-2 fs-4 rounded-1">Confirm Changes</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/auth/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/auth/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/izitoast/iziToast.min.js') }}"></script>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }

        function togglePasswordConfirmationVisibility() {
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const toggleIcon = document.getElementById('togglePasswordConfirmation');

            if (passwordConfirmationInput.type === 'password') {
                passwordConfirmationInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordConfirmationInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>

    @include('auth.response')
</body>
</html>
