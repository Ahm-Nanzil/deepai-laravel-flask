<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML API Integration</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Roboto+Mono:wght@300;400;500&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto Mono', monospace;
            background: #0a0a0a;
            color: #00ff88;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated grid background */
        .grid-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(0, 255, 136, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 136, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            z-index: 1;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Circuit pattern overlay */
        .circuit-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 20%, rgba(0, 255, 255, 0.1) 1px, transparent 2px),
                radial-gradient(circle at 80% 80%, rgba(255, 0, 255, 0.1) 1px, transparent 2px),
                radial-gradient(circle at 40% 70%, rgba(255, 255, 0, 0.1) 1px, transparent 2px);
            z-index: 1;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            animation: glitchIn 1s ease-out;
        }

        .header h1 {
            font-family: 'Orbitron', monospace;
            font-size: 3.5rem;
            font-weight: 900;
            color: #00ff88;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 1rem;
            position: relative;
            text-shadow:
                0 0 10px #00ff88,
                0 0 20px #00ff88,
                0 0 30px #00ff88;
        }

        .header h1::before {
            content: 'ML API INTEGRATION';
            position: absolute;
            top: 0;
            left: 0;
            color: #ff0080;
            z-index: -1;
            animation: glitch 2s infinite;
        }

        .header .subtitle {
            font-size: 1.1rem;
            color: #00ffff;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.8;
        }

        .main-panel {
            background: linear-gradient(145deg, #1a1a1a, #0d0d0d);
            border: 2px solid #00ff88;
            border-radius: 0;
            padding: 3rem;
            position: relative;
            box-shadow:
                0 0 50px rgba(0, 255, 136, 0.3),
                inset 0 0 50px rgba(0, 255, 136, 0.1);
            animation: slideInLeft 0.8s ease-out 0.3s both;
        }

        .main-panel::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #00ff88, #00ffff, #ff0080, #00ff88);
            border-radius: 0;
            z-index: -1;
            animation: borderGlow 3s linear infinite;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-title {
            font-family: 'Orbitron', monospace;
            font-size: 1.3rem;
            color: #00ffff;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-left: 4px solid #00ff88;
            padding-left: 1rem;
        }

        .input-group {
            margin-bottom: 2rem;
        }

        .input-label {
            display: block;
            color: #00ff88;
            font-weight: 500;
            margin-bottom: 0.8rem;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .feature-input {
            width: 100%;
            padding: 1.2rem;
            font-size: 1.1rem;
            font-family: 'Roboto Mono', monospace;
            background: #000;
            border: 2px solid #333;
            color: #00ff88;
            transition: all 0.3s ease;
            outline: none;
        }

        .feature-input:focus {
            border-color: #00ff88;
            box-shadow:
                0 0 20px rgba(0, 255, 136, 0.5),
                inset 0 0 20px rgba(0, 255, 136, 0.1);
            background: #111;
        }

        .feature-input::placeholder {
            color: #666;
            font-style: italic;
        }

        .predict-btn {
            width: 100%;
            padding: 1.5rem;
            font-size: 1.2rem;
            font-family: 'Orbitron', monospace;
            font-weight: 700;
            background: linear-gradient(45deg, #000, #1a1a1a);
            color: #00ff88;
            border: 2px solid #00ff88;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .predict-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.3), transparent);
            transition: left 0.5s;
        }

        .predict-btn:hover::before {
            left: 100%;
        }

        .predict-btn:hover {
            background: linear-gradient(45deg, #00ff88, #00ffff);
            color: #000;
            box-shadow:
                0 0 30px rgba(0, 255, 136, 0.7),
                inset 0 0 30px rgba(0, 255, 136, 0.2);
            transform: translateY(-2px);
        }

        .result-panel, .error-panel {
            margin-top: 2rem;
            padding: 2rem;
            border: 2px solid;
            position: relative;
            animation: slideInRight 0.6s ease-out;
        }

        .result-panel {
            background: linear-gradient(145deg, rgba(0, 255, 136, 0.1), rgba(0, 255, 255, 0.05));
            border-color: #00ff88;
            box-shadow: 0 0 30px rgba(0, 255, 136, 0.3);
        }

        .error-panel {
            background: linear-gradient(145deg, rgba(255, 0, 128, 0.1), rgba(255, 0, 0, 0.05));
            border-color: #ff0080;
            box-shadow: 0 0 30px rgba(255, 0, 128, 0.3);
        }

        .panel-header {
            font-family: 'Orbitron', monospace;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .result-panel .panel-header {
            color: #00ff88;
        }

        .error-panel .panel-header {
            color: #ff0080;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .result-panel .status-indicator {
            background: #00ff88;
            box-shadow: 0 0 10px #00ff88;
        }

        .error-panel .status-indicator {
            background: #ff0080;
            box-shadow: 0 0 10px #ff0080;
        }

        .data-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 255, 136, 0.2);
            font-family: 'Roboto Mono', monospace;
        }

        .data-row:last-child {
            border-bottom: none;
        }

        .data-label {
            color: #00ffff;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .data-value {
            color: #00ff88;
            font-weight: 400;
            font-size: 1rem;
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }

        .prediction-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: linear-gradient(45deg, #00ff88, #00ffff);
            color: #000;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Orbitron', monospace;
            animation: badgeGlow 2s infinite alternate;
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #333;
            border-radius: 50%;
            border-top-color: #00ff88;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        /* Keyframe animations */
        @keyframes glitchIn {
            0% {
                transform: translateX(-100px);
                opacity: 0;
                filter: blur(10px);
            }
            100% {
                transform: translateX(0);
                opacity: 1;
                filter: blur(0);
            }
        }

        @keyframes glitch {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(-2px, -2px); }
            60% { transform: translate(2px, 2px); }
            80% { transform: translate(2px, -2px); }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes borderGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
        }

        @keyframes badgeGlow {
            0% { box-shadow: 0 0 5px #00ff88; }
            100% { box-shadow: 0 0 20px #00ff88, 0 0 30px #00ffff; }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header h1 {
                font-size: 2.5rem;
                letter-spacing: 1px;
            }

            .main-panel {
                padding: 2rem;
            }

            .data-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .data-value {
                max-width: 100%;
                text-align: left;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        ::-webkit-scrollbar-thumb {
            background: #00ff88;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #00ffff;
        }
    </style>
</head>
<body>
    <div class="grid-background"></div>
    <div class="circuit-overlay"></div>

    <div class="container">
        <div class="header">
            <h1>ML API Integration</h1>
            <div class="subtitle">Machine Learning Prediction Engine</div>
        </div>

        <div class="main-panel">
            <div class="form-section">
                <div class="form-title">🤖 Input Parameters</div>
                <form method="POST" action="/predict" id="mlForm">
                    @csrf
                    <div class="input-group">
                        <label class="input-label" for="features">Feature Vector</label>
                        <input
                            type="text"
                            name="features"
                            id="features"
                            class="feature-input"
                            placeholder="Enter comma-separated values: 5.1, 3.5, 1.4, 0.2"
                            value="{{ old('features', $features ?? '') }}"
                            required>
                    </div>
                    <button type="submit" class="predict-btn" id="predictBtn">
                        🔮 Execute Prediction
                    </button>
                </form>
            </div>
        </div>

        @if (isset($prediction))
            <div class="result-panel">
                <div class="panel-header">
                    <div class="status-indicator"></div>
                    Prediction Results
                </div>
                <div class="data-row">
                    <span class="data-label">Input Features:</span>
                    <span class="data-value">{{ $features }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Model Output:</span>
                    <span class="data-value">
                        <span class="prediction-badge">{{ $prediction }}</span>
                    </span>
                </div>
            </div>
        @endif

        @if (isset($error))
            <div class="error-panel">
                <div class="panel-header">
                    <div class="status-indicator"></div>
                    System Error
                </div>
                <div class="data-row">
                    <span class="data-label">Error Message:</span>
                    <span class="data-value" style="color: #ff0080;">{{ $error }}</span>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('mlForm');
            const button = document.getElementById('predictBtn');
            const input = document.getElementById('features');

            // Add real-time input validation
            input.addEventListener('input', function() {
                const value = this.value;
                const isValid = /^[\d\s,.-]+$/.test(value) || value === '';

                if (!isValid && value !== '') {
                    this.style.borderColor = '#ff0080';
                    this.style.boxShadow = '0 0 20px rgba(255, 0, 128, 0.5)';
                } else {
                    this.style.borderColor = '#00ff88';
                    this.style.boxShadow = '0 0 20px rgba(0, 255, 136, 0.5)';
                }
            });

            // Enhanced form submission
            form.addEventListener('submit', function(e) {
                button.innerHTML = '<span class="loading"></span>Processing...';
                button.disabled = true;
                button.style.opacity = '0.7';
                button.style.cursor = 'not-allowed';
            });

            // Add typing effect to placeholder
            let placeholderText = 'Enter comma-separated values: 5.1, 3.5, 1.4, 0.2';
            let currentText = '';
            let index = 0;

            function typePlaceholder() {
                if (input.value === '' && document.activeElement !== input) {
                    if (index < placeholderText.length) {
                        currentText += placeholderText[index];
                        input.placeholder = currentText + '|';
                        index++;
                        setTimeout(typePlaceholder, 100);
                    } else {
                        input.placeholder = currentText;
                        setTimeout(() => {
                            currentText = '';
                            index = 0;
                            setTimeout(typePlaceholder, 3000);
                        }, 2000);
                    }
                }
            }

            // Start typing effect after page load
            setTimeout(typePlaceholder, 1000);
        });
    </script>
</body>
</html>
