<?php
require_once 'config.php';
require_once 'functions.php';

session_start();
require_login();

$page_title = "Profil Ayarları";
include 'header.php';

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_messages = [];

// Mevcut kullanıcı bilgilerini getir
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kullanıcı adı ve email validasyonu
    if (empty($username)) {
        $error_messages[] = "Kullanıcı adı boş bırakılamaz.";
    }
    if (empty($email)) {
        $error_messages[] = "E-posta adresi boş bırakılamaz.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Geçerli bir e-posta adresi giriniz.";
    }

    // Kullanıcı adı ve email benzersizlik kontrolü
    $sql = "SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $email, $user_id);
    $stmt->execute();
    $duplicate = $stmt->get_result()->num_rows > 0;
    $stmt->close();

    if ($duplicate) {
        $error_messages[] = "Bu kullanıcı adı veya e-posta adresi zaten kullanılıyor.";
    }

    // Şifre değişikliği yapılacaksa
    $password_updated = false;
    if (!empty($current_password)) {
        // Mevcut şifreyi kontrol et
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();
        $stmt->close();

        if (!password_verify($current_password, $user_data['password'])) {
            $error_messages[] = "Mevcut şifre hatalı.";
        } elseif (empty($new_password)) {
            $error_messages[] = "Yeni şifre boş bırakılamaz.";
        } elseif ($new_password !== $confirm_password) {
            $error_messages[] = "Yeni şifreler eşleşmiyor.";
        } elseif (strlen($new_password) < 6) {
            $error_messages[] = "Yeni şifre en az 6 karakter olmalıdır.";
        } else {
            $password_updated = true;
        }
    }

    // Hata yoksa güncelleme yap
    if (empty($error_messages)) {
        if ($password_updated) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $email, $hashed_password, $user_id);
        } else {
            $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $username, $email, $user_id);
        }

        if ($stmt->execute()) {
            $_SESSION['username'] = $username; // Session'daki kullanıcı adını güncelle
            $success_message = "Profil bilgileriniz başarıyla güncellendi.";
            $user['username'] = $username;
            $user['email'] = $email;
        } else {
            $error_messages[] = "Güncelleme sırasında bir hata oluştu.";
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
    <title>Profil Ayarları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="mb-4">Profil Ayarları</h2>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($error_messages)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($error_messages as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı:</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresi:</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <h4 class="mt-4 mb-3">Şifre Değiştir</h4>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mevcut Şifre:</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <small class="form-text text-muted">Şifrenizi değiştirmek istemiyorsanız boş bırakın.</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Yeni Şifre:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Yeni Şifre (Tekrar):</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Değişiklikleri Kaydet</button>
                            <a href="dashboard.php" class="btn btn-secondary">Geri Dön</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>