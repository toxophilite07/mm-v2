<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function handleChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);
    
        $client = new Client();
        $apiKey = env('OPENAI_API_KEY'); // Ensure this is set
    
        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo', // Specify your model
                    'messages' => [['role' => 'user', 'content' => $request->message]],
                ],
            ]);
    
            $responseBody = json_decode($response->getBody(), true);
            
            // Log the response for debugging
            \Log::info('OpenAI Response:', $responseBody);
            \Log::info('Chat message received:', ['message' => $message]);

            $botMessage = $responseBody['choices'][0]['message']['content'];
    
            return response()->json(['response' => $botMessage]);
        } catch (\Exception $e) {
            \Log::error('API Request Error: ' . $e->getMessage()); // Log the error message
            return response()->json(['error' => 'Failed to fetch a response.'], 500);
        }
    }
    
}

