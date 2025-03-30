<?php
include('../database/db.php');
session_start(); 


if (!isset($_SESSION['user_id'])) {
    echo "<p>You need to log in first.</p>";
    exit;
}

$user_id = $_SESSION['user_id']; 
$book_id = $_POST['book_id'];


$query = "SELECT * FROM cart WHERE user_id = '$user_id' AND book_id = '$book_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$user_id' AND book_id = '$book_id'";
    mysqli_query($conn, $update_query);
} else {

    $insert_query = "INSERT INTO cart (user_id, book_id, quantity) VALUES ('$user_id', '$book_id', 1)";
    mysqli_query($conn, $insert_query);
}


header("Location: ../frontend/index.php");
exit();
?>
