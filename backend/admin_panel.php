<?php
session_start();
include '../database/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, email, phone, address, role, created_at FROM users WHERE user_id = ? AND role = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if (!$admin) {
    echo "Error: Admin not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin_panel.css">
</head>
<body>
    <nav class="admin-nav">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_panel.php">Dashboard</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="books.php">Books</a></li>
            <li><a href="manage_orders.php">Orders</a></li>
            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </nav>
    <div class="admin-dashboard">
        <h2>Welcome, <?php echo ($admin['name']); ?>!</h2>
        <div class="admin-div">
            <p><strong>Email:</strong> <?php echo ($admin['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo ($admin['phone'] ?: 'N/A'); ?></p>
            <p><strong>Address:</strong> <?php echo ($admin['address'] ?: 'N/A'); ?></p>
            <p><strong>Role:</strong> <?php echo ucfirst($admin['role']); ?></p>
            <p><strong>Joined On:</strong> <?php echo date("F j, Y", strtotime($admin['created_at'])); ?></p>
        </div>
        <div class="main-site">
            <a href="../frontend/index.php" class="btn">Go to Main Website</a>
        </div>
    </div>

</body>
</html>
