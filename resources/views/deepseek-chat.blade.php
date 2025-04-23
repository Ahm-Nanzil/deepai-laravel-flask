

@section('content')
<div class="container">
    <div class="card shadow-lg rounded-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3>AI Chat</h3>
        </div>
        <div class="card-body">
            <div id="chat-box" class="border p-3 rounded overflow-auto" style="height: 400px;">
                <!-- Messages will be appended here -->
            </div>
            <div class="mt-3 d-flex">
                <input type="text" id="user-input" class="form-control" placeholder="Type a message..." />
                <button class="btn btn-primary ms-2" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    function sendMessage() {
        let message = document.getElementById('user-input').value;
        if (!message.trim()) return;

        let chatBox = document.getElementById('chat-box');
        chatBox.innerHTML += `<div class='text-end'><strong>You:</strong> ${message}</div>`;

        document.getElementById('user-input').value = '';

        fetch("{{ route('chat.send') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            chatBox.innerHTML += `<div class='text-start'><strong>AI:</strong> ${data.response}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
