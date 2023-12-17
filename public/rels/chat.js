$(document).ready(function () {
  // Load messages when the page loads
  loadMessages();
  loadConversations();

  // Refresh the chat window every 5 seconds
  setInterval(loadMessages, 5000);
  setInterval(loadConversations, 5000);

  $("#messageInput").on("input", function () {
    this.style.height = "auto";
    this.style.height = this.scrollHeight + "px";
  });

  $(document).on("click", ".chat-bubble", function () {
    var textToCopy = $(this).attr("data-content");
    navigator.clipboard.writeText(textToCopy).then(function () {
      // Show toast notification
      var toast = $("#toast");
      toast.removeClass("hidden");
      setTimeout(function () {
        toast.addClass("hidden");
      }, 3000); // Hide after 3 seconds
    });
  });

  // Send message logic
  $("#sendMessage").click(function () {
    var message = $("#messageInput").val();
    var systemContent =
      $("#systemContentInput").val() || "You are a helpful assistant.";
    var currentConversationId = getCurrentConversationId(); //Fetch current conversation ID //Forced 2

    // Clear the input field
    $("#messageInput").val("");

    // Send the message to the server
    $.ajax({
      url: "endpoint.php",
      type: "POST",
      data: {
        method: "sendMessage",
        message: message,
        systemContent: systemContent,
        conversationId: currentConversationId, // Include the conversation ID
      },
      success: function (response) {
        // Display the sent message and the AI response
        $("#chatWindow").append("<div>You: " + message + "</div>");
        $("#chatWindow").append("<div>AI: " + response + "</div>");
      },
    });
  });

  // Function to load and display messages
  function loadMessages() {
    var currentConversationId = getCurrentConversationId();

    $.ajax({
      url: "endpoint.php",
      type: "POST",
      data: {
        method: "getMessages",
        conversationId: currentConversationId,
      },
      success: function (response) {
        var messages = JSON.parse(response);
        $("#chatWindow").empty();

        messages.forEach(function (message) {
          // Append user messages as is
          if (message.user_message) {
            $("#chatWindow").append(
              '<div class="chat-message"><div class="chat-bubble user-message" data-content="' +
                message.user_message +
                '">' +
                message.user_message +
                "</div></div>"
            );
          }

          // Check for code in AI messages and format if necessary
          if (message.content) {
            var formattedContent = formatCodeInMessage(message.content);
            $("#chatWindow").append(
              '<div class="chat-message"><div class="chat-bubble ai-message" data-content="' +
                message.content +
                '">' +
                formattedContent +
                "</div></div>"
            );
          }
        });
      },
    });
  }

  // Function to format code in message
  function formatCodeInMessage(content) {
    // Using regex to detect and format code blocks enclosed in triple backticks
    return content.replace(/```(.*?)```/gs, '<pre class="code-block">$1</pre>');
}


  // Function to get the current conversation ID
  function getCurrentConversationId() {
    // Placeholder implementation - adjust this based on your actual logic
    return 2; // Example: return the first conversation for now
  }

  function loadConversations() {
    $.ajax({
      url: "endpoint.php",
      type: "POST",
      data: { method: "getConversations" },
      success: function (response) {
        var conversations = JSON.parse(response);
        $("#conversations").empty();
        conversations.forEach(function (conversation) {
          $("#conversations").append(`
                        <div class="conversation-card p-4 mb-2 bg-white rounded-lg shadow cursor-pointer hover:bg-gray-100" data-id="${conversation.conversation_id}">
                            <h3 class="text-lg font-semibold">${conversation.name}</h3>
                            <p class="text-sm text-gray-600">Click to view messages</p>
                        </div>
                    `);
        });
      },
    });
  }
});
