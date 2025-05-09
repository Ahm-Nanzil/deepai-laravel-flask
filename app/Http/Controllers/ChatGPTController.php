<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatGPTController extends Controller
{
    public function chat(Request $request)
    {
        // Validate the input
        $request->validate([
            'message' => 'required|string',
        ]);

        // OpenAI API endpoint
        $apiUrl = 'https://api.openai.com/v1/chat/completions';

        // Create a Guzzle client
        $client = new Client();

        try {
            // Send a POST request to the OpenAI API
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo', // Use the ChatGPT model
                    'messages' => [
                        ['role' => 'user', 'content' => $request->input('message')],
                    ],
                ],
            ]);

            // Decode the JSON response
            $result = json_decode($response->getBody(), true);

            // Return the ChatGPT response
            return response()->json([
                'response' => $result['choices'][0]['message']['content'],
            ]);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'error' => 'Failed to connect to ChatGPT: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function showChat()
    {
        return view('chat');
    }
}




