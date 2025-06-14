<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MLController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// use App\Http\Controllers\SentimentController;

// Route::post('/analyze-sentiment', [SentimentController::class, 'analyze']);
// // routes/web.php
// Route::get('/sentiment', function () {
//     return view('sentiment');
// });
// routes/web.php
use App\Http\Controllers\SentimentController;

// Display the form
Route::get('/sentiment', [SentimentController::class, 'showForm'])->name('sentiment-form');

// Handle form submission
Route::post('/analyze-sentiment', [SentimentController::class, 'analyze'])->name('analyze-sentiment');
// Route::post('/predict', [MlApiController::class, 'predict']);
// Route::get('/predict-form', function () {
//     return view('predict');
// });
// routes/web.php
use App\Http\Controllers\MlApiController;

// Display the form
Route::get('/predict-form', [MlApiController::class, 'showForm'])->name('predict-form');

// Handle form submission
Route::post('/predict', [MlApiController::class, 'predict'])->name('predict');

// use App\Http\Controllers\ChatGPTController;

// // Show the chat dashboard
// Route::get('/chat', [ChatGPTController::class, 'showChat'])->name('chat');

// // Handle chat requests
// Route::post('/chat', [ChatGPTController::class, 'chat']);

use App\Http\Controllers\DeepSeekController;

// Show the chat dashboard
// Route::get('/deepseek-chat', [DeepSeekController::class, 'showChat'])->name('deepseek-chat');

// // Handle chat requests
// Route::post('/deepseek-chat', [DeepSeekController::class, 'chat']);


Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::post('/chat/send', [DeepSeekController::class, 'sendMessage'])->name('chat.send');


use App\Http\Controllers\HuggingFaceController;

// // Show the chat dashboard
// Route::get('/huggingface-chat', [HuggingFaceController::class, 'showChat'])->name('huggingface-chat');

// // Handle chat requests
// Route::post('/huggingface-chat', [HuggingFaceController::class, 'chat']);
