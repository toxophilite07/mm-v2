<div id="installPopup" style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); width: 320px; padding: 15px; background-color: #FFFF; border: 1px solid #F6A5BB; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); z-index: 9999; font-family: Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <p style="margin: 0; font-size: 16px; color: #333; font-weight: bold;">Download our app!</p>
        <button id="closePopupButton" style="background: none; border: none; font-size: 18px; font-weight: bold; cursor: pointer; color: #333;">&times;</button>
    </div>
    <p style="margin-top: 10px; font-size: 14px; color: #666;">Download our app for a better experience on your device.</p>
    <button id="installButton" style="margin-top: 10px; padding: 10px 15px; background-color: #F6A5BB; border: none; border-radius: 3px; color: white; font-size: 14px; cursor: pointer;">Download Now</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('deviceready', function () {
    // Check if it's running in a Cordova app (Android or other platforms)
    if (window.cordova) {
        // Check if the app is running on Android platform
        if (cordova.platformId === 'android') {
            return; // Prevent popup from showing on Android platform
        }

        // Check if running inside InAppBrowser
        if (cordova.InAppBrowser) {
            return; // Prevent popup if inside InAppBrowser
        }
    }

    // Skip showing popup if already closed (via localStorage)
    if (localStorage.getItem('installPopupClosed') === 'true') {
        return;
    }

    // Show the install popup for browser users
    const popup = document.getElementById('installPopup');
    popup.style.display = 'block';

    // Handle the Install Now button click
    document.getElementById('installButton').addEventListener('click', function () {
        window.open(
            'https://www.mediafire.com/file/cj7tjxtebxglk0b/Menstrual_Monitoring_App_v2.apk/file',
            '_blank'
        ); // Link to your app's APK or Play Store URL
    });

    // Handle Close button click
    document.getElementById('closePopupButton').addEventListener('click', function () {
        document.getElementById('installPopup').style.display = 'none';
        localStorage.setItem('installPopupClosed', 'true'); // Remember that user closed the popup
    });
});
</script>
