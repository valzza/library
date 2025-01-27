
<?php 
session_start();

if (!isset($_GET['key']) || empty($_GET['key'])) {
	header("Location: index.php");
	exit;
}
$key = $_GET['key'];

include "db_conn.php";

include "php/func-book.php";
$books = search_books($conn, $key);

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

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css">

</head>
<body>
<header>
    <nav class="navbar">
      <div class="logo">
	  <a href="index.php"><img src="uploads/images/logo1.png" alt="Logo" id="logo"> </a>
      </div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="aboutus.html">About Us</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
      <div class="auth-links">
      <?php if (isset($_SESSION['user_id'])) {?>
		      <a class="nav-link" href="admin.php">Admin</a>
		  <?php }else{ ?>
          <a href="login.php">Log In</a>
          <a href="signup.php">Sign Up</a>
		  <?php } ?>
      </div>
    </nav>
	</header>
	<br>
	<div class="text-center fst-italic fs-5 m-auto p-3">
		Search result for <b><?=$key?></b>
	</div>
		<div class="m-auto">
			<?php if ($books == 0){ ?>
				<div class="alert alert-secondary text-center p-5 justify-center" role="alert">
        		<img src="uploads/images/empty.jpg" width="100">
        	     <br>
				  The key <b>"<?=$key?>"</b> didn't match to any record
		           in the database
			  </div>
			<?php }else{ ?>
				<?php foreach ($books as $book) { ?>
					<div class="book-collection">
				<div class="details-container">
					<!-- Book Cover -->
					<img src="../uploads/cover/<?=$book['cover']?>" class="book-cover img-fluid" alt="Book Cover">
					</div>
					<div class="col-md-auto">
					<!-- Book Details -->
					<h5 class="card-title">
						Title: <?=$book['title']?>
					</h5>
					<p class="card-text">
						<i><b>By:
						<?php foreach($authors as $author) { 
							if ($author['id'] == $book['author_id']) {
							echo $author['name'];
							break;
							}
						} ?>
						</b></i>
						<br><?=$book['description']?>
						<br><i><b>Category:
						<?php foreach($categories as $category) { 
							if ($category['id'] == $book['category_id']) {
							echo $category['name'];
							break;
							}
						} ?>
						</b></i>
					</p>
					<a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Read the Book</a>
					<a href="uploads/files/<?=$book['file']?>" class="btn btn-primary" download="<?=$book['title']?>">Download</a>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>
		</div>
	</div>
</body>
</html>