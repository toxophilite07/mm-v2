<?php

namespace App\Http\Controllers;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Http\Request;
use OpenAI\Client;

class ChatController extends Controller
{
    protected $openai;

    public function __construct(Client $openai)
    {
        $this->openai = $openai;
    }

    public function getAIResponse(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'message' => 'required|string',
        ]);
    
        $message = strtolower($request->message);
    
        // Define FAQ responses
        $faqAnswers = [
            'what is menstruation' => 'Menstruation is the monthly shedding of the uterine lining when pregnancy does not occur. It typically lasts between 3-7 days and happens every 21-35 days for most women.',
            'what is a normal menstrual cycle' => 'A normal menstrual cycle ranges from 21 to 35 days. Day 1 is the first day of your period, and the cycle ends the day before your next period starts.',
            'what causes irregular periods' => 'Irregular periods can be caused by stress, hormonal imbalances, extreme weight loss or gain, excessive exercise, or underlying health conditions like polycystic ovary syndrome (PCOS).',
            'is it normal to experience cramps during menstruation' => 'Yes, menstrual cramps (dysmenorrhea) are common and usually occur in the lower abdomen. However, severe pain that interferes with daily life might indicate a medical condition like endometriosis.',
            'what is premenstrual syndrome' => 'PMS refers to a variety of symptoms such as mood swings, bloating, headaches, and breast tenderness that occur in the days leading up to menstruation.',
            'what should i do if my period is late' => 'A delayed period can be caused by stress, hormonal changes, illness, or pregnancy. If your period is late by more than a week and pregnancy is possible, consider taking a pregnancy test or consulting a healthcare professional.',
            'how can i manage period pain' => 'Period pain can be managed through over-the-counter pain relievers like ibuprofen, heat therapy, gentle exercise, or relaxation techniques.',
            'what is the difference between a regular and irregular menstrual cycle' => 'A regular menstrual cycle occurs at roughly the same time every month (21-35 days). An irregular cycle can vary greatly in length and may skip months.',
            'can stress affect my menstrual cycle' => 'Yes, stress can interfere with the hormonal balance, causing missed or delayed periods.',
            'what are the common signs of pregnancy during menstruation' => 'If you\'re pregnant, you won\'t have a regular period, but you may experience light spotting or implantation bleeding. Other early pregnancy signs include nausea, fatigue, and tender breasts.',
            'when should i see a doctor about my period' => 'Consult a doctor if your periods stop for more than 3 months, you have severe pain or bleeding, your cycle suddenly becomes irregular, or you suspect conditions like PCOS or endometriosis.',
            'what is an irregular period cycle' => 'An irregular period cycle is when the timing, flow, or duration of menstruation varies significantly from one cycle to another. Periods may be too frequent, infrequent, or completely absent.',
            'can i get pregnant during my period' => 'While it\'s less likely, it is possible to get pregnant during your period, especially if you have a shorter menstrual cycle or ovulate early.',
            'how does diet affect menstruation' => 'A balanced diet with essential nutrients helps regulate your menstrual cycle. Poor nutrition or extreme dieting can disrupt hormonal balance, leading to irregular periods.',
            'what is an ovulation cycle and how is it related to menstruation' => 'Ovulation is when an ovary releases an egg, usually around the middle of your cycle. If the egg is not fertilized, the uterine lining sheds, leading to menstruation.'
        ];
    
        // Check if the message contains an FAQ question
        foreach ($faqAnswers as $question => $answer) {
            if (stripos($message, $question) !== false) {
                return response()->json([
                    'response' => $answer,
                ]);
            }
        }
    
        // Call OpenAI API if message does not match any FAQ
        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $message],
            ],
        ]);
    
        // Log received message and OpenAI API response
        Log::info('Received message: ' . $message);
        if ($result && isset($result->choices[0])) {
            Log::info('OpenAI API response: ', ['response' => $result->choices[0]->message->content]);
        } else {
            Log::error('OpenAI API response error: ', ['response' => $result]);
        }
    
        // Return the AI response as JSON
        return response()->json([
            'response' => $result->choices[0]->message->content,
        ]);
    }
    
    
}
