<?php
require_once 'config.php';
require_once 'functions.php';

$error = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($username)) {
        $error[] = "Kullanıcı adı gereklidir.";
    }
    if (empty($email)) {
        $error[] = "E-posta adresi gereklidir.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Geçerli bir e-posta adresi giriniz.";
    }
    if (empty($password)) {
        $error[] = "Şifre gereklidir.";
    } elseif (strlen($password) < 6) {
        $error[] = "Şifre en az 6 karakter olmalıdır.";
    }
    if ($password !== $confirm_password) {
        $error[] = "Şifreler eşleşmiyor.";
    }

    // If no errors, proceed with registration
    if (empty($error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error[] = "Kayıt işlemi sırasında bir hata oluştu. Lütfen tekrar deneyin.";
        }

        $stmt->close();
    }
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Kaydı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Kullanıcı Kaydı</h2>
                <?php
                if ($success) {
                    echo '<div class="alert alert-success">Kayıt işlemi başarıyla tamamlandı. <a href="login.php">Giriş yapabilirsiniz</a>.</div>';
                } else {
                    if (!empty($error)) {
                        echo '<div class="alert alert-danger"><ul>';
                        foreach ($error as $err) {
                            echo '<li>' . htmlspecialchars($err) . '</li>';
                        }
                        echo '</ul></div>';
                    }
                ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Kullanıcı Adı:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-posta Adresi:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Şifre:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Şifre Tekrar:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Kayıt Ol</button>
                    </div>
                </form>
                <?php } ?>
                <p class="mt-3 text-center">Zaten hesabınız var mı? <a href="login.php">Giriş yapın</a></p>
            </div>
        </div>
    </div>
</body>
</html>