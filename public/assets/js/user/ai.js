// function toggleChatbox() {
//     const chatbox = document.getElementById('chatbox');
//     chatbox.style.display = chatbox.style.display === 'none' || chatbox.style.display === '' ? 'flex' : 'none';
// }

// function closeChatbox() {
//     const chatbox = document.getElementById('chatbox');
//     const chatboxBody = document.getElementById('chatbox-body');
//     chatbox.style.display = 'none';
//     chatboxBody.innerHTML = '<div class="chat-message ai-response">Welcome! How can I assist you today?</div>';
// }


// function sendMessage() {
//     const chatboxInput = document.getElementById('chatbox-input');
//     const chatboxBody = document.getElementById('chatbox-body');
//     const message = chatboxInput.value.trim();

//     if (message !== '') {
//         // Create and append the user message element
//         const userMessageElement = document.createElement('div');
//         userMessageElement.className = 'chat-message user-message';
//         userMessageElement.textContent = message;
//         chatboxBody.appendChild(userMessageElement);
//         chatboxInput.value = '';

//         // Ensure the chatbox scrolls to the bottom
//         scrollToBottom(chatboxBody);

//         // Simulate AI typing effect
//         const typingElement = document.createElement('div');
//         typingElement.className = 'chat-message ai-response';
//         typingElement.style.color = 'blue';
//         typingElement.textContent = 'Typing...';
//         chatboxBody.appendChild(typingElement);

//         // Ensure the chatbox scrolls to the bottom after AI typing effect
//         scrollToBottom(chatboxBody);

//         // Replace "Typing..." with the actual AI response
//         setTimeout(() => {
//             typingElement.textContent = '';
//             const responseText = getAIResponse(message);
//             typeEffect(typingElement, responseText);

//             // Ensure the chatbox scrolls to the bottom after AI response
//             setTimeout(() => scrollToBottom(chatboxBody), 500); // Delay to ensure typing effect finishes
//         }, 1500);
//     }
// }

// function typeEffect(element, text, speed = 10) {
//     let i = 0;
//     function type() {
//         if (i < text.length) {
//             element.textContent += text.charAt(i);
//             i++;
//             setTimeout(type, speed);
//         }
//     }
//     type();
// }

// function scrollToBottom(element) {
//     element.scrollTop = element.scrollHeight;
// }

// function handleKeyPress(event) {
//     if (event.key === 'Enter') {
//         sendMessage();
//     }
// }

// // function getAIResponse(message) {
// //     console.log("Received message:", message); // Debugging line

