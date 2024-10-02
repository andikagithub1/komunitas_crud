<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Cek apakah email ada di database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Buat token untuk reset password
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $sql = "INSERT INTO password_resets (email, token, expiry) VALUES ('$email', '$token', '$expiry')";
        $conn->query($sql);

        // Kirim email dengan link reset password
        $reset_link = "http://localhost/community_app/reset_password.php?token=$token";
        $subject = "Reset Password";
        $message = "Klik link berikut untuk mengatur ulang kata sandi Anda: $reset_link";
        mail($email, $subject, $message);

        echo "Email untuk reset password telah dikirim.";
    } else {
        echo "Email tidak terdaftar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Lupa Password</h2>
        <form method="POST" class="mt-3">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
        </form>
    </div>
</body>
</html>
