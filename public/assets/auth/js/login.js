 // DISABLE EMAIL WHEN HAVE A NUMBER 

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


 ///PASSWORD HIDE AND UNHIDE 

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


  ///GREETINGS 

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


