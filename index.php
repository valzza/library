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

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to Our Library</h1>
      <h2>Discover Your Next Great Read</h2>
      <a href="#books" class="btn-explore">Explore Books</a>
    </div>
  </section>

  <!-- Book Collection Section -->
  <main>
    <div class="main">
    <h1 class="main-headers">Top Books for you to read</h1>
    </div>
    <form action="search.php" method="get" style="width: 100%; max-width: 30rem; margin:auto;">
      <div class="input-group my-5">
		    <input type="text" 
		       class="form-control"
		       name="key" 
	         placeholder="Search Book..." 
	         aria-describedby="basic-addon2">

        <button class="input-group-text btn btn-primary" id="basic-addon2">
            Search
        </button>
		  </div>
    </form>
    
    <section id="books" class="book-collection d-flex ">
    <?php if ($books == 0){ ?>
				<div class="alert alert-secondary text-center p-5" role="alert">
        	<img src="uploads/images/empty.jpg" width="100">
          <br>
			      There is no book in the database
		    </div>
			<?php }else{ ?>
      <!-- <div class="pdf-list d-flex flex-wrap"> -->
      <?php
      $count = 0; 
      foreach ($books as $book) { ?>
        <div class="card m-1">
        <img src="uploads/cover/<?=$book['cover']?>" class="book-image">
					<div class="card-body">
						<h5 class="card-title">
							<?=$book['title']?>
						</h5>
							<i><b>By:
								<?php foreach($authors as $author){ 
									if ($author['id'] == $book['author_id']) {
										echo $author['name'];
										break;
									}?>
                <?php } ?>
                <br>
              </b></i>
							<br>
              <i><b>Category:
								<?php foreach($categories as $category){ 
									if ($category['id'] == $book['category_id']) {
										echo $category['name'];
										break;
									}
								?>
								<?php } ?>
							<br></b></i>
              </p>
              <?php
              if (isset($_GET['id'])) {
                $id = intval($_GET['id']); // me check a osht int, nese jo e kthen ne int

                $sql = "SELECT * FROM books WHERE id = :id"; //merr id specifike
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $book = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                
                <?php } ?>
                <a href="seemore.php?id=<?= $book['id'] ?>" class="btn btn-primary">See more</a>
					</div>
				</div>
        
				<?php  
            $count++;
            if($count >= 5){
              break;
            }} ?>
			</div>
		<?php } ?>
    </section>
    <?php ?>
    <section>
      <div class="main-headers">
        <h2>For more books you need to <a href="login.php">Log In</a> or <a href="signup.php">Sign Up</a></h2>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <p>© Library 2024</p>
  </footer>
</body>
</html>
