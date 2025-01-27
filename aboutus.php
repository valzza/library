<?php 
session_start();

include "db_conn.php";

include "php/func-book.php";
$books = get_all_books($conn);

include "php/func-author.php";
$authors = get_all_author($conn);

include "php/func-category.php";
$categories = get_all_categories($conn);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library</title>
  <link rel="icon" type="image/x-icon" href="uploads/images/logo1.png">
	<!-- For icons -->
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <!-- bootstrap 5 Js bundle CDN-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navigation Bar -->
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="index.php"><img src="uploads/images/logo1.png" alt="Logo" id="logo"> </a>
      </div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
      <div class="auth-links">
      <?php if (isset($_SESSION['user_id'])) {?>
		      <a  href="admin.php"> Profile  <i class="lni lni-user"></i></i></a>
		  <?php }else{ ?>
          <a href="login.php">Log In</a>
          <a href="signup.php">Sign Up</a>
		  <?php } ?>
      </div>
    </nav>
  </header>

  <main>
    <section class="container info-box" style="margin: auto;">
      <div class="">
        <h2>More information about the Library</h2>
        <ul class="">
          <p>
            Discover a world of literature at our online bookstore. 
            We curate a diverse collection, provide personalized recommendations, 
            and offer exceptional service to fuel your reading journey. 
            Welcome to a digital haven for book enthusiasts, where imagination knows no bounds.
          </p>
          <h2>Who are we?</h2>
          <p>
            We are a dedicated team behind a captivating bookstore web app. 
            With our curated collection and personalized recommendations, 
            we strive to create a remarkable reading experience for book enthusiasts like you. 
            Join us on this literary journey today!
            <br>
            We invite you to be a part of our vibrant literary community and embark on a journey of discovery and imagination.
          </p>
          <h2>Our Process</h2>
          <p>
            Embarking on our journey to create a web/app for our online book store was an exhilarating adventure. 
            With our vision in place, we harnessed the power of technology to bring our dream to life. 
            Our developers worked tirelessly, crafting an elegant and user-friendly interface that welcomed visitors 
            to a digital sanctuary of literature.
            <br>
            We knew that finding the perfect book was a journey in itself, 
            so we incorporated a sophisticated recommendation system. 
            Virtual book clubs flourished, connecting like-minded individuals across the globe, enriching their reading experiences.
          </p>
        </ul>
      </div>
    </section>
    <section class="container aboutus-box" style="margin:10px auto;">
      <div class="">
        <h2>Project Made By:</h2>
        <ul class="aboutus-info">
          <li>Valza Dalipi</li>
          <li>Toska Kastrati</li>
          <li>Jeta Murtezi</li>
        </ul>
      </div>
    </section>
    
   
  </main>

  <!-- Footer -->
  <footer>
    <p>© Library 2024</p>
  </footer>
</body>
</html>