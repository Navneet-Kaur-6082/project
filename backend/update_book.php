<?php
include '../database/db.php';

if (!isset($_GET['book_id'])) {
    echo "Book ID is missing.";
    exit;
}

$book_id = $_GET['book_id'];

$sql = "SELECT * FROM books WHERE book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "Book not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $cover_image = $_POST['cover_image'];
    
    $update_sql = "UPDATE books SET title = ?, author = ?, category = ?, price = ?, stock = ?, description = ?, cover_image = ? WHERE book_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssdssi", $title, $author, $category, $price, $stock, $description, $cover_image, $book_id);
    
    if ($update_stmt->execute()) {
        header("Location: books.php");
        exit;
    } else {
        echo "Error updating book.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
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
        <h2>Update Book</h2>
        <form method="POST">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

            <label>Author:</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>

            <label>Category:</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($book['category']); ?>" required>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($book['price']); ?>" required>

            <label>Stock:</label>
            <input type="number" name="stock" value="<?php echo htmlspecialchars($book['stock']); ?>" required>

            <label>Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($book['description']); ?></textarea>

            <label>Cover Image URL:</label>
            <input type="text" name="cover_image" value="<?php echo htmlspecialchars($book['cover_image']); ?>" required>

            <button type="submit">Update Book</button>
        </form>
    </div>
</body>
</html>
