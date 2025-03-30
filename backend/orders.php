<?php
include '../database/db.php';
$sql_orders = "SELECT o.order_id, u.name AS user_name, o.total_price, o.order_status, ot.status AS tracking_status, o.created_at 
               FROM orders o
               JOIN users u ON o.user_id = u.user_id
               LEFT JOIN order_tracking ot ON o.order_id = ot.order_id
               ORDER BY o.created_at DESC";
$result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
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
        <h2>Manage Orders</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total Price</th>
                <th>Order Status</th>
                <th>Tracking Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php while ($order = $result_orders->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['user_name']; ?></td>
                <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                <td><?php echo $order['order_status']; ?></td>
                <td><?php echo $order['tracking_status'] ?? 'N/A'; ?></td>
                <td><?php echo $order['created_at']; ?></td>
                <td>
                    <a href="update_order.php?order_id=<?php echo $order['order_id']; ?>" class="edit-btn">Update</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function confirmDelete(orderId) {
            if (confirm("Are you sure you want to delete this order?")) {
                window.location.href = "delete_order.php?order_id=" + orderId;
            }
        }
    </script>

</body>
</html>
