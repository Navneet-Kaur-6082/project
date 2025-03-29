<?php
session_start();
include '../database/db.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for logged-in user
$sql = "SELECT c.cart_id, b.title, b.price, c.quantity 
        FROM cart c 
        JOIN books b ON c.book_id = b.book_id 
        WHERE c.user_id = $user_id";

$result = $conn->query($sql);
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Shelfy</title>
    <link rel="stylesheet" href="../css/checkout.css">
</head>
<body>

    <div class="checkout-container">
        <h2>Checkout</h2>

        <div class="cart-items">
            <h4> Price</h4>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <span><?php echo $row['title']; ?></span>
                        <span>$<?php echo number_format($row['price'] * $row['quantity'], 2); ?></span>
                    </li>
                    <span class="quan">Qty: <?php echo $row['quantity']; ?></span>
                    <hr>
                    <?php $total_price += ($row['price'] * $row['quantity']); ?>
                <?php endwhile; ?>
            </ul>
            <p> Total:   $<?php echo number_format($total_price, 2); ?></p>
        </div>

        <form method="POST" action="../backend/process_checkout.php">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">

            <label for="address">Shipping Address:</label>
            <textarea name="address" required></textarea>

            <button type="submit" class="checkout-btn">Place Order</button>
        </form>
    </div>

</body>
</html>
