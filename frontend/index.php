
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shelfy</title>
    <link rel="stylesheet" href="../css/index.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-dark shadow-sm">
      <div class="container">
        <a class="navbar-brand fw-bold text-gradient" href="#">Shelfy</a>
        <button
          class="navbar-toggler border-0"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link" href="#categories">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link" href="checkout.php">Cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link" href="../backend/accounts.php"
                >Account</a
              >
            </li>
            <li class="nav-item">
                <?php 
                    session_start();
                    if (isset($_SESSION['user_id'])) {
                        echo "<a class='nav-link logout-link' href='../backend/logout.php'>Logout</a>";
                    } else {
                        echo "<a class='nav-link logout-link' href='../backend/login.php'>Login</a>";
                    }
                ?>

            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container1">
      <input
        type="text"
        id="search"
        placeholder="Search books..."
        onkeyup="fetchBooks()"
      />
      <select id="category" onchange="fetchBooks()">
        <option value="">All Categories</option>
        <option value="Fiction">Fiction</option>
        <option value="Mystery">Mystery</option>
        <option value="Science">Science</option>
        <option value="Romance">Romance</option>
        <option value="Self-Help">Self-Help</option>
      </select>

      <div class="book-list" id="book-list"></div>
    </div>

    <script>
      function fetchBooks() {
        let search = document.getElementById("search").value;
        let category = document.getElementById("category").value;

        fetch(`../backend/index.php?search=${search}&category=${category}`)
          .then((response) => response.text())
          .then(
            (data) => (document.getElementById("book-list").innerHTML = data)
          );
      }

      document.addEventListener("DOMContentLoaded", fetchBooks);
    </script>
    <?php include '../backend/index.php'; ?>
  </body>
</html>
