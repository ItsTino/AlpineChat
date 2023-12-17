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
        <header class="bg-gray-800 text-white shadow-md">
            <div class="text-center p-4">
                <h1 class="text-2xl font-bold">AlpineChat</h1>
                <p class="text-sm text-gray-300">powered by anyscale endpoints</p>
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">
            <!-- Left Sidebar for System Content and Conversation Management -->
            <div class="bg-white w-1/4 p-4 overflow-y-auto">
                <!--Model Selector-->
                <div class="mb-4">
                    <label for="modelSelector" class="block text-sm font-medium text-gray-700">Select Model</label>
                    <select id="modelSelector" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="Mixtral-8x7B-Instruct-v0.1">Mixtral-8x7B-Instruct-v0.1</option>
                        <option value="Llama-2-70b-chat-hf">Llama-2-70b-chat-hf</option>
                        <option value="CodeLlama-34b-Instruct-hf">CodeLlama-34b-Instruct-hf</option>
                    </select>
                </div>
                <!-- System Content -->
                <h2 class="font-bold text-lg">System Content</h2>
                <input type="text" id="systemContentInput" class="border p-2 w-full rounded mb-4" placeholder="AI Prompt (e.g., 'You are a helpful assistant.')">

                <!-- Conversations -->
                <h2 class="font-bold text-lg mb-4">Conversations</h2>
                <div id="conversations" class="mb-4">
                    <!-- Conversations will appear here -->
                </div>
                <button id="newConversation" class="bg-blue-500 text-white p-2 rounded w-full">New Conversation</button>
            </div>

            <!-- Chat Window -->
            <!-- Chat Window -->
            <div class="flex flex-col w-3/4 p-4 bg-white overflow-hidden">
                <div id="chatWindow" class="flex-1 overflow-y-auto">
                    <!-- Messages will appear here -->
                </div>
                <div class="mt-4 flex">
                    <textarea id="messageInput" class="border p-2 flex-grow rounded-l" placeholder="Type a message..." rows="1"></textarea>
                    <button id="sendMessage" class="bg-blue-500 text-white p-2 rounded-r">Send</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="rels/chat.js"></script>
</body>

</html>