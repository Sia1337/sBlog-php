<?php
// Veritabanı bağlantısı
require_once "config.php";

// Blog ID'sini al
if (isset($_GET['id'])) {
    $blogId = $_GET['id'];

    // Blog verilerini veritabanından al
    $sql = "SELECT * FROM posts WHERE id = '$blogId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
        $created_at = $row['created_at'];
    } else {
        echo "Blog bulunamadı.";
        exit();
    }
} else {
    echo "Geçersiz blog ID'si.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Detayları</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .blog-details {
            margin-bottom: 20px;
        }

        .blog-details h2 {
            margin-bottom: 10px;
        }

        .blog-details p {
            margin-bottom: 5px;
        }

        .blog-details .created-at {
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blog Detayları</h1>

        <div class="blog-details">
            <h2><?php echo $title; ?></h2>
            <p><?php echo $content; ?></p>
            <p class="created-at">Tarih: <?php echo $created_at; ?></p>
        </div>

        <a href="index.php">Ana Sayfaya Geri Dön</a>
    </div>
</body>
</html>