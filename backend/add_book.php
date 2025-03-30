<?php
include '../database/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $cover_image = $_POST['cover_image'];

    $sql = "INSERT INTO books (title, author, category, price, stock, description, cover_image) 
            VALUES ('$title', '$author', '$category', '$price', '$stock', '$description', '$cover_image')";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
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
        <h2>Add New Book</h2>

        <form action="add_book.php" method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category">

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="cover_image">Cover Image URL:</label>
            <input type="text" id="cover_image" name="cover_image">

            <button type="submit">Add Book</button>
        </form>
    </div>

</body>
</html>
