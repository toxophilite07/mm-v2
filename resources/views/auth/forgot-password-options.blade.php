<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menstrual Monitoring App :: Forgot Password Options</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/blood.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/izitoast/iziToast.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
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
        .close-button-container {
        text-align: right;
         }
    </style>
</head>
<body style="background-color: #FFD6D1;">
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="card floating-shadow">
            <div class="close-button-container text-end p-2">
                <button type="button" class="btn-close" aria-label="Close" title="Close Form" onclick="closeForm()"></button>
            </div>
            <div class="card-body">
                @if(request('error') === 'expired')
                    <script>
                        iziToast.error({
                            close: false,
                            displayMode: 2,
                            layout: 2,
                            drag: false,
                            position: "topCenter",
                            title: 'Oops!',
                            message: 'This password reset link has expired. Please request a new one.',
                            transitionIn: "bounceInDown",
                            transitionOut: "fadeOutUp",
                        });
                    </script>
                @endif
                <h4 class="text-center fw-bold mb-3">Forgot Password</h4>
                <p class="text-center mb-4">Choose how you want to reset your password:</p>
                <div class="d-flex flex-column gap-3">
                    <a href="{{ URL::to('forgot-password') }}" title="Send Password Reset Link via Email" class="btn btn-primary py-2 fs-5 w-100 rounded-1">
                        <i class="fa-solid fa-envelope"></i> Send password reset link via Email
                    </a>
                    <button type="button" id="sendOtpEmail" class="btn btn-primary py-2 fs-5 w-100 rounded-1" data-bs-toggle="modal" data-bs-target="#emailOtpModal">
                        <i class="fa-solid fa-envelope"></i> Send OTP via Email
                    </button>
                    <div class="modal fade" id="emailOtpModal" tabindex="-1" aria-labelledby="emailOtpModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="emailOtpModalLabel">Enter Your Email</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="sendOtpForm">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="otpEmail" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="otpEmail" name="otpEmail" placeholder="Enter your email" required>
                                       
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="sendOtpButton" class="btn btn-primary" disabled>
                                            <span id="buttonText"><i class="fa-solid fa-paper-plane"></i> Send OTP</span>
                                            <span id="buttonIndicator" style="display: none;">
                                                <i class="fa fa-spinner fa-spin"></i> Please wait a moment...
                                            </span>
                                        </button>
                                    </div>

                                    <script>
                                        const emailInput = document.getElementById('otpEmail');
                                        const sendOtpButton = document.getElementById('sendOtpButton');

                                        emailInput.addEventListener('input', function () {
                                            // Enable the button only if the input is not empty and is a valid email format
                                            if (emailInput.value.trim() !== '' && validateEmail(emailInput.value)) {
                                                sendOtpButton.disabled = false;
                                            } else {
                                                sendOtpButton.disabled = true;
                                            }
                                        });

                                        // Function to validate email format
                                        function validateEmail(email) {
                                            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                            return emailPattern.test(email);
                                        }
                                    </script>

                                    <script>
                                        document.getElementById('sendOtpButton').addEventListener('click', function () {
                                            // Change button text and show indicator
                                            const buttonText = document.getElementById('buttonText');
                                            const buttonIndicator = document.getElementById('buttonIndicator');

                                            // Hide "Send OTP" text
                                            buttonText.style.display = 'none';
                                            // Show the spinner and "Please wait..." text
                                            buttonIndicator.style.display = 'inline-block';
                                        });
                                    </script>

                                </form>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('reset-via-sms') }}" title="Send Password Reset Link via SMS" class="btn btn-primary py-2 fs-5 w-100 rounded-1">
                        <i class="fa-solid fa-sms"></i> Send password reset link via SMS
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/auth/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/auth/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        function closeForm() {
                window.location.href = '/login';
        }

        function validateEmail(email) {
                const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                return regex.test(email);
        }

        // document.getElementById('sendOtpForm').addEventListener('submit', function (e) {
        //     e.preventDefault();
        //     const email = document.getElementById('otpEmail').value;

        //     if (!validateEmail(email)) {
        //         iziToast.error({
        //             close: false,
        //             displayMode: 2,
        //             layout: 2,
        //             drag: false,
        //             position: "topCenter",
        //             title: 'Error',
        //             message: 'Invalid email format.',
        //             position: 'topCenter',
        //         });
        //         return;
        //     }

        //     fetch('{{ route("send-otp-email") }}', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //         },
        //         body: JSON.stringify({ email })
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             iziToast.success({
        //                 close: false,
        //                 displayMode: 2,
        //                 layout: 2,
        //                 drag: false,
        //                 position: "topCenter",
        //                 title: 'Success',
        //                 message: data.message,
        //                 position: 'topCenter',
        //             });

        //             // Hide the modal and display the OTP form
        //             $('#emailOtpModal').modal('hide');

        //             const otpFormHtml = `
        //                 <h5 class="text-center">Enter OTP</h5>
        //                 <form id="verifyOtpForm">
        //                     <input type="hidden" name="email" value="${email}">
        //                     <div class="mb-3">
        //                         <label for="otp" class="form-label">OTP CODE</label>
        //                         <input type="text" id="otp" name="otp" class="form-control" maxlength="6" required>
        //                     </div>
        //                     <button type="submit" class="btn btn-primary w-100" id="verifyOtpBtn" disabled>Verify OTP</button>
        //                 </form>
        //             `;

        //             const cardBody = document.querySelector('.card-body');
        //             cardBody.innerHTML = '';
        //             cardBody.insertAdjacentHTML('beforeend', otpFormHtml);

        //             // Enable the verify OTP button once the form is displayed
        //             document.getElementById('otp').addEventListener('input', function() {
        //                 const otpInput = document.getElementById('otp');
        //                 const verifyButton = document.getElementById('verifyOtpBtn');
        //                 // Enable button if OTP is entered
        //                 verifyButton.disabled = otpInput.value.length !== 6;
        //             });

        //             // Ensure the verify form submits properly
        //             document.getElementById('verifyOtpForm').addEventListener('submit', verifyOtp);
        //         } else {
        //             iziToast.error({
        //                 close: false,
        //                 displayMode: 2,
        //                 layout: 2,
        //                 drag: false,
        //                 position: "topCenter",
        //                 title: 'Oops!',
        //                 message: data.message,
        //                 position: 'topCenter',
        //             });
        //         }
        //     })
        //     .catch(err => {
        //         iziToast.error({
        //             close: false,
        //             displayMode: 2,
        //             layout: 2,
        //             drag: false,
        //             position: "topCenter",
        //             title: 'Oops!',
        //             message: 'An unexpected error occurred. Please try again.',
        //             position: 'topCenter',
        //         });
        //     });
        // });

        document.getElementById('sendOtpForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('otpEmail').value;
            const sendOtpButton = document.getElementById('sendOtpButton');
            const buttonText = document.getElementById('buttonText');
            const buttonIndicator = document.getElementById('buttonIndicator');

            if (!validateEmail(email)) {
                iziToast.error({
                    close: false,
                    displayMode: 2,
                    layout: 2,
                    drag: false,
                    position: "topCenter",
                    title: 'Error',
                    message: 'Invalid email format.',
                });
                return;
            }

            // Show loading indicator
            buttonText.style.display = 'none';
            buttonIndicator.style.display = 'inline-block';
            sendOtpButton.disabled = true;

            fetch('{{ route("send-otp-email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ email }),
            })
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    buttonText.style.display = 'inline-block';
                    buttonIndicator.style.display = 'none';
                    sendOtpButton.disabled = false;

                    if (data.success) {
                        iziToast.success({
                            close: false,
                            displayMode: 2,
                            layout: 2,
                            drag: false,
                            position: "topCenter",
                            title: 'Success',
                            message: data.message,
                        });

                        // Hide the modal and display the OTP form
                        $('#emailOtpModal').modal('hide');

                        const otpFormHtml = `
                            <h5 class="text-center">Enter OTP</h5>
                            <form id="verifyOtpForm">
                                <input type="hidden" name="email" value="${email}">
                                <div class="mb-3">
                                    <label for="otp" class="form-label">OTP CODE</label>
                                    <input type="text" id="otp" name="otp" class="form-control" maxlength="6" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" id="verifyOtpBtn" disabled>Verify OTP</button>
                            </form>
                        `;

                        const cardBody = document.querySelector('.card-body');
                        cardBody.innerHTML = '';
                        cardBody.insertAdjacentHTML('beforeend', otpFormHtml);

                        document.getElementById('otp').addEventListener('input', function () {
                            const otpInput = document.getElementById('otp');
                            const verifyButton = document.getElementById('verifyOtpBtn');
                            verifyButton.disabled = otpInput.value.length !== 6;
                        });

                        document.getElementById('verifyOtpForm').addEventListener('submit', verifyOtp);
                    } else {
                        iziToast.error({
                            close: false,
                            displayMode: 2,
                            layout: 2,
                            drag: false,
                            position: "topCenter",
                            title: 'Oops!',
                            message: data.message,
                        });
                    }
                })
                .catch(err => {
                    // Reset button state
                    buttonText.style.display = 'inline-block';
                    buttonIndicator.style.display = 'none';
                    sendOtpButton.disabled = false;

                    iziToast.error({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        drag: false,
                        position: "topCenter",
                        title: 'Oops!',
                        message: 'An unexpected error occurred. Please try again.',
                    });
                });
        });


        function verifyOtp(e) {
            e.preventDefault(); // Prevent default form submission

            const email = document.querySelector('input[name="email"]').value;
            const otp = document.getElementById('otp').value;

            // Make the API call to verify OTP
            fetch('{{ route("verify-otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for Laravel
                },
                body: JSON.stringify({ email, otp })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Unexpected error occurred');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success toast first
                    iziToast.success({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        drag: false,
                        position: "topCenter",
                        title: 'Success',
                        message: data.message,
                        position: 'topCenter',
                    });

                    // Wait a moment to allow the toast to be displayed before redirecting
                    setTimeout(() => {
                        window.location.href = data.redirect_url; // Redirect to reset password page
                    }, 1500); // Adjust timeout (1500ms = 1.5 seconds) if necessary
                } else {
                    iziToast.error({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        drag: false,
                        position: "topCenter",
                        title: 'Oops!',
                        message: data.message,
                        position: 'topCenter',
                    });
                }
            })

            .catch(err => {
                console.error('Error verifying OTP:', err.message);
                iziToast.error({
                    close: false,
                    displayMode: 2,
                    layout: 2,
                    drag: false,
                    position: "topCenter",
                    title: 'Oops!',
                    message: err.message || 'An error occurred while verifying OTP. Please try again.',
                    position: 'topCenter',
                });
            });
        }
        </script>
</body>

</html>
