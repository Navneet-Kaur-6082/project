<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = "../frontend/index.php";
        }, 3000);
    </script>
</head>
<body>

    <h1>You have been logged out</h1>
    <p class="message">Redirecting you to the main page...</p>

</body>
</html>
