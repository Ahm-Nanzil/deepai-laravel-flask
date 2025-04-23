<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HuggingFaceController extends Controller
{
    public function chat(Request $request)
    {
        // Validate the input
        $request->validate([
            'message' => 'required|string',
        ]);

        // Hugging Face API endpoint
        $apiUrl = 'https://api-inference.huggingface.co/models/google-bert/bert-base-uncased'; // Example model

        // Create a Guzzle client
        $client = new Client();

        try {
            // Send a POST request to the Hugging Face API
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('HUGGING_FACE_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'inputs' => $request->input('message'),
                ],
            ]);

            // Decode the JSON response
            $result = json_decode($response->getBody(), true);

            // Return the response
            return response()->json([
                'response' => $result[0]['generated_text'],
            ]);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'error' => 'Failed to connect to Hugging Face: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function showChat()
    {
        return view('huggingface-chat');
    }
}
