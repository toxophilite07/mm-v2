<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function handleChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant specialized in menstrual health.'],
                    ['role' => 'user', 'content' => $request->message]
                ],
            ]);

            $reply = $response->choices[0]->message->content;
            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            Log::error('Error in ChatController', ['error' => $e->getMessage()]);
            
            // Check if the error is due to exceeding quota
            if (strpos($e->getMessage(), 'exceeded your current quota') !== false) {
                return response()->json([
                    'reply' => "I'm sorry, but I'm temporarily unavailable due to high demand. Please try again later or contact support if this persists."
                ], 503);
            }

            return response()->json([
                'reply' => "I'm sorry, but I couldn't process your request at this time. Please try again later."
            ], 500);
        }
    }
}