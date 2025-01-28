<?php
include "../db_conn.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // LOGIN LOGIC
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!empty($email) && !empty($password)) {
            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ($password === $user['password']) { //nese nuk osht hash pass
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['user_role'] = $user['role'];

                    if ($user['role'] == 1) {
                        header("Location: ../admin.php");
                    } else {
                        header("Location: ../admin.php");
                    }
                    exit;
                } else {
                    $_SESSION['message'] = "Incorrect password.";
                    header("Location: ../login.php");
                    exit;
                }
            } else {
                $_SESSION['message'] = "Email not found.";
                header("Location: ../login.php");
                exit;
            }
        } else {
            $_SESSION['message'] = "Please fill out both email and password.";
            header("Location: ../login.php");
            exit;
        }
    } elseif (isset($_POST['signup'])) {
        // SIGNUP LOGIC
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['message'] = "Email already exists. Please use a different email.";
                header("Location: ../signup.php");
                exit();
            } else {
                $query = "INSERT INTO users (full_name, email, password) 
                          VALUES (:full_name, :email, :password)";
                $stmt = $conn->prepare($query);
                $stmt->execute([
                    ':full_name' => $full_name,
                    ':email' => $email,
                    ':password' => $password 
                ]);

                $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['full_name'];

                header("Location: ../admin.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = "Error: " . $e->getMessage();
            header("Location: ../signup.php");
            exit();
        }
    } else {
        header("Location: ../signup.php");
        exit();
    }
} else {
    header("Location: ../signup.php");
    exit();
}
?>
