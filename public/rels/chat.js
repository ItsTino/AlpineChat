$(document).ready(function() {
    // Load messages when the page loads
    loadMessages();
    loadConversations();

    // Refresh the chat window every 5 seconds
    setInterval(loadMessages, 5000);
    setInterval(loadConversations, 5000);

    $('#messageInput').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Send message logic
    $('#sendMessage').click(function() {
        var message = $('#messageInput').val();
        var systemContent = $('#systemContentInput').val() || 'You are a helpful assistant.';
        var currentConversationId = getCurrentConversationId(); //Fetch current conversation ID //Forced 2

        // Clear the input field
        $('#messageInput').val('');

        // Send the message to the server
        $.ajax({
            url: 'endpoint.php',
            type: 'POST',
            data: {
                method: 'sendMessage',
                message: message,
                systemContent: systemContent,
                conversationId: currentConversationId  // Include the conversation ID
            },
            success: function(response) {
                // Display the sent message and the AI response
                $('#chatWindow').append('<div>You: ' + message + '</div>');
                $('#chatWindow').append('<div>AI: ' + response + '</div>');
            }
        });
    });

    // Function to load and display messages
// Function to load and display messages
function loadMessages() {
    var currentConversationId = getCurrentConversationId();

    $.ajax({
        url: 'endpoint.php',
        type: 'POST',
        data: {
            method: 'getMessages',
            conversationId: currentConversationId
        },
        success: function(response) {
            var messages = JSON.parse(response);
            $('#chatWindow').empty();

            messages.forEach(function(message) {
                if (message.user_message) {
                    $('#chatWindow').append('<div class="chat-message"><div class="chat-bubble user-message">' + message.user_message + '</div></div>');
                }

                if (message.content) {
                    $('#chatWindow').append('<div class="chat-message ai"><div class="chat-bubble ai-message">' + message.content + '</div></div>');
                }
            });
        }
    });
}

    // Function to get the current conversation ID
    function getCurrentConversationId() {
        // Placeholder implementation - adjust this based on your actual logic
        return 2; // Example: return the first conversation for now
    }

    function loadConversations() {
        $.ajax({
            url: 'endpoint.php',
            type: 'POST',
            data: { method: 'getConversations' },
            success: function(response) {
                var conversations = JSON.parse(response);
                $('#conversations').empty();
                conversations.forEach(function(conversation) {
                    $('#conversations').append(`
                        <div class="conversation-card p-4 mb-2 bg-white rounded-lg shadow cursor-pointer hover:bg-gray-100" data-id="${conversation.conversation_id}">
                            <h3 class="text-lg font-semibold">${conversation.name}</h3>
                            <p class="text-sm text-gray-600">Click to view messages</p>
                        </div>
                    `);
                });
            }
        });
    }
    
});
