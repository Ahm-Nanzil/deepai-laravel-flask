<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MlApiController extends Controller
{
    public function showForm()
    {
        return view('predict');
    }

    public function predict(Request $request)
    {
        // Validate the input
        $request->validate([
            'features' => 'required|string',
        ]);

        // Convert comma-separated string to an array
        $features = array_map('floatval', explode(',', $request->input('features')));

        // Flask API endpoint
        $flaskApiUrl = 'http://127.0.0.1:5000/predict';

        // Create a Guzzle client
        $client = new Client();

        try {
            // Send a POST request to the Flask API
            $response = $client->post($flaskApiUrl, [
                'json' => [
                    'features' => $features,
                ],
            ]);

            // Decode the JSON response
            $result = json_decode($response->getBody(), true);

            // Return the prediction to the view
            return view('predict', [
                'features' => $request->input('features'),
                'prediction' => $result['prediction'][0],
            ]);
        } catch (\Exception $e) {
            // Handle errors and return an error message to the view
            return view('predict', [
                'features' => $request->input('features'),
                'error' => 'Failed to connect to the ML API: ' . $e->getMessage(),
            ]);
        }
    }
}
