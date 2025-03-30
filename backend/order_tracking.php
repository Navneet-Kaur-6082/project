<?php
include '../database/db.php';
if (!isset($_GET['order_id'])) {
    echo "Invalid request.";
    exit();
}

$order_id = intval($_GET['order_id']);
$sql = "SELECT * FROM order_tracking WHERE order_id = $order_id ORDER BY updated_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <link rel="stylesheet" href="../css/order_tracking.css">
</head>
<body>
    <div class="tracking-container">
        <h2>Order Tracking Status</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>Status</th>
                    <th>Updated At</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['updated_at']; ?></td>
                </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No tracking information found for this order.</p>
        <?php } ?>
        <a href="accounts.php" class="back-btn">Back to Orders</a>
    </div>
</body>
</html>
