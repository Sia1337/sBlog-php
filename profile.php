<!DOCTYPE html>
<html>
<head>
    <title>Profil Sayfası</title>
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-info h3 {
            margin-bottom: 5px;
        }

        .profile-info p {
            color: #777;
        }

        .logout-button {
            text-align: center;
            margin-top: 20px;
        }

        .logout-button a {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            text-decoration: none;
        }

        .blog-button {
            text-align: center;
            margin-top: 20px;
        }

        .blog-button a {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 3px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Kullanıcı oturum açmış mı kontrol et
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Oturum açmış kullanıcının bilgilerini al
    $username = $_SESSION['username'];

    // Diğer kullanıcı bilgilerini veritabanından çekmek için gerekli sorguları yapabilirsiniz
    // Örneğin: SELECT * FROM users WHERE username = '$username'
    ?>

    <div class="container">
        <h2>Profil Sayfası</h2>

        <div class="profile-info">
            <h3>Hoş geldiniz, <?php echo $username; ?>!</h3>
            <!-- Diğer kullanıcı bilgilerini burada görüntüleyebilirsiniz -->
            <p>Profil sayfanızın içeriği buraya gelecek.</p>
        </div>

        <div class="blog-button">
            <a href="blog-add.php">Blog Ekle</a>
        </div>

        <div class="logout-button">
            <a href="logout.php">Çıkış Yap</a>
        </div>
    </div>
</body>
</html>