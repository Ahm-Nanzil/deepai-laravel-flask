<!DOCTYPE html>
<html>
<head>
    <title>Sentiment Analysis Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 16px;
        }
        button {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .result, .error {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .result {
            background-color: #e0f7fa;
            border: 1px solid #00bcd4;
        }
        .error {
            background-color: #ffebee;
            border: 1px solid #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sentiment Analysis</h1>
        <form method="POST" action="{{ route('analyze-sentiment') }}">
            @csrf
            <textarea name="text" placeholder="Enter text to analyze...">{{ old('text', $text ?? '') }}</textarea><br>
            <button type="submit">Analyze Sentiment</button>
        </form>

        @if (isset($sentiment))
            <div class="result">
                <h2>Result:</h2>
                <p><strong>Text:</strong> {{ $text }}</p>
                <p><strong>Sentiment:</strong> {{ $sentiment }}</p>
            </div>
        @endif

        @if (isset($error))
            <div class="error">
                <h2>Error:</h2>
                <p>{{ $error }}</p>
            </div>
        @endif
    </div>
</body>
</html>
