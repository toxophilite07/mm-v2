<div id="installPopup" style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); width: 320px; padding: 15px; background-color: #FFFF; border: 1px solid #F6A5BB; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); z-index: 9999; font-family: Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <p style="margin: 0; font-size: 16px; color: #333; font-weight: bold;">Install our app!</p>
        <button id="closePopupButton" style="background: none; border: none; font-size: 18px; font-weight: bold; cursor: pointer; color: #333;">&times;</button>
    </div>
    <p style="margin-top: 10px; font-size: 14px; color: #666;">Install our app for a better experience on your device.</p>
    <button id="installButton" style="margin-top: 10px; padding: 10px 15px; background-color: #F6A5BB; border: none; border-radius: 3px; color: white; font-size: 14px; cursor: pointer;">Install Now</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Multiple detection methods for mobile environments
function isMobileEnvironment() {
    const mobileUserAgents = [
        /Android/i,
        /webOS/i,
        /iPhone/i,
        /iPad/i,
        /iPod/i,
        /BlackBerry/i,
        /Windows Phone/i
    ];

    // Check user agent
    const isMobileUA = mobileUserAgents.some(ua => ua.test(navigator.userAgent));

    // Additional checks
    const isMobileScreen = window.innerWidth <= 768;
    const isCordovaMobile = window.cordova && 
        (window.cordova.platformId === 'android' || 
         window.cordova.platformId === 'ios');

    // Extensive logging for debugging
    console.log('Mobile User Agent:', isMobileUA);
    console.log('Mobile Screen Size:', isMobileScreen);
    console.log('Cordova Mobile:', isCordovaMobile);
    console.log('Window Cordova:', !!window.cordova);
    console.log('Cordova Platform:', window.cordova ? window.cordova.platformId : 'Not detected');

    return isMobileUA || isMobileScreen || isCordovaMobile;
}

// Function to completely remove popup
function preventMobilePopup() {
    const popup = document.getElementById('installPopup');
    if (popup) {
        // Multiple methods to ensure popup is hidden
        popup.style.display = 'none';
        popup.style.visibility = 'hidden';
        popup.style.opacity = '0';
        
        // Try to remove from DOM
        try {
            popup.remove();
        } catch (error) {
            console.log('Could not remove popup:', error);
        }
    }
}

// Different event listeners to catch all scenarios
document.addEventListener('DOMContentLoaded', function () {
    if (isMobileEnvironment()) {
        preventMobilePopup();
        return;
    }

    // Normal popup logic for non-mobile environments
    const popup = document.getElementById('installPopup');
    if (popup) {
        // Check if popup was previously closed
        if (localStorage.getItem('installPopupClosed') !== 'true') {
            popup.style.display = 'block';
        }

        // Install button handler
        document.getElementById('installButton').addEventListener('click', function () {
            window.open(
                'https://www.mediafire.com/file/cj7tjxtebxglk0b/Menstrual_Monitoring_App_v2.apk/file',
                '_blank'
            );
        });

        // Close button handler
        document.getElementById('closePopupButton').addEventListener('click', function () {
            popup.style.display = 'none';
            localStorage.setItem('installPopupClosed', 'true');
        });
    }
});

// Backup deviceready event listener
document.addEventListener('deviceready', function () {
    if (isMobileEnvironment()) {
        preventMobilePopup();
    }
}, false);

// Additional failsafe for mobile detection
window.addEventListener('load', function() {
    if (isMobileEnvironment()) {
        preventMobilePopup();
    }
});
</script>
