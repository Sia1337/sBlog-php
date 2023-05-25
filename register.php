<!DOCTYPE html>
<html>
<head>
    <title>Kayıt Ol</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .button-container {
            text-align: center;
        }

        .button-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .error-message {
            color: #f00;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
        require_once "config.php";

        $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

        if ($conn->connect_error) {
            die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
        }

        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Kullanıcı adının kullanılıp kullanılmadığını kontrol et
            $check_username = "SELECT * FROM users WHERE username = '$username'";
            $result = $conn->query($check_username);

            if ($result->num_rows > 0) {
                $error = "Bu kullanıcı adı zaten kullanılıyor.";
            } else {
                // Yeni kullanıcıyı veritabanına ekle
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert_user = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";

                if ($conn->query($insert_user) === TRUE) {
                    // Giriş yapmış gibi işaretle
                    session_start();
                    $_SESSION['username'] = $username;

                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Kayıt işlemi başarısız oldu.";
                }
            }
        }

        $conn->close();
    ?>

    <div class="container">
        <h1>Kayıt Ol</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Kullanıcı Adı:</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Şifre:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>E-posta:</label>
                <input type="email" name="email" required>
            </div>

            <div class="button-container">
                <input type="submit" name="register" value="Kayıt Ol">
            </div>
        </form>
    </div>
</body>
</html>
