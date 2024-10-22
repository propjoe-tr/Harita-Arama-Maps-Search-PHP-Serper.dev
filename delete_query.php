<?php
require_once 'config.php';
require_once 'functions.php';

session_start();
require_login();

$user_id = $_SESSION['user_id'];
$query_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($query_id > 0) {
    // İlk önce kullanıcının bu sorguyu silme yetkisi olup olmadığını kontrol et
    $sql = "SELECT id FROM queries WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $query_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Sorguyu ve ilişkili sonuçları sil
        $conn->begin_transaction();

        try {
            $sql = "DELETE FROM query_results WHERE query_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $query_id);
            $stmt->execute();

            $sql = "DELETE FROM queries WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $query_id);
            $stmt->execute();

            $conn->commit();
            $message = "Sorgu başarıyla silindi.";
        } catch (Exception $e) {
            $conn->rollback();
            $message = "Sorgu silinirken bir hata oluştu: " . $e->getMessage();
        }
    } else {
        $message = "Bu sorguyu silme yetkiniz yok veya sorgu bulunamadı.";
    }
} else {
    $message = "Geçersiz sorgu ID'si.";
}

// Kullanıcıyı dashboard'a yönlendir ve mesajı göster
$_SESSION['message'] = $message;
header("Location: dashboard.php");
exit();