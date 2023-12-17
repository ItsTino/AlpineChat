<?php

$dbPath = __DIR__ . '/../app/database/chat.db';
$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Create 'conversations' table
    $pdo->exec("CREATE TABLE IF NOT EXISTS conversations (
        conversation_id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT
    )");

    // Create 'messages' table with an additional column for the user message
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        message_id INTEGER PRIMARY KEY AUTOINCREMENT,
        conversation_id INTEGER,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        model TEXT,
        response_type TEXT,
        content TEXT,
        user_message TEXT,
        system_prompt TEXT,
        completion_tokens INTEGER,
        prompt_tokens INTEGER,
        total_tokens INTEGER,
        FOREIGN KEY (conversation_id) REFERENCES conversations (conversation_id)
    )");

    echo "Database and tables created successfully.";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
