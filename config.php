<?php
// config.php

$config = [
    // API ayarları
    'api_key' => 'Serper.dev api kodu',
    'results_per_page' => 10,
    'default_country' => 'tr',
    'default_language' => 'tr',

    // Veritabanı ayarları
    'db_host' => 'localhost',
    'db_name' => 'database adı',
    'db_user' => 'database kullanıcı adı',
    'db_pass' => 'Parola',

    // Diğer ayarlar
    'site_url' => 'https://propjoe.com.tr', // Sitenizin URL'si
    'admin_email' => 'admin@your-site.com',
];

// Veritabanı bağlantısını oluştur
try {
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    $conn->set_charset("utf8mb4");
    
    if ($conn->connect_error) {
        throw new Exception("Veritabanı bağlantı hatası: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Kritik hata: " . $e->getMessage());
}

// Yapılandırma dizisini döndür
return $config;