{{-- resources/views/partials/terms-and-conditions.blade.php --}}
<div id="terms-popup" class="terms-popup" style="display: none;">
    <div class="terms-popup-content">
        <h2>Terms and Conditions</h2>
        <p>These Terms and Conditions govern your use of the Menstrual Monitoring App. By using this app, you accept these terms in full. If you disagree with any part of these terms, you must not use our app.</p>
        
        <h3>Use License</h3>
        <p>You are granted a limited license to use the app for personal, non-commercial purposes.</p>
        
        <h3>Limitations</h3>
        <p>You must not:</p>
        <ul>
            <li>Republish material from this app</li>
            <li>Sell, rent, or sub-license material from this app</li>
            <li>Reproduce, duplicate, or copy material from this app</li>
        </ul>

        <h3>Modifications</h3>
        <p>We may revise these terms from time to time. Please check this page regularly to ensure you are happy with any changes.</p>

        <button id="close-terms" class="btn btn">Close</button>
    </div>
</div>

<style>
.terms-popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.terms-popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    max-width: 600px;
    max-height: 80vh;
    overflow-y: auto;
    position: relative;
    width: 90%; /* Make it more responsive */
}

.terms-popup h2 {
    margin-top: 0;
}

#close-terms {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #FFD6D1;
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

/* Media Query for smaller screens */
@media screen and (max-width: 600px) {
    .terms-popup-content {
        max-width: 95%;
        max-height: 90vh;
        padding: 15px;
    }

    #close-terms {
        font-size: 14px;
        top: 5px;
        right: 5px;
    }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const termsLink = document.getElementById('terms-link');
    const termsPopup = document.getElementById('terms-popup');
    const closeTermsButton = document.getElementById('close-terms');

    termsLink.addEventListener('click', function(e) {
        e.preventDefault();
        termsPopup.style.display = 'flex';
    });

    closeTermsButton.addEventListener('click', function() {
        termsPopup.style.display = 'none';
    });

    termsPopup.addEventListener('click', function(e) {
        if (e.target === termsPopup) {
            termsPopup.style.display = 'none';
        }
    });
});
</script>