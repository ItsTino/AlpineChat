<?php
// Database connection setup
try {
    $pdo = new PDO('sqlite:/home/debian/anyscale-mixtral-chat/app/database/chat.db');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

// Function to create a new conversation
function createConversation($name)
{
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO conversations (name) VALUES (:name)");
    $stmt->execute([':name' => $name]);
    return $pdo->lastInsertId(); // Returns the ID of the newly created conversation
}

// Function to store a message

function storeMessage($conversationId, $model, $responseType, $content, $userMessage, $systemPrompt = null, $completionTokens = 0, $promptTokens = 0, $totalTokens = 0)
{
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO messages (conversation_id, model, response_type, content, user_message, system_prompt, completion_tokens, prompt_tokens, total_tokens) VALUES (:conversation_id, :model, :response_type, :content, :user_message, :system_prompt, :completion_tokens, :prompt_tokens, :total_tokens)");
    $stmt->execute([
        ':conversation_id' => $conversationId,
        ':model' => $model,
        ':response_type' => $responseType,
        ':content' => $content,
        ':user_message' => $userMessage,
        ':system_prompt' => $systemPrompt,
        ':completion_tokens' => $completionTokens,
        ':prompt_tokens' => $promptTokens,
        ':total_tokens' => $totalTokens
    ]);
}

// Function to retrieve messages from a specific conversation
function getMessages($conversationId)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM messages WHERE conversation_id = :conversation_id ORDER BY timestamp ASC");
    $stmt->execute([':conversation_id' => $conversationId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function shouldStartNewConversation()
{
    global $pdo;

    // Implement your logic here. For example, checking the time since the last message.
    // This is a placeholder example:
    $stmt = $pdo->query("SELECT timestamp FROM messages ORDER BY timestamp DESC LIMIT 1");
    $lastMessage = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$lastMessage || strtotime($lastMessage['timestamp']) < strtotime('-1 hour')) {
        return true;
    }
    return false;
}
