// const chatbox = document.getElementById('chatbox');
// const chatboxBody = document.getElementById('chatbox-body');
// const inputField = document.getElementById('chatbox-input');
// const sendButton = document.getElementById('send-button');
// const initialGreeting = document.getElementById('initial-greeting');
// const typingIndicator = document.getElementById('typing-indicator');
// const faqSection = document.getElementById('faq-section');

// const welcomeMessage = "Hello! I'm NyxAI, your health assistant. How can I help you today?";
// initialGreeting.innerText = welcomeMessage;

// function showTypingIndicator() {
//     const typingIndicator = document.getElementById("typing-indicator");
//     typingIndicator.classList.add("active");
// }

// function hideTypingIndicator() {
//     const typingIndicator = document.getElementById("typing-indicator");
//     typingIndicator.classList.remove("active");
// }

// function toggleChatbox() {
//     chatbox.style.display = chatbox.style.display === 'none' ? 'flex' : 'none';
//     if (chatbox.style.display === 'flex') {
//         inputField.focus();
//     }
// }

// function closeChatbox() {
//     chatbox.style.display = 'none';
// }

// function toggleFAQ() {
//     faqSection.style.display = faqSection.style.display === 'none' ? 'block' : 'none';
// }

// function hideFAQ() {
//     faqSection.style.display = 'none';
// }

// function toggleSendButton() {
//     sendButton.disabled = !inputField.value.trim();
// }

// function handleKeyPress(event) {
//     if (event.key === 'Enter') {
//         event.preventDefault();
//         sendMessage();
//     }
// }

// function appendMessage(message, sender) {
//     const messageElement = document.createElement('div');
//     messageElement.className = `chat-message ${sender}-response`;
//     messageElement.innerText = message;
    
//     // Get the current scroll position
//     const scrollPos = chatboxBody.scrollTop;
    
//     // Append the new message
//     chatboxBody.appendChild(messageElement);
    
//     // If the chat was scrolled to the bottom before adding the new message,
//     // scroll to the bottom again. Otherwise, maintain the scroll position.
//     if (scrollPos + chatboxBody.clientHeight >= chatboxBody.scrollHeight - 10) {
//         chatboxBody.scrollTop = chatboxBody.scrollHeight;
//     } else {
//         chatboxBody.scrollTop = scrollPos;
//     }
    
//     return messageElement;
// }

// function sendMessage() {
//     const userMessage = inputField.value.trim();
//     if (!userMessage) return; // Prevent sending empty messages

//     appendMessage(userMessage, 'user'); // Append user message
//     inputField.value = ''; // Clear the input field
//     toggleSendButton(); // Disable send button

//     // Show typing indicator
//     typingIndicator.style.display = 'block';

//     // Simulate delay for AI response
//     setTimeout(() => {
//         const aiResponse = getAIResponse(userMessage.toLowerCase());
//         const aiMessageElement = appendMessage(aiResponse, 'ai'); // Append AI response
        
//         // If the message is longer than a certain height, add a class to make it scrollable
//         if (aiMessageElement.scrollHeight > 150) { // 150px is an example, adjust as needed
//             aiMessageElement.classList.add('scrollable-message');
//         }
        
//         // Scroll to the new message
//         aiMessageElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
//         typingIndicator.style.display = 'none'; // Hide typing indicator
//     }, 2000); // Adjust delay as needed
// }