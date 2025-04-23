<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

$pageTitle = "Search Results";

$query = $_GET['query'];
$stmt = $conn->prepare("SELECT * FROM movies WHERE title LIKE ?");
$searchTerm = "%$query%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
$movies = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
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
                <li class="nav-item"><a href="logout.php" class="btn btn-danger">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>

<div class="search-form">
        <form class="form" action="search.php" method="get">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>

<div class="container mt-4">
    <h2 class="text-center mb-4">Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
    <div class="row justify-content-center">
        <?php if (count($movies) > 0): ?>
            <?php foreach ($movies as $movie): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <?php
                        $imagePath = 'images/' . $movie['image'];
                        if (file_exists($imagePath)) {
                            echo '<img src="' . $imagePath . '" class="card-img-top img-fluid" alt="' . htmlspecialchars($movie['title']) . '">';
                        } else {
                            echo '<img src="images/placeholder.jpg" class="card-img-top img-fluid" alt="Placeholder">';
                        }
                        ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                            <p class="card-text text-truncate"><?php echo htmlspecialchars(substr($movie['description'], 0, 120)); ?>...</p>
                            <a href="movie_detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-primary mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="alert alert-warning">No movies found matching your search query.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>