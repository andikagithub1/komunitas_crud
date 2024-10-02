<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komunitas Kami</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Tambahkan file CSS eksternal -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background: url('img/hero.jpg') no-repeat center center;
            background-size: cover;
            height: 300px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            color: black;
        }
        .hero p {
            font-size: 1.2rem;
        }
        .card {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Komunitas Kami</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="posts.php">Postingan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Daftar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="hero">
        <div>
            <h1>Selamat Datang di Komunitas Kami</h1>
            <p>Bergabunglah dan berbagi pengalaman bersama!</p>
            <a href="register.php" class="btn btn-primary btn-lg">Daftar Sekarang</a>
        </div>
    </div>

    <div class="container">
        <h2 class="text-center mb-4">Postingan Terbaru</h2>
        <div class="row">
            <?php
            // Menampilkan 3 postingan terbaru
            $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars(substr($row['content'], 0, 100)) . '...</p>';
                    echo '<a href="posts.php" class="btn btn-primary">Lihat Selengkapnya</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Tidak ada postingan terbaru.</p>';
            }
            ?>
        </div>
    </div>

    <footer class="bg-light text-center py-4">
        <p>&copy; 2024 Komunitas Kami. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
