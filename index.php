<!DOCTYPE html>
<html lang="en">

 <?php
$servername = "remotemysql.com";
$username = "UO5aMFOKxs";
$password = "PGGh525shg";
$dbname = "UO5aMFOKxs";

// Create connection
$conn = new mysqli("remotemysql.com", "UO5aMFOKxs", "PGGh525shg", "UO5aMFOKxs");

session_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?> 

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Top 10 Movies</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Today's Top 10 Movies</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-sm-1">

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="http://www.palace-cinema.com/images/slide01.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="http://www.palace-cinema.com/images/slide02.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="https://www.whats-on-netflix.com/wp-content/uploads/2019/05/secret-life-pets-2-netflix-uk.jpg" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">

		  <?php
		  
			$sql = "SELECT id, title, poster, percentage, profit FROM topMovies";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo "<div class='col-lg-4 col-md-6 mb-4'>";
				echo "<div class='card h-100'>";
				echo "<a href='#'><img class='card-img-top' src='".$row['poster']."' alt=''></a>";
				echo "<div class='card-body'>";
				echo "<h4 class='card-title'>";
				echo "<a href='#'>".$row['title']."</a>";
				echo "</h4>";
				echo "<h5>Profit:".$row['profit']."</h5>";
				echo "<div class='card-footer'>";
				echo "<small>".$row['percentage']."</small>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
			} else {
				echo "0 results";
			}
			?>

        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php
	$conn->close();
?>