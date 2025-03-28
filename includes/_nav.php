<nav class="navbar navbar-expand-lg bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-gradient" href="#">Shelfy</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link nav-link" href="#categories">Categories</a></li>
                <li class="nav-item"><a class="nav-link nav-link" href="#">Cart</a></li>
                <li class="nav-item"><a class="nav-link nav-link" href="#">Account</a></li>
                <li class="nav-item"><a class="nav-link logout-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .text-gradient {
        background: linear-gradient(90deg, #ff8c00, #ff4500);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 1.5rem;
    }

    .nav-link {
        color: #f8f9fa !important;
        font-weight: 500;
        transition: color 0.3s ease-in-out;
    }

    .nav-link:hover {
        color: #ff8c00 !important;
    }

    .logout-link {
        color: #dc3545 !important;
        font-weight: 600;
    }

    .logout-link:hover {
        color: #ff073a !important;
    }

    .navbar {
        padding: 12px 0;
    }

    .navbar-toggler {
        border: none;
        outline: none;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }
</style>
