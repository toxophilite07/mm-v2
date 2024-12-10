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
document.addEventListener('deviceready', function () {
    // More comprehensive detection for mobile Cordova environments
    const isAndroidCordova = (
        window.cordova && 
        window.cordova.platformId === 'android' &&
        (window.device || navigator.platform === 'android')
    );

    // Additional check for mobile platforms
    const isMobilePlatform = 
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    // If it's an Android Cordova app or mobile platform, prevent popup
    if (isAndroidCordova || isMobilePlatform) {
        const popup = document.getElementById('installPopup');
        if (popup) {
            popup.style.display = 'none';
            popup.remove(); // Completely remove from DOM
        }
        return;
    }

    // Fallback popup logic for web browsers
    if (localStorage.getItem('installPopupClosed') === 'true') {
        return;
    }

    const popup = document.getElementById('installPopup');
    if (popup) {
        popup.style.display = 'block';

        document.getElementById('installButton').addEventListener('click', function () {
            window.open(
                'https://www.mediafire.com/file/cj7tjxtebxglk0b/Menstrual_Monitoring_App_v2.apk/file',
                '_blank'
            );
        });

        document.getElementById('closePopupButton').addEventListener('click', function () {
            popup.style.display = 'none';
            localStorage.setItem('installPopupClosed', 'true');
        });
    }
}, false);

// Fallback event listener in case deviceready doesn't fire
document.addEventListener('DOMContentLoaded', function() {
    const isAndroidCordova = (
        window.cordova && 
        window.cordova.platformId === 'android' &&
        (window.device || navigator.platform === 'android')
    );

    const isMobilePlatform = 
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    if (isAndroidCordova || isMobilePlatform) {
        const popup = document.getElementById('installPopup');
        if (popup) {
            popup.style.display = 'none';
            popup.remove(); // Completely remove from DOM
        }
    }
});
</script>
