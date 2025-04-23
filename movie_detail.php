<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

$movieId = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->bind_param("i", $movieId);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch reviews and average rating
$stmt = $conn->prepare("SELECT reviews.*, AVG(reviews.rating) as avg_rating, users.username FROM reviews JOIN users ON reviews.user_id = users.id WHERE reviews.movie_id = ? GROUP BY reviews.id DESC LIMIT 2");
$stmt->bind_param("i", $movieId);
$stmt->execute();
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$avgRating = isset($reviews[0]) ? $reviews[0]['avg_rating'] : 0; // Check if there are reviews to avoid warnings
$stmt->close();

$pageTitle = $movie['title'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/styles.css">
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
                    <li class="nav-item"><a href="logout.php" class="btn btn-danger">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="row mt-4">
            <div class="col-md-4 text-center">
                <img src="<?php echo file_exists("images/" . $movie['image']) ? "images/" . $movie['image'] : 'images/placeholder.jpg'; ?>" class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($movie['title']); ?>">
            </div>
            <div class="col-md-8">
                <h2 class="display-5 fw-bold"> <?php echo htmlspecialchars($movie['title']); ?> </h2>
                <p class="lead"> <?php echo nl2br(htmlspecialchars($movie['description'])); ?> </p>
                <br>
                <h3>Trailer</h3>
                <iframe width="100%" height="400" src="<?php echo $movie['trailer']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" sty allowfullscreen></iframe>
                <br style="margin-bottom: 50px;">
                <h4 class="text-primary"> Average Rating: <?php echo round($avgRating, 1); ?> / 5</h4>
                <form action="add_favorite.php" method="post" onsubmit="return confirmFavorite();">
                    <input type="hidden" name="movie_id" value="<?php echo $movieId; ?>">
                    <button type="submit" class="btn btn-success">Add to Favorites</button>
                </form>
            </div>
        </div>

        <div class="mt-5">
            <h3 class="fw-bold">Reviews</h3>
            <?php if ($reviews) : ?>
                <?php foreach ($reviews as $review) : ?>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title text-primary"> <?php echo htmlspecialchars($review['username']); ?> </h5>
                            <p class="card-text"> <?php echo nl2br(htmlspecialchars($review['review'])); ?> </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-muted">No reviews yet.</p>
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <h3 class="fw-bold">Add a Review</h3>
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="alert alert-info"> <?php echo $_SESSION['message'];
                                                unset($_SESSION['message']); ?> </div>
            <?php endif; ?>
            <form action="add_review.php" method="post">
                <input type="hidden" name="movie_id" value="<?php echo $movieId; ?>">
                <div class="mb-3">
                    <label for="rating" class="form-label">Your Rating</label>
                    <select name="rating" class="form-select" required>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Good</option>
                        <option value="3">3 - Average</option>
                        <option value="2">2 - Poor</option>
                        <option value="1">1 - Terrible</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="review" class="form-label">Your Review</label>
                    <textarea name="review" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script>
        function confirmFavorite() {
            return confirm("Are you sure you want to add this movie to your favorites?");
        }
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>