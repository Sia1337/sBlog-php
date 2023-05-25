<?php
session_start();

// Kullanıcı oturum açmış mı kontrol et
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Veritabanı bağlantısı
require_once "config.php";

// Hata mesajı
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];

    // Veritabanına yeni gönderiyi ekle
    $sql = "INSERT INTO posts (category_id, title, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $category, $title, $content);

    if ($stmt->execute()) {
        // Gönderi başarıyla eklendi, kullanıcıyı ana sayfaya yönlendir
        header("Location: index.php");
        exit();
    } else {
        $error = "Gönderi eklenirken bir hata oluştu.";
    }
}

// Kategorileri veritabanından al
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
$categories = $result->fetch_all(MYSQLI_ASSOC);

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Yazısı Ekle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Blog Yazısı Ekle</h2>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php if (!empty($error)) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <div>
                <label for="title">Başlık:</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div>
                <label for="category">Kategori:</label>
                <select name="category" id="category" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="content">İçerik:</label>
                <textarea name="content" id="content" rows="5" required></textarea>
            </div>

            <div>
                <button type="submit">Gönder</button>
            </div>
        </form>
    </div>
</body>
</html>