<?php
include '../database/db.php';

if (isset($_GET['delete_user_id'])) {
    $delete_user_id = $_GET['delete_user_id'];
    $sql_delete = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param('i', $delete_user_id);

    if ($stmt->execute()) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
}

$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
        <h2>Manage Users</h2>
        <button onclick="window.location.href='add_user.php'" class="add-btn">+ Add User</button>

        <table>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <?php while ($user = $result_users->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['phone'] ? $user['phone'] : 'N/A'; ?></td>
                <td><?php echo $user['address'] ? $user['address'] : 'N/A'; ?></td>
                <td>
                    <a href="update_user.php?user_id=<?php echo $user['user_id']; ?>" class="edit-btn">Edit</a>
                    <a href="users.php?delete_user_id=<?php echo $user['user_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
