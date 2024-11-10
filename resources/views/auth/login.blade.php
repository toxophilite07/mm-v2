<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentrual Monitoring App :: Sign In ::</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/blood.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/izitoast/iziToast.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


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
    .toggle-password {
        position: absolute;
        right: 10px;
        top: 55%;
        transform: translateY(-50%);
        cursor: pointer;
        }
        .g-recaptcha{
            transform: scale(0.90);
            transform-origin: 0 0;
        }
        @media{
            g-recaptcha{
                transform: scale(0.90);
                transform-origin: 0 0;  
            }
        }
    </style>
</head>
@include('partials.cookie-consent')
<body style="background-color: #FFD6D1;">
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body floating-shadow">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img style="width: 200px" class="img-fluid" alt="logo" src="{{ asset('assets/images/blood.jpg') }}" />
                                </div>
                                <br>
                                <div>
                               <h4 id="greeting" class="mb-3 mb-md-0" style="text-align: center;"></h4>
                                  </div>
                                <br>
                                @if(Route::has('login'))
                                    <p class="text-center fw-bolder mb-1 h4">Menstrual Monitoring App</p>
                                    @auth
                                        @if(Auth::user()->user_role_id == 1)
                                            <p class="text-center mb-4">Leaving already? click below to return to dashboard</p>
                                            <a href="{{ URL::to('admin/dashboard') }}" class="btn btn-primary w-100 py-2 fs-4 rounded-1">Return to Dashboard</a>
                                        @elseif(Auth::user()->user_role_id == 3)
                                            <p class="text-center mb-4">Leaving already? click below to return to dashboard</p>
                                            <a href="{{ URL::to('health-worker/dashboard') }}" class="btn btn-primary w-100 py-2 fs-4 rounded-1">Return to Dashboard</a>
                                        @else
                                            <p class="text-center mb-4">Leaving already? click below to return to dashboard</p>
                                            <a href="{{ URL::to('user/dashboard') }}" class="btn btn-primary w-100 py-2 fs-4 rounded-1">Return to Dashboard</a>
                                        @endif
                                    @else
                                        <p class="text-center mb-4">Sign in using email or mobile # to your account to proceed</p>
                                        <form method="POST" action="{{ route('login') }}" autocomplete="off" id="loginForm">
                                            @csrf
                                            <div class="mb-3" id="emailInput">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Enter email ex: juany@sample.com" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <!-- <div class="mb-3" id="mobileInput">
                                                <label for="contact_no" class="form-label">Mobile # (Optional)</label>
                                                <div class="input-group">
                                                    <span class="input-addon px-2 rounded-start-1 border border-end-0 d-flex align-items-center justify-content-center" id="basic-addon1">+63</span>
                                                    <input type="text" id="contact_no" name="contact_no" class="form-control" required autofocus placeholder="9123456789" oninput="formatPhoneNumber(this)" maxlength="10" pattern="[9]{1}[0-9]{9}">
                                                </div>
                                                @if ($errors->has('contact_no'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                                    </span>
                                                @endif
                                            </div> -->

                                            <div class="mb-4">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="•••••••" required>
                                                    <span class="input-group-text">
                                                    <i class="fas fa-eye-slash toggle-password" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')"></i>
                                                </span>
                                             </div>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <!-- <div class="col-12 col-md-6 mb-4">
                                                <div id="recaptcha" class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" required></div>
                                                <p id="captcha-error" style="color: red; display: none;">
                                                    Please verify that you are not a robot
                                                </p>
                                            </div>    -->
                                            <div class="col-12 col-md-6 mb-4">
                                                <div id="hcaptcha" class="h-captcha" data-sitekey="{{ env('HCAPTCHA_SITE_KEY') }}" required></div>
                                                <p id="captcha-error" style="color: red; display: none;">
                                                    Please verify that you are not a robot
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="form-check">
                                                    <input class="form-check-input primary" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label text-dark" for="remember">Remember me</label>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100 py-2 fs-4 rounded-1" id="loginButton" {{ session('login-error') && str_contains(session('login-error'), 'Too many login attempts') ? 'disabled' : '' }}>
                                                Sign In
                                            </button>

                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                @if(Route::has('register'))
                                                    <a class="text-primary fw-bold" href="{{ route('register') }}">Register an Account</a>
                                                @endif
                                                <a class="text-primary fw-bold" href="{{ URL::to('forgot-password') }}">Forgot Password</a>
                                            </div>
                                        </form>
                                    @endauth
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- <script src="https://hcaptcha.com/1/api.js" async defer></script> -->


    <!-- DISABLE EMAIL WHEN HAVE A NUMBER -->
    <script>
        const email = document.getElementById("email");
        const contact_no = document.getElementById("contact_no");

        email.addEventListener("input", function () {
            if(email.value){
                contact_no.disabled = true;
                contact_no.value = "";
            }else{
                contact_no.disabled = false;
            }
        });

        contact_no.addEventListener("input", function () {
            if(contact_no.value){
                email.disabled = true;
                email.value = "";
            }else{
                email.disabled = false;
            }
        });

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

    <!-- PASSWORD HIDE AND UNHIDE -->
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

    <!-- GREETINGS -->
    <script>
               $(document).ready(function() {
            var greetingMessages = [
                "Hello there! Ready to monitor your menstrual health?",
                "Welcome back! Let’s track your cycle together!",
                "Hi! We're here to help you with your menstrual health!",
                "Greetings! Ready to take charge of your health?"
            ];
            var randomGreeting = greetingMessages[Math.floor(Math.random() * greetingMessages.length)];
            $("#greeting").text(randomGreeting);
        });

      // Get references to the elements
        // const loginForm = document.getElementById('loginForm');
        // const loginButton = document.getElementById('loginButton');
        // const buttonText = document.getElementById('buttonText');
        // const loadingSpinner = document.getElementById('loadingSpinner');
        // const captchaError = document.getElementById('captcha-error');

        // // Add event listener to the form submit event
        // loginForm.addEventListener('submit', function(event) {
        //     // Check if reCAPTCHA is completed
        //     const recaptchaResponse = grecaptcha.getResponse();

        //     // If reCAPTCHA is not checked, prevent form submission
        //     if (recaptchaResponse.length === 0) {
        //         event.preventDefault();  // Stop form submission
        //         captchaError.style.display = "block";  // Show error message
        //     } else {
        //         // Hide the error message if reCAPTCHA is completed
        //         captchaError.style.display = "none";

        //         // Disable the submit button to prevent multiple submissions
        //         loginButton.disabled = true;

        //         // Show the loading spinner and hide the button text
        //         buttonText.classList.add('d-none');
        //         loadingSpinner.classList.remove('d-none');
        //     }
        // });

    // // Get references to the elements
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const captchaError = document.getElementById('captcha-error');

    // Add event listener to the form submit event
    loginForm.addEventListener('submit', function(event) {
        // Check if hCaptcha is completed
        const hcaptchaResponse = hcaptcha.getResponse();

        // If hCaptcha is not completed, prevent form submission
        if (hcaptchaResponse.length === 0) {
            event.preventDefault();  // Stop form submission
            
            // Show error message
            captchaError.style.display = "block";  
            captchaError.textContent = "Please complete the captcha to proceed."; // Clear error message
            
            // Reset the hCaptcha for user to try again
            hcaptcha.reset();

            // Enable the submit button to allow for retrying
            loginButton.disabled = false;

            // Show the button text again and hide the loading spinner
            buttonText.classList.remove('d-none');
            loadingSpinner.classList.add('d-none');
        } else {
            // Hide the error message if hCaptcha is completed
            captchaError.style.display = "none";

            // Disable the submit button to prevent multiple submissions
            loginButton.disabled = true;

            // Show the loading spinner and hide the button text
            buttonText.classList.add('d-none');
            loadingSpinner.classList.remove('d-none');
        }
    });
    </script>

        @include('auth.response')
    </body>
    </html>
