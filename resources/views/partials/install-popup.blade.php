document.addEventListener('DOMContentLoaded', function () {
    // Check for Cordova environment and AppBrowser
    const isCordova = window.cordova && window.cordova.platformId !== 'browser';
    const isInAppBrowser = window.cordova && window.cordova.InAppBrowser;

    // More comprehensive check to prevent popup in Cordova environments
    if (isCordova || isInAppBrowser) {
        // Hide or completely remove the popup
        const popup = document.getElementById('installPopup');
        if (popup) {
            popup.style.display = 'none';
            // Optional: completely remove the popup from the DOM
            // popup.remove();
        }
        return; 
    }

    // Existing popup logic for non-Cordova environments
    if (localStorage.getItem('installPopupClosed') === 'true') {
        return;
    }

    const popup = document.getElementById('installPopup');
    popup.style.display = 'block';

    document.getElementById('installButton').addEventListener('click', function () {
        window.open(
            'https://www.mediafire.com/file/cj7tjxtebxglk0b/Menstrual_Monitoring_App_v2.apk/file',
            '_blank'
        );
    });

    document.getElementById('closePopupButton').addEventListener('click', function () {
        document.getElementById('installPopup').style.display = 'none';
        localStorage.setItem('installPopupClosed', 'true');
    });
});
