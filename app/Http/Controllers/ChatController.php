<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function getAIResponse(Request $request)
    {
        // Input from user chat request
        $userInput = $request->input('message');

        try {
            // Make the OpenAI API call with gpt-3.5-turbo model
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $userInput],
                ],
            ]);

            // Get the response from OpenAI
            $aiResponse = $response['choices'][0]['message']['content'];

            // Return the response to the frontend
            return response()->json(['response' => $aiResponse]);

        } catch (\Exception $e) {
            // Log the error and send a friendly error message to the frontend
            \Log::error("OpenAI API error: " . $e->getMessage());
            return response()->json(['error' => 'OpenAI request failed. Please try again later.']);
        }
    }
}
