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
                                    <p class="text-center fw-bolder mb-2 h4">Reset Password</p>
                                    <p class="text-center mb-4">Enter a new password for your account.</p>
                                    <form action="{{ URL::to('reset-password') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                        <div class="mb-4">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" id="password" name="password" class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" required>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mb-4">
                                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control  {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" required>

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

    @include('auth.response')
</body>
</html>