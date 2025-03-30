<?php
include '../database/db.php';

if (!isset($_GET['order_id'])) {
    echo "Order ID is missing.";
    exit;
}

$order_id = $_GET['order_id'];
$sql = "SELECT o.order_id, o.user_id, o.total_price, o.order_status, ot.status as tracking_status
        FROM orders o
        LEFT JOIN order_tracking ot ON o.order_id = ot.order_id
        WHERE o.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Order not found.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_status = $_POST['order_status'];
    $tracking_status = $_POST['tracking_status'];
    $conn->begin_transaction();

    try {
        $update_order_sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        $update_order_stmt = $conn->prepare($update_order_sql);
        $update_order_stmt->bind_param("si", $order_status, $order_id);
        $update_order_stmt->execute();
        $update_tracking_sql = "INSERT INTO order_tracking (order_id, status) VALUES (?, ?)";
        $update_tracking_stmt = $conn->prepare($update_tracking_sql);
        $update_tracking_stmt->bind_param("is", $order_id, $tracking_status);
        $update_tracking_stmt->execute();
        $conn->commit();
        header("Location: orders.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error updating order: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
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
        <h2>Update Order</h2>
        <form method="POST">
            <label for="order_status">Order Status:</label>
            <select name="order_status" id="order_status" required>
                <option value="Pending" <?php echo $order['order_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="Shipped" <?php echo $order['order_status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                <option value="Delivered" <?php echo $order['order_status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                <option value="Cancelled" <?php echo $order['order_status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>

            <label for="tracking_status">Tracking Status:</label>
            <select name="tracking_status" id="tracking_status" required>
                <option value="Processing" <?php echo $order['tracking_status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                <option value="Shipped" <?php echo $order['tracking_status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                <option value="Out for Delivery" <?php echo $order['tracking_status'] == 'Out for Delivery' ? 'selected' : ''; ?>>Out for Delivery</option>
                <option value="Delivered" <?php echo $order['tracking_status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
            </select>

            <button type="submit">Update Order</button>
        </form>
    </div>

</body>
</html>
