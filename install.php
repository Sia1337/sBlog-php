<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $servername  = $_POST['hostname'];
    $usernameDB = $_POST['username'];
    $passwordDB = $_POST['password'];
    $dbname = $_POST['database'];

    // Veritabanı bağlantısı oluştur
    $conn = new mysqli($servername, $usernameDB, $passwordDB);

    // Bağlantı hatasını kontrol et
    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

        // Veritabanını seç
        $conn->select_db($dbname);

        // Kullanıcılar tablosunu oluşturma
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL
        )";
        $conn->query($sql);

        // Kategoriler tablosunu oluşturma
        $sql = "CREATE TABLE IF NOT EXISTS categories (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL
        )";
        $conn->query($sql);

        // Gönderiler tablosunu oluşturma
        $sql = "CREATE TABLE IF NOT EXISTS posts (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            category_id INT(11) UNSIGNED,
            title VARCHAR(255) NOT NULL,
            content TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        )";
        $conn->query($sql);

    // Veritabanı bağlantısını kapat
    $conn->close();

    // Config dosyasını oluştur
    $config = <<<EOL
<?php
\$servername  = '$servername';
\$usernameDB = '$usernameDB';
\$passwordDB = '$passwordDB';
\$dbname = '$dbname';

// Veritabanı bağlantısı oluştur
\$conn = new mysqli(\$servername, \$usernameDB, \$passwordDB, \$dbname);

// Bağlantı hatasını kontrol et
if (\$conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . \$conn->connect_error);
}
?>
EOL;

    // Config dosyasını oluşturulan içerikle kaydet
    file_put_contents('config.php', $config);

    // Başarılı mesajını göster
    $message = "Veritabanı tabloları oluşturuldu ve config dosyası kaydedildi.";

    // Diğer işlemleri yapmak ya da yönlendirme yapmak için devam edebilirsiniz
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MySQL Yapılandırma</title>
</head>
<body>
    <h2>MySQL Yapılandırma</h2>

    <?php if (isset($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php else : ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="hostname">MySQL Host Adı:</label>
            <input type="text" name="hostname" id="hostname" required>

            <label for="username">MySQL Kullanıcı Adı:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">MySQL Şifre:</label>
            <input type="password" name="password" id="password">

            <label for="database">Veritabanı Adı:</label>
            <input type="text" name="database" id="database" required>

            <button type="submit">Kaydet</button>
        </form>
    <?php endif; ?>
</body>
</html>
