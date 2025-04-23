<!DOCTYPE html>
<html>
<head>
    <title>ChatGPT Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        #chat-box {
            border: 1px solid #ccc;
            padding: 20px;
            height: 400px;
            overflow-y: scroll;
            margin-bottom: 20px;
        }
        #chat-box .message {
            margin-bottom: 10px;
        }
        #chat-box .user {
            color: blue;
        }
        #chat-box .bot {
            color: green;
        }
        #chat-form {
            display: flex;
        }
        #chat-form input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
        }
        #chat-form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        #chat-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ChatGPT Dashboard</h1>
        <div id="chat-box">
            <!-- Chat messages will appear here -->
        </div>
        <form id="chat-form">
            @csrf
            <input type="text" id="message" name="message" placeholder="Type your message here..." required>
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        // Handle form submission
        document.getElementById('chat-form').addEventListener('submit', function (e) {
            e.preventDefault();

            // Get the message from the input
            const message = document.getElementById('message').value;

            // Add the user's message to the chat box
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML += `<div class="message user"><strong>You:</strong> ${message}</div>`;

            // Clear the input
            document.getElementById('message').value = '';

            // Scroll to the bottom of the chat box
            chatBox.scrollTop = chatBox.scrollHeight;

            // Send the message to the server
            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ message }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    // Display the error message
                    chatBox.innerHTML += `<div class="message bot"><strong>Error:</strong> ${data.error}</div>`;
                } else {
                    // Display ChatGPT's response
                    chatBox.innerHTML += `<div class="message bot"><strong>ChatGPT:</strong> ${data.response}</div>`;
                }

                // Scroll to the bottom of the chat box
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
