<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menstrual Monitoring App :: Forgot Password Options</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/blood.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/izitoast/iziToast.min.css') }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            background: linear-gradient(180deg, rgba(255, 214, 209, 0.8), rgba(255, 214, 209, 0.9)); /* Gradient background */
        }
        .btn-primary {
            background-color: #F6A5BB;
            border: none;
        }
        .form-control {
            border-radius: 2px !important;
        }
        .btn-light {
            background-color: #ffffff;
            border: 1px solid #ddd;
        }
        .floating-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
            transition: box-shadow 0.3s ease-in-out;
        }
        .floating-shadow:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 12px 40px rgba(0, 0, 0, 0.8);
        }
        .card {
            margin: 40px auto;
            max-width: 500px;
            width: 100%;
        }
        /* Make it responsive */
        @media (max-width: 768px) {
            .card {
                margin: 20px;
                width: 90%;
            }
        }

        .page-wrapper {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="card floating-shadow">
            <div class="card-body">
                <h4 class="text-center fw-bold mb-3">Forgot Password</h4>
                <p class="text-center mb-4">Choose how you want to reset your password:</p>
                <div class="d-flex flex-column gap-3">
                    <a href="{{ URL::to('forgot-password') }}" class="btn btn-primary py-2 fs-5 w-100 rounded-1">
                        <i class="fa-solid fa-envelope"></i> Reset via Email
                    </a>
                    <a href="{{ route('reset-via-sms') }}" class="btn btn-primary py-2 fs-5 w-100 rounded-1">
                        <i class="fa-solid fa-sms"></i> Reset via SMS
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-light py-2 fs-5 w-100 rounded-1">
                        <i class="fa-solid fa-arrow-left"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/auth/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/auth/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
