<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentrual Monitoring App :: Sign In ::</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/blood.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/izitoast/iziToast.min.css') }}">

    <style>
        .form-control { border-radius: 2px !important; }
        .btn-primary {
    background-color: #F6A5BB;
    border: none;
}
.floating-shadow {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5), 0 6px 20px rgba(0, 0, 0, 0.4);
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
    </style>
</head>
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
                                        <form method="POST" action="{{ route('login') }}" autocomplete="off">
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
                                            <div class="mb-3" id="mobileInput">
                                                <label for="contact_no" class="form-label">Mobile #</label>
                                                <div class="input-group">
                                                    <span class="input-addon px-2 rounded-start-1 border border-end-0 d-flex align-items-center justify-content-center" id="basic-addon1">+63</span>
                                                    <input type="text" id="contact_no" name="contact_no" class="form-control" required autofocus placeholder="9123456789" oninput="formatPhoneNumber(this)" maxlength="10" pattern="[9]{1}[0-9]{9}">
                                                </div>
                                                @if ($errors->has('contact_no'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="mb-4">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="•••••••" required>
                                                    <button type="button" class="btn btn-outline-secondary" id="showPasswordBtn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                                                    </button>
                                                </div>
                                                {{-- <label for="password" class="form-label">Password</label>
                                                <input type="password" id="password" name="password" class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="•••••••" required> --}}

                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="form-check">
                                                    <input class="form-check-input primary" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label text-dark" for="remember">Remember me</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary no-hover w-100 py-2 fs-4 rounded-1">Sign In</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var passwordInput = document.getElementById('password');
            var showPasswordBtn = document.getElementById('showPasswordBtn');
    
            showPasswordBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const greetingElement = document.getElementById('greeting');
    const currentTime = new Date();
    const currentHour = currentTime.getHours();
    let greeting = 'Good morning';

    if (currentHour >= 6 && currentHour < 12) {
        greeting = 'Hello 👋, Good morning! Welcome to';
    } else if (currentHour >= 12 && currentHour < 18) {
        greeting = 'Hello 👋, Good afternoon! Welcome to';
    } else {
        greeting = 'Hello 👋, Good evening! Welcome to';
    }

    greetingElement.textContent = greeting;
});
</script>


    @include('auth.response')
</body>
</html>