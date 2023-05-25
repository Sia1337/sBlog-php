<?php
$servername  = '';
$usernameDB = '';
$passwordDB = '';
$dbname = '';

// Veritabanı bağlantısı oluştur
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Bağlantı hatasını kontrol et
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}
?>
