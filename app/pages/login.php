<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chat App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div id="loginForm" class="max-w-sm mx-auto">
            <form id="login" method="POST" action="endpoint.php">
                <input type="password" name="password" class="border p-2 w-full rounded" placeholder="Enter password">
                <button type="submit" class="bg-blue-500 text-white p-2 mt-2 rounded w-full">Login</button>
            </form>
            <div id="loginError" class="text-red-500 mt-2"></div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response === 'Success') {
                            window.location.href = 'index.php';
                        } else {
                            $('#loginError').text(response);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
