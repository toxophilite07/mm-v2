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
    // Check if the app is running in a Cordova environment
    if (window.cordova && window.cordova.platformId !== 'browser' && !window.cordova.InAppBrowser) {
        // If it's in Cordova and not in the browser, don't show the popup
        return; 
    }

    // Check if the user has closed the popup before (using localStorage)
    if (localStorage.getItem('installPopupClosed') === 'true') {
        return; // Skip showing the popup if it's closed previously
    }

    // Show the install popup for browser users
    const popup = document.getElementById('installPopup');
    popup.style.display = 'block';

    // Handle the Install Now button click
    document.getElementById('installButton').addEventListener('click', function () {
        window.open(
            'https://www.mediafire.com/file/cj7tjxtebxglk0b/Menstrual_Monitoring_App_v2.apk/file',
            '_blank'
        ); // Replace with your app's Play Store URL
    });

    // Handle the Close button click
    document.getElementById('closePopupButton').addEventListener('click', function () {
        document.getElementById('installPopup').style.display = 'none';

        // Set a flag in localStorage to remember that the user closed the popup
        localStorage.setItem('installPopupClosed', 'true');
    });
});

</script>
