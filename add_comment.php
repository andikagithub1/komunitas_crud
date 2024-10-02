<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $username = $_POST['username'];
    $content = $_POST['content'];

    $sql = "INSERT INTO comments (post_id, username, content) VALUES ('$post_id', '$username', '$content')";

    if ($conn->query($sql) === TRUE) {
        header("Location: posts.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
