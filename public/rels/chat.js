$(document).ready(function () {
  var conversationId; // Global conversation ID variable

  // Load messages and conversations when the page loads
  loadMessages();
  loadConversations();

  // Refresh the chat window every 5 seconds
  setInterval(loadMessages, 5000);
  setInterval(loadConversations, 5000);

  // Conversation selection
  $(document).on("click", ".conversation-card", function () {
    conversationId = $(this).data("id");
    loadMessages();
  });

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

  // Sending a new message
  $("#sendMessage").click(function () {
    var message = $("#messageInput").val();
    var systemContent =
      $("#systemContentInput").val() || "You are a helpful assistant.";

    $("#messageInput").val("");

    let requestData = {
      method: "sendMessage",
      message: message,
      systemContent: systemContent,
    };
    if (conversationId) {
      requestData.conversationId = conversationId;
    }

    $.ajax({
      url: "endpoint.php",
      type: "POST",
      data: requestData,

      success: function (response) {
        // Append the sent message and AI response to the chat window
        $("#chatWindow").append("<div>You: " + message + "</div>");
        $("#chatWindow").append("<div>AI: " + response + "</div>");
      },
    });
  });

  // Function to load and display messages
  function loadMessages() {
    $.ajax({
      url: "endpoint.php",
      type: "POST",
      data: {
        method: "getMessages",
        conversationId: conversationId,
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
        highlightActiveConversation(conversationId);
      },
    });
  }

  function highlightActiveConversation(conversationId) {
    $(".conversation-card").removeClass("active-conversation");
    $('.conversation-card[data-id="' + conversationId + '"]').addClass(
      "active-conversation"
    );
  }

  // Function to format code in message
  function formatCodeInMessage(content) {
    // Using regex to detect and format code blocks enclosed in triple backticks
    return content.replace(/```(.*?)```/gs, '<pre class="code-block">$1</pre>');
  }

  // Function to load and display conversations
  function loadConversations() {
    $.ajax({
      url: "endpoint.php",
      type: "POST",
      data: { method: "getConversations" },
      success: function (response) {
        var conversations = JSON.parse(response);
        $("#conversations").empty();

        if (conversations.length > 0 && !conversationId) {
          // Set the global conversationId to the first conversation's ID
          conversationId = conversations[0].conversation_id;
          loadMessages(); // Load messages for the first conversation
        }

        conversations.forEach(function (conversation) {
          var isActive = conversationId == conversation.conversation_id;
          var activeClass = isActive ? "active-conversation" : "";
          $("#conversations").append(`
                    <div class="conversation-card p-4 mb-2 bg-white rounded-lg shadow cursor-pointer hover:bg-gray-100 ${activeClass}" data-id="${conversation.conversation_id}">
                        <h3 class="text-lg font-semibold">${conversation.name}</h3>
                        <p class="text-sm text-gray-600">Click to view messages</p>
                    </div>
                `);
        });
      },
      error: function (error) {
        console.error("Error loading conversations: ", error);
      },
    });
  }

  // Create new conversation
  $("#newConversation").click(function () {
    $.ajax({
      url: "endpoint.php",
      type: "POST",
      data: { method: "createNewConversation" },
      success: function (response) {
        var newConversationId = JSON.parse(response).conversation_id;
        conversationId = newConversationId;
        loadConversations();
        loadMessages();
      },
      error: function () {
        alert("Error creating conversation");
      },
    });
  });
});
