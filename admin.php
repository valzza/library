<?php  
session_start();

if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email']) &&
	isset($_SESSION['user_role'])) {

	include "db_conn.php";

	include "php/func-book.php";
    $books = get_all_books($conn);

	include "php/func-author.php";
    $authors = get_all_author($conn);

	include "php/func-category.php";
    $categories = get_all_categories($conn);

    $user_id = $_SESSION['user_id'];
    $user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $user_query->execute([$user_id]);
    $user = $user_query->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ADMIN</title>
	<!-- For icons -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
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
	  <?php if ($_SESSION['user_role'] == 1) { ?>
      <ul class="nav-links">
        <li class="nav-item"><a class="nav-link-active" href="index.php">Home</a></li>
        <li><a href="add-book.php"> <i class="lni lni-circle-plus"></i> Add Book</a></li>
        <li><a href="add-author.php"><i class="lni lni-circle-plus"></i> Add Author</a></li>
        <li><a href="add-category.php"><i class="lni lni-circle-plus"></i> Add Category</a></li>
      </ul>
	  <?php }?>
	  <?php if ($_SESSION['user_role'] == 2) { ?>
      <ul class="nav-links">
        <li class="nav-item"><a class="nav-link-active" href="index.php">Home</a></li>
        <li><a href="#allbooks">All Books</a></li>
        <li><a href="#categories">Categories</a></li>
        <li><a href="#authors">Authors</a></li>
      </ul>
	  <?php }?>
      <div class="auth-links">
          <a href="logout.php">Log out</a>
      </div>
    </nav>
  </header>
	<div class="container">
       <form action="search.php"
             method="get" 
             style="width: 100%; max-width: 30rem">

       	<div class="input-group my-5">
		  <input type="text" 
		         class="form-control"
		         name="key" 
		         placeholder="Search Book..." 
		         aria-label="Search Book..." 
		         aria-describedby="basic-addon2">

		  <button class="input-group-text btn btn-primary" id="basic-addon2">
			Search
		  </button>
		</div>
    <!-- User Profile Section -->
	 <?php if($_SESSION["user_role"] == 2) { ?>
    <div class="user-profile mt-5">
      <h3><i class="lni lni-user"></i></i>  User Profile</h3>
      <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </div>
	<?php } ?>
	<?php if($_SESSION["user_role"] == 1) { ?>
    <div class="user-profile mt-5">
      <h3><i class="lni lni-user"></i></i>  Admin Dashboard</h3>
      <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </div>
	<?php } ?>
       </form>
       <div class="mt-5"></div>
        <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>


        <?php  if ($books == 0) { ?>
        	<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/emptyy.jpg" 
        	          width="100">
        	     <br>
			  There is no book in the database
		  </div>
        <?php }else {?>


        <!-- List of all books -->
		<h4 id="allbooks">All Books</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Author</th>
					<th>Description</th>
					<th>Category</th>
					<?php if ($_SESSION['user_role'] == 1) { ?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
			  <?php 
			  $i = 0;
			  foreach ($books as $book) {
			    $i++;
			  ?>
			  <tr>
				<td><?=$i?></td>
				<td>
					<img width="100"
					     src="uploads/cover/<?=$book['cover']?>" >
					<a  class="link-dark d-block
					           text-center"
					    href="uploads/files/<?=$book['file']?>">
					   <?=$book['title']?>	
					</a>
						
				</td>
				<td>
					<?php if ($authors == 0) {
						echo "Undefined";}else{ 

					    foreach ($authors as $author) {
					    	if ($author['id'] == $book['author_id']) {
					    		echo $author['name'];
					    	}
					    }
					}
					?>

				</td>
				<td><?=$book['description']?></td>
				<td>
					<?php if ($categories == 0) {
						echo "Undefined";}else{ 

					    foreach ($categories as $category) {
					    	if ($category['id'] == $book['category_id']) {
					    		echo $category['name'];
					    	}
					    }
					}
					?>
				</td>
				<?php if ($_SESSION['user_role'] == 1) { ?>
				<td>
					<a href="edit-book.php?id=<?=$book['id']?>" 
					   class="btn btn-warning">
					   Edit</a>

					<a href="php/delete-book.php?id=<?=$book['id']?>" 
					   class="btn btn-danger">
				       Delete</a>
				</td>
				<?php } ?>
			  </tr>
			  <?php } ?>
			</tbody>
		</table>
	   <?php }?>

        <?php  if ($categories == 0) { ?>
        	<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/emptyy.jpg" 
        	          width="100">
        	     <br>
			  There is no category in the database
		    </div>
        <?php }else {?>
	    <!-- List of all categories -->
		<h4 id="categories" class="mt-5">All Categories</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Category Name</th>
					<?php if ($_SESSION['user_role'] == 1) { ?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$j = 0;
				foreach ($categories as $category ) {
				$j++;	
				?>
				<tr>
					<td><?=$j?></td>
					<td><?=$category['name']?></td>
					<?php if ($_SESSION['user_role'] == 1) { ?>
					<td>
						<a href="edit-category.php?id=<?=$category['id']?>" 
						   class="btn btn-warning">
						   Edit</a>

						<a href="php/delete-category.php?id=<?=$category['id']?>" 
						   class="btn btn-danger">
					       Delete</a>
					</td>
					<?php } ?>
				</tr>
			    <?php } ?>
			</tbody>
		</table>
	    <?php } ?>

	    <?php  if ($authors == 0) { ?>
        	<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/emptyy.jpg" 
        	          width="100">
        	     <br>
			  There is no author in the database
		    </div>
        <?php }else {?>
	    <!-- List of all Authors -->
		<h4 id="authors" class="mt-5">All Authors</h4>
         <table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Author Name</th>
					<?php if ($_SESSION['user_role'] == 1) { ?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$k = 0;
				foreach ($authors as $author ) {
				$k++;	
				?>
				<tr>
					<td><?=$k?></td>
					<td><?=$author['name']?></td>
					<?php if ($_SESSION['user_role'] == 1) { ?>
					<td>
						<a href="edit-author.php?id=<?=$author['id']?>" 
						   class="btn btn-warning">
						   Edit</a>

						<a href="php/delete-author.php?id=<?=$author['id']?>" 
						   class="btn btn-danger">
					       Delete</a>
					</td>
					<?php } ?>
				</tr>
			    <?php } ?>
			</tbody>
		</table> 
		<?php } ?>
	</div>
</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
} ?>