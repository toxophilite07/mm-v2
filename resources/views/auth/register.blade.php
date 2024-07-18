<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentrual Monitoring App :: Sign Up ::</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/blood.jpg') }}" />
    
    <link rel="stylesheet" href="{{ asset('assets/template/css/demo_1/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.2.1-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom_datepicker_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/custom_style.css') }}">
    <style>
        .form-control { border-radius: 2px !important; }
        footer {
            text-align: center;
            padding: 1em;
            background-color: transpent;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            footer {
                font-size: 0.8em;
            }
        }

        @media (min-width: 769px) {
            footer {
                font-size: 1em;
            }
        }
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
</style>
</head>
<body style="background-color: #FFD6D1;">
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100 py-5">
                <div class="row justify-content-center w-100">
                        @auth
                            <div class="col-md-3">
                        @else
                            <div class="col-md-8 col-lg-6">
                        @endauth
                        <div class="card mb-0">
                            <div class="card-body floating-shadow">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img style="width: 200px" class="img-fluid" alt="logo" src="{{ asset('assets/images/blood.jpg') }}" />
                                </div>
                                <br>
                                <h4 id="greeting" class="mb-3 mb-md-0" style="text-align: center;"></h4>
                                  <br>
                                <p class="text-center fw-bolder mb-1 h4">Menstrual Monitoring App!</p>
                                @if(Route::has('register'))
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
                                        <p class="text-center mb-4">Please fill-up the form to create an account.</p>
                                        <form id="sign_up_form" method="POST" action="{{ route('register') }}" autocomplete="off">
                                            @csrf

                                            <div class="row">
                                                <div class="col-lg-4 col-sm-12 mb-3">
                                                    <label for="first_name" class="form-label">First Name</label>
                                                    <input type="text" id="first_name" name="first_name" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" value="{{ old('first_name') }}" placeholder="Enter your first name" autofocus oninput="handleInputCapitalize(event)">
            
                                                    @if ($errors->has('first_name'))
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('first_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
            
                                                <div class="col-lg-4 col-sm-12 mb-3">
                                                    <label for="middle_name" class="form-label">Middle Name</label>
                                                    <input type="text" id="middle_name" name="middle_name" class="form-control {{ $errors->has('middle_name') ? 'is-invalid' : '' }}" value="{{ old('middle_name') }}" placeholder="Enter your middle name" oninput="handleInputCapitalize(event)">
                                                </div>
            
                                                <div class="col-lg-4 col-sm-12 mb-3">
                                                    <label for="last_name" class="form-label">Last Name</label>
                                                    <input type="text" id="last_name" name="last_name" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" value="{{ old('last_name') }}" placeholder="Enter your last name" oninput="handleInputCapitalize(event)">
            
                                                    @if ($errors->has('last_name'))
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('last_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-8 col-sm-12 mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <input type="text" id="address" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" value="{{ old('address') }}" placeholder="Enter your address" oninput="handleInputCapitalize(event)">
                                                </div>
    
                                                <div class="col-lg-4 col-sm-12 mb-4">
                                                    <label for="birthdate" class="form-label">Birthdate</label>
                                                    <div class="input-group date datepicker" id="birthdate_datepicker">
                                                        <input type="text" id="birthdate" name="birthdate" class="form-control">
                                                        <span class="input-group-addon">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                                            </svg>
                                                        </span>
                                                    </div>
    
                                                    @if ($errors->has('birthdate'))
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('birthdate') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Enter email ex: juany@sample.com">
    
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="contact_no" class="form-label">Contact No. (optional)</label>
                                                    <div class="input-group">
                                                        <span class="input-addon px-2 rounded-start-1 border border-end-0 d-flex align-items-center justify-content-center" id="basic-addon1">+63</span>
                                                        <input type="text" id="contact_no" name="contact_no" class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" value="{{ old('contact_no') }}" placeholder="9123456789" oninput="formatPhoneNumber(this)" maxlength="10" pattern="[9]{1}[0-9]{9}">
                                                    </div>

                                                    @if ($errors->has('contact_no'))
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('contact_no') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" id="password" name="password" class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="•••••••" required>

                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mb-4">
                                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control  {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" placeholder="•••••••" required>

                                                @if ($errors->has('password_confirmation'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                             
                                            <div class="alert alert-primary" role="alert">
                                                <h5>Select your Role</h5>
                                                 <div class="col-12 mt-2 ml-2">
                                                   <small id="role_help" class="form-text text-muted">
                                                    <li><span class="fw-bolder">Feminine</span> - If you are feminine</li>
                                                    <li><span class="fw-bolder">Health Worker</span> - If you are health worker</li>
                                                   </small>
                                                  </div>
                                            </div>  

                                            <div class="form-group">
                                        <label for="role">Role</label>
                                        <select id="role" name="role" class="form-control" required>
                                            <option value="">Select Role</option>
                                            <option value="Health Worker">Health Worker</option>
                                            <option value="Feminine">Feminine</option>
                                        </select>
                                    </div>

                                    <div id="menstruation-status-fields" style="display: none;">
                                        <div class="alert alert-primary" role="alert">
                                            <h5>Select your current menstruation status</h5>
                                            <div class="col-12 mt-2 ml-2">
                                                <small id="menstruation_help" class="form-text text-muted">
                                                    <li><span class="fw-bolder">Active</span> - Your menstruation is active and is not pregnant</li>
                                                    <li><span class="fw-bolder">Inactive</span> - Your menstruation is not active and might be pregnant or delayed</li>
                                                </small>
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6 col-lg-6 col-sm-12 p-0">
                                            <label for="menstruation_status" class="form-label">Menstruation Status</label>
                                            <select class="form-control" name="menstruation_status" id="menstruation_status">
                                                <option value="" hidden>-- Select --</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>

                                            @if ($errors->has('menstruation_status'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('menstruation_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                            <div class="d-flex align-items-center justify-content-between">
                                                <span>Already have an account? <a class="text-primary fw-bold " href="{{ route('login') }}">Sign in</a></span>
                                                <button type="submit" class="btn btn-primary no-hover py-2 fs-4 rounded-1"><i class="fa-regular fa-circle-check mr-1"></i> Confirm Registration</button>
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
    <!-- <footer class="text-center mt-4">
        <p>Menstrual Monitoring App v2</p>
    </footer> -->

    <script src="{{ asset('assets/auth/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/auth/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/datepicker.js') }}"></script>

    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/sign_up_validation.js') }}"></script>

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
 <script>
    document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const menstruationFields = document.getElementById('menstruation-status-fields');
            const menstruationStatusSelect = document.getElementById('menstruation_status');

            roleSelect.addEventListener('change', function() {
                const selectedRole = roleSelect.value;
                if (selectedRole === 'Feminine') {
                    menstruationFields.style.display = 'block';
                    menstruationStatusSelect.setAttribute('required', 'required');
                } else {
                    menstruationFields.style.display = 'none';
                    menstruationStatusSelect.removeAttribute('required');
                    menstruationStatusSelect.value = ''; // Clear value if not required
                }
            });

            roleSelect.dispatchEvent(new Event('change')); // Trigger change event initially
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
</body>
</html>