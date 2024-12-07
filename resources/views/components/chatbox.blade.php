<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="shortcut icon" href="{{ asset('assets/images/blood.jpg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aifloat.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <style>
      /* Popup text animation */
    .popup-text {
        position: absolute;
        bottom: 80px;
        right: 0;
        background-color: rgba(255, 105, 180, 0.9);
        color: white;
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
        display: none;
        animation: popup 5s infinite;
    }

    @keyframes popup {
        0%, 80% {
            opacity: 0;
            transform: translateY(10px);
        }
        85%, 95% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>
<body>
    <button class="floating-icon" onclick="toggleChatbox()">
    <i class="fa-solid fa-comments"></i> 
     <div class="popup-text" id="popupText">Hi! You can ask about menstruation here!</div>
    </button>

    <div class="chatbox" id="chatbox">
        <div class="chatbox-header">
            <span>NyxAI Assistance BETA</span>
            <button onclick="closeChatbox()"><i class="fa-solid fa-times"></i></button>
        </div>

        <div class="chatbox-body" id="chatbox-body">
            <div class="chat-message ai-response" id="initial-greeting">Hello! I'm Nyx, your virtual assistant for menstrual health. How can I help you today?</div>
        </div>   
        
        <div class="chatbox-footer">
            <textarea id="chatbox-input" placeholder="Ask with Nyx..." onkeypress="handleKeyPress(event)" oninput="adjustInputHeight(this)"></textarea>
            <button id="send-button" onclick="sendMessage()" disabled>
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        const API_URL = 'https://api.cohere.ai/v1/generate'; // Cohere API endpoint
        const API_KEY = 'R5piDJyEOvvsKm6GsWzG91VArzjOtAlR2TSvmCaw'; // Replace with your actual Cohere API key

        function toggleChatbox() {
            const chatbox = document.getElementById('chatbox');
            chatbox.style.display = chatbox.style.display === 'flex' ? 'none' : 'flex';
        }

        function closeChatbox() {
            document.getElementById('chatbox').style.display = 'none';
        }

        function toggleSendButton() {
            const input = document.getElementById('chatbox-input');
            const sendButton = document.getElementById('send-button');
            sendButton.disabled = input.value.trim() === '';
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function adjustInputHeight(element) {
            element.style.height = 'auto';
            element.style.height = (element.scrollHeight) + 'px';
            toggleSendButton();
        }

        async function sendMessage() {
            const input = document.getElementById('chatbox-input');
            const message = input.value.trim();
            if (message === '') return;

            // Display user message
            displayMessage(message, 'user-response');

            // Clear input and reset height
            input.value = '';
            input.style.height = 'auto';
            toggleSendButton();

            // Show typing indicator
            showTypingIndicator();

            try {
                // Call the Cohere API
                const response = await axios.post(API_URL, {
                    prompt: message,
                    max_tokens: 150, // Adjust max tokens as needed
                    temperature: 0.7 // Adjust temperature as needed
                }, {
                    headers: {
                        'Authorization': `Bearer ${API_KEY}`,
                        'Content-Type': 'application/json'
                    }
                });

                // Get AI response text
                const aiResponse = response.data.generations[0].text.trim();
                displayMessage(aiResponse, 'ai-response');
            } catch (error) {
                console.error('Error calling Cohere API:', error);
                displayMessage("Sorry, I'm having trouble responding right now.", 'ai-response');
            } finally {
                // Hide typing indicator
                hideTypingIndicator();
            }
        }

        function displayMessage(message, className) {
            const chatboxBody = document.getElementById('chatbox-body');
            const messageElement = document.createElement('div');
            messageElement.className = `chat-message ${className}`;
            messageElement.textContent = message;
            chatboxBody.appendChild(messageElement);
            chatboxBody.scrollTop = chatboxBody.scrollHeight; // Scroll to the bottom
        }

   function showTypingIndicator() {
        const chatboxBody = document.getElementById('chatbox-body');
        let typingIndicator = document.getElementById('typing-indicator');
        
        if (!typingIndicator) {
            typingIndicator = document.createElement('div');
            typingIndicator.id = 'typing-indicator';
            typingIndicator.className = 'typing-indicator';
            typingIndicator.innerHTML = '<span></span><span></span><span></span>';
        }
        
        chatboxBody.appendChild(typingIndicator);
        chatboxBody.scrollTop = chatboxBody.scrollHeight;
    }

    function hideTypingIndicator() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator && typingIndicator.parentNode) {
            typingIndicator.parentNode.removeChild(typingIndicator);
        }
    }

        // Show and hide popup text periodically
function showPopupText() {
    const popupText = document.getElementById("popupText");
    popupText.style.display = "block";
    setTimeout(() => {
        popupText.style.display = "none";
    }, 1000);
}

// Call showPopupText every 8 seconds
setInterval(showPopupText, 1000);
    </script>
</body>
</html>
