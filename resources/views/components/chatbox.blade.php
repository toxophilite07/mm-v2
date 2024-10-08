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
        }

        .floating-icon:hover {
            transform: scale(1.1);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }

        .chatbox {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 350px;
            max-width: 90%;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            display: none;
            flex-direction: column;
            box-shadow: 0px 5px 25px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.3s forwards;
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
            font-weight: bold;
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
            max-height: 300px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .chatbox-footer {
            padding: 15px;
            display: flex;
            background-color: #f8f8f8;
        }

        .chatbox-footer input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .chatbox-footer input:focus {
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
            /* background-color: #333333; */
        }

        .chatbox-footer button:disabled {
            /* background-color: #cccccc; */
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

        .faq-toggle {
            text-align: right;
            padding: 5px;
            margin-right: 10px;
        }

        .faq-button {
            background-color: #f0f0f0;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .faq-section {
            max-height: 200px;
            overflow-y: auto;
            /* background-color: #f9f9f9; */
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
        }

        .faq-section h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .faq-section ul {
            list-style: none;
            padding: 0;
        }

        .faq-section li {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .faq-section li strong {
            font-weight: bold;
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

        <div class="faq-toggle" onclick="toggleFAQ()">
            <button class="faq-button">
                <i class="fa-solid fa-question-circle"></i> 
            </button>
        </div>

        <div class="faq-section" id="faq-section" style="display: none;">
            <h3>Menstruation FAQ</h3>
            <ul>
                <li><strong>What is menstruation?</strong> <br> Menstruation is the monthly shedding of the uterine lining when pregnancy does not occur.</li>
                <li><strong>What is a normal menstrual cycle?</strong> <br> A normal menstrual cycle ranges from 21 to 35 days.</li>
                <li><strong>What causes irregular periods?</strong> <br> Irregular periods can be caused by stress, hormonal imbalances, or health conditions.</li>
                <li><strong>How can I manage period pain?</strong> <br> Period pain can be managed with over-the-counter pain relievers and heat therapy.</li>
                <li><strong>Can stress affect my menstrual cycle?</strong> <br> Yes, stress can interfere with hormonal balance, causing missed or delayed periods.</li>
            </ul>
        </div>


        <div class="chatbox-body" id="chatbox-body">
            <div class="chat-message ai-response" id="initial-greeting"></div>
        </div>   
        <div class="typing-indicator" id="typing-indicator"></div> <!-- Typing indicator -->
        
        <div class="chatbox-footer">
            <input type="text" id="chatbox-input" placeholder="Ask with Nyx..." onkeypress="handleKeyPress(event)" oninput="toggleSendButton()" onfocus="hideFAQ()">
            <button id="send-button" onclick="sendMessage()" disabled>
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
