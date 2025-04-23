<?php
session_start();
require 'db.php';


$pageTitle = "Dashboard";

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
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Saira+Condensed:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="css/globals.css" />
  <link rel="stylesheet" href="css/styleguide.css" />
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="img/logo.png" alt="Logo" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="login.php" class="btn btn-primary">Login</a>
          </li>
          <li class="nav-item">
            <a href="register.php" class="btn btn-danger">Signup</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Carousel -->
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
  <!-- Showcase -->
  <section class="banner">
    <div class="banner-content">
      <button class="btn btn-primary my-2">Fantasy</button>
      <button class="btn btn-danger my-2">Action</button>
      <h1>July 26th</h1>
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

  <div class="row">
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
            <li>
              <a href="#">Login</a>
            </li>

            <li>
              <a href="#">Movies</a>
            </li>

            <li>
              <a href="#">Home</a>
            </li>

            <li>
              <a href="#">Favourites</a>
            </li>
          </ul>

          <li>
            <a href="#" class="btn light">Sign Up</a>
          </li>


        </div>

        <div class="links">
          <ul>
            <li>
              <a href="#">Privacy Policy</a>
            </li>

            <li>
              <a href="#">Terms & Conditions</a>
            </li>
          </ul>

        </div>
        <p class="copyright"> © Copyright 2024. All Rights Reserved. MovieBuzz </p>
      </div>
    </div>
  </footer>

  <!-- Showcase
        <div class="MovieBuzz-movie">
            <div class="div">
              <div class="overlap">
                <div class="overlap-group">
                  <div class="overlap-2">
                      <img class="vector" src="img/fb_ic.png" />
                    <img class="group" src="img/linkedin_ic.png" />
                    <img class="img" src="img/insta_ic.png" />
                    <div class="ellipse"></div>
                    <div class="ellipse-2"></div>
                    <div class="ellipse-3"></div>
                    <div class="frame">
                      <p class="JULY-DEADPOOL">
                        <span class="text-wrapper">JULY 26TH  </span>
                        <br>
                        <span class="span">DEADPOOL</span>
                        <span class="text-wrapper"> 3</span>
                      </p>
                    </div>
                    <div class="FOLLOW-US-wrapper">
                        <p class="FOLLOW-US">
                          <span class="text-wrapper-2">FOLLOW US : <br /> </span>
                        </p>
                      </div>
                    <img class="group-2" src="img/videoic.png" />
              <div class="watch-trailer-wrapper"><div class="watch-trailer">WATCH TRAILER</div>
            </div>
              <img class="frame-5" src="img/fav.png" />
              <div class="div-wrapper"><div class="text-wrapper-3">ADD TO FAVOURITE</div>
            </div>
            <img class="frame-5" src="img/share.png" />
              <div class="share-wrapper"><div class="share">SHARE</div>
            </div>
             
          <div class="view-all">
            <div class="view-all-2">VIEW ALL</div>
        </div>
        <img class="more-than" src="img/more-than-1.png" />
      </div>
            <div class="frame-9">
              <div class="ellipse-4"></div>
              <div class="ellipse-5"></div>
              <div class="ellipse-6"></div>
           
        </div>
        */
-->

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>