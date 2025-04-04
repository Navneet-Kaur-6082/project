<?php
include '../database/db.php';
session_start(); 
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM books WHERE 1";
if (!empty($search)) {
    $sql .= " AND title LIKE '%$search%'";
}
if (!empty($category)) {
    $sql .= " AND category = '$category'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shelfy</title>
    <link rel="stylesheet" href="../css/index.css" />
  </head>
  <body>
    <nav class="admin-nav">
        <h2>Shelfy</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="checkout.php">Checkout</a></li>
            <li><a href="../backend/accounts.php">Account</a></li>
            <li>
              <?php 
                    if (isset($_SESSION['user_id'])) {
                        echo "<a class='nav-btn' href='../backend/logout.php'>Logout</a>";
                    } else {
                        echo "<a class='nav-btn' href='../backend/login.php'>Login</a>";
                    }
              ?>
            </li>
        </ul>
    </nav>
    
    <div class="container1">
      <input type="text" id="search" placeholder="Search books..." onkeyup="fetchBooks()" />
      <select id="category" onchange="fetchBooks()">
        <option value="">All Categories</option>
        <option value="Fiction">Fiction</option>
        <option value="Historical">Historical</option>
        <option value="Fantasy">Fantasy</option>
        <option value="Romance">Romance</option>
        <option value="Novel">Novel</option>
      </select>
      
      <div class="book-list" id="book-list">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class='book'>
              <h3><?= $row['title'] ?></h3>
              <img src='<?= $row['cover_image'] ?>' alt='Book Cover'>  
              <p><b>Price:</b> $<?= $row['price'] ?></p>
              <p><b>Author:</b> <?= $row['author'] ?></p>
              <p><b>Description:</b> <?= $row['description'] ?></p>
              <p><b>Genre:</b> <?= $row['category'] ?></p>
              
              <form method="POST" action="../backend/add_to_cart.php">
                <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                <button type="submit" class="btn-buy">Add to Cart</button>
              </form>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No books found.</p>
        <?php endif; ?>
      </div>
    </div>
    
    <script>
      function fetchBooks() {
        let search = document.getElementById("search").value;
        let category = document.getElementById("category").value;

        fetch(`index.php?search=${search}&category=${category}`)
          .then(response => response.text())
          .then(data => {
            document.getElementById("book-list").innerHTML = 
              new DOMParser().parseFromString(data, 'text/html').querySelector('#book-list').innerHTML;
          });
      }
    </script>
  </body>
</html>
