<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in!";
    exit();
}

$user_id = $_SESSION['user_id'];
$address = $_POST['address'];
$total_price = $_POST['total_price'];

// Insert the order into the orders table
$sql_order = "INSERT INTO orders (user_id, total_price, order_status) VALUES (?, ?, 'Pending')";
$stmt = $conn->prepare($sql_order);
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();
$order_id = $stmt->insert_id;  // Get the newly created order ID
$stmt->close();

// ✅ Insert a new tracking record for the order
$sql_tracking = "INSERT INTO order_tracking (order_id, status) VALUES (?, 'Processing')";
$stmt_tracking = $conn->prepare($sql_tracking);
$stmt_tracking->bind_param("i", $order_id);
$stmt_tracking->execute();
$stmt_tracking->close();

// Fetch items from the user's cart
$sql_cart = "SELECT book_id, quantity FROM cart WHERE user_id = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

while ($row = $result_cart->fetch_assoc()) {
    $book_id = $row['book_id'];
    $quantity = $row['quantity'];

    // Insert each cart item into order_items table
    $sql_order_item = "INSERT INTO order_items (order_id, book_id, quantity, price) 
                       SELECT ?, book_id, ?, price FROM books WHERE book_id = ?";
    $stmt_order_item = $conn->prepare($sql_order_item);
    $stmt_order_item->bind_param("iii", $order_id, $quantity, $book_id);
    $stmt_order_item->execute();
    $stmt_order_item->close();
}

// Clear the user's cart after placing the order
$sql_clear_cart = "DELETE FROM cart WHERE user_id = ?";
$stmt_clear_cart = $conn->prepare($sql_clear_cart);
$stmt_clear_cart->bind_param("i", $user_id);
$stmt_clear_cart->execute();
$stmt_clear_cart->close();

// Redirect to the success page
header("Location: checkout_success.php");
exit();
?>
