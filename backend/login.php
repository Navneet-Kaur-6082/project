<?php
session_start();
include '../database/db.php';

$login_success = false;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $login_success = true;
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No account found with this email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Shelfy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css" />
    <style>
        .message {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #28a745;
        }
        .error {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #dc3545;
        }
    </style>
    <?php if ($login_success): ?>
    <script>
        setTimeout(function() {
            window.location.href = "../frontend/index.php"; 
        }, 2000);
    </script>
    <?php endif; ?>
</head>
<body>

<div class="login-container">
    <h2 class="mb-4">Login to <span style="background: linear-gradient(90deg, #ff8c00, #ff4500); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Shelfy</span></h2>

    <?php if ($login_success): ?>
        <p class="message">Login successful! Redirecting...</p>
    <?php endif; ?>

    <?php if (!$login_success): ?>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="register.php" class="register-link">Register here</a></p>
    <?php endif; ?>
</div>

</body>
</html>
