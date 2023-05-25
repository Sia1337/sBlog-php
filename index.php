<!DOCTYPE html>
<html>
<head>
    <title>Ana Sayfa</title>
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
        }

        .links {
            text-align: center;
        }

        .links a {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background-color: #ccc;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
        }

        .links a:hover {
            background-color: #999;
        }

        .blog-list {
            margin-top: 20px;
        }

        .blog-item {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 3px;
        }

        .blog-item h2 {
            margin-top: 0;
        }

        .blog-item p {
            margin-bottom: 10px;
        }

        .blog-item a {
            display: inline-block;
            background-color: #ccc;
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .blog-item a:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ana Sayfa</h1>

        <?php
        session_start();

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<div class='message'>Hoş geldiniz, $username! Giriş yaptınız.</div>";
            echo "<div class='links'>";
            echo "<a href='profile.php'>Profil</a>";
            echo "<a href='logout.php'>Çıkış yap</a>";
            echo "</div>";
        } else {
            echo "<div class='message'>Henüz giriş yapmadınız.</div>";
            echo "<div class='links'>";
            echo "<a href='login.php'>Giriş yap</a>";
            echo "<a href='register.php'>Kayıt ol</a>";
            echo "</div>";
        }

        // Blog yazılarını sorgula
        require_once "config.php";
        $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

        if ($conn->connect_error) {
            die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
        }

        $sql = "SELECT posts.*, categories.name AS category_name 
                FROM posts 
                INNER JOIN categories ON posts.category_id = categories.id 
                ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='blog-list'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='blog-item'>";
                echo "<h2>" . $row['title'] . "</h2>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<p>Kategori: " . $row['category_name'] . "</p>";
                echo "<p>Tarih: " . $row['created_at'] . "</p>";
                echo "<p><a href='blog_details.php?id=" . $row['id'] . "'>Devamını Oku</a></p>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>Henüz blog yazısı bulunmamaktadır.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
