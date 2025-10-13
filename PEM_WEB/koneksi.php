<?php
$host = "localhost";
$username = "lamurah_user";  // atau "root" jika menggunakan default
$password = "lamurah_password123";  // atau "" jika menggunakan root tanpa password
$database = "lamurah_store";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// Function untuk keamanan
function sanitize($data) {
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(trim($data)));
}
?>