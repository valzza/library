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
<?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        
            $sql = "SELECT * FROM books WHERE id = :id";
            $query = $conn->prepare($sql);
        
            $query->bindValue(':id', $id, PDO::PARAM_INT);
        
            $query->execute();
        
            $book = $query->fetch(PDO::FETCH_ASSOC);
        
            if ($book) {
                $authors = get_all_author($conn);
                $categories = get_all_categories($conn);
            } else {
                echo "Book not found.";
                exit;
            }
        } else {
            echo "No book selected.";
            exit;
        }
?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php if (isset($book)) { ?>
  <title><?php $book['title']?></title>
  <?php } ?>
  
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../style.css">
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

  <div class="book-collection">
  <div class="details-container">
      <img src="../uploads/cover/<?=$book['cover']?>" class="book-cover img-fluid" alt="Book Cover">
    </div>
    <div class="col-md-auto">
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
      <form action="comments.php" method="post" class="mt-3">
        <textarea name="comment" class="form-control" placeholder="Comments" required></textarea>
        <input type="hidden" name="book_id" value="<?=$book['id']?>">
        <br>
        <button class="btn btn-primary" type="submit">Submit</button>
      </form>
      <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success mt-3">
        Comment submitted successfully!
    </div>
<?php endif; ?>
    </div>
  </div>
</div>
</main>
</body>
</html>