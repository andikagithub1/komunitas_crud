<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postingan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Komunitas Kami</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="create_post.php">Buat Postingan</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Postingan</h1>
        <div class="list-group">
            <?php
            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="list-group-item">';
                    echo '<h5>' . htmlspecialchars($row['title']) . '</h5>';
                    echo '<p>' . htmlspecialchars($row['content']) . '</p>';
                    if ($row['image']) {
                        echo '<img src="img/' . htmlspecialchars($row['image']) . '" class="img-fluid" alt="Gambar Postingan">';
                    }
                    echo '<small>' . $row['created_at'] . '</small>';

                    // Hitung jumlah komentar
                    $post_id = $row['id'];
                    $comment_count_sql = "SELECT COUNT(*) as count FROM comments WHERE post_id='$post_id'";
                    $comment_count_result = $conn->query($comment_count_sql);
                    $comment_count = $comment_count_result->fetch_assoc()['count'];

                    echo '<p><small>' . $comment_count . ' Komentar</small></p>';

                    // Link untuk mengedit postingan
                    echo '<div class="mt-2">';
                    echo '<a href="edit_post.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a>';
                    echo '</div>';

                    echo '<h6>Komentar:</h6>';

                    // Ambil komentar untuk postingan ini
                    $comment_sql = "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY created_at DESC";
                    $comment_result = $conn->query($comment_sql);

                    if ($comment_result->num_rows > 0) {
                        while ($comment = $comment_result->fetch_assoc()) {
                            echo '<div class="bg-light p-2 mb-2">';
                            echo '<strong>' . htmlspecialchars($comment['username']) . '</strong>';
                            echo '<p>' . htmlspecialchars($comment['content']) . '</p>';
                            echo '<small>' . $comment['created_at'] . '</small>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Tidak ada komentar.</p>';
                    }

                    // Form komentar
                    if (isset($_SESSION['user_id'])) {
                        echo '<form method="POST" action="add_comment.php" class="mt-3">';
                        echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                        echo '<div class="form-group">';
                        echo '<input type="text" name="username" class="form-control" placeholder="Nama Anda" required>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<textarea name="content" class="form-control" placeholder="Komentar" required></textarea>';
                        echo '</div>';
                        echo '<button type="submit" class="btn btn-primary">Kirim Komentar</button>';
                        echo '</form>';
                    } else {
                        echo '<p>Silakan <a href="login.php">login</a> untuk menambahkan komentar.</p>';
                    }

                    echo '</div>'; // end of list-group-item
                }
            } else {
                echo '<p>Tidak ada postingan.</p>';
            }
            ?>
        </div>
    </div>

    <footer class="bg-light text-center py-4">
        <p>&copy; 2024 Komunitas Kami. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
