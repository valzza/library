<?php  
session_start();

if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	if (!isset($_GET['id'])) {
        header("Location: admin.php");
        exit;
	}

	$id = $_GET['id'];

	include "db_conn.php";

	include "php/func-book.php";
    $book = get_book($conn, $id);
    
    if ($book == 0) {
        header("Location: admin.php");
        exit;
    }

	include "php/func-category.php";
    $categories = get_all_categories($conn);

	include "php/func-author.php";
    $authors = get_all_author($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Book</title>
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
      <ul class="nav-links">
        <li class="nav-item"><a class="nav-link-active" href="admin.php">Profile</a></li>
        <li><a href="add-book.php"> <i class="lni lni-circle-plus"></i> Add Book</a></li>
        <li><a href="add-author.php"><i class="lni lni-circle-plus"></i> Add Author</a></li>
        <li><a href="add-category.php"><i class="lni lni-circle-plus"></i> Add Category</a></li>
      </ul>
      <div class="auth-links">
          <a href="logout.php">Log out</a>
      </div>
    </nav>
  </header>
  <div class="container">
     <form action="php/edit-book.php"
           method="post"
           enctype="multipart/form-data" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		Edit Book
     	</h1>
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
     	<div class="mb-3">
		    <label class="form-label">
		           Book Title
		           </label>
		    <input type="text" 
		           hidden
		           value="<?=$book['id']?>" 
		           name="book_id">

		    <input type="text" 
		           class="form-control"
		           value="<?=$book['title']?>" 
		           name="book_title">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Description
		           </label>
		    <input type="text" 
		           class="form-control" 
		           value="<?=$book['description']?>"
		           name="book_description">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Author
		           </label>
		    <select name="book_author"
		            class="form-control">
		    	    <option value="0">
		    	    	Select author
		    	    </option>
		    	    <?php 
                    if ($authors == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($authors as $author) { 
		    	    	if ($book['author_id'] == $author['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$author['id']?>">
		    	    	  <?=$author['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$author['id']?>">
							<?=$author['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Category
		           </label>
		    <select name="book_category"
		            class="form-control">
		    	    <option value="0">
		    	    	Select category
		    	    </option>
		    	    <?php 
                    if ($categories == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($categories as $category) { 
		    	    	if ($book['category_id'] == $category['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$category['id']?>">
		    	    	  <?=$category['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$category['id']?>">
							<?=$category['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Cover
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="book_cover">

		     <input type="text" 
		           hidden
		           value="<?=$book['cover']?>" 
		           name="current_cover">

		    <a href="uploads/cover/<?=$book['cover']?>"
		       class="link-dark">Current Cover</a>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           File
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="file">

		     <input type="text" 
		           hidden
		           value="<?=$book['file']?>" 
		           name="current_file">

		    <a href="uploads/files/<?=$book['file']?>"
		       class="link-dark">Current File</a>
		</div>

	    <button type="submit" 
	            class="btn btn-primary">
	            Update</button>
     </form>
	</div>
</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
} ?>