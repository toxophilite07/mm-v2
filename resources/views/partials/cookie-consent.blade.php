{{-- resources/views/partials/cookie-consent.blade.php --}}

@if(session('show_cookie_consent'))
<div id="cookie-consent" class="cookie-consent">
    <div class="cookie-consent-content">
        <p>🍪This website uses cookies to enhance your experience. By clicking "Accept", you agree to our use of cookies.🍪</p>
        <div class="cookie-consent-actions">
            <button id="accept-cookies" class="btn btn-primary">Accept</button>
            <button id="reject-cookies" class="btn btn-danger">Reject</button>          
        </div>
        <button id="view-policy" class="btn btn-link">View Cookie Policy</button>
    </div>

    <!-- Policy section moved outside of the cookie consent div -->
    <div id="policy" style="display: none; margin-top: 20px; max-height: 300px; overflow-y: auto;"> {{-- Initially hidden --}}
        <h1>Cookie Policy</h1>
        <p>This Cookie Policy explains how Menstrual Monitoring App ("we", "us", or "our") uses cookies and similar technologies to recognize you when you visit our application. It explains what these technologies are, why we use them, and your rights to control our use of them.</p>


        <h2>What Are Cookies?</h2>
        <p>Cookies are small data files that are placed on your computer or mobile device when you visit a website. Cookies are widely used by website owners to make their websites work, or to work more efficiently, as well as to provide reporting information.</p>

        <h2>Types of Cookies We Use</h2>
        <ul>
            <li><strong>Essential Cookies:</strong> These cookies are necessary for the website to function properly. They enable core functionalities such as security, network management, and accessibility. For example, our <code>cookie_consent</code> cookie helps us remember your cookie preferences.</li>
            
            <li><strong>Performance and Analytics Cookies:</strong> These cookies allow us to track how users interact with our website. They help us analyze website performance and improve the user experience by understanding which pages are the most and least popular.</li>
            
            <li><strong>Functionality Cookies:</strong> These cookies enhance functionality and personalization. They remember your preferences and choices, such as language settings and user interface customizations, to provide a more tailored experience on your return visits.</li>
            
            <li><strong>Advertising Cookies:</strong> These cookies are used to show you relevant advertisements based on your browsing activity. They may also limit the number of times you see an ad and help measure the effectiveness of advertising campaigns.</li>
        </ul>

        <h2>Your Choices Regarding Cookies</h2>
        <p>You have the right to decide whether to accept or reject cookies. You can set your web browser to refuse cookies or alert you when cookies are being sent. However, if you choose to reject cookies, you may not be able to use some parts of our website.</p>

        <h2>Contact Us</h2>
        <p>If you have any questions about our use of cookies or our Cookie Policy, please contact us at <a href="mailto:nelbanbetache@gmail.com">Menstrual Monitoring App</a>.</p>
    </div>
</div>

<style>
/* CSS changes */
.cookie-consent {
    position: fixed;
    bottom: -100%; /* Changed from bottom: 20px */
    left: 50%;
    transform: translateX(-50%);
    background-color: #fff;
    border: 1px solid #F6A5BB;
    border-radius: 5px;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 4px 8px;
    padding: 15px;
    width: 90%;
    max-width: 600px;
    z-index: 9999;
    opacity: 0; /* Added */
    transition: bottom 0.5s ease-in-out, opacity 0.5s ease-in-out; /* Added */
}

.cookie-consent.show { /* New class */
    bottom: 20px;
    opacity: 1;
}

.cookie-consent-content {
    text-align: center;
}

.cookie-consent p {
    margin: 0 0 10px;
    color: #333;
}

.cookie-consent-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.cookie-consent button {
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    transition: all 0.3s ease; /* Changed */
    border: none; /* Added */
    font-weight: bold; /* Added */
}

.cookie-consent button:hover {
    transform: translateY(-2px); /* Added */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Added */
}

#accept-cookies {
    background-color: #4CAF50; /* Added */
    color: white; /* Added */
}

#reject-cookies {
    background-color: #f44336; /* Added */
    color: white; /* Added */
}

#policy {
    display: none; /* Initially hidden */
    margin-top: 20px; /* Add some spacing from the consent section */
    max-height: 300px; /* Maximum height for the policy */
    overflow-y: auto; /* Enable vertical scrolling */
}
</style>

<script>
// JavaScript changes
document.addEventListener('DOMContentLoaded', function() {
    const cookieConsent = document.getElementById('cookie-consent');
    const acceptButton = document.getElementById('accept-cookies');
    const rejectButton = document.getElementById('reject-cookies');
    const viewPolicyButton = document.getElementById('view-policy');
    const policy = document.getElementById('policy');

    function showConsentPopup() {
        cookieConsent.classList.add('show');
        acceptButton.classList.add('pulse');
    }

    function hideConsentPopup() {
        cookieConsent.classList.remove('show');
        setTimeout(() => {
            cookieConsent.style.display = 'none';
        }, 500);
    }

    // Toggle cookie policy visibility
    viewPolicyButton.addEventListener('click', function() {
        if (policy.style.display === 'none') {
            policy.style.display = 'block';
            viewPolicyButton.textContent = 'Hide Cookie Policy'; // Change button text
        } else {
            policy.style.display = 'none';
            viewPolicyButton.textContent = 'View Cookie Policy'; // Reset button text
        }
    });

    // Check if the cookie consent was already accepted or rejected
    if (!localStorage.getItem('cookieConsent')) {
        setTimeout(showConsentPopup, 1000); // Show the consent popup after a 1-second delay
    }

    acceptButton.addEventListener('click', function() {
        localStorage.setItem('cookieConsent', 'accepted');
        hideConsentPopup();
    });

    rejectButton.addEventListener('click', function() {
        localStorage.setItem('cookieConsent', 'rejected');
        hideConsentPopup();
    });

    // Add hover animations
    [acceptButton, rejectButton].forEach(button => {
        button.addEventListener('mouseover', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
        });
        button.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>

@endif
