<?php
require_once 'config.php';
require_once 'functions.php';

session_start();
require_login();
$page_title = "Kullanıcı Paneli";
include 'header.php';
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Kullanıcının sorgularını getir
$sql = "SELECT * FROM queries WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$queries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Hoş geldiniz, <?php echo htmlspecialchars($username); ?>!</h2>
                <a href="logout.php" class="btn btn-danger float-end">Çıkış Yap</a>
                <h3 class="mt-4">Sorgularınız</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sorgu</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($queries as $query): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($query['query_text']); ?></td>
                            <td><?php echo htmlspecialchars($query['created_at']); ?></td>
                            <td>
                                <a href="view_results.php?id=<?php echo $query['id']; ?>" class="btn btn-primary btn-sm">Sonuçları Görüntüle</a>
                                <a href="delete_query.php?id=<?php echo $query['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu sorguyu silmek istediğinizden emin misiniz?');">Sil</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="index.php" class="btn btn-success">Yeni Sorgu Yap</a>
            </div>
        </div>
    </div>
</body>
</html>