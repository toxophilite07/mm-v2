<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI; // Ensure this is the correct import for your OpenAI library
use Log;

class ChatController extends Controller
{
    public function getAIResponse(Request $request)
    {
        // Validate input
        $request->validate([
            'message' => 'required|string|max:1000', // Adjust max length as necessary
        ]);

        $userInput = $request->input('message');

        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $userInput],
                ],
            ]);

            // Check if response structure is as expected
            if (isset($response['choices'][0]['message']['content'])) {
                $aiResponse = $response['choices'][0]['message']['content'];
                return response()->json(['response' => $aiResponse]);
            } else {
                throw new \Exception("Unexpected response structure: " . json_encode($response));
            }

        } catch (\Exception $e) {
            // Log detailed error message
            Log::error("OpenAI API error: " . $e->getMessage());
            Log::error("Full Exception: " . json_encode($e));
            return response()->json(['error' => 'OpenAI request failed. Please try again later.']);
        }
    }
}