// //     // Define your responses object
// //     const responses = {
// //         "hello": "Hi there! How can I assist you today?",
// //         "cute ba si jee ann?": "Yes! Sya lang ang nag-iisang cute sa earth every universe!",
// //         "hi": "Hello! What can I help you with today?",
// //         "good morning": "Good morning! How can I help you today?",
// //         "morning": "Good morning! How can I help you today?",
// //         "good afternoon": "Good afternoon! How can I assist you?",
// //         "good noon": "Good noon! How can I assist you?",
// //         "good evening": "Good evening! How can I assist you tonight?",
// //         "good night": "Good night! If you need any help, just ask.",
// //         "bye": "Goodbye! Have a great day!",
// //         "thanks": "You're welcome! If you have any other questions, feel free to ask.",
// //         "thank you": "My pleasure! Let me know if there's anything else I can help with.",
// //         "cycle": "A menstrual cycle is the series of changes a woman's body goes through to prepare for a potential pregnancy. It typically lasts about 28 days.",
// //         "period": "Your period is the time when your body sheds the lining of your uterus, usually lasting between 3 to 7 days. It is a natural part of the menstrual cycle.",
// //         "ovulation": "Ovulation occurs about halfway through your menstrual cycle, which is when an egg is released from the ovary and can be fertilized. It’s a crucial part of reproduction.",
// //         "symptoms": "Common menstrual symptoms include cramping, bloating, mood swings, and breast tenderness. These symptoms vary from person to person and can be managed with self-care and, if necessary, medical advice.",
// //         "irregular": "Irregular periods can be caused by factors such as stress, hormonal imbalances, or health conditions. If you experience irregular periods frequently, it's a good idea to consult a healthcare provider to rule out any underlying issues.",
// //         "tips": "Here are some tips for managing menstrual symptoms: stay hydrated, exercise regularly, eat a balanced diet, and consider using a heating pad for cramps. Keeping track of your cycle can also help manage symptoms.",
// //         "pms": "Premenstrual Syndrome (PMS) refers to a range of symptoms that occur before your period, such as mood swings, fatigue, and irritability. Managing stress, getting regular exercise, and eating a balanced diet can help alleviate these symptoms.",
// //         "menopause": "Menopause marks the end of a woman's reproductive years and typically occurs around age 50. During menopause, menstrual periods stop permanently and you may experience symptoms such as hot flashes and mood changes.",
// //         "hormones": "Hormones play a crucial role in regulating your menstrual cycle. Imbalances in hormones can affect your cycle and overall health. If you suspect hormonal imbalances, consider consulting a healthcare provider for evaluation and treatment options.",
// //         "birth control": "Birth control methods can help regulate your menstrual cycle and manage symptoms. There are various options available, so it's important to consult with a healthcare provider to find the best method for your needs.",
// //         "heavy period": "Heavy periods, also known as menorrhagia, can be caused by hormonal imbalances, fibroids, or other health issues. If you experience heavy bleeding that affects your daily life, it’s important to seek medical advice.",
// //         "light period": "A lighter period can be normal for some women, but it may also indicate hormonal changes or other health issues. If you notice a significant change in your menstrual flow, consider discussing it with a healthcare provider.",
// //         "spotting": "Spotting between periods can be normal, but if it happens frequently or is accompanied by other symptoms, it could indicate underlying issues. It's best to consult a healthcare provider for a proper evaluation.",
// //         "delayed period": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, it’s a good idea to consult a healthcare provider for a thorough evaluation.",
// //         "my menstruation is delayed": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, it’s a good idea to consult a healthcare provider for a thorough evaluation.",
// //         "okay": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
// //         "ok": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
// //         "good": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
// //         "my period is delayed": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, it’s a good idea to consult a healthcare provider for a thorough evaluation.",
// //         "menstrual cycle": "Your menstrual cycle includes the time from the first day of one period to the first day of the next. It's typically around 28 days but can vary from person to person.",
// //         "pms symptoms": "PMS symptoms can include irritability, depression, mood swings, headaches, and bloating. These can start a week or two before your period begins and usually go away once your period starts.",
// //         "period pain": "Menstrual cramps, or dysmenorrhea, are common and can be managed with over-the-counter pain relievers, heat therapy, or regular exercise. If the pain is severe, consult a healthcare provider.",
// //         "period tracker": "A period tracker can help you monitor your menstrual cycle, predict your next period, and track symptoms. There are many apps available to help you keep track of your cycle and symptoms.",
// //         "endometriosis": "Endometriosis is a condition where tissue similar to the lining of the uterus grows outside the uterus. It can cause painful periods, heavy bleeding, and other symptoms. Consult a healthcare provider for diagnosis and treatment options.",
// //         "pcos": "Polycystic Ovary Syndrome (PCOS) is a hormonal disorder causing enlarged ovaries with small cysts. It can lead to irregular periods, excess hair growth, and other symptoms. Consult a healthcare provider for diagnosis and management.",
// //         "fertility": "Fertility refers to the ability to conceive a child. Factors affecting fertility include age, hormonal balance, and overall health. If you're having trouble conceiving, consider consulting a fertility specialist for evaluation and advice.",
// //         "birth control methods": "There are several types of birth control methods, including hormonal methods (pills, patches), barrier methods (condoms), and long-acting methods (IUDs, implants). Discuss with a healthcare provider to choose the best option for your needs.",
// //         "menstrual hygiene": "Maintaining good menstrual hygiene is important for health and comfort. Use sanitary products like pads, tampons, or menstrual cups, and change them regularly. Make sure to practice good hand hygiene and keep the area clean.",
// //         "diet during period": "Eating a balanced diet during your period can help manage symptoms. Include foods rich in iron, calcium, and magnesium, and stay hydrated. Avoid excessive caffeine, sugar, and salty foods.",
// //         "exercise during period": "Light exercise, such as walking or yoga, can help alleviate menstrual cramps and improve mood. However, listen to your body and adjust your exercise routine based on how you feel.",
// //         "stress and periods": "Stress can affect your menstrual cycle and exacerbate symptoms. Managing stress through relaxation techniques, exercise, and a healthy lifestyle can help regulate your cycle and improve overall well-being.",
// //         "cycle length": "The average menstrual cycle length is about 28 days, but it can range from 21 to 35 days. If your cycle is consistently outside this range, you might want to consult a healthcare provider.",
// //         "period flow": "Period flow can vary from light to heavy during your cycle. If you experience unusually heavy or prolonged bleeding, it’s best to speak with a healthcare provider.",
// //         "menstrual cup": "A menstrual cup is a reusable, eco-friendly alternative to pads and tampons. It’s made of medical-grade silicone and can be worn for up to 12 hours.",
// //         "tampons": "Tampons are a convenient and discreet menstrual product. Remember to change them every 4-8 hours to reduce the risk of Toxic Shock Syndrome (TSS).",
// //         "pads": "Pads are an easy-to-use menstrual product that come in different sizes and absorbencies. Change them regularly to maintain hygiene.",
// //         "missed period": "A missed period could be due to stress, changes in routine, or pregnancy. If you miss more than one period or have other symptoms, consider consulting a healthcare provider.",
// //         "cramps": "Menstrual cramps are common and can usually be managed with pain relief, heating pads, or light exercise. If the pain is severe, it's a good idea to consult a healthcare provider.",
// //         "late period": "A late period can be caused by stress, hormonal changes, or pregnancy. If your period is consistently late, consider seeing a healthcare provider.",
// //         "period myths": "There are many myths about periods, like not being able to swim or exercise. The truth is, you can do almost anything on your period with the right menstrual products.",
// //         "menstrual cycle phases": "The menstrual cycle has four phases: menstruation, the follicular phase, ovulation, and the luteal phase. Each phase involves different hormonal changes in the body.",
// //         "period symptoms": "Period symptoms can include bloating, cramps, fatigue, and mood swings. These are normal but can be managed with self-care practices and over-the-counter remedies.",
// //         "why is my period delayed": "A delayed period can be due to stress, changes in your routine, or hormonal fluctuations. Pregnancy is also a possibility if you're sexually active. If you're concerned, it might be a good idea to take a pregnancy test or consult with a healthcare provider.",
// //         "why my period is delayed": "A delayed period can be due to stress, changes in your routine, or hormonal fluctuations. Pregnancy is also a possibility if you're sexually active. If you're concerned, it might be a good idea to take a pregnancy test or consult with a healthcare provider.",
// //         "Why is my period late": "A late period can be caused by a variety of factors including stress, hormonal changes, changes in weight, excessive exercise, or pregnancy. If your period is consistently late or you have other symptoms, it might be a good idea to consult a healthcare provider.",
// //         "What can cause a delayed period": "A delayed period can be caused by stress, hormonal imbalances, changes in diet or exercise habits, thyroid issues, or pregnancy. If you're concerned, consider reaching out to a healthcare provider for advice.",
// //         "Could I be pregnant if my period is delayed":  "If your period is delayed and you've been sexually active, pregnancy is one possible reason. Consider taking a pregnancy test to find out. If you're unsure, it's best to consult with a healthcare provider.",
// //          "My period is late, but Im not pregnant.": "If pregnancy is ruled out, a late period could be due to stress, hormonal imbalances, changes in routine, weight fluctuations, or underlying health conditions. If this continues, consulting a healthcare provider is recommended.",
// //          "my period is late, but im not pregnant.": "If pregnancy is ruled out, a late period could be due to stress, hormonal imbalances, changes in routine, weight fluctuations, or underlying health conditions. If this continues, consulting a healthcare provider is recommended.",
// //          "irregular periods": "Irregular periods can happen due to stress, hormonal imbalances, or lifestyle changes. If they persist, consider seeing a healthcare provider.",
// //          "cramps during ovulation": "Cramps during ovulation, also known as mittelschmerz, can occur when the egg is released from the ovary. These cramps are typically mild but can sometimes be uncomfortable.",
// //          "heavy menstrual bleeding": "Heavy menstrual bleeding may indicate conditions like fibroids or hormonal imbalances. It's important to consult a doctor if you frequently experience heavy periods.",
// //          "missing period": "Missing a period can be caused by stress, hormonal changes, or pregnancy. If you're concerned, it's a good idea to take a pregnancy test or consult your healthcare provider.",
// //          "menstrual migraine": "Menstrual migraines are headaches that coincide with your menstrual cycle. They are often triggered by hormonal changes, and over-the-counter pain relief may help.",
// //          "how to track periods": "You can use apps or a calendar to track your menstrual cycle. This helps in predicting your next period and identifying any irregularities.",             
// //     };

// //      // Initialize response variable
// //      let response = "I'm not quite sure about that. Could you please ask something related to menstrual health or rephrase your question?";

// //      // Convert message to lowercase for case-insensitive matching
// //      const lowerCaseMessage = message.toLowerCase();
 
// //      // Check for exact matches first
// //      for (const [key, value] of Object.entries(responses)) {
// //          if (lowerCaseMessage.includes(key)) {
// //              response = value;
// //              break; // Exit loop after first match
// //          }
// //      }
  
// //      // Return the final response
// //      console.log("Responding with:", response); // Debugging line
// //      return response;
// //  }

