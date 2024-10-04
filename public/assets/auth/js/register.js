
    $('#reload').click(function(){
        $.ajax({
            type:'GET',
            url:'reload-captcha',
            success:function(data){
                $(".captcha span").html(data.captcha)
            }
        });
    });

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

//    // Toggle password visibility for "password" input
//     document.getElementById('togglePasswordBtn').addEventListener('click', function () {
//         const passwordInput = document.getElementById('password');
//         const showIcon = document.getElementById('showIcon');
//         const hideIcon = document.getElementById('hideIcon');
//         if (passwordInput.type === 'password') {
//             passwordInput.type = 'text';
//             showIcon.style.display = 'none';
//             hideIcon.style.display = 'inline';
//         } else {
//             passwordInput.type = 'password';
//             showIcon.style.display = 'inline';
//             hideIcon.style.display = 'none';
//         }
//     });

//     // Toggle password visibility for "confirm password" input
//     document.getElementById('toggleConfirmPasswordBtn').addEventListener('click', function () {
//         const confirmPasswordInput = document.getElementById('password_confirmation');
//         const showConfirmIcon = document.getElementById('showConfirmIcon');
//         const hideConfirmIcon = document.getElementById('hideConfirmIcon');
//         if (confirmPasswordInput.type === 'password') {
//             confirmPasswordInput.type = 'text';
//             showConfirmIcon.style.display = 'none';
//             hideConfirmIcon.style.display = 'inline';
//         } else {
//             confirmPasswordInput.type = 'password';
//             showConfirmIcon.style.display = 'inline';
//             hideConfirmIcon.style.display = 'none';
//         }
//     });


    // document.addEventListener('DOMContentLoaded', function() {
    //         const roleSelect = document.getElementById('role');
    //         const menstruationFields = document.getElementById('menstruation-status-fields');
    //         const menstruationStatusSelect = document.getElementById('menstruation_status');

    //         roleSelect.addEventListener('change', function() {
    //             const selectedRole = roleSelect.value;
    //             if (selectedRole === 'Feminine') {
    //                 menstruationFields.style.display = 'block';
    //                 menstruationStatusSelect.setAttribute('required', 'required');
    //             } else {
    //                 menstruationFields.style.display = 'none';
    //                 menstruationStatusSelect.removeAttribute('required');
    //                 menstruationStatusSelect.value = ''; // Clear value if not required
    //             }
    //         });

    //         roleSelect.dispatchEvent(new Event('change')); // Trigger change event initially
    //     });


    //     //close form
    //     function closeForm() {
    //     window.location.href = '/'; // Redirects to the main page or index page
    // }
    

