<?php
require '../vendor/autoload.php';
include '../app/app_funcs.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'login':
            if (isset($_POST['password'])) {
                echo handleLogin($_POST['password']);
            }
            break;

        case 'sendMessage':
            if (isset($_POST['message'], $_POST['systemContent'])) {
                $aiResponse = getAIResponse($_POST['message'], $_POST['systemContent'], $_POST['conversationId']);
                echo isset($aiResponse['choices'][0]['message']['content']) ? $aiResponse['choices'][0]['message']['content'] : 'Error processing request';
            }
            break;

        case 'getMessages':
            if (isset($_POST['conversationId'])) {
                $messages = getMessages($_POST['conversationId']);
                echo json_encode($messages); // Send back the messages as JSON
            }
            break;
        case 'getConversations':
            echo json_encode(getAllConversations());
            break;

        case 'createNewConversation':
            $newConversationName = generateConversationName("New Conversation"); // Custom logic to generate a conversation name
            $newConversationId = createConversation($newConversationName);
            echo json_encode(['conversation_id' => $newConversationId]);
            break;


        default:
            echo 'Invalid method';
            break;
    }
} else {
    echo 'Invalid request';
}
