<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentrual Monitoring App :: Forgot Password ::</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/auth/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/izitoast/iziToast.min.css') }}">

    <style>
        .form-control { border-radius: 2px !important; }
    </style>
</head>
<body style="background-color: #FAE6E7;">
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                @if(Route::has('login'))
                                    <p class="text-center fw-bolder mb-2 h4">Forgot Password</p>
                                    <p class="text-center mb-4">Enter the email address associated with your account and we will send you a link to reset your password.</p>
                                    <form action="{{ URL::to('forgot-password') }}" method="POST" class="submit-once" autocomplete="off">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" id="email" name="email" class="form-control" required autofocus>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3">
                                            <button type="submit" class="btn btn-primary py-2 fs-4 rounded-1"><i class="fa-solid fa-paper-plane"></i> Send Password Reset Link</button>
                                            <a href="{{ route('login') }}" class="btn btn-light py-2 fs-4 rounded-1"><i class="fa-solid fa-paper-plane"></i> Cancel</a>
                                        </div>
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
        $('form.submit-once').submit(function(e){
            if( $(this).hasClass('form-submitted') ){
                e.preventDefault();
                return;
            }
            $(this).addClass('form-submitted').find('button[type=submit]').attr('disabled', true).html('Please wait a moment...');
        });
    </script>

    @include('auth.response')
</body>
</html>