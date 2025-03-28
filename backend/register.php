<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);

    if ($stmt->execute()) {
        header('Location: login.php');
        exit();
    } else {
        echo "<p class='error'>Error: " . $stmt->error . "</p>";
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
    <title>Register | Shelfy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-register {
            background: linear-gradient(90deg, #ff8c00, #ff4500);
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px;
            transition: background 0.3s;
        }

        .btn-register:hover {
            background: linear-gradient(90deg, #ff4500, #ff8c00);
        }

        .login-link {
            color: #ff8c00;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link:hover {
            color: #ff4500;
        }

        .error {
            color: #ff4c4c;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2 class="mb-4">Create an Account on <span style="background: linear-gradient(90deg, #ff8c00, #ff4500); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Shelfy</span></h2>
    <form method="post">
        <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Full Name" required>
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="phone" placeholder="Phone (Optional)">
        </div>
        <div class="mb-3">
            <textarea class="form-control" name="address" placeholder="Address (Optional)"></textarea>
        </div>
        <button type="submit" class="btn btn-register w-100">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php" class="login-link">Login here</a></p>
</div>

</body>
</html>
