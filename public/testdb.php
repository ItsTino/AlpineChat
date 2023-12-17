<?php
try {
    $pdo = new PDO('sqlite:../app/database/chat.db');
    echo "Connection successful";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
