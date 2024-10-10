<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="shortcut icon" href="{{ asset('assets/images/blood.jpg') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .floating-icon {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #4a4a4a;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .floating-icon:hover {
            transform: scale(1.1);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }

        .chatbox {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 500px;
            max-width: 95%;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            display: none;
            flex-direction: column;
            box-shadow: 0px 5px 25px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.3s forwards;
            z-index: 999;
        }

        @media (max-width: 768px) {
            .chatbox {
                width: 90%;
                right: 5%;
                left: 5%;
                bottom: 70px;
            }

            .floating-icon {
                right: 20px;
                bottom: 20px;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbox-header {
            background-color: #4a4a4a;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chatbox-header span {
            /* font-weight: bold; */
            font-size: 15px;
        }

        .chatbox-header button {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .chatbox-header button:hover {
            transform: scale(1.1);
        }

        .chatbox-body {
            padding: 20px;
            height: 400px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .chatbox-footer {
            padding: 15px;
            display: flex;
            background-color: #f8f8f8;
        }

        .chatbox-footer textarea {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            transition: border-color 0.3s;
            min-height: 20px;
            max-height: 100px;
            overflow-y: auto;
            resize: none;
        }

        .chatbox-footer textarea:focus {
            border-color: #4a4a4a;
            outline: none;
        }

        .chatbox-footer button {
            background-color: #4a4a4a;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-left: 10px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .chatbox-footer button:hover:not(:disabled) {
            background-color: #333333;
        }

        .chatbox-footer button:disabled {
            cursor: not-allowed;
        }

        .chat-message {
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 15px;
            max-width: 80%;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .ai-response {
            background-color: #f0f0f0;
            align-self: flex-start;
            color: #333;
        }

        .user-response {
            background-color: #4a4a4a;
            color: white;
            align-self: flex-end;
        }

        .typing-indicator {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        background-color: #f0f0f0;
        border-radius: 15px;
        align-self: flex-start;
        margin-bottom: 15px;
        width: fit-content;
    }

    .typing-indicator span {
        height: 8px;
        width: 8px;
        background-color: #4a4a4a;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        animation: typing 1s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
        margin-right: 0;
    }

    @keyframes typing {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }
    </style>
</head>
<body>
    <button class="floating-icon" onclick="toggleChatbox()">
        <i class="fa-solid fa-comments"></i>
    </button>

    <div class="chatbox" id="chatbox">
        <div class="chatbox-header">
            <span>NyxAI Assistance</span>
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
    </script>
</body>
</html>