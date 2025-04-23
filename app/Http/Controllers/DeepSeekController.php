<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DeepSeekController extends Controller
{
    public function sendMessage(Request $request)
    {
        $apiKey = env('OPENROUTER_API_KEY');  // Store in .env
        $userMessage = $request->message;

        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'deepseek/deepseek-r1-zero:free',
            'messages' => [
                ['role' => 'user', 'content' => $userMessage]
            ]
        ]);

        return response()->json(['response' => $response->json()['choices'][0]['message']['content'] ?? 'Error']);
    }
}
