<?php
require 'config/conf.php'; // Include configuration file
require 'db.php';   // Include db.php for database functions
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

session_start();

function handleLogin($password) {
    global $hashed_password;

    if (password_verify($password, $hashed_password)) {
        $_SESSION['logged_in'] = true;
        return 'Success';
    } else {
        return 'Invalid password';
    }
}

function getAppCurrentConversationId() {
    //return getCurrentConversationId();
}

function getAIResponse($message, $systemContent) {
    global $anyscale_api_key, $ai_model, $pdo;

    $client = new Client();
    $url = 'https://api.endpoints.anyscale.com/v1/chat/completions';

    try {
        // Check if a new conversation should be started
        if (shouldStartNewConversation()) {
            $conversationName = generateConversationName($message);
            $conversationId = createConversation($conversationName);
        } else {
            $conversationId = getCurrentConversationId($pdo);
        }
        $conversationId = 2;

        $response = $client->request('POST', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $anyscale_api_key,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'model' => $ai_model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemContent],
                    ['role' => 'user', 'content' => $message]
                ],
                'temperature' => 0.7
            ]
        ]);


        $responseBody = json_decode($response->getBody(), true);
        error_log("AI Response: " . json_encode($responseBody));
        
        if (isset($responseBody['choices'][0]['message']['content'])) {
            $aiResponseContent = $responseBody['choices'][0]['message']['content'];
            $usage = $responseBody['usage'] ?? ['completion_tokens' => 0, 'prompt_tokens' => 0, 'total_tokens' => 0];
            
           //storeMessage($conversationId, $ai_model, "success", $aiResponseContent, $systemContent, $message, $usage['completion_tokens'], $usage['prompt_tokens'], $usage['total_tokens']);
            storeMessage($conversationId, $ai_model, "success", $aiResponseContent, $message, $systemContent, $usage['completion_tokens'], $usage['prompt_tokens'], $usage['total_tokens']);
        }

        return $responseBody;

    } catch (GuzzleException $e) {
        return 'Error: ' . $e->getMessage();
    }
}

function generateConversationName($message) {
    // Implement the AI call here to generate a conversation name based on $message
    // For now, returning a placeholder name based on the message content
    return "Conversation: " . substr($message, 0, 30);
}

function getCurrentConversationId($pdo) {
    // Example implementation: Get the ID of the most recent conversation
    $stmt = $pdo->query("SELECT conversation_id FROM messages ORDER BY timestamp DESC LIMIT 1");
    $lastConversation = $stmt->fetch(PDO::FETCH_ASSOC);

    return $lastConversation ? $lastConversation['conversation_id'] : null;
}