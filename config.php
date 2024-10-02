<?php
$host = "localhost"; // Ganti jika perlu
$user = "root"; // Ganti jika perlu
$pass = ""; // Ganti jika perlu
$db_name = "community_db"; // Ganti sesuai nama database Anda

$conn = new mysqli($host, $user, $pass, $db_name);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
