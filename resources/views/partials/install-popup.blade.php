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
document.addEventListener('DOMContentLoaded', function () {
    // Check if running in Cordova Android environment
    const isAndroidCordova = window.cordova && 
        window.cordova.platformId === 'android';

    // Check if it's a mobile device
    const isMobileDevice = /Android/i.test(navigator.userAgent);

    // Debug logging
    console.log('Is Cordova Android:', isAndroidCordova);
    console.log('Is Mobile Device:', isMobileDevice);

    // If NOT in Cordova Android, show popup normally
    if (!isAndroidCordova) {
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
        return;
    }

    // For Android Cordova, hide or remove popup
    const popup = document.getElementById('installPopup');
    if (popup) {
        popup.style.display = 'none';
        popup.remove(); // Completely remove from DOM
    }
});

// Backup check for Cordova's deviceready event
document.addEventListener('deviceready', function () {
    const isAndroidCordova = window.cordova && 
        window.cordova.platformId === 'android';

    if (isAndroidCordova) {
        const popup = document.getElementById('installPopup');
        if (popup) {
            popup.style.display = 'none';
            popup.remove();
        }
    }
}, false);
</script>
