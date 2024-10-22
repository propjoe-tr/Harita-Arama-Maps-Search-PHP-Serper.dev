<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Gerekli dosyaları dahil et
$config = require 'config.php';
require_once 'functions.php';

session_start();
require_login();

$page_title = "Yer Arama"; // Sayfa başlığını güncelledim
include 'header.php';

// HTTPS kontrolü
if (!is_https()) {
    die('Bu form yalnızca HTTPS üzerinden kullanılabilir.');
}

// API anahtarı kontrolü
if (!validate_api_key()) {
    die('Geçerli bir API anahtarı bulunamadı.');
}

$error = [];
$results = null;
$pagination = null;
$api_response_time = null;

// Otomatik tamamlama isteği
if (isset($_GET['term'])) {
    $term = sanitize_input($_GET['term']);
    $type = sanitize_input($_GET['type'] ?? '');
    if (strlen($term) >= 2) {
        try {
            $suggestions = get_autocomplete_suggestions($term, $type);
            echo json_encode($suggestions);
        } catch (Exception $e) {
            echo json_encode([]);
        }
        exit;
    }
}

// Form gönderildi mi kontrol et
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
    // Kullanıcı girdilerini al ve temizle
    $name = sanitize_input($_GET['name'] ?? '');
    $city = sanitize_input($_GET['city'] ?? '');
    $country = sanitize_input($_GET['country'] ?? $config['default_country']);
    $language = sanitize_input($_GET['language'] ?? $config['default_language']);
    $limit = isset($_GET['limit']) ? min(intval($_GET['limit']), 100) : $config['results_per_page'];
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Girdileri doğrula
    $input_errors = validate_inputs([
        'name' => $name,
        'city' => $city,
        'country' => $country,
        'language' => $language,
        'limit' => $limit
    ]);

    if (empty($input_errors)) {
        $query = build_search_query($name, $city);

        try {
         $api_call = function() use ($query, $country, $language, $limit, $page) {
    return get_places($query, $country, $language, $limit, $page);
};

$measured_results = measure_api_response_time($api_call, []);
$api_results = $measured_results['result'];
$api_response_time = $measured_results['time'];

$results = $api_results['places'];
$total_results = $api_results['total_results'];

            $pagination = calculate_pagination($total_results, $page, $limit);

            // Sorguyu veritabanına kaydet
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO queries (user_id, query_text) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $user_id, $query);
            $stmt->execute();
            $query_id = $stmt->insert_id;
            $stmt->close();

            // Sorgu sonuçlarını veritabanına kaydet
            $sql = "INSERT INTO query_results (query_id, result_data) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $result_data = json_encode($results);
            $stmt->bind_param("is", $query_id, $result_data);
            $stmt->execute();
            $stmt->close();

        } catch (Exception $e) {
            $error[] = "API hatası: " . $e->getMessage();
        }
    } else {
        $error = array_merge($error, $input_errors);
    }
}

/**
 * API yanıt süresini ölçer.
 *
 * @param callable $func Çağrılacak fonksiyon
 * @param array $args Fonksiyon argümanları
 * @return array Sonuç ve geçen süre
 */
function measure_api_response_time($func, $args) {
    $start = microtime(true);
    $result = call_user_func_array($func, $args);
    $end = microtime(true);
    $time = round($end - $start, 2);
    return ['result' => $result, 'time' => $time];
}

// Şablonu yükle
require 'template.php';