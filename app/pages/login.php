<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chat App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
        <form id="login" class="space-y-6" method="POST">
            <h5 class="text-xl font-medium text-gray-900 dark:text-white">AlpineChat</h5>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                <input type="password" name="password" id="passwordInput" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
            </div>
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
            <div id="loginError" class="text-red-500 mt-2"></div>
        </form>
    </div>
    

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login').on('submit', function(e) {
                e.preventDefault();
                var password = $('#passwordInput').val(); // Fetch the password value

                $.ajax({
                    url: 'endpoint.php', // Make sure this URL is correct
                    type: 'POST',
                    data: {
                        method: 'login',
                        password: password
                    },
                    success: function(response) {
                        if (response === 'Success') {
                            document.location.reload(true);
                        } else {
                            $('#loginError').text(response); // Display login errors
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loginError').text('Login request failed: ' + error);
                    }
                });
            });
        });
    </script>
</body>

</html>