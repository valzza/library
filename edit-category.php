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

	include "php/func-category.php";
    $category = get_category($conn, $id);

    if ($category == 0) {
        header("Location: admin.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Author</title>
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
     <form action="php/edit-category.php"
           method="post" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		Edit Category
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
		           	Category Name
		           </label>

		     <input type="text" 
		            value="<?=$category['id'] ?>" 
		            hidden
		            name="category_id">


		    <input type="text" 
		           class="form-control"
		           value="<?=$category['name'] ?>" 
		           name="category_name">
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