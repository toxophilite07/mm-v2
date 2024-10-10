// function getAIResponse(message) {
//     console.log("Received message:", message); // Debugging line

//     // Define your responses object
//     const responses = {
//         "hello": "Hi there! How can I assist you today?",
//         "hi": "Hello! What can I help you with today?",
//         "good morning": "Good morning! How can I help you today?",
//         "morning": "Good morning! How can I help you today?",
//         "good afternoon": "Good afternoon! How can I assist you?",
//         "good noon": "Good noon! How can I assist you?",
//         "good evening": "Good evening! How can I assist you tonight?",
//         "good night": "Good night! If you need any help, just ask.",
//         "bye": "Goodbye! Have a great day!",
//         "thanks": "You're welcome! If you have any other questions, feel free to ask.",
//         "thank you": "My pleasure! Let me know if there's anything else I can help with.",
//         "cycle": "A menstrual cycle is the series of changes a woman's body goes through to prepare for a potential pregnancy. It typically lasts about 28 days.",
//         "ovulation": "Ovulation occurs about halfway through your menstrual cycle, which is when an egg is released from the ovary and can be fertilized. Its a crucial part of reproduction.",
//         "symptoms": "Common menstrual symptoms include cramping, bloating, mood swings, and breast tenderness. These symptoms vary from person to person and can be managed with self-care and, if necessary, medical advice.",
//         "irregular": "Irregular periods can be caused by factors such as stress, hormonal imbalances, or health conditions. If you experience irregular periods frequently, it's a good idea to consult a healthcare provider to rule out any underlying issues.",
//         "tips": "Here are some tips for managing menstrual symptoms: stay hydrated, exercise regularly, eat a balanced diet, and consider using a heating pad for cramps. Keeping track of your cycle can also help manage symptoms.",
//         "pms": "Premenstrual Syndrome (PMS) refers to a range of symptoms that occur before your period, such as mood swings, fatigue, and irritability. Managing stress, getting regular exercise, and eating a balanced diet can help alleviate these symptoms.",
//         "menopause": "Menopause marks the end of a woman's reproductive years and typically occurs around age 50. During menopause, menstrual periods stop permanently and you may experience symptoms such as hot flashes and mood changes.",
//         "hormones": "Hormones play a crucial role in regulating your menstrual cycle. Imbalances in hormones can affect your cycle and overall health. If you suspect hormonal imbalances, consider consulting a healthcare provider for evaluation and treatment options.",
//         "birth control": "Birth control methods can help regulate your menstrual cycle and manage symptoms. There are various options available, so it's important to consult with a healthcare provider to find the best method for your needs.",
//         "heavy period": "Heavy periods, also known as menorrhagia, can be caused by hormonal imbalances, fibroids, or other health issues. If you experience heavy bleeding that affects your daily life, its important to seek medical advice.",
//         "light period": "A lighter period can be normal for some women, but it may also indicate hormonal changes or other health issues. If you notice a significant change in your menstrual flow, consider discussing it with a healthcare provider.",
//         "spotting": "Spotting between periods can be normal, but if it happens frequently or is accompanied by other symptoms, it could indicate underlying issues. It's best to consult a healthcare provider for a proper evaluation.",
//         "delayed period": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, its a good idea to consult a healthcare provider for a thorough evaluation.",
//         "my menstruation is delayed": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, its a good idea to consult a healthcare provider for a thorough evaluation.",
//         "okay": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
//         "ok": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
//         "good": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
//         "my period is delayed": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, its a good idea to consult a healthcare provider for a thorough evaluation.",
//         "menstrual cycle": "Your menstrual cycle includes the time from the first day of one period to the first day of the next. It's typically around 28 days but can vary from person to person.",
//         "pms symptoms": "PMS symptoms can include irritability, depression, mood swings, headaches, and bloating. These can start a week or two before your period begins and usually go away once your period starts.",
//         "period pain": "Menstrual cramps, or dysmenorrhea, are common and can be managed with over-the-counter pain relievers, heat therapy, or regular exercise. If the pain is severe, consult a healthcare provider.",
//         "period tracker": "A period tracker can help you monitor your menstrual cycle, predict your next period, and track symptoms. There are many apps available to help you keep track of your cycle and symptoms.",
//         "endometriosis": "Endometriosis is a condition where tissue similar to the lining of the uterus grows outside the uterus. It can cause painful periods, heavy bleeding, and other symptoms. Consult a healthcare provider for diagnosis and treatment options.",
//         "pcos": "Polycystic Ovary Syndrome (PCOS) is a hormonal disorder causing enlarged ovaries with small cysts. It can lead to irregular periods, excess hair growth, and other symptoms. Consult a healthcare provider for diagnosis and management.",
//         "fertility": "Fertility refers to the ability to conceive a child. Factors affecting fertility include age, hormonal balance, and overall health. If you're having trouble conceiving, consider consulting a fertility specialist for evaluation and advice.",
//         "birth control methods": "There are several types of birth control methods, including hormonal methods (pills, patches), barrier methods (condoms), and long-acting methods (IUDs, implants). Discuss with a healthcare provider to choose the best option for your needs.",
//         "menstrual hygiene": "Maintaining good menstrual hygiene is important for health and comfort. Use sanitary products like pads, tampons, or menstrual cups, and change them regularly. Make sure to practice good hand hygiene and keep the area clean.",
//         "diet during period": "Eating a balanced diet during your period can help manage symptoms. Include foods rich in iron, calcium, and magnesium, and stay hydrated. Avoid excessive caffeine, sugar, and salty foods.",
//         "exercise during period": "Light exercise, such as walking or yoga, can help alleviate menstrual cramps and improve mood. However, listen to your body and adjust your exercise routine based on how you feel.",
//         "stress and periods": "Stress can affect your menstrual cycle and exacerbate symptoms. Managing stress through relaxation techniques, exercise, and a healthy lifestyle can help regulate your cycle and improve overall well-being.",
//         "cycle length": "The average menstrual cycle length is about 28 days, but it can range from 21 to 35 days. If your cycle is consistently outside this range, you might want to consult a healthcare provider.",
//         "period flow": "Period flow can vary from light to heavy during your cycle. If you experience unusually heavy or prolonged bleeding, its best to speak with a healthcare provider.",
//         "menstrual cup": "A menstrual cup is a reusable, eco-friendly alternative to pads and tampons. Its made of medical-grade silicone and can be worn for up to 12 hours.",
//         "tampons": "Tampons are a convenient and discreet menstrual product. Remember to change them every 4-8 hours to reduce the risk of Toxic Shock Syndrome (TSS).",
//         "pads": "Pads are an easy-to-use menstrual product that come in different sizes and absorbencies. Change them regularly to maintain hygiene.",
//         "missed period": "A missed period could be due to stress, changes in routine, or pregnancy. If you miss more than one period or have other symptoms, consider consulting a healthcare provider.",
//         "cramps": "Menstrual cramps are common and can usually be managed with pain relief, heating pads, or light exercise. If the pain is severe, it's a good idea to consult a healthcare provider.",
//         "late period": "A late period can be caused by stress, hormonal changes, or pregnancy. If your period is consistently late, consider seeing a healthcare provider.",
//         "period myths": "There are many myths about periods, like not being able to swim or exercise. The truth is, you can do almost anything on your period with the right menstrual products.",
//         "menstrual cycle phases": "The menstrual cycle has four phases: menstruation, the follicular phase, ovulation, and the luteal phase. Each phase involves different hormonal changes in the body.",
//         "period symptoms": "Period symptoms can include bloating, cramps, fatigue, and mood swings. These are normal but can be managed with self-care practices and over-the-counter remedies.",
//         "why is my period delayed": "A delayed period can be due to stress, changes in your routine, or hormonal fluctuations. Pregnancy is also a possibility if you're sexually active. If you're concerned, it might be a good idea to take a pregnancy test or consult with a healthcare provider.",
//         "why my period is delayed": "A delayed period can be due to stress, changes in your routine, or hormonal fluctuations. Pregnancy is also a possibility if you're sexually active. If you're concerned, it might be a good idea to take a pregnancy test or consult with a healthcare provider.",
//         "Why is my period late": "A late period can be caused by a variety of factors including stress, hormonal changes, changes in weight, excessive exercise, or pregnancy. If your period is consistently late or you have other symptoms, it might be a good idea to consult a healthcare provider.",
//         "What can cause a delayed period": "A delayed period can be caused by stress, hormonal imbalances, changes in diet or exercise habits, thyroid issues, or pregnancy. If you're concerned, consider reaching out to a healthcare provider for advice.",
//         "Could I be pregnant if my period is delayed":  "If your period is delayed and you've been sexually active, pregnancy is one possible reason. Consider taking a pregnancy test to find out. If you're unsure, it's best to consult with a healthcare provider.",
//          "My period is late, but Im not pregnant.": "If pregnancy is ruled out, a late period could be due to stress, hormonal imbalances, changes in routine, weight fluctuations, or underlying health conditions. If this continues, consulting a healthcare provider is recommended.",
//          "my period is late, but im not pregnant.": "If pregnancy is ruled out, a late period could be due to stress, hormonal imbalances, changes in routine, weight fluctuations, or underlying health conditions. If this continues, consulting a healthcare provider is recommended.",
//          "irregular periods": "Irregular periods can happen due to stress, hormonal imbalances, or lifestyle changes. If they persist, consider seeing a healthcare provider.",
//          "cramps during ovulation": "Cramps during ovulation, also known as mittelschmerz, can occur when the egg is released from the ovary. These cramps are typically mild but can sometimes be uncomfortable.",
//          "heavy menstrual bleeding": "Heavy menstrual bleeding may indicate conditions like fibroids or hormonal imbalances. It's important to consult a doctor if you frequently experience heavy periods.",
//          "missing period": "Missing a period can be caused by stress, hormonal changes, or pregnancy. If you're concerned, it's a good idea to take a pregnancy test or consult your healthcare provider.",
//          "menstrual migraine": "Menstrual migraines are headaches that coincide with your menstrual cycle. They are often triggered by hormonal changes, and over-the-counter pain relief may help.",
//          "how to track periods": "You can use apps or a calendar to track your menstrual cycle. This helps in predicting your next period and identifying any irregularities.",      
//          "what is menstruation" : "Menstruation, often referred to as a period is the regular discharge of blood and tissue from the inner lining of the uterus through the vagina. It is a natural biological process that occurs in women and people with female reproductive systems as part of the menstrual cycle. " ,
//          "what is puberty?": "Puberty is a physical change that naturally happens to us girls between the ages 10-14. During this stage, you'll notice changes happening to your body, like your waistline starting to become more defined and your breasts starting to develop -- and of course  the occurrence of your first period!",  
//          "puberty": "Puberty is a physical change that naturally happens to us girls between the ages 10-14. During this stage, you'll notice changes happening to your body, like your waistline starting to become more defined and your breasts starting to develop -- and of course  the occurrence of your first period!",
//          "menstruation" : "Menstruation, often referred to as a period is the regular discharge of blood and tissue from the inner lining of the uterus through the vagina. It is a natural biological process that occurs in women and people with female reproductive systems as part of the menstrual cycle. " ,
//          "what is menstruation?" : "Menstruation, often referred to as a period is the regular discharge of blood and tissue from the inner lining of the uterus through the vagina. It is a natural biological process that occurs in women and people with female reproductive systems as part of the menstrual cycle. " ,
//          "what is period?" : "Once puberty hits, you’ll start having a monthly cycle, and your period is the last stage. Stage 1 is when your body starts preparing for pregnancy by building up blood-rich cells. Stage 2 is when you ovulate. Stage 3 is when your body sheds the blood-rich membrane, also known as your period, which usually lasts 3-7 days. Your body will repeat this cycle, unless you get pregnant" ,
//          "what is period" : "Once puberty hits, you’ll start having a monthly cycle, and your period is the last stage. Stage 1 is when your body starts preparing for pregnancy by building up blood-rich cells. Stage 2 is when you ovulate. Stage 3 is when your body sheds the blood-rich membrane, also known as your period, which usually lasts 3-7 days. Your body will repeat this cycle, unless you get pregnant" ,
//          "why do periods hurt?": "Period pain, or dysmenorrhea, is caused by uterine contractions as it sheds its lining. For most people, it can be managed with over-the-counter pain relievers or home remedies.",
//          "why do periods hurt": "Period pain, or dysmenorrhea, is caused by uterine contractions as it sheds its lining. For most people, it can be managed with over-the-counter pain relievers or home remedies.",
//          "why do periods hurts?": "Period pain, or dysmenorrhea, is caused by uterine contractions as it sheds its lining. For most people, it can be managed with over-the-counter pain relievers or home remedies.",
//          "when will my period start?": "It’s different for everyone! You may experience your first period between the ages 10-14, but about 50% of girls have theirs at the age of 12. If your period comes in earlier than your friends’, don’t fret—it’s totally normal!",
//          "when will my period start": "It’s different for everyone! You may experience your first period between the ages 10-14, but about 50% of girls have theirs at the age of 12. If your period comes in earlier than your friends’, don’t fret—it’s totally normal!",
//          "when will my period starts": "It’s different for everyone! You may experience your first period between the ages 10-14, but about 50% of girls have theirs at the age of 12. If your period comes in earlier than your friends’, don’t fret—it’s totally normal!",
//          "how long will my period last?": "Usually, you get your period approximately once a month as part of your cycle. Most girls experience their period for 3-7 days. It takes a couple of years for your body to find a pattern that is unique to you, so if you notice something irregular about your period, don’t be too shy to consult your doctor!",
//          "how long will my period last": "Usually, you get your period approximately once a month as part of your cycle. Most girls experience their period for 3-7 days. It takes a couple of years for your body to find a pattern that is unique to you, so if you notice something irregular about your period, don’t be too shy to consult your doctor!",
//          "Menstrual cycle" : "A series of natural changes that occur in the female reproductive system, including the production of hormones and the structure of the uterus and ovaries. The average menstrual cycle lasts about 28 days, but can vary from person to person.",
//          "menstrual cycle" : "A series of natural changes that occur in the female reproductive system, including the production of hormones and the structure of the uterus and ovaries. The average menstrual cycle lasts about 28 days, but can vary from person to person.",
//          "Menstruation" : "The monthly bleeding that occurs when the body sheds the lining of the uterus. Menstrual blood is a combination of blood and tissue from the uterus. A normal period lasts between three and seven days.",
//          "menstruation" : "The monthly bleeding that occurs when the body sheds the lining of the uterus. Menstrual blood is a combination of blood and tissue from the uterus. A normal period lasts between three and seven days.",
//          "Menstrual" : "Menstrual refers to the monthly cycle of hormonal changes that prepare the body for pregnancy, and the monthly bleeding that occurs when the body sheds the lining of the uterus",
//          "menstrual" : "Menstrual refers to the monthly cycle of hormonal changes that prepare the body for pregnancy, and the monthly bleeding that occurs when the body sheds the lining of the uterus",
//          "how often should i change my pads" : "Normally, your first two days are the heaviest! For heavy flow days, it’s ideal to change your pad every 2-3 hours; otherwise, changing it every 4 hours should be just right to keep you clean and protected.",
//          "how often should i change my pads?" : "Normally, your first two days are the heaviest! For heavy flow days, it’s ideal to change your pad every 2-3 hours; otherwise, changing it every 4 hours should be just right to keep you clean and protected.",
//          "what is discharge?" : "If you find sticky stuff coming from your vagina, don’t panic! It happens to every woman and is your body’s way of keeping the vagina clean and healthy. Vaginal discharge is normally odorless and varies in color, depending on the monthly cycle stage you’re in. If you notice anything strange about your discharge, again, don’t be too shy to consult your doctor!",
//          "what is discharge" : "If you find sticky stuff coming from your vagina, don’t panic! It happens to every woman and is your body’s way of keeping the vagina clean and healthy. Vaginal discharge is normally odorless and varies in color, depending on the monthly cycle stage you’re in. If you notice anything strange about your discharge, again, don’t be too shy to consult your doctor!",
//          "how can i get rid of cramps and pain during my period" : "It’s normal to experience discomfort during your period. Abdominal pain or cramps are the most common. There are many natural remedies you can try at home to relieve some of the pain, like taking a warm bath or placing a hot water bottle on your abdomen. The warmth will help ease overall tension and pain. Bloating is another discomfort you might experience, but you can counter this by staying active and following a healthy diet. For any severe pain caused by your period, you can always talk to your doctor or gynecologists for better treatment.",
//          "how can i get rid of cramps and pain during my period?" : "It’s normal to experience discomfort during your period. Abdominal pain or cramps are the most common. There are many natural remedies you can try at home to relieve some of the pain, like taking a warm bath or placing a hot water bottle on your abdomen. The warmth will help ease overall tension and pain. Bloating is another discomfort you might experience, but you can counter this by staying active and following a healthy diet. For any severe pain caused by your period, you can always talk to your doctor or gynecologists for better treatment.",
//          "how will i feel when i have my period?" : "It differs per person. Some girls might feel less discomfort and less emotional than others, but exercising and maintaining a healthy diet will help make you feel better no matter where you are in your monthly cycle. Try incorporating these things into your daily routine and see how it makes you feel!",
//          "how will i feel when i have my period" : "It differs per person. Some girls might feel less discomfort and less emotional than others, but exercising and maintaining a healthy diet will help make you feel better no matter where you are in your monthly cycle. Try incorporating these things into your daily routine and see how it makes you feel!",
//          "what about odor?" : "In general, menstrual blood will start to smell when it leaves your body and comes in contact with air. Lucky for you, MODESS® always has your back in preventing odor and in keeping you feeling fresh and protected. Check out our wide range of sanitary protection that caters to your specific needs!",
//          "what about odor" : "In general, menstrual blood will start to smell when it leaves your body and comes in contact with air. Lucky for you, MODESS® always has your back in preventing odor and in keeping you feeling fresh and protected. Check out our wide range of sanitary protection that caters to your specific needs!",
//          "Will people know when I have my period?" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
//          "will people know when I have my period?" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
//          "will people know when i have my period?" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
//          "Will people know when I have my period" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
//          "will people know when i have my period" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
//          "Do boys have anything like this?" : "Boys don’t have periods, but they do go through puberty. They grow body hair, get pimples, and some grow tall very quickly. Many boys feel embarrassed when their voices suddenly change or when they act clumsy. And they get moody, too.",
//          "do boys have anything like this?" : "Boys don’t have periods, but they do go through puberty. They grow body hair, get pimples, and some grow tall very quickly. Many boys feel embarrassed when their voices suddenly change or when they act clumsy. And they get moody, too.",
//          "Do boys have anything like this" : "Boys don’t have periods, but they do go through puberty. They grow body hair, get pimples, and some grow tall very quickly. Many boys feel embarrassed when their voices suddenly change or when they act clumsy. And they get moody, too.",
//          "do boys have anything like this" : "Boys don’t have periods, but they do go through puberty. They grow body hair, get pimples, and some grow tall very quickly. Many boys feel embarrassed when their voices suddenly change or when they act clumsy. And they get moody, too.",
//          "" : "",
//          "Menstrual products" : "There are many types of menstrual products available, including sanitary pads, tampons, menstrual cups, menstrual discs, and period underwear.",
//          "menstrual products" : "There are many types of menstrual products available, including sanitary pads, tampons, menstrual cups, menstrual discs, and period underwear.",
//          "Menstrual product" : "There are many types of menstrual products available, including sanitary pads, tampons, menstrual cups, menstrual discs, and period underwear.",
//          "menstrual product" : "There are many types of menstrual products available, including sanitary pads, tampons, menstrual cups, menstrual discs, and period underwear.",
//          "How do I choose a menstrual product?" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
//          "how do I choose a menstrual product?" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
//          "How do i choose a menstrual product?" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
//          "How do I choose a menstrual product" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
//          "how do i choose a menstrual product" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
//          "How do I dispose of menstrual products?" : "Wrap used products in toilet paper and throw them away in a sanitary disposal container or waste bin. You should not flush organic or biodegradable products, as they can take months to break down and pollute the environment.",
//          "how do i dispose of menstrual products?" : "Wrap used products in toilet paper and throw them away in a sanitary disposal container or waste bin. You should not flush organic or biodegradable products, as they can take months to break down and pollute the environment.",
//          "how do i dispose of menstrual products" : "Wrap used products in toilet paper and throw them away in a sanitary disposal container or waste bin. You should not flush organic or biodegradable products, as they can take months to break down and pollute the environment.",
//          "How do I=i dispose of menstrual products?" : "Wrap used products in toilet paper and throw them away in a sanitary disposal container or waste bin. You should not flush organic or biodegradable products, as they can take months to break down and pollute the environment.",
//          "Are menstrual products safe?" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS. <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",       
//          "Are menstrual products safe?" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",
//          "are menstrual products safe?" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",
//          "Are menstrual products safe" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",
//          "are menstrual products safe" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",
//          "When should I talk to a doctor?" : "You should talk to a doctor if you experience a change in vaginal odor, extreme pain, or more severe period symptoms than usual. ",
//          "when should I talk to a doctor?" : "You should talk to a doctor if you experience a change in vaginal odor, extreme pain, or more severe period symptoms than usual. ",
//          "when should I talk to a doctor" : "You should talk to a doctor if you experience a change in vaginal odor, extreme pain, or more severe period symptoms than usual. ",
//          "when should I talk to a doctor" : "You should talk to a doctor if you experience a change in vaginal odor, extreme pain, or more severe period symptoms than usual. ",
//          "When will I get my first period?" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
//          "When will I get my first period" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
//          "when will I get my first period?" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
//          "when will I get my first period" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
//          "when will i get my first period?" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
//          "How long is each cycle?" : "Don’t worry if your period sometimes skips months for the first few years. You might even have a period twice in one month. That’s OK. By the time you’re an adult, it is normal for a cycle (the time from the first day of one period to the first day of your next period) to take 21 to 34 days. That’s why you hear women talk about a “monthly cycle.”",
//          "how long is each cycle?" : "Don’t worry if your period sometimes skips months for the first few years. You might even have a period twice in one month. That’s OK. By the time you’re an adult, it is normal for a cycle (the time from the first day of one period to the first day of your next period) to take 21 to 34 days. That’s why you hear women talk about a “monthly cycle.”",
//          "How long is each cycle" : "Don’t worry if your period sometimes skips months for the first few years. You might even have a period twice in one month. That’s OK. By the time you’re an adult, it is normal for a cycle (the time from the first day of one period to the first day of your next period) to take 21 to 34 days. That’s why you hear women talk about a “monthly cycle.”",
//          "how long is each cycle" : "Don’t worry if your period sometimes skips months for the first few years. You might even have a period twice in one month. That’s OK. By the time you’re an adult, it is normal for a cycle (the time from the first day of one period to the first day of your next period) to take 21 to 34 days. That’s why you hear women talk about a “monthly cycle.”",
//          "How long does each period last?" : "Each girl is different, but it’s normal for a period to last 2 to 7 days. Talk to your parents or healthcare provider if your period lasts longer than 8 days for 2 cycles in a row.",
//          "how long does each period last?" : "Each girl is different, but it’s normal for a period to last 2 to 7 days. Talk to your parents or healthcare provider if your period lasts longer than 8 days for 2 cycles in a row.",
//          "How long does each period last" : "Each girl is different, but it’s normal for a period to last 2 to 7 days. Talk to your parents or healthcare provider if your period lasts longer than 8 days for 2 cycles in a row.",
//          "how long does each period last" : "Each girl is different, but it’s normal for a period to last 2 to 7 days. Talk to your parents or healthcare provider if your period lasts longer than 8 days for 2 cycles in a row.",
//          "What does a period look like?" : "The lining of the uterus is rich with blood. So the color of your menstrual flow can be pink, red, or brown. The flow can be thick, lumpy, or runny.",
//          "what does a period look like" : "The lining of the uterus is rich with blood. So the color of your menstrual flow can be pink, red, or brown. The flow can be thick, lumpy, or runny.",
//          "What does a period look like" : "The lining of the uterus is rich with blood. So the color of your menstrual flow can be pink, red, or brown. The flow can be thick, lumpy, or runny.",
//          "what does a period look like?" : "The lining of the uterus is rich with blood. So the color of your menstrual flow can be pink, red, or brown. The flow can be thick, lumpy, or runny.",
//          "How much will I bleed?" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
//          "How much will I bleed" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
//          "how much will I bleed?" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
//          "how much will I bleed" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
//          "how much will i bleed?" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
//          "how much will i bleed" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
//          "Can I bleed too much?" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
//          "can I bleed too much?" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
//          "Can I bleed too much" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
//          "Can i bleed too much?" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
//          "can i bleed too much?" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
//          "can i bleed too much" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
//          "how do I practice healthy menstrual hygiene?": 
//          "• Wash your hands before and after using the restroom and before and after using a menstrual product.<br>" +
//          "• Change sanitary pads every few hours, or more frequently if your period is heavy.<br>" +
//          "• Change tampons every 4 to 8 hours, and use the lowest-absorbency tampon needed.<br>" +
//          "• Rinse your genital area at least twice a day with warm water without soap.",
//          "How do I practice healthy menstrual hygiene?": 
//          "• Wash your hands before and after using the restroom and before and after using a menstrual product.<br>" +
//          "• Change sanitary pads every few hours, or more frequently if your period is heavy.<br>" +
//          "• Change tampons every 4 to 8 hours, and use the lowest-absorbency tampon needed.<br>" +
//          "• Rinse your genital area at least twice a day with warm water without soap.",
//          "how do i practice healthy menstrual hygiene?": 
//          "• Wash your hands before and after using the restroom and before and after using a menstrual product.<br>" +
//          "• Change sanitary pads every few hours, or more frequently if your period is heavy.<br>" +
//          "• Change tampons every 4 to 8 hours, and use the lowest-absorbency tampon needed.<br>" +
//          "• Rinse your genital area at least twice a day with warm water without soap.",
//          "how do i practice healthy menstrual hygiene": 
//          "• Wash your hands before and after using the restroom and before and after using a menstrual product.<br>" +
//          "• Change sanitary pads every few hours, or more frequently if your period is heavy.<br>" +
//          "• Change tampons every 4 to 8 hours, and use the lowest-absorbency tampon needed.<br>" +
//          "• Rinse your genital area at least twice a day with warm water without soap.",
//          "What is menstrual" : "Menstruation, or period, is normal vaginal bleeding that occurs as part of a woman's monthly cycle. Every month, your body prepares for pregnancy. If no pregnancy occurs, the uterus, or womb, sheds its lining. The menstrual blood is partly blood and partly tissue from inside the uterus.",
//          "what is menstrual?" : "Menstruation, or period, is normal vaginal bleeding that occurs as part of a woman's monthly cycle. Every month, your body prepares for pregnancy. If no pregnancy occurs, the uterus, or womb, sheds its lining. The menstrual blood is partly blood and partly tissue from inside the uterus.",
//          "What is menstrual" : "Menstruation, or period, is normal vaginal bleeding that occurs as part of a woman's monthly cycle. Every month, your body prepares for pregnancy. If no pregnancy occurs, the uterus, or womb, sheds its lining. The menstrual blood is partly blood and partly tissue from inside the uterus.",
//          "What is a normal menstrual cycle?" : "A normal menstrual cycle ranges from 21 to 35 days.",
//          "What is a normal menstrual cycle" : "A normal menstrual cycle ranges from 21 to 35 days.",
//          "what is a normal menstrual cycle?" : "A normal menstrual cycle ranges from 21 to 35 days.",
//          "what is a normal menstrual cycle" : "A normal menstrual cycle ranges from 21 to 35 days.",
//          "What causes irregular periods?" : "Irregular periods can be caused by stress, hormonal imbalances, or health conditions.",
//          "What causes irregular periods" : "Irregular periods can be caused by stress, hormonal imbalances, or health conditions.",
//          "what causes irregular periods?" : "Irregular periods can be caused by stress, hormonal imbalances, or health conditions.",
//          "what causes irregular periods" : "Irregular periods can be caused by stress, hormonal imbalances, or health conditions.",
//          "How can I manage period pain?" : "Period pain can be managed with over-the-counter pain relievers and heat therapy",
//          "How can I manage period pain" : "Period pain can be managed with over-the-counter pain relievers and heat therapy",
//          "how can I manage period pain?" : "Period pain can be managed with over-the-counter pain relievers and heat therapy",
//          "how can I manage period pain?" : "Period pain can be managed with over-the-counter pain relievers and heat therapy",
//          "Can stress affect my menstrual cycle?" : "Yes, stress can interfere with hormonal balance, causing missed or delayed periods.",
//          "Can stress affect my menstrual cycle" : "Yes, stress can interfere with hormonal balance, causing missed or delayed periods.",
//          "can stress affect my menstrual cycle?" : "Yes, stress can interfere with hormonal balance, causing missed or delayed periods.",
//          "can stress affect my menstrual cycle" : "Yes, stress can interfere with hormonal balance, causing missed or delayed periods.",
//          "When to tell that I am pregnant?" : "Pregnancy is typically confirmed through several signs and medical tests. Here are some key indicators of pregnancy: •Missed Period One of the earliest and most common signs of pregnancy is a missed menstrual period. If your period is late, especially if your cycles are usually regular, it may be a sign of pregnancy. •Home Pregnancy Test Home pregnancy tests can detect pregnancy as early as the first day of a missed period by measuring the level of human chorionic gonadotropin (hCG), a hormone produced after a fertilized egg attaches to the uterus. For best results, take the test a few days after your missed period. •Early Pregnancy Symptoms Fatigue: Feeling more tired than usual. Nausea/Morning Sickness: This can start around 4-6 weeks into pregnancy. Breast Changes: Tenderness or swelling of the breasts is common. Frequent Urination: Pregnancy hormones can make you feel like you need to pee more often. Mood Swings: Hormonal changes can lead to emotional fluctuations.",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",
//          "" : "",

//     };

//     const lowerCaseMessage = message.toLowerCase();

//     // Check if the message matches any key in the responses object
//     if (responses[lowerCaseMessage]) {
//         return responses[lowerCaseMessage];
//     } else {
//         // Return a message for unrelated questions
//         return "I'm not quite sure about that. Could you please ask something related to menstrual health or rephrase your question?";
//     }
// }


function getAIResponse(message) {
    console.log("Received message:", message); // Debugging line

    // Define your responses object
     const responses = {
        "hello": "Hi there! How can I assist you today?",
        "hi": "Hello! What can I help you with today?",
        "good morning": "Good morning! How can I help you today?",
        "morning": "Good morning! How can I help you today?",
        "good afternoon": "Good afternoon! How can I assist you?",
        "good noon": "Good noon! How can I assist you?",
        "good evening": "Good evening! How can I assist you tonight?",
        "good night": "Good night! If you need any help, just ask.",
        "bye": "Goodbye! Have a great day!",
        "thanks": "You're welcome! If you have any other questions, feel free to ask.",
        "thank you": "My pleasure! Let me know if there's anything else I can help with.",
        "cycle": "A menstrual cycle is the series of changes a woman's body goes through to prepare for a potential pregnancy. It typically lasts about 28 days.",
        "ovulation": "Ovulation occurs about halfway through your menstrual cycle, which is when an egg is released from the ovary and can be fertilized. Its a crucial part of reproduction.",
        "symptoms": "Common menstrual symptoms include cramping, bloating, mood swings, and breast tenderness. These symptoms vary from person to person and can be managed with self-care and, if necessary, medical advice.",
        "irregular": "Irregular periods can be caused by factors such as stress, hormonal imbalances, or health conditions. If you experience irregular periods frequently, it's a good idea to consult a healthcare provider to rule out any underlying issues.",
        "tips": "Here are some tips for managing menstrual symptoms: stay hydrated, exercise regularly, eat a balanced diet, and consider using a heating pad for cramps. Keeping track of your cycle can also help manage symptoms.",
        "pms": "Premenstrual Syndrome (PMS) refers to a range of symptoms that occur before your period, such as mood swings, fatigue, and irritability. Managing stress, getting regular exercise, and eating a balanced diet can help alleviate these symptoms.",
        "menopause": "Menopause marks the end of a woman's reproductive years and typically occurs around age 50. During menopause, menstrual periods stop permanently and you may experience symptoms such as hot flashes and mood changes.",
        "hormones": "Hormones play a crucial role in regulating your menstrual cycle. Imbalances in hormones can affect your cycle and overall health. If you suspect hormonal imbalances, consider consulting a healthcare provider for evaluation and treatment options.",
        "birth control": "Birth control methods can help regulate your menstrual cycle and manage symptoms. There are various options available, so it's important to consult with a healthcare provider to find the best method for your needs.",
        "heavy period": "Heavy periods, also known as menorrhagia, can be caused by hormonal imbalances, fibroids, or other health issues. If you experience heavy bleeding that affects your daily life, its important to seek medical advice.",
        "light period": "A lighter period can be normal for some women, but it may also indicate hormonal changes or other health issues. If you notice a significant change in your menstrual flow, consider discussing it with a healthcare provider.",
        "spotting": "Spotting between periods can be normal, but if it happens frequently or is accompanied by other symptoms, it could indicate underlying issues. It's best to consult a healthcare provider for a proper evaluation.",
        "delayed period": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, its a good idea to consult a healthcare provider for a thorough evaluation.",
        "my menstruation is delayed": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, its a good idea to consult a healthcare provider for a thorough evaluation.",
        "okay": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
        "ok": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
        "good": "Got it! If you have any more questions or need further assistance, just let me know. I'm here to help!",
        "my period is delayed": "If your period is delayed, it could be due to various factors such as stress, hormonal changes, or pregnancy. If you're sexually active and your period is late, consider taking a pregnancy test. If the delay persists or you have other symptoms, its a good idea to consult a healthcare provider for a thorough evaluation.",
        "menstrual cycle": "Your menstrual cycle includes the time from the first day of one period to the first day of the next. It's typically around 28 days but can vary from person to person.",
        "pms symptoms": "PMS symptoms can include irritability, depression, mood swings, headaches, and bloating. These can start a week or two before your period begins and usually go away once your period starts.",
        "period pain": "Menstrual cramps, or dysmenorrhea, are common and can be managed with over-the-counter pain relievers, heat therapy, or regular exercise. If the pain is severe, consult a healthcare provider.",
        "period tracker": "A period tracker can help you monitor your menstrual cycle, predict your next period, and track symptoms. There are many apps available to help you keep track of your cycle and symptoms.",
        "endometriosis": "Endometriosis is a condition where tissue similar to the lining of the uterus grows outside the uterus. It can cause painful periods, heavy bleeding, and other symptoms. Consult a healthcare provider for diagnosis and treatment options.",
        "pcos": "Polycystic Ovary Syndrome (PCOS) is a hormonal disorder causing enlarged ovaries with small cysts. It can lead to irregular periods, excess hair growth, and other symptoms. Consult a healthcare provider for diagnosis and management.",
        "fertility": "Fertility refers to the ability to conceive a child. Factors affecting fertility include age, hormonal balance, and overall health. If you're having trouble conceiving, consider consulting a fertility specialist for evaluation and advice.",
        "birth control methods": "There are several types of birth control methods, including hormonal methods (pills, patches), barrier methods (condoms), and long-acting methods (IUDs, implants). Discuss with a healthcare provider to choose the best option for your needs.",
        "menstrual hygiene": "Maintaining good menstrual hygiene is important for health and comfort. Use sanitary products like pads, tampons, or menstrual cups, and change them regularly. Make sure to practice good hand hygiene and keep the area clean.",
        "diet during period": "Eating a balanced diet during your period can help manage symptoms. Include foods rich in iron, calcium, and magnesium, and stay hydrated. Avoid excessive caffeine, sugar, and salty foods.",
        "exercise during period": "Light exercise, such as walking or yoga, can help alleviate menstrual cramps and improve mood. However, listen to your body and adjust your exercise routine based on how you feel.",
        "stress and periods": "Stress can affect your menstrual cycle and exacerbate symptoms. Managing stress through relaxation techniques, exercise, and a healthy lifestyle can help regulate your cycle and improve overall well-being.",
        "cycle length": "The average menstrual cycle length is about 28 days, but it can range from 21 to 35 days. If your cycle is consistently outside this range, you might want to consult a healthcare provider.",
        "period flow": "Period flow can vary from light to heavy during your cycle. If you experience unusually heavy or prolonged bleeding, its best to speak with a healthcare provider.",
        "menstrual cup": "A menstrual cup is a reusable, eco-friendly alternative to pads and tampons. Its made of medical-grade silicone and can be worn for up to 12 hours.",
        "tampons": "Tampons are a convenient and discreet menstrual product. Remember to change them every 4-8 hours to reduce the risk of Toxic Shock Syndrome (TSS).",
        "pads": "Pads are an easy-to-use menstrual product that come in different sizes and absorbencies. Change them regularly to maintain hygiene.",
        "missed period": "A missed period could be due to stress, changes in routine, or pregnancy. If you miss more than one period or have other symptoms, consider consulting a healthcare provider.",
        "cramps": "Menstrual cramps are common and can usually be managed with pain relief, heating pads, or light exercise. If the pain is severe, it's a good idea to consult a healthcare provider.",
        "late period": "A late period can be caused by stress, hormonal changes, or pregnancy. If your period is consistently late, consider seeing a healthcare provider.",
        "period myths": "There are many myths about periods, like not being able to swim or exercise. The truth is, you can do almost anything on your period with the right menstrual products.",
        "menstrual cycle phases": "The menstrual cycle has four phases: menstruation, the follicular phase, ovulation, and the luteal phase. Each phase involves different hormonal changes in the body.",
        "period symptoms": "Period symptoms can include bloating, cramps, fatigue, and mood swings. These are normal but can be managed with self-care practices and over-the-counter remedies.",
        "why is my period delayed": "A delayed period can be due to stress, changes in your routine, or hormonal fluctuations. Pregnancy is also a possibility if you're sexually active. If you're concerned, it might be a good idea to take a pregnancy test or consult with a healthcare provider.",
        "why my period is delayed": "A delayed period can be due to stress, changes in your routine, or hormonal fluctuations. Pregnancy is also a possibility if you're sexually active. If you're concerned, it might be a good idea to take a pregnancy test or consult with a healthcare provider.",
        "Why is my period late": "A late period can be caused by a variety of factors including stress, hormonal changes, changes in weight, excessive exercise, or pregnancy. If your period is consistently late or you have other symptoms, it might be a good idea to consult a healthcare provider.",
        "What can cause a delayed period": "A delayed period can be caused by stress, hormonal imbalances, changes in diet or exercise habits, thyroid issues, or pregnancy. If you're concerned, consider reaching out to a healthcare provider for advice.",
        "Could I be pregnant if my period is delayed":  "If your period is delayed and you've been sexually active, pregnancy is one possible reason. Consider taking a pregnancy test to find out. If you're unsure, it's best to consult with a healthcare provider.",
         "My period is late, but Im not pregnant.": "If pregnancy is ruled out, a late period could be due to stress, hormonal imbalances, changes in routine, weight fluctuations, or underlying health conditions. If this continues, consulting a healthcare provider is recommended.",
         "my period is late, but im not pregnant.": "If pregnancy is ruled out, a late period could be due to stress, hormonal imbalances, changes in routine, weight fluctuations, or underlying health conditions. If this continues, consulting a healthcare provider is recommended.",
         "irregular periods": "Irregular periods can happen due to stress, hormonal imbalances, or lifestyle changes. If they persist, consider seeing a healthcare provider.",
         "cramps during ovulation": "Cramps during ovulation, also known as mittelschmerz, can occur when the egg is released from the ovary. These cramps are typically mild but can sometimes be uncomfortable.",
         "heavy menstrual bleeding": "Heavy menstrual bleeding may indicate conditions like fibroids or hormonal imbalances. It's important to consult a doctor if you frequently experience heavy periods.",
         "missing period": "Missing a period can be caused by stress, hormonal changes, or pregnancy. If you're concerned, it's a good idea to take a pregnancy test or consult your healthcare provider.",
         "menstrual migraine": "Menstrual migraines are headaches that coincide with your menstrual cycle. They are often triggered by hormonal changes, and over-the-counter pain relief may help.",
         "how to track periods": "You can use apps or a calendar to track your menstrual cycle. This helps in predicting your next period and identifying any irregularities.",      
         "what is menstruation" : "Menstruation, often referred to as a period is the regular discharge of blood and tissue from the inner lining of the uterus through the vagina. It is a natural biological process that occurs in women and people with female reproductive systems as part of the menstrual cycle. " ,
         "what is puberty?": "Puberty is a physical change that naturally happens to us girls between the ages 10-14. During this stage, you'll notice changes happening to your body, like your waistline starting to become more defined and your breasts starting to develop -- and of course  the occurrence of your first period!",  
         "puberty": "Puberty is a physical change that naturally happens to us girls between the ages 10-14. During this stage, you'll notice changes happening to your body, like your waistline starting to become more defined and your breasts starting to develop -- and of course  the occurrence of your first period!",
         "menstruation" : "Menstruation, often referred to as a period is the regular discharge of blood and tissue from the inner lining of the uterus through the vagina. It is a natural biological process that occurs in women and people with female reproductive systems as part of the menstrual cycle. " ,
         "what is menstruation?" : "Menstruation, often referred to as a period is the regular discharge of blood and tissue from the inner lining of the uterus through the vagina. It is a natural biological process that occurs in women and people with female reproductive systems as part of the menstrual cycle. " ,
         "what is period?" : "Once puberty hits, you’ll start having a monthly cycle, and your period is the last stage. Stage 1 is when your body starts preparing for pregnancy by building up blood-rich cells. Stage 2 is when you ovulate. Stage 3 is when your body sheds the blood-rich membrane, also known as your period, which usually lasts 3-7 days. Your body will repeat this cycle, unless you get pregnant" ,
         "what is period" : "Once puberty hits, you’ll start having a monthly cycle, and your period is the last stage. Stage 1 is when your body starts preparing for pregnancy by building up blood-rich cells. Stage 2 is when you ovulate. Stage 3 is when your body sheds the blood-rich membrane, also known as your period, which usually lasts 3-7 days. Your body will repeat this cycle, unless you get pregnant" ,
         "why do periods hurt?": "Period pain, or dysmenorrhea, is caused by uterine contractions as it sheds its lining. For most people, it can be managed with over-the-counter pain relievers or home remedies.",
         "why do periods hurt": "Period pain, or dysmenorrhea, is caused by uterine contractions as it sheds its lining. For most people, it can be managed with over-the-counter pain relievers or home remedies.",
         "why do periods hurts?": "Period pain, or dysmenorrhea, is caused by uterine contractions as it sheds its lining. For most people, it can be managed with over-the-counter pain relievers or home remedies.",
         "when will my period start?": "It’s different for everyone! You may experience your first period between the ages 10-14, but about 50% of girls have theirs at the age of 12. If your period comes in earlier than your friends’, don’t fret—it’s totally normal!",
         "when will my period start": "It’s different for everyone! You may experience your first period between the ages 10-14, but about 50% of girls have theirs at the age of 12. If your period comes in earlier than your friends’, don’t fret—it’s totally normal!",
         "when will my period starts": "It’s different for everyone! You may experience your first period between the ages 10-14, but about 50% of girls have theirs at the age of 12. If your period comes in earlier than your friends’, don’t fret—it’s totally normal!",
         "how long will my period last?": "Usually, you get your period approximately once a month as part of your cycle. Most girls experience their period for 3-7 days. It takes a couple of years for your body to find a pattern that is unique to you, so if you notice something irregular about your period, don’t be too shy to consult your doctor!",
         "how long will my period last": "Usually, you get your period approximately once a month as part of your cycle. Most girls experience their period for 3-7 days. It takes a couple of years for your body to find a pattern that is unique to you, so if you notice something irregular about your period, don’t be too shy to consult your doctor!",
         "Menstrual cycle" : "A series of natural changes that occur in the female reproductive system, including the production of hormones and the structure of the uterus and ovaries. The average menstrual cycle lasts about 28 days, but can vary from person to person.",
         "menstrual cycle" : "A series of natural changes that occur in the female reproductive system, including the production of hormones and the structure of the uterus and ovaries. The average menstrual cycle lasts about 28 days, but can vary from person to person.",
         "Menstruation" : "The monthly bleeding that occurs when the body sheds the lining of the uterus. Menstrual blood is a combination of blood and tissue from the uterus. A normal period lasts between three and seven days.",
         "menstruation" : "The monthly bleeding that occurs when the body sheds the lining of the uterus. Menstrual blood is a combination of blood and tissue from the uterus. A normal period lasts between three and seven days.",
         "Menstrual" : "Menstrual refers to the monthly cycle of hormonal changes that prepare the body for pregnancy, and the monthly bleeding that occurs when the body sheds the lining of the uterus",
         "menstrual" : "Menstrual refers to the monthly cycle of hormonal changes that prepare the body for pregnancy, and the monthly bleeding that occurs when the body sheds the lining of the uterus",
         "how often should i change my pads" : "Normally, your first two days are the heaviest! For heavy flow days, it’s ideal to change your pad every 2-3 hours; otherwise, changing it every 4 hours should be just right to keep you clean and protected.",
         "how often should i change my pads?" : "Normally, your first two days are the heaviest! For heavy flow days, it’s ideal to change your pad every 2-3 hours; otherwise, changing it every 4 hours should be just right to keep you clean and protected.",
         "what is discharge?" : "If you find sticky stuff coming from your vagina, don’t panic! It happens to every woman and is your body’s way of keeping the vagina clean and healthy. Vaginal discharge is normally odorless and varies in color, depending on the monthly cycle stage you’re in. If you notice anything strange about your discharge, again, don’t be too shy to consult your doctor!",
         "what is discharge" : "If you find sticky stuff coming from your vagina, don’t panic! It happens to every woman and is your body’s way of keeping the vagina clean and healthy. Vaginal discharge is normally odorless and varies in color, depending on the monthly cycle stage you’re in. If you notice anything strange about your discharge, again, don’t be too shy to consult your doctor!",
         "how can i get rid of cramps and pain during my period" : "It’s normal to experience discomfort during your period. Abdominal pain or cramps are the most common. There are many natural remedies you can try at home to relieve some of the pain, like taking a warm bath or placing a hot water bottle on your abdomen. The warmth will help ease overall tension and pain. Bloating is another discomfort you might experience, but you can counter this by staying active and following a healthy diet. For any severe pain caused by your period, you can always talk to your doctor or gynecologists for better treatment.",
         "how can i get rid of cramps and pain during my period?" : "It’s normal to experience discomfort during your period. Abdominal pain or cramps are the most common. There are many natural remedies you can try at home to relieve some of the pain, like taking a warm bath or placing a hot water bottle on your abdomen. The warmth will help ease overall tension and pain. Bloating is another discomfort you might experience, but you can counter this by staying active and following a healthy diet. For any severe pain caused by your period, you can always talk to your doctor or gynecologists for better treatment.",
         "how will i feel when i have my period?" : "It differs per person. Some girls might feel less discomfort and less emotional than others, but exercising and maintaining a healthy diet will help make you feel better no matter where you are in your monthly cycle. Try incorporating these things into your daily routine and see how it makes you feel!",
         "how will i feel when i have my period" : "It differs per person. Some girls might feel less discomfort and less emotional than others, but exercising and maintaining a healthy diet will help make you feel better no matter where you are in your monthly cycle. Try incorporating these things into your daily routine and see how it makes you feel!",
         "what about odor?" : "In general, menstrual blood will start to smell when it leaves your body and comes in contact with air. Lucky for you, MODESS® always has your back in preventing odor and in keeping you feeling fresh and protected. Check out our wide range of sanitary protection that caters to your specific needs!",
         "what about odor" : "In general, menstrual blood will start to smell when it leaves your body and comes in contact with air. Lucky for you, MODESS® always has your back in preventing odor and in keeping you feeling fresh and protected. Check out our wide range of sanitary protection that caters to your specific needs!",
         "Will people know when I have my period?" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
         "will people know when I have my period?" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
         "will people know when i have my period?" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
         "Will people know when I have my period" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
         "will people know when i have my period" : "You are very aware of your period, but you won’t look different to other people. If you glance at yourself in the mirror, you’ll see this is true!",
         "Do boys have anything like this?" : "Boys don’t have periods, but they do go through puberty. They grow body hair, get pimples, and some grow tall very quickly. Many boys feel embarrassed when their voices suddenly change or when they act clumsy. And they get moody, too.",
         "do boys have anything like this?" : "Boys don’t have periods, but they do go through puberty. They grow body hair, get pimples, and some grow tall very quickly. Many boys feel embarrassed when their voices suddenly change or when they act clumsy. And they get moody, too.",
         "Do boys have anything like this" : "Boys don’t have periods, but they do go through puberty. They grow body hair, get pimples, and some grow tall very quickly. Many boys feel embarrassed when their voices suddenly change or when they act clumsy. And they get moody, too.",
         "do boys have anything like this" : "Boys don’t have periods, but they do go through puberty. They grow body hair, get pimples, and some grow tall very quickly. Many boys feel embarrassed when their voices suddenly change or when they act clumsy. And they get moody, too.",
         "" : "",
         "Menstrual products" : "There are many types of menstrual products available, including sanitary pads, tampons, menstrual cups, menstrual discs, and period underwear.",
         "menstrual products" : "There are many types of menstrual products available, including sanitary pads, tampons, menstrual cups, menstrual discs, and period underwear.",
         "Menstrual product" : "There are many types of menstrual products available, including sanitary pads, tampons, menstrual cups, menstrual discs, and period underwear.",
         "menstrual product" : "There are many types of menstrual products available, including sanitary pads, tampons, menstrual cups, menstrual discs, and period underwear.",
         "How do I choose a menstrual product?" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
         "how do I choose a menstrual product?" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
         "How do i choose a menstrual product?" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
         "How do I choose a menstrual product" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
         "how do i choose a menstrual product" : "There are many options, and you can choose based on your menstrual flow, where you'll be, and when you'll need coverage. Some people like tampons for sports or storing in a pocket, while others prefer pads because they're easy to use and see when they need to be changed.",
         "How do I dispose of menstrual products?" : "Wrap used products in toilet paper and throw them away in a sanitary disposal container or waste bin. You should not flush organic or biodegradable products, as they can take months to break down and pollute the environment.",
         "how do i dispose of menstrual products?" : "Wrap used products in toilet paper and throw them away in a sanitary disposal container or waste bin. You should not flush organic or biodegradable products, as they can take months to break down and pollute the environment.",
         "how do i dispose of menstrual products" : "Wrap used products in toilet paper and throw them away in a sanitary disposal container or waste bin. You should not flush organic or biodegradable products, as they can take months to break down and pollute the environment.",
         "How do I=i dispose of menstrual products?" : "Wrap used products in toilet paper and throw them away in a sanitary disposal container or waste bin. You should not flush organic or biodegradable products, as they can take months to break down and pollute the environment.",
         "Are menstrual products safe?" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS. <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",       
         "Are menstrual products safe?" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",
         "are menstrual products safe?" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",
         "Are menstrual products safe" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",
         "are menstrual products safe" : "In general, menstrual products are safe, but there are some things to consider  : •Toxic shock syndrome (TSS): Highly absorbent tampons have been linked to TSS, a rare but life-threatening condition. Changing tampons frequently can reduce the risk of TSS <br>•Skin reactions: Some people with sensitive skin may have reactions to the materials in menstrual products, such as fragrances. ",
         "When should I talk to a doctor?" : "You should talk to a doctor if you experience a change in vaginal odor, extreme pain, or more severe period symptoms than usual. ",
         "when should I talk to a doctor?" : "You should talk to a doctor if you experience a change in vaginal odor, extreme pain, or more severe period symptoms than usual. ",
         "when should I talk to a doctor" : "You should talk to a doctor if you experience a change in vaginal odor, extreme pain, or more severe period symptoms than usual. ",
         "when should I talk to a doctor" : "You should talk to a doctor if you experience a change in vaginal odor, extreme pain, or more severe period symptoms than usual. ",
         "When will I get my first period?" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
         "When will I get my first period" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
         "when will I get my first period?" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
         "when will I get my first period" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
         "when will i get my first period?" : "You’ll start having periods when your body is ready. Many girls have their first period about 2 to 3 years after they begin puberty. Girls get their periods at different ages. Try not to compare yourself to your friends. You will each get your period when it is right for your body.",
         "How long is each cycle?" : "Don’t worry if your period sometimes skips months for the first few years. You might even have a period twice in one month. That’s OK. By the time you’re an adult, it is normal for a cycle (the time from the first day of one period to the first day of your next period) to take 21 to 34 days. That’s why you hear women talk about a “monthly cycle.”",
         "how long is each cycle?" : "Don’t worry if your period sometimes skips months for the first few years. You might even have a period twice in one month. That’s OK. By the time you’re an adult, it is normal for a cycle (the time from the first day of one period to the first day of your next period) to take 21 to 34 days. That’s why you hear women talk about a “monthly cycle.”",
         "How long is each cycle" : "Don’t worry if your period sometimes skips months for the first few years. You might even have a period twice in one month. That’s OK. By the time you’re an adult, it is normal for a cycle (the time from the first day of one period to the first day of your next period) to take 21 to 34 days. That’s why you hear women talk about a “monthly cycle.”",
         "how long is each cycle" : "Don’t worry if your period sometimes skips months for the first few years. You might even have a period twice in one month. That’s OK. By the time you’re an adult, it is normal for a cycle (the time from the first day of one period to the first day of your next period) to take 21 to 34 days. That’s why you hear women talk about a “monthly cycle.”",
         "How long does each period last?" : "Each girl is different, but it’s normal for a period to last 2 to 7 days. Talk to your parents or healthcare provider if your period lasts longer than 8 days for 2 cycles in a row.",
         "how long does each period last?" : "Each girl is different, but it’s normal for a period to last 2 to 7 days. Talk to your parents or healthcare provider if your period lasts longer than 8 days for 2 cycles in a row.",
         "How long does each period last" : "Each girl is different, but it’s normal for a period to last 2 to 7 days. Talk to your parents or healthcare provider if your period lasts longer than 8 days for 2 cycles in a row.",
         "how long does each period last" : "Each girl is different, but it’s normal for a period to last 2 to 7 days. Talk to your parents or healthcare provider if your period lasts longer than 8 days for 2 cycles in a row.",
         "What does a period look like?" : "The lining of the uterus is rich with blood. So the color of your menstrual flow can be pink, red, or brown. The flow can be thick, lumpy, or runny.",
         "what does a period look like" : "The lining of the uterus is rich with blood. So the color of your menstrual flow can be pink, red, or brown. The flow can be thick, lumpy, or runny.",
         "What does a period look like" : "The lining of the uterus is rich with blood. So the color of your menstrual flow can be pink, red, or brown. The flow can be thick, lumpy, or runny.",
         "what does a period look like?" : "The lining of the uterus is rich with blood. So the color of your menstrual flow can be pink, red, or brown. The flow can be thick, lumpy, or runny.",
         "How much will I bleed?" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
         "How much will I bleed" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
         "how much will I bleed?" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
         "how much will I bleed" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
         "how much will i bleed?" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
         "how much will i bleed" : "For most girls, the amount of flow for an entire period is only 4 teaspoons to 6 teaspoons, although for some girls it may feel like more. Expect the flow to be light on some days and heavier on others.",
         "Can I bleed too much?" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
         "can I bleed too much?" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
         "Can I bleed too much" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
         "Can i bleed too much?" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
         "can i bleed too much?" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
         "can i bleed too much" : "During your period, bleeding can look like more than it is. Don’t let this frighten you. But if you ever soak a new pad in 1 hour or less, let your parents know.",
         "how do I practice healthy menstrual hygiene?": 
         "• Wash your hands before and after using the restroom and before and after using a menstrual product.<br>" +
         "• Change sanitary pads every few hours, or more frequently if your period is heavy.<br>" +
         "• Change tampons every 4 to 8 hours, and use the lowest-absorbency tampon needed.<br>" +
         "• Rinse your genital area at least twice a day with warm water without soap.",
         "How do I practice healthy menstrual hygiene?": 
         "• Wash your hands before and after using the restroom and before and after using a menstrual product.<br>" +
         "• Change sanitary pads every few hours, or more frequently if your period is heavy.<br>" +
         "• Change tampons every 4 to 8 hours, and use the lowest-absorbency tampon needed.<br>" +
         "• Rinse your genital area at least twice a day with warm water without soap.",
         "how do i practice healthy menstrual hygiene?": 
         "• Wash your hands before and after using the restroom and before and after using a menstrual product.<br>" +
         "• Change sanitary pads every few hours, or more frequently if your period is heavy.<br>" +
         "• Change tampons every 4 to 8 hours, and use the lowest-absorbency tampon needed.<br>" +
         "• Rinse your genital area at least twice a day with warm water without soap.",
         "how do i practice healthy menstrual hygiene": 
         "• Wash your hands before and after using the restroom and before and after using a menstrual product.<br>" +
         "• Change sanitary pads every few hours, or more frequently if your period is heavy.<br>" +
         "• Change tampons every 4 to 8 hours, and use the lowest-absorbency tampon needed.<br>" +
         "• Rinse your genital area at least twice a day with warm water without soap.",
         "What is menstrual" : "Menstruation, or period, is normal vaginal bleeding that occurs as part of a woman's monthly cycle. Every month, your body prepares for pregnancy. If no pregnancy occurs, the uterus, or womb, sheds its lining. The menstrual blood is partly blood and partly tissue from inside the uterus.",
         "what is menstrual?" : "Menstruation, or period, is normal vaginal bleeding that occurs as part of a woman's monthly cycle. Every month, your body prepares for pregnancy. If no pregnancy occurs, the uterus, or womb, sheds its lining. The menstrual blood is partly blood and partly tissue from inside the uterus.",
         "What is menstrual" : "Menstruation, or period, is normal vaginal bleeding that occurs as part of a woman's monthly cycle. Every month, your body prepares for pregnancy. If no pregnancy occurs, the uterus, or womb, sheds its lining. The menstrual blood is partly blood and partly tissue from inside the uterus.",
         "What is a normal menstrual cycle?" : "A normal menstrual cycle ranges from 21 to 35 days.",
         "What is a normal menstrual cycle" : "A normal menstrual cycle ranges from 21 to 35 days.",
         "what is a normal menstrual cycle?" : "A normal menstrual cycle ranges from 21 to 35 days.",
         "what is a normal menstrual cycle" : "A normal menstrual cycle ranges from 21 to 35 days.",
         "What causes irregular periods?" : "Irregular periods can be caused by stress, hormonal imbalances, or health conditions.",
         "What causes irregular periods" : "Irregular periods can be caused by stress, hormonal imbalances, or health conditions.",
         "what causes irregular periods?" : "Irregular periods can be caused by stress, hormonal imbalances, or health conditions.",
         "what causes irregular periods" : "Irregular periods can be caused by stress, hormonal imbalances, or health conditions.",
         "How can I manage period pain?" : "Period pain can be managed with over-the-counter pain relievers and heat therapy",
         "How can I manage period pain" : "Period pain can be managed with over-the-counter pain relievers and heat therapy",
         "how can I manage period pain?" : "Period pain can be managed with over-the-counter pain relievers and heat therapy",
         "how can I manage period pain?" : "Period pain can be managed with over-the-counter pain relievers and heat therapy",
         "Can stress affect my menstrual cycle?" : "Yes, stress can interfere with hormonal balance, causing missed or delayed periods.",
         "Can stress affect my menstrual cycle" : "Yes, stress can interfere with hormonal balance, causing missed or delayed periods.",
         "can stress affect my menstrual cycle?" : "Yes, stress can interfere with hormonal balance, causing missed or delayed periods.",
         "can stress affect my menstrual cycle" : "Yes, stress can interfere with hormonal balance, causing missed or delayed periods.",
         "When to tell that I am pregnant?" : "Pregnancy is typically confirmed through several signs and medical tests. Here are some key indicators of pregnancy: •Missed Period One of the earliest and most common signs of pregnancy is a missed menstrual period. If your period is late, especially if your cycles are usually regular, it may be a sign of pregnancy. •Home Pregnancy Test Home pregnancy tests can detect pregnancy as early as the first day of a missed period by measuring the level of human chorionic gonadotropin (hCG), a hormone produced after a fertilized egg attaches to the uterus. For best results, take the test a few days after your missed period. •Early Pregnancy Symptoms Fatigue: Feeling more tired than usual. Nausea/Morning Sickness: This can start around 4-6 weeks into pregnancy. Breast Changes: Tenderness or swelling of the breasts is common. Frequent Urination: Pregnancy hormones can make you feel like you need to pee more often. Mood Swings: Hormonal changes can lead to emotional fluctuations.",
         "Why is menstrual tracking important?" : "Menstrual tracking is important because it helps individuals monitor their reproductive health, understand their cycles, identify patterns and irregularities, manage symptoms, and enhance fertility awareness, ultimately promoting informed health decisions.",
         "why is menstrual tracking important?" : "Menstrual tracking is important because it helps individuals monitor their reproductive health, understand their cycles, identify patterns and irregularities, manage symptoms, and enhance fertility awareness, ultimately promoting informed health decisions.",
         "Why is menstrual tracking important" : "Menstrual tracking is important because it helps individuals monitor their reproductive health, understand their cycles, identify patterns and irregularities, manage symptoms, and enhance fertility awareness, ultimately promoting informed health decisions.",
         "why is menstrual tracking important?" : "Menstrual tracking is important because it helps individuals monitor their reproductive health, understand their cycles, identify patterns and irregularities, manage symptoms, and enhance fertility awareness, ultimately promoting informed health decisions.",
         "why is menstrual tracking important" : "Menstrual tracking is important because it helps individuals monitor their reproductive health, understand their cycles, identify patterns and irregularities, manage symptoms, and enhance fertility awareness, ultimately promoting informed health decisions.",
         "How can I track my cycle if I have irregular cycles?" : "To track your cycle with irregular periods, record the start and end dates of each cycle, note any symptoms, and use a calendar or app to identify patterns over time, even if those patterns are inconsistent.",
         "how can I track my cycle if I have irregular cycles?" : "To track your cycle with irregular periods, record the start and end dates of each cycle, note any symptoms, and use a calendar or app to identify patterns over time, even if those patterns are inconsistent.",
         "How can I track my cycle if I have irregular cycles" : "To track your cycle with irregular periods, record the start and end dates of each cycle, note any symptoms, and use a calendar or app to identify patterns over time, even if those patterns are inconsistent.",
         "how can I track my cycle if i have irregular cycles?" : "To track your cycle with irregular periods, record the start and end dates of each cycle, note any symptoms, and use a calendar or app to identify patterns over time, even if those patterns are inconsistent.",
         "how can I track my cycle if I have irregular cycles" : "To track your cycle with irregular periods, record the start and end dates of each cycle, note any symptoms, and use a calendar or app to identify patterns over time, even if those patterns are inconsistent.",
         "how can I track my cycle if i have irregular cycles" : "To track your cycle with irregular periods, record the start and end dates of each cycle, note any symptoms, and use a calendar or app to identify patterns over time, even if those patterns are inconsistent.",
         "how can i track my cycle if i have irregular cycles" : "To track your cycle with irregular periods, record the start and end dates of each cycle, note any symptoms, and use a calendar or app to identify patterns over time, even if those patterns are inconsistent.",
         "What are common menstrual disorders? " : "Common menstrual disorders include dysmenorrhea (painful periods), amenorrhea (absence of menstruation), menorrhagia (heavy bleeding), oligomenorrhea (infrequent periods), and premenstrual syndrome (PMS) each affecting individuals in different ways.",
         "what are common menstrual disorders? " : "Common menstrual disorders include dysmenorrhea (painful periods), amenorrhea (absence of menstruation), menorrhagia (heavy bleeding), oligomenorrhea (infrequent periods), and premenstrual syndrome (PMS) each affecting individuals in different ways.",
         "What are common menstrual disorders" : "Common menstrual disorders include dysmenorrhea (painful periods), amenorrhea (absence of menstruation), menorrhagia (heavy bleeding), oligomenorrhea (infrequent periods), and premenstrual syndrome (PMS) each affecting individuals in different ways.",
         "what are common menstrual disorders" : "Common menstrual disorders include dysmenorrhea (painful periods), amenorrhea (absence of menstruation), menorrhagia (heavy bleeding), oligomenorrhea (infrequent periods), and premenstrual syndrome (PMS) each affecting individuals in different ways.",
         "how are you?" : "I’m doing well, thank you! How about you? How's your Laravel project coming along?"
         };

    //      const lowerCaseMessage = message.toLowerCase();

    //      // Function to calculate the relevance score of a key to the message
    //      function calculateRelevance(key, message) {
    //          const keyWords = key.toLowerCase().split(' ');
    //          let score = 0;
     
    //          // Check if the message contains the keyword
    //          for (let keyWord of keyWords) {
    //              if (message.includes(keyWord)) {
    //                  score += 1; // Increment score for each keyword found
    //              }
    //          }
     
    //          // Bonus for exact match
    //          if (message === key.toLowerCase()) {
    //              score += 10;
    //          }
     
    //          // Bonus for matching word order
    //          let orderScore = 0;
    //          const messageWords = message.split(' ');
    //          for (let i = 0; i <= messageWords.length - keyWords.length; i++) {
    //              if (messageWords.slice(i, i + keyWords.length).join(' ') === key.toLowerCase()) {
    //                  orderScore = 5; // Increment order score for correct sequence
    //                  break;
    //              }
    //          }
     
    //          return score + orderScore;
    //      }
     
    //      // Find the best matching response
    //      let bestMatch = '';
    //      let bestScore = 0;
     
    //      for (const key in responses) {
    //          const score = calculateRelevance(key, lowerCaseMessage);
    //          console.log(`Checking key: "${key}" with score: ${score}`); // Debugging line
    //          if (score > bestScore) {
    //              bestMatch = key;
    //              bestScore = score;
    //          }
    //      }
     
    //      // Only respond if there's a relevant match and the best score is greater than a threshold
    //      if (bestScore > 1) { // Adjust this threshold as needed
    //          console.log("Responding with:", responses[bestMatch]); // Debugging line
    //          return responses[bestMatch];
    //      }
     
    //      console.log("Responding with default message"); // Debugging line
    //      return "I'm not quite sure about that. Could you please ask something related to menstrual health or rephrase your question?";
    //  }
     
    //  // Example usage
    //  const userMessage1 = "What causes a delayed period?"; // Test with a relevant question
    //  const reply1 = getAIResponse(userMessage1);
    //  console.log("Final response:", reply1);
     
    //  const userMessage2 = "Tell me about the weather."; // Test with an unrelated question
    //  const reply2 = getAIResponse(userMessage2);
    //  console.log("Final response:", reply2);