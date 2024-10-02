<?php
session_start();
include 'config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah ID postingan tersedia
if (!isset($_GET['id'])) {
    header("Location: posts.php");
    exit;
}

// Ambil data postingan berdasarkan ID
$post_id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id='$post_id'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: posts.php");
    exit;
}

$post = $result->fetch_assoc();

// Proses edit postingan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Proses upload gambar (jika ada)
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "img/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $post['image']; // Jika tidak ada gambar baru, gunakan gambar lama
    }

    $sql = "UPDATE posts SET title='$title', content='$content', image='$image' WHERE id='$post_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: posts.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Postingan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Komunitas Kami</a>
    </nav>

    <div class="container mt-5">
        <h1>Edit Postingan</h1>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Judul" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="form-group">
                <textarea name="content" class="form-control" placeholder="Konten" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="image" class="form-control">
                <small>Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>

    <footer class="bg-light text-center py-4">
        <p>&copy; 2024 Komunitas Kami. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
