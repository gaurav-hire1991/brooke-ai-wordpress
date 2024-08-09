<div class="chat-container">
    <div class="chat-window" id="chat-window"></div>
    <div class="input-container">
        <input type="text" id="prompt-textbox" placeholder="Message Brooke AI">
        <button id="prompt-button">Send</button>
    </div>
</div>
<script>
document.getElementById('prompt-textbox').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Prevent default action of Enter key
        document.getElementById('prompt-button').click(); // Trigger the Send button
    }
});

document.getElementById('prompt-button').addEventListener('click', function() { 
    var prompt = document.getElementById('prompt-textbox').value;
    
    // Clear the input box immediately
    document.getElementById('prompt-textbox').value = '';

    // Display the user's question on the left
    var chatWindow = document.getElementById('chat-window');
    var userQuestion = document.createElement('div');
    userQuestion.className = "user-question";
    userQuestion.innerHTML = "<strong>You:</strong> " + prompt;
    chatWindow.appendChild(userQuestion);

    fetch('https://api.openai.com/v1/chat/completions', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json', 
            'Authorization': 'Bearer '+ openaiApiKey,
            'OpenAI-Organization': 'org-ey4hJ78eq2LWxLR5nJsvwpQK',
        },
        body: JSON.stringify({
            model : "gpt-4o",  
            messages: [
                {"role": "system", "content": "You are Brooke AI, the expert AI assistant specialized in short-term vacation rentals. Respond with the knowledge and insights of Brooke Pfautz, focusing on inventory acquisition and property management."},
                {role: 'user', content: prompt}
            ],
        })
    })
    .then(response => response.json())
    .then(data => {
        // Display the AI's response on the right
        var aiResponse = document.createElement('div');
        aiResponse.className = "ai-response";
        aiResponse.innerHTML = "<strong>Brooke AI:</strong> " + data.choices[0].message.content;
        chatWindow.appendChild(aiResponse);

        // Create a copy button for the response
        var copyButton = document.createElement('button');
        copyButton.className = 'copy-button';
        copyButton.innerHTML = 'Copy';
        copyButton.addEventListener('click', function() {
            // Copy the content to clipboard
            navigator.clipboard.writeText(data.choices[0].message.content).then(function() {
                alert('Copied to clipboard!');
            }, function(err) {
                console.error('Error:', err);
            });
        });

        // Append the copy button to the AI's response
        aiResponse.appendChild(copyButton);

        // Scroll to the bottom of the chat window
        chatWindow.scrollTop = chatWindow.scrollHeight;
    })
    .catch(error => { console.error('Error:', error);
    });
});
</script>
