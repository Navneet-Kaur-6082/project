<?php
include '../database/db.php';

$sql_books = "SELECT * FROM books";
$result_books = $conn->query($sql_books);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
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
        <h2>Manage Books</h2>
        <button onclick="window.location.href='add_book.php'" class="add-btn">+ Add Book</button>

        <table>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php while ($book = $result_books->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $book['book_id']; ?></td>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td>$<?php echo number_format($book['price'], 2); ?></td>
                <td>
                    <a href="update_book.php?book_id=<?php echo $book['book_id']; ?>" class="edit-btn">Edit</a>
                    <button class="delete-btn" onclick="confirmDelete(<?php echo $book['book_id']; ?>)">Delete</button>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function confirmDelete(bookId) {
            if (confirm("Are you sure you want to delete this book?")) {
                window.location.href = "delete_book.php?book_id=" + bookId;
            }
        }
    </script>

</body>
</html>
