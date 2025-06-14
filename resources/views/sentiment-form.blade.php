<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Sentiment Analysis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 120px; height: 120px; left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 60px; height: 60px; left: 60%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 100px; height: 100px; left: 80%; animation-delay: 1s; }
        .particle:nth-child(5) { width: 40px; height: 40px; left: 70%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-100px) rotate(180deg); opacity: 0.3; }
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            animation: slideDown 0.8s ease-out;
        }

        .header h1 {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff, #f0f8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(255, 255, 255, 0.3);
        }

        .header p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.8s ease-out 0.2s both;
            transition: all 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        }

        .input-group {
            margin-bottom: 2rem;
        }

        .input-label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            margin-bottom: 0.8rem;
            font-size: 1.1rem;
        }

        textarea {
            width: 100%;
            height: 180px;
            padding: 1.5rem;
            font-size: 1.1rem;
            font-family: inherit;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            color: white;
            resize: vertical;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        textarea:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .analyze-btn {
            width: 100%;
            padding: 1.2rem 2rem;
            font-size: 1.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .analyze-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .analyze-btn:hover:before {
            left: 100%;
        }

        .analyze-btn:hover {
            background: linear-gradient(135deg, #ff5252, #d63031);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(238, 90, 36, 0.4);
        }

        .analyze-btn:active {
            transform: translateY(-1px);
        }

        .result-card, .error-card {
            margin-top: 2rem;
            padding: 2rem;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.6s ease-out;
        }

        .result-card {
            background: linear-gradient(135deg, rgba(46, 213, 115, 0.2), rgba(0, 206, 201, 0.2));
            border-left: 5px solid #2ed573;
        }

        .error-card {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.2), rgba(238, 90, 36, 0.2));
            border-left: 5px solid #ff6b6b;
        }

        .result-header, .error-header {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .result-content p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .sentiment-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: pulse 2s infinite;
        }

        .sentiment-positive {
            background: linear-gradient(135deg, #2ed573, #1dd1a1);
            color: white;
        }

        .sentiment-negative {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
        }

        .sentiment-neutral {
            background: linear-gradient(135deg, #ffa502, #ff6348);
            color: white;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header h1 {
                font-size: 2.5rem;
            }

            .form-card {
                padding: 2rem;
            }

            textarea {
                height: 120px;
            }
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="bg-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="container">
        <div class="header">
            <h1>✨ AI Sentiment Analysis</h1>
            <p>Discover the emotional tone behind your text with advanced AI</p>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('analyze-sentiment') }}">
                @csrf
                <div class="input-group">
                    <label class="input-label">📝 Enter your text below</label>
                    <textarea
                        name="text"
                        placeholder="Type or paste your text here... I'll analyze its emotional sentiment using advanced AI algorithms."
                        required>{{ old('text', $text ?? '') }}</textarea>
                </div>
                <button type="submit" class="analyze-btn">
                    🧠 Analyze Sentiment
                </button>
            </form>
        </div>

        @if (isset($sentiment))
            <div class="result-card">
                <div class="result-header">
                    🎯 Analysis Complete
                </div>
                <div class="result-content">
                    <p><strong>📄 Text Analyzed:</strong></p>
                    <p style="font-style: italic; background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        "{{ $text }}"
                    </p>
                    <p><strong>🎭 Detected Sentiment:</strong></p>
                    <span class="sentiment-badge sentiment-{{ strtolower($sentiment) }}">
                        {{ $sentiment }}
                    </span>
                </div>
            </div>
        @endif

        @if (isset($error))
            <div class="error-card">
                <div class="error-header">
                    ⚠️ Analysis Error
                </div>
                <div class="result-content">
                    <p>{{ $error }}</p>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.querySelector('textarea');
            const button = document.querySelector('.analyze-btn');

            // Add character counter
            const charCounter = document.createElement('div');
            charCounter.style.cssText = `
                text-align: right;
                margin-top: 0.5rem;
                color: rgba(255, 255, 255, 0.6);
                font-size: 0.9rem;
            `;
            textarea.parentNode.appendChild(charCounter);

            function updateCounter() {
                const count = textarea.value.length;
                charCounter.textContent = `${count} characters`;

                if (count > 500) {
                    charCounter.style.color = '#ff6b6b';
                } else if (count > 300) {
                    charCounter.style.color = '#ffa502';
                } else {
                    charCounter.style.color = 'rgba(255, 255, 255, 0.6)';
                }
            }

            textarea.addEventListener('input', updateCounter);
            updateCounter();

            // Button loading state
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                button.innerHTML = '🔄 Analyzing...';
                button.disabled = true;
                button.style.opacity = '0.7';
            });
        });
    </script>
</body>
</html>
