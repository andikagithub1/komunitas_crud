<?php
session_start();
include 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cek token di database
    $sql = "SELECT * FROM password_resets WHERE token='$token' AND expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        die("Token tidak valid atau sudah kedaluwarsa.");
    }

    // Proses reset password
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $result->fetch_assoc()['email'];

        // Update password di tabel users
        $sql = "UPDATE users SET password='$new_password' WHERE email='$email'";
        $conn->query($sql);

        // Hapus token dari tabel password_resets
        $sql = "DELETE FROM password_resets WHERE token='$token'";
        $conn->query($sql);

        echo "Password telah berhasil direset. Silakan login.";
    }
} else {
    die("Token tidak valid.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Reset Password</h2>
        <form method="POST" class="mt-3">
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Kata Sandi Baru" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Kata Sandi</button>
        </form>
    </div>
</body>
</html>
