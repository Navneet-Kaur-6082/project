<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../database/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
    <link rel="stylesheet" href="../css/checkout_success.css">
</head>
<body>
    <div class="order-placed-container">
        <h2>Order Placed Successfully!</h2>
        <p>Thank you for shopping with us. Your order is being processed.</p>
        <a href="../frontend/index.php" class="continue-shopping-btn">Continue Shopping</a>
    </div>
</body>
</html>
