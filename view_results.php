<?php
require_once 'config.php';
require_once 'functions.php';

session_start();
require_login();
$page_title = "Sayfa Başlığı"; // Her sayfa için uygun başlığı ayarlayın
include 'header.php';
$user_id = $_SESSION['user_id'];
$query_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($query_id == 0) {
    die("Geçersiz sorgu ID'si.");
}

// Sorguyu ve sonuçlarını getir
$sql = "SELECT q.*, qr.result_data 
        FROM queries q 
        LEFT JOIN query_results qr ON q.id = qr.query_id 
        WHERE q.id = ? AND q.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $query_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Sorgu bulunamadı veya bu sorguya erişim izniniz yok.");
}

$query_data = $result->fetch_assoc();
$stmt->close();

$results = json_decode($query_data['result_data'], true);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorgu Sonuçları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Sorgu Sonuçları</h2>
                <p><strong>Sorgu:</strong> <?php echo htmlspecialchars($query_data['query_text']); ?></p>
                <p><strong>Tarih:</strong> <?php echo htmlspecialchars($query_data['created_at']); ?></p>
                
                <h3 class="mt-4">Sonuçlar</h3>
                <?php echo format_search_results($results); ?>
                
                <a href="dashboard.php" class="btn btn-primary mt-3">Panele Dön</a>
            </div>
        </div>
    </div>
</body>
</html>