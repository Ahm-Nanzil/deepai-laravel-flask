<!DOCTYPE html>
<html>
<head>
    <title>ML API Integration</title>
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
        <h1>ML API Integration</h1>
        <form method="POST" action="/predict">
            @csrf
            <label for="features">Enter features (comma-separated):</label><br>
            <input type="text" name="features" id="features" placeholder="5.1, 3.5, 1.4, 0.2" value="{{ old('features', $features ?? '') }}"><br><br>
            <button type="submit">Predict</button>
        </form>

        @if (isset($prediction))
            <div class="result">
                <h2>Result:</h2>
                <p><strong>Features:</strong> {{ $features }}</p>
                <p><strong>Prediction:</strong> {{ $prediction }}</p>
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
