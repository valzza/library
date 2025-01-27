<?php  
include "db_conn.php";

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #8e4e1d;">
    <div class="login-container">
        
        <form action="php/auth.php" method="POST">
        <h1>LOGIN</h1>
        <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);
            }
            ?>
            <label>Email address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label>Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <div>
            <button type="submit" name="login" class="login-btn">Login</button>
            <p class="signup-btn">Don't have an account? <span><a href="signup.php">SIGN UP</a></span></p>
            <a href="index.php" class="back-link">Go Back</a>
        </div>
        </form>
    </div>
</body>
</html>