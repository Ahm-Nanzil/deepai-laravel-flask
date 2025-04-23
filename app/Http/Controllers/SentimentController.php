<?php

/// app/Http/Controllers/SentimentController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SentimentController extends Controller
{
    // Display the form
    public function showForm()
    {
        return view('sentiment-form');
    }

    // Handle form submission
    public function analyze(Request $request)
    {
        // Validate the input
        $request->validate([
            'text' => 'required|string',
        ]);

        // Get the input text from the request
        $text = $request->input('text');

        // Path to the Python script
        $scriptPath = base_path('python/sentiment_analysis.py');

        // Use shell_exec() to run the Python script
        // Pass the input text as a command-line argument
        $result = shell_exec("python $scriptPath \"$text\"");

        // Check if the Python script executed successfully
        if ($result === null) {
            $error = "Failed to execute Python script. Please check the script path and permissions.";
            return view('sentiment-form', ['error' => $error, 'text' => $text]);
        }

        // Return the result to the view
        return view('sentiment-form', [
            'text' => $text,
            'sentiment' => trim($result), // Trim any extra whitespace
        ]);
    }
}
