<?php
require_once('../app/security.php');
?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="rels/chat.css">
    
</head>

<body class="bg-gray-100 h-full">
    <div class="flex flex-col h-full">
        <header class="text-xl text-center p-4 bg-white shadow-md">Chat Application</header>
        <div class="flex flex-1 overflow-hidden">
            <!-- Left Sidebar for Chat List -->
            <div class="bg-white w-1/4 p-4 overflow-y-auto">
                <h2 class="font-bold text-lg">Chats</h2>
                <div id="chatList">
                    <!-- Dynamic chat list will be loaded here -->
                </div>
            </div>

            <!-- Chat Window -->
            <div class="flex flex-col w-1/2 p-4 bg-white overflow-hidden">
                <div id="chatWindow" class="flex-1 overflow-y-auto">
                    <!-- Messages will appear here -->
                </div>
                <div class="mt-4">
                    <input type="text" id="messageInput" class="border p-2 w-full rounded" placeholder="Type a message...">
                    <button id="sendMessage" class="bg-blue-500 text-white p-2 mt-2 rounded">Send</button>
                </div>
            </div>

            <!-- Right Sidebar for System Content -->
            <div class="bg-white w-1/4 p-4 overflow-y-auto">
                <h2 class="font-bold text-lg">System Content</h2>
                <input type="text" id="systemContentInput" class="border p-2 w-full rounded mb-2" placeholder="System content (e.g., 'You are a helpful assistant.')">
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="rels/chat.js"></script>

</body>

</html>