<?php
// functions.php

/**
 * Kullanıcı girdilerini temizler ve güvenli hale getirir.
 *
 * @param string $data Temizlenecek veri
 * @return string Temizlenmiş veri
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Kullanıcının oturum açıp açmadığını kontrol eder.
 *
 * @return bool Kullanıcı oturum açmışsa true, aksi halde false
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Kullanıcının oturum açmasını gerektirir, aksi halde login sayfasına yönlendirir.
 */
function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Kullanıcıyı güvenli bir şekilde çıkış yapar.
 */
function logout() {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    header("Location: login.php");
    exit();
}

/**
 * Google Serper API'sini kullanarak yer araması yapar.
 *
 * @param string $query Arama sorgusu
 * @param string $country Ülke kodu
 * @param string $language Dil kodu
 * @param int $limit Sayfa başına sonuç sayısı
 * @param int $page Sayfa numarası
 * @return array API'den dönen sonuçlar
 * @throws Exception API hatası durumunda
 */
function get_places($query, $country, $language, $limit, $page) {
    global $config;
    
    $results = [];
    $total_results = 0;
    $api_calls = ceil($limit / 20); // API her seferinde maksimum 20 sonuç döndürdüğünü varsayıyoruz

    for ($i = 0; $i < $api_calls; $i++) {
        $current_page = $page + $i;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://google.serper.dev/places',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'q' => $query,
                'gl' => $country,
                'hl' => $language,
                'num' => 20, // Her seferinde 20 sonuç iste
                'page' => $current_page
            ]),
            CURLOPT_HTTPHEADER => array(
                "X-API-KEY: {$config['api_key']}",
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        }

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON decode error: " . json_last_error_msg());
        }

        $results = array_merge($results, $result['places'] ?? []);
        $total_results = $result['searchMetadata']['totalResults'] ?? 0;

        if (count($results) >= $limit) {
            break;
        }
    }

    return [
        'places' => array_slice($results, 0, $limit),
        'total_results' => intval($total_results)
    ];
}

function combine_results($results, $limit) {
    $combined_results = [];
    $total_results = 0;

    foreach ($results as $result) {
        $combined_results = array_merge($combined_results, $result['places']);
        $total_results = max($total_results, $result['total_results']);

        if (count($combined_results) >= $limit) {
            break;
        }
    }

    return [
        'places' => array_slice($combined_results, 0, $limit),
        'total_results' => $total_results
    ];
}

/**
 * Sayfalama bilgilerini hesaplar.
 *
 * @param int $total_results Toplam sonuç sayısı
 * @param int $page Mevcut sayfa numarası
 * @param int $limit Sayfa başına sonuç sayısı
 * @return array Sayfalama bilgileri
 */
function calculate_pagination($total_results, $page, $limit) {
    $total_pages = ceil($total_results / $limit);

    return [
        'total_pages' => $total_pages,
        'current_page' => min($page, $total_pages),
        'total_results' => $total_results,
        'results_per_page' => $limit
    ];
}

/**
 * Arama sonuçlarını formatlar ve HTML olarak döndürür.
 *
 * @param array $places Arama sonuçları
 * @return string Formatlanmış HTML
 */
function format_search_results($places) {
    $html = '';
    foreach ($places as $place) {
        $html .= '<div class="card mb-3 result-card">';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title">' . htmlspecialchars($place['title']) . '</h5>';
        
        if (isset($place['address'])) {
            $html .= '<p class="card-text"><strong>Adres:</strong> ' . htmlspecialchars($place['address']) . '</p>';
        }
        if (isset($place['phoneNumber'])) {
            $html .= '<p class="card-text"><strong>Telefon:</strong> ' . htmlspecialchars($place['phoneNumber']) . '</p>';
            // WhatsApp bağlantısı ekle
            $whatsapp_number = preg_replace('/[^0-9]/', '', $place['phoneNumber']);
            $html .= '<a href="https://wa.me/' . $whatsapp_number . '" target="_blank" class="btn btn-success btn-sm">WhatsApp\'ta Mesaj Gönder</a>';
        }
        if (isset($place['rating'])) {
            $html .= '<p class="card-text"><strong>Puan:</strong> ' . htmlspecialchars($place['rating']) . '</p>';
        }
        if (isset($place['reviewsCount'])) {
            $html .= '<p class="card-text"><strong>Değerlendirme Sayısı:</strong> ' . htmlspecialchars($place['reviewsCount']) . '</p>';
        }
        if (isset($place['category'])) {
            $html .= '<p class="card-text"><strong>Kategori:</strong> ' . htmlspecialchars($place['category']) . '</p>';
        }
        if (isset($place['website'])) {
            $html .= '<a href="' . htmlspecialchars($place['website']) . '" class="btn btn-outline-primary btn-sm" target="_blank">Website</a>';
        }
        
        $html .= '</div></div>';
    }
    return $html;
}

/**
 * Kullanıcı girdilerini doğrular.
 *
 * @param array $inputs Doğrulanacak girdiler
 * @return array Hata mesajları
 */
function validate_inputs($inputs) {
    $errors = [];
    
    if (empty($inputs['name'])) {
        $errors[] = "Aranacak isim boş olamaz.";
    }
    
    if (empty($inputs['city'])) {
        $errors[] = "Şehir boş olamaz.";
    }
    
    if (!in_array($inputs['country'], ['tr', 'us', 'gb', 'de'])) {
        $errors[] = "Geçersiz ülke seçimi.";
    }
    
    if (!in_array($inputs['language'], ['tr', 'en', 'de'])) {
        $errors[] = "Geçersiz dil seçimi.";
    }
    
    if ($inputs['limit'] < 1 || $inputs['limit'] > 100) {
        $errors[] = "Geçersiz sonuç sayısı. 1 ile 100 arasında olmalıdır.";
    }
    
    return $errors;
}

/**
 * Arama sorgusunu oluşturur.
 *
 * @param string $name Aranacak isim
 * @param string $city Şehir
 * @return string Oluşturulan sorgu
 */
function build_search_query($name, $city) {
    return trim($name . ' ' . $city);
}

/**
 * Hata mesajlarını formatlı bir şekilde döndürür.
 *
 * @param array $errors Hata mesajları dizisi
 * @return string Formatlı hata mesajları
 */
function format_errors($errors) {
    if (empty($errors)) {
        return '';
    }
    
    $html = '<div class="alert alert-danger" role="alert">';
    $html .= '<ul>';
    foreach ($errors as $error) {
        $html .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $html .= '</ul>';
    $html .= '</div>';
    
    return $html;
}

/**
 * HTTPS bağlantısını kontrol eder.
 *
 * @return bool HTTPS bağlantısı varsa true, yoksa false
 */
function is_https() {
    return (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
    );
}

/**
 * API anahtarının geçerliliğini kontrol eder.
 *
 * @return bool API anahtarı geçerli ise true, değilse false
 */
function validate_api_key() {
    global $config;
    
    if (empty($config['api_key'])) {
        log_error('API anahtarı bulunamadı.');
        return false;
    }
    
    // Burada gerekirse API anahtarının geçerliliğini kontrol eden
    // daha kapsamlı bir mantık eklenebilir.
    
    return true;
}

/**
 * Hata mesajlarını loglama fonksiyonu.
 *
 * @param string $message Hata mesajı
 * @param string $level Hata seviyesi (örn. 'ERROR', 'WARNING')
 */
function log_error($message, $level = 'ERROR') {
    $log_file = __DIR__ . '/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] [$level] $message" . PHP_EOL;
    error_log($log_message, 3, $log_file);
}

/**
 * Google Serper API'sini kullanarak otomatik tamamlama önerileri alır.
 *
 * @param string $term Arama terimi
 * @param string $type Arama tipi ('city' veya 'name')
 * @return array Öneriler listesi
 * @throws Exception API hatası durumunda
 */
function get_autocomplete_suggestions($term, $type) {
    global $config;
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://google.serper.dev/search',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode([
            'q' => $type == 'city' ? "cities in Turkey $term" : "$term in Turkey",
            'gl' => 'tr',
            'hl' => 'tr'
        ]),
        CURLOPT_HTTPHEADER => array(
            "X-API-KEY: {$config['api_key']}",
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        throw new Exception("cURL Error #:" . $err);
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON decode error: " . json_last_error_msg());
    }

    $suggestions = [];
    if (isset($data['organic'])) {
        foreach ($data['organic'] as $result) {
            $suggestions[] = htmlspecialchars($result['title']);
        }
    }
    return $suggestions;
}