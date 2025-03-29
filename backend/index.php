<?php
include '../database/db.php';
session_start(); 

if (!isset($_SESSION['user_id'])) {
    echo "<p>Please log in to add books to your cart.</p>";
    exit; 
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM books WHERE title LIKE '%$search%'";

if (!empty($category)) {
    $sql .= " AND category = '$category'";
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='book'>";
        echo "<h3>{$row['title']}</h3>";
        echo "<img src='{$row['cover_image']}' alt='Book Cover'>";  
        echo "<p><b>Price:</b> $ {$row['price']}</p>";
        echo "<p><b>Author:</b> {$row['author']}</p>";
        echo "<p><b>Description:</b> {$row['description']}</p>";
        echo "<p><b>Genre:</b> {$row['category']}</p>";
        
        echo '<form method="POST" action="../backend/add_to_cart.php">';
        echo '<input type="hidden" name="book_id" value="' . $row['book_id'] . '">';
        echo '<button type="submit" class="btn-buy">Add to Cart</button>';
        echo '</form>';
        
        echo "</div>";
    }
} else {
    echo "<p>No books found.</p>";
}
?>
