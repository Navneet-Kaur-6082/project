
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to SHELFY</title>
</head>
<body>
    <h1>Welcome to SHELFY</h1>
    <a href="register.php">Register</a> | <a href="index.html">Login</a>
</body>
</html>
<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: ../frontend/index.html"); 
exit();
?>
