<?php
session_start();
include '../database/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_sql = "SELECT name, email, phone, address, role FROM users WHERE user_id = ?";
$stmt = $conn->prepare($user_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$is_admin = ($user['role'] === 'admin');
$order_sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$order_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="../css/order_tracking.css">
</head>
<body>

    <div class="account-container">
        <h2>My Account</h2>
        <div class="user-info">
            <h3>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h3>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?: 'Not Provided'); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address'] ?: 'Not Provided'); ?></p>
        </div>

        <h2>My Orders</h2>
        <?php if ($order_result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Track</th>
                </tr>
                <?php while ($row = $order_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td>$<?php echo $row['total_price']; ?></td>
                    <td><?php echo $row['order_status']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="order_tracking.php?order_id=<?php echo $row['order_id']; ?>" class="track-btn">
                            Track
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>You have no orders yet.</p>
        <?php } ?>
        <?php if ($is_admin): ?>
            <a href="admin_panel.php" class="back-btn">Go to Admin Panel</a>
        <?php endif; ?>
        <a href="../frontend/index.php" class="back-btn">Go back to Home Page</a>
    </div>

</body>
</html>
