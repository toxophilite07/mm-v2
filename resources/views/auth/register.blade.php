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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

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
.close-button-container {
        text-align: right;
    }
    .form-control {
        transition: background-color 0.3s ease; /* Smooth transition for background color */
    }
    .strength-indicator {
    height: 5px; /* Height of the indicator */
    background-color: transparent; /* Default to transparent */
    transition: width 0.3s ease, background-color 0.3s ease; /* Smooth transition for width and color */
    border-radius: 3px; /* Rounded corners */
    margin-top: 5px; /* Space above the indicator */
}

.strength-indicator.weak {
    /* Styles for weak can be left empty as we set it in JavaScript */
}

.strength-indicator.moderate {
    /* Styles for moderate can be left empty as we set it in JavaScript */
}

.strength-indicator.strong {
    /* Styles for strong can be left empty as we set it in JavaScript */
}


.mb-4 {
    position: relative; /* Ensure this parent is positioned */
}

.toggle-password {
    position: absolute; /* Absolutely position the toggle icon */
    right: 15px; /* Adjust this value to suit your design */
    top: 61%; /* Center vertically */
    transform: translateY(-50%); /* Adjust to ensure centering */
    cursor: pointer;
    z-index: 10; /* Optional: ensures the icon is above the input */
}

/* Optional: Adjust the input padding */
input[type="password"] {
    padding-right: 40px; /* Give enough space for the icon */
}


@media (max-width: 768px) { /* Adjust the max-width as needed */
    .toggle-password {
        right: 10px; /* Reduce right margin on smaller screens */
        top: 61%; /* Keep centered */
    }
}

</style>
</head>
@include('partials.terms-and-conditions')
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
                            <div class="close-button-container">
                            <button type="button" class="btn-close" aria-label="Close" onclick="closeForm()"></button>
                        </div>
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
                                                        <!-- Input with datalist -->
                                                        <input type="text" id="address" name="address" list="addressOptions" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" value="{{ old('address') }}" placeholder="Type or select your address" oninput="handleInputCapitalize(event)" required>
                                                        
                                                        <!-- Datalist for address options -->
                                                        <datalist id="addressOptions">
                                                            <option value="Tarong Madridejos Cebu"></option>
                                                            <option value="Bunakan Madridejos Cebu"></option>
                                                            <option value="Kangwayan Madridejos Cebu"></option>
                                                            <option value="Kaongkod Madridejos Cebu"></option>
                                                            <option value="Kodia Madridejos Cebu"></option>
                                                            <option value="Maalat Madridejos Cebu"></option>
                                                            <option value="Malbago Madridejos Cebu"></option>
                                                            <option value="Mancilang Madridejos Cebu"></option>
                                                            <option value="Pili Madridejos Cebu"></option>
                                                            <option value="Poblacion Madridejos Cebu"></option>
                                                            <option value="San Agustin Madridejos Cebu"></option>
                                                            <option value="Tabagak Madridejos Cebu"></option>
                                                            <option value="Talangnan Madridejos Cebu"></option>
                                                            <option value="Tugas Madridejos Cebu"></option>
                                                        </datalist>

                                                        <!-- Display error message if validation fails -->
                                                        @if ($errors->has('address'))
                                                            <span class="invalid-feedback">
                                                                <strong>{{ $errors->first('address') }}</strong>
                                                            </span>
                                                        @endif
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
                                                    <label for="contact_no" class="form-label">Contact No. (Optional)</label>
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
                                                <div id="password-strength-indicator" class="strength-indicator"></div>
                                                
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
                                                    <li><span class="fw-bolder">Female Residents</span> - If you are feminine</li>
                                                    <li><span class="fw-bolder">Barangay Health Worker (BHW)</span> - If you are health worker</li>
                                                   </small>
                                                  </div>
                                            </div>  

                                            <div class="form-group">
                                        <label for="role">Role</label>
                                        <select id="role" name="role" class="form-control" required>
                                            <option value="">Select Role</option>
                                            <option value="Feminine">Female Residents</option>
                                            <option value="Health Worker">Barangay Health Worker (BHW)</option>                 
                                        </select>
                                    </div>

                                    <div id="menstruation-status-fields" style="display: none;">
                                        <div class="alert alert-primary" role="alert">
                                            <h5>Select your current menstruation status</h5>
                                            <div class="col-12 mt-2 ml-2">
                                                <small id="menstruation_help" class="form-text text-muted">
                                                    <li><span class="fw-bolder">Regular</span> - Your menstruation is active and is not pregnant</li>
                                                    <li><span class="fw-bolder">Irregular</span> - Your menstruation is not active and might be pregnant or delayed</li>
                                                </small>
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6 col-lg-6 col-sm-12 p-0">
                                            <label for="menstruation_status" class="form-label">Menstruation Status</label>
                                            <select class="form-control" name="menstruation_status" id="menstruation_status">
                                                <option value="" hidden>-- Select --</option>
                                                <option value="1">Regular</option>
                                                <option value="0">Irregular</option>
                                            </select>

                                            @if ($errors->has('menstruation_status'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('menstruation_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group mt-2 mb-2">
                                        <div class="captcha">
                                            <span>{!! captcha_img('math') !!}</span>
                                            <button type="button" class="btn btn-danger reload" id="reload">&#x21bb;</button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                        @error('captcha')
                                            <label for="" class="text-danger">{{$message}}</label>
                                        @enderror
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I have read and accept the 
                                            <a href="javascript:void(0);" id="terms-link">Terms and Conditions</a>
                                        </label>
                                        @if ($errors->has('terms'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('terms') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>Already have an account? <a class="text-primary fw-bold" href="{{ route('login') }}">Sign in</a></span>
                                        <button type="submit" id="submit-button" class="btn btn-primary no-hover py-2 fs-4 rounded-1">
                                            <i class="fa-regular fa-circle-check mr-1"></i> Confirm Registration
                                            <span id="loading-indicator" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                        </button>
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
    <script src="{{ asset('assets/auth/js/register.js') }}"></script>



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


        //close form
        function closeForm() {
        window.location.href = '/'; // Redirects to the main page or index page
    }
    </script>

    <!-- PASSWROD INDICATOR -->
    <script>
    // Function to capitalize each word as user types
    function checkPasswordStrength(password) {
        // Basic password strength checking logic
        const strengthIndicator = document.getElementById('password-strength-indicator');
        let strength = 'Weak';
        if (password.length > 8) strength = 'Moderate';
        if (/[A-Z]/.test(password) && /[0-9]/.test(password)) strength = 'Strong';
        
        strengthIndicator.textContent = strength;
        strengthIndicator.style.color = strength === 'Strong' ? 'green' : (strength === 'Moderate' ? 'orange' : 'red');
    }
    </script>

    <!-- LOADING FOR PRESSING BUTTON -->
    <script>
    function handleFormSubmit(event) {
        event.preventDefault(); // Prevent default form submission

        const submitButton = document.getElementById('submit-button');
        const loadingIndicator = document.getElementById('loading-indicator');

        // Show loading indicator
        loadingIndicator.classList.remove('d-none');
        submitButton.disabled = true; // Disable the button to prevent multiple submissions

        // Simulate form submission (replace this with your actual submission logic)
        setTimeout(() => {
            // After form submission logic, you can hide the loading indicator
            loadingIndicator.classList.add('d-none');
            submitButton.disabled = false; // Re-enable the button if needed

            // You can handle any further logic here (e.g., redirect, update UI)
        }, 2000); // Simulating a 2-second delay for demonstration
    }
    </script>

    
</body>
</html>