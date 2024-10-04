public function getAIResponse(Request $request)
{
    $userInput = $request->input('message');

    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $userInput],
            ],
        ]);

        $aiResponse = $response['choices'][0]['message']['content'];
        return response()->json(['response' => $aiResponse]);

    } catch (\Exception $e) {
        \Log::error("OpenAI API error: " . $e->getMessage());
        \Log::error("Full Exception: " . json_encode($e));
        return response()->json(['error' => 'OpenAI request failed. Please try again later.']);
    }
}
