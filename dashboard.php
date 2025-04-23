<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

$pageTitle = "Dashboard";
$username = $_SESSION['username'];

// Fetch random movies
$randomMovies = $conn->query("SELECT * FROM movies")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MovieBuzz movie Review</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/globals.css" />
    <link rel="stylesheet" href="css/styleguide.css" />
    <link rel="stylesheet" href="css/styles.css" />

    <style>
        .user-circle {
            width: 45px;
            height: 45px;
            background-color: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
        }

        .dropdown-menu {
            min-width: 150px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php"><img src="img/logo.png" alt="Logo" height="40"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php#movies">Movies</a></li>
                    <li class="nav-item"><a class="nav-link" href="favorites.php">Favorites</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="user-circle">
                                <?php echo strtoupper(substr($username, 0, 1)); ?>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-item-text">Hello, <strong><?php echo htmlspecialchars($username); ?></strong></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
        <ol class="carousel-indicators">
            <li data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="1"></li>
            <li data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/banner_1.png" class="d-block w-100 d-sm-block" alt="..." />
            </div>
            <div class="carousel-item">
                <img src="img/banner_2.png" class="d-block w-100 d-sm-block" alt="..." />
            </div>
            <div class="carousel-item">
                <img src="img/banner_2.png" class="d-block w-100 d-sm-block" alt="..." />
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <section class="banner">
        <div class="banner-content">
            <button class="btn btn-primary my-2">Fantasy</button>
            <button class="btn btn-danger my-2">Action</button>
            
            <h1>
                <span class="text-warning">Deadpool </span>
                <span class="text-danger">3</span>
            </h1>
        </div>
    </section>

    <div class="search-form">
        <form class="form" action="search.php" method="get">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>

    <div class="row" id="movies">
        <?php foreach ($randomMovies as $movie) : ?>
            <div class="card mb-4">
                <?php
                $imagePath = 'images/' . $movie['image'];
                if (file_exists($imagePath)) {
                    echo '<img src="' . $imagePath . '" class="card-img-top" alt="' . $movie['title'] . '">';
                } else {
                    echo '<img src="images/placeholder.jpg" class="card-img-top" alt="Placeholder">';
                }
                ?>
                <div class="card-body">
                    <h3 class="card-title"><?php echo $movie['title']; ?></h3>
                    <p class="card-text"><?php echo substr($movie['description'], 0, 100); ?>...</p>
                    <a href="movie_detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <div class="wrapper">
            <div class="links-container">
                <div class="links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="dashboard.php">Movies</a></li>
                        <li><a href="dashboard.php">Home</a></li>
                        <li><a href="favorites.php">Favourites</a></li>
                    </ul>
                    <li><a href="#" class="btn light">Sign Up</a></li>
                </div>
                <div class="links">
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
                <p class="copyright">© Copyright 2024. All Rights Reserved. MovieBuzz</p>
            </div>
        </div>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
