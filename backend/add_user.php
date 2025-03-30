<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $name, $email, $hashed_password, $phone, $address, $role);

    if ($stmt->execute()) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="../css/admin_panel.css">
</head>
<body>

    <nav class="admin-nav">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_panel.php">Dashboard</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="books.php">Books</a></li>
            <li><a href="orders.php">Orders</a></li>
        </ul>
    </nav>

    <div class="admin-section">
        <h2>Add New User</h2>
        <form action="add_user.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone">

            <label for="address">Address:</label>
            <textarea name="address" id="address"></textarea>

            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Add User</button>
        </form>
    </div>

</body>
</html>
