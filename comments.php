<?php
include "db_conn.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    $book_id = intval($_POST['book_id']); 

    if (!empty($comment) && $book_id > 0) {
        $sql = "INSERT INTO comments (book_id, comment_text) VALUES (:book_id, :comment)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: seemore.php?id=" . $book_id . "&success=1");
        } else {
            echo "Failed to submit the comment.";
        }
    } else {
        echo "Comment cannot be empty, and a valid book ID is required.";
    }
}
?>