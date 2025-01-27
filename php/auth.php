<?php
include "../db_conn.php";

session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name']; 
				$_SESSION['user_role'] = $user['role'];

                if ($user['role'] == 1) {
                    // Role 1: Admin
                    header("Location: ../admin.php"); 
                } else if ($user['role'] == 2) {
                    // Role 2: Normal User
                    header("Location: ../admin.php"); 
                }
                exit;
            } else {
                // Password is incorrect
                $_SESSION['message'] = "Your password is incorrect.";
                header("Location: ../login.php"); 
                exit;
            }
        } else {
            // User not found
            $_SESSION['message'] = "Your email is incorrect.";
            header("Location: ../login.php"); 
            exit;
        }
    } else {
        $_SESSION['message'] = "Please provide both email and password.";
        header("Location: ../login.php");
        exit;
    }
} else {
    // Nese nuk permbushet forma
    header("Location: ../login.php");
    exit;
}
?>
