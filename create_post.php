<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Proses upload gambar
    $image = $_FILES['image']['name'];
    $target = "img/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO posts (title, content, image) VALUES ('$title', '$content', '$image')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: posts.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Postingan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Komunitas Kami</a>
    </nav>

    <div class="container mt-5">
        <h1>Buat Postingan</h1>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Judul" required>
            </div>
            <div class="form-group">
                <textarea name="content" class="form-control" placeholder="Konten" required></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Kirim</button>
        </form>
    </div>

    <footer class="bg-light text-center py-4">
        <p>&copy; 2024 Komunitas Kami. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
