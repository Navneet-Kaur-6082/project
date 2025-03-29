<?php
include '../database/db.php';
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p>Please log in to add books to your cart.</p>";
    exit; // Stop further execution if user is not logged in
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// SQL query to fetch books based on search and category
$sql = "SELECT * FROM books WHERE title LIKE '%$search%'";

// Add category filter if category is selected
if (!empty($category)) {
    $sql .= " AND category = '$category'";
}

$result = $conn->query($sql);

// Check if there are any books
if ($result->num_rows > 0) {
    // Loop through the results and display books
    while ($row = $result->fetch_assoc()) {
        echo "<div class='book'>";
        echo "<h3>{$row['title']}</h3>";
        echo "<img src='{$row['cover_image']}' alt='Book Cover'>";  
        echo "<p><b>Price:</b> $ {$row['price']}</p>";
        echo "<p><b>Author:</b> {$row['author']}</p>";
        echo "<p><b>Description:</b> {$row['description']}</p>";
        echo "<p><b>Genre:</b> {$row['category']}</p>";
        
        // Add to Cart form
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
