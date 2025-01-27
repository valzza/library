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
   <!-- Contact Section -->
  <section class="contact-section">
    <div class="contact-box">
      <h2>Contact Us</h2>
      <ul class="contact-info">
        <li>Email: <a href="mailto:info@library.com">info@library.com</a></li>
        <li>Facebook: <a href="https://facebook.com" target="_blank">facebook.com/library</a></li>
        <li>Instagram: <a href="https://instagram.com" target="_blank">instagram.com/library</a></li>
        <li>Telephone: <a href="tel:+1234567890">+1 234 567 890</a></li>
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