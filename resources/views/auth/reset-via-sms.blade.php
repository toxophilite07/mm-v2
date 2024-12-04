<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentrual Monitoring App :: Forgot Password via SMS::</title>
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
        .close-button-container {
        text-align: right;
        }
        .form-control {
            transition: background-color 0.3s ease; /* Smooth transition for background color */
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
                            <!-- Close button container -->
                            <div class="close-button-container text-end p-2">
                                <button type="button" class="btn-close" aria-label="Close" onclick="closeForm()"></button>
                            </div>
                            <div class="card-body">
                                <p class="text-center fw-bolder mb-2 h4">Reset Password via SMS</p>
                                <p class="text-center mb-4">Enter the mobile number associated with your account, and we will send you a link to reset your password.</p>
                                <form action="{{ route('send.reset.link.sms') }}" method="POST" class="submit-once" autocomplete="off">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="contact_no" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+63</span>
                                            <input type="text" id="contact_no" name="contact_no" 
                                                class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" 
                                                value="{{ old('contact_no') }}" placeholder="9123456789" 
                                                maxlength="10" pattern="[9]{1}[0-9]{9}" 
                                                aria-label="Phone Number" aria-describedby="contact_no_error" required>
                                        </div>
                                        @error('contact_no')
                                        <div id="contact_no_error" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mt-3">
                                        <button type="submit"title="Send Password Reset Link" class="btn btn-primary py-2 fs-5 w-100 mb-2 mb-md-0 me-md-2 rounded-1">
                                            <i class="fa-solid fa-paper-plane"></i> Send Password Reset Link
                                        </button>
                                        <a href="{{ route('forgot-password-options') }}" title="Back to Options" class="btn btn-light py-2 fs-5 w-100 rounded-1">
                                            <i class="fa-solid fa-paper-plane"></i> Back to Options
                                        </a>
                                    </div>
                                </form>
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
        $('form.submit-once').submit(function(e){
            if( $(this).hasClass('form-submitted') ){
                e.preventDefault();
                return;
            }
            $(this).addClass('form-submitted').find('button[type=submit]').attr('disabled', true).html('Please wait a moment...');
        });


                //close form
        function closeForm() {
        window.location.href = '/login'; // Redirects to the main page or index page
        }
    </script>

    @include('auth.response')
</body>
</html>