-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 22 Eki 2024, 15:44:06
-- Sunucu sürümü: 8.0.37
-- PHP Sürümü: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `propjoec_harita`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `queries`
--

CREATE TABLE `queries` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `query_text` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Tablo döküm verisi `queries`
--

INSERT INTO `queries` (`id`, `user_id`, `query_text`, `created_at`) VALUES
(1, 1, 'tert test', '2024-10-20 16:49:26'),
(2, 1, 'tert test', '2024-10-20 16:49:30'),
(3, 1, 'test etst', '2024-10-20 16:49:52'),
(4, 1, 'kebapçı istanbul', '2024-10-20 16:50:08'),
(5, 1, 'test etst', '2024-10-20 16:57:19'),
(6, 1, 'internet cafe istanbul', '2024-10-21 13:53:56'),
(23, 1, 'internet cafe istanbul', '2024-10-22 12:29:38');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `query_results`
--

CREATE TABLE `query_results` (
  `id` int NOT NULL,
  `query_id` int DEFAULT NULL,
  `result_data` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Tablo döküm verisi `query_results`
--

INSERT INTO `query_results` (`id`, `query_id`, `result_data`, `created_at`) VALUES
(1, 1, '[]', '2024-10-20 16:49:26'),
(2, 2, '[]', '2024-10-20 16:49:30'),
(3, 3, '[{\"position\":1,\"title\":\"Testo Ltd. \\u015eti.\",\"address\":\"Fulya, Vefa Deresi Sk. Gayrettepe \\u0130\\u015f Merkezi D:5\\/1 D:2-3-4-5, 34394 \\u015ei\\u015fli\\/\\u0130stanbul\",\"latitude\":41.063906599999996,\"longitude\":29.002208699999997,\"rating\":4.8,\"ratingCount\":29,\"category\":\"Kurumsal Ofis\",\"phoneNumber\":\"(0212) 217 01 55\",\"website\":\"http:\\/\\/www.testo.com.tr\\/\",\"cid\":\"14465449926429057056\"},{\"position\":2,\"title\":\"TRTEST Test ve De\\u011ferlendirme A\\u015e\",\"address\":\"Serhat Mahallesi 2224. Cadde Teknopark Ankara C Blok, 13.Kat, \\u0130vedik OSB, 06374\",\"latitude\":39.9958715,\"longitude\":32.752486499999996,\"rating\":4.8,\"ratingCount\":12,\"category\":\"End\\u00fcstriyel Dan\\u0131\\u015fman\",\"phoneNumber\":\"(0312) 923 99 99\",\"cid\":\"18415125773412281021\"},{\"position\":3,\"title\":\"TESTED BELGELENDIRME\",\"address\":\"FERHATPA\\u015eA MAH YED\\u0130TEPE CAD. NO:118-3-ISTANBUL, 34888 ATA\\u015eEH\\u0130R\\/\\u0130stanbul\",\"latitude\":40.9857763,\"longitude\":29.1773709,\"rating\":5,\"ratingCount\":2,\"category\":\"Sertifika Ajans\\u0131\",\"phoneNumber\":\"(0216) 545 58 51\",\"website\":\"http:\\/\\/www.testede.net\\/\",\"cid\":\"2006065555985005434\"},{\"position\":4,\"title\":\"COTEST TEST C\\u0130HAZLARI VE DANI\\u015eMANLIK\",\"address\":\"Orta, 34880 Kartal\\/\\u0130stanbul\",\"latitude\":40.9143683,\"longitude\":29.2053192,\"rating\":2.8,\"ratingCount\":6,\"category\":\"Elektronik \\u00dcreticisi\",\"phoneNumber\":\"(0216) 370 12 66\",\"website\":\"http:\\/\\/www.cotest.com.tr\\/\",\"cid\":\"10671994569854978566\"},{\"position\":5,\"title\":\"Test At\\u00f6lyesi\",\"rating\":4.9,\"ratingCount\":28,\"category\":\"E\\u011fitim Dan\\u0131\\u015fman\\u0131\",\"phoneNumber\":\"0533 203 99 77\",\"website\":\"http:\\/\\/www.testatolyesi.com\\/\",\"cid\":\"12253643374500171828\"},{\"position\":6,\"title\":\"Test Laboratuvar Cihazlar\\u0131\",\"address\":\"\\u0130kitelli OSB, Esot San. Sit, \\u0130kitelli OSB Mah. S\\u00fcleyman Demirel Bulvar\\u0131 No:6, L Blok No:1, 34490 Ba\\u015fak\\u015fehir\\/\\u0130stanbul\",\"latitude\":41.066717399999995,\"longitude\":28.8027683,\"rating\":5,\"ratingCount\":4,\"category\":\"Laboratuar Ekipman\\u0131 Tedarik\\u00e7ileri\",\"phoneNumber\":\"(0212) 549 19 40\",\"website\":\"http:\\/\\/www.testlab.com.tr\\/\",\"cid\":\"17404587841073786440\"},{\"position\":7,\"title\":\"Testlerimiz.com\",\"address\":\"\\u0130lyask\\u00f6y, \\u015eair Baki Sk. No:9 Kat:2, 55050 \\u0130lkad\\u0131m\\/Samsun\",\"latitude\":41.27842280000001,\"longitude\":36.3189464,\"phoneNumber\":\"0546 496 86 21\",\"cid\":\"4602255141526868632\"},{\"position\":8,\"title\":\"Testtesis A.\\u015e.\",\"address\":\"\\u0130\\u00e7erenk\\u00f6y, Eston \\u00c7aml\\u0131 Evler, Da\\u011f\\u00e7am\\u0131 Apt. D.2, 34752 Ata\\u015fehir\\/\\u0130stanbul\",\"latitude\":40.9721127,\"longitude\":29.109957899999998,\"phoneNumber\":\"(0216) 469 05 50\",\"website\":\"http:\\/\\/testtesis.com.tr\\/\",\"cid\":\"2220901692714710768\"},{\"position\":9,\"title\":\"test i\\u015fletmesi\",\"address\":\"Fatih, 1778. Sk No:1, 34218 Ba\\u011fc\\u0131lar\\/\\u0130stanbul\",\"latitude\":41.049362599999995,\"longitude\":28.846255199999995,\"cid\":\"1570216278112114888\"},{\"position\":10,\"title\":\"ECE Test\",\"address\":\"T\\u0131naztepe, E\\u015frefpa\\u015fa Cd. NO: 237 -241 \\/ A, 35270 Konak\\/\\u0130zmir\",\"latitude\":38.4107816,\"longitude\":27.1291855,\"phoneNumber\":\"(0232) 683 31 14\",\"website\":\"http:\\/\\/www.ecetest.com\\/\",\"cid\":\"6118332801538845735\"}]', '2024-10-20 16:49:52'),
(4, 4, '[{\"position\":1,\"title\":\"Kebap\\u00e7\\u0131 \\u00d6zcan Usta\",\"address\":\"Hoca Pa\\u015fa, Ankara Caddesi, Hoca Pa\\u015fa Sk. No:6, 34110 Fatih\\/\\u0130stanbul\",\"latitude\":41.0139366,\"longitude\":28.975410300000004,\"rating\":4.8,\"ratingCount\":1,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0212) 527 00 27\",\"cid\":\"2578900725190192259\"},{\"position\":2,\"title\":\"Etiler Kebap\\u00e7\\u0131\",\"address\":\"Etiler, Nisbetiye Cd No:76, 34337 Be\\u015fikta\\u015f\\/\\u0130stanbul\",\"latitude\":41.078770999999996,\"longitude\":29.031163,\"rating\":4.3,\"ratingCount\":2,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0212) 257 02 09\",\"website\":\"https:\\/\\/www.etilerkebapci.com.tr\\/\",\"cid\":\"5485899275049541781\"},{\"position\":3,\"title\":\"Bilice Kebap\",\"address\":\"Asmal\\u0131 Mescit, Asmal\\u0131 Mescit Cd. No:8, 34430 Beyo\\u011flu\\/\\u0130stanbul\",\"latitude\":41.029924,\"longitude\":28.9749171,\"rating\":4.3,\"ratingCount\":2,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"0532 172 12 07\",\"website\":\"https:\\/\\/www.facebook.com\\/pages\\/Bilice-Kebap\\/149334705208336\",\"cid\":\"13363431937675137111\"},{\"position\":4,\"title\":\"Kebap\\u00e7\\u0131 \\u00c7avu\\u015f\",\"address\":\"Ferik\\u00f6y, Kocaba\\u015f Sk. No:4, 34200 \\u015ei\\u015fli\\/\\u0130stanbul\",\"latitude\":41.0455336,\"longitude\":28.9778089,\"rating\":4.4,\"ratingCount\":2,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0212) 238 11 99\",\"cid\":\"14562961011729804803\"},{\"position\":5,\"title\":\"\\u015eehzade Ca\\u011f Kebap\",\"address\":\"Hoca Pa\\u015fa, Hoca Pa\\u015fa Sk. No:6 D:4, 34110 Fatih\\/\\u0130stanbul\",\"latitude\":41.013978099999996,\"longitude\":28.9752568,\"rating\":4.3,\"ratingCount\":7,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0212) 520 33 61\",\"cid\":\"4193175250874352887\"},{\"position\":6,\"title\":\"Bitlisli\",\"address\":\"Hoca Pa\\u015fa, Hoca Camii Sokak 2\\/B, 34110 Sirkeci Fatih\\/Fatih\\/\\u0130stanbul\",\"latitude\":41.0136709,\"longitude\":28.975555599999996,\"rating\":4.8,\"ratingCount\":4,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0212) 513 77 63\",\"cid\":\"11428273797115291843\"},{\"position\":7,\"title\":\"\\u00c7iya Sofras\\u0131\",\"address\":\"Cafera\\u011fa, G\\u00fcne\\u015fli Bah\\u00e7e Sok, 34710 Kad\\u0131k\\u00f6y\\/\\u0130stanbul\",\"latitude\":40.989319599999995,\"longitude\":29.0244093,\"rating\":4.1,\"ratingCount\":11,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0216) 418 51 15\",\"website\":\"http:\\/\\/www.ciya.com.tr\\/\",\"cid\":\"6389111112583631123\"},{\"position\":8,\"title\":\"Kebap\\u00e7\\u0131 Murat\",\"address\":\"Topkap\\u0131, No:, Topkap\\u0131 Cd. No:19, 34093 Fatih\\/\\u0130stanbul\",\"latitude\":41.019782899999996,\"longitude\":28.9279017,\"rating\":4.4,\"ratingCount\":1,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0212) 523 01 01\",\"cid\":\"7035540993136412369\"},{\"position\":9,\"title\":\"Kebap\\u00e7\\u0131 Mahmut\",\"address\":\"Ak\\u015femsettin, Adnan Menderes Blv. No:14, 34080 Fatih\\/\\u0130stanbul\",\"latitude\":41.0154125,\"longitude\":28.9432042,\"rating\":3.9,\"ratingCount\":4,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0212) 525 11 11\",\"website\":\"http:\\/\\/www.kebapcimahmut.com.tr\\/\",\"cid\":\"1976618022214784292\"},{\"position\":10,\"title\":\"Tarihi \\u0130stanbul Sofras\\u0131\",\"address\":\"Yenimahalle, \\u0130stanbul Cd. No:77\\/A, 34142 Bak\\u0131rk\\u00f6y\\/\\u0130stanbul\",\"latitude\":40.9787239,\"longitude\":28.8787861,\"rating\":4.4,\"ratingCount\":745,\"category\":\"Kebap Restoran\\u0131\",\"phoneNumber\":\"(0212) 570 06 62\",\"website\":\"http:\\/\\/www.istanbulsofrasi.com\\/\",\"cid\":\"2849922346888792712\"}]', '2024-10-20 16:50:08'),
(5, 5, '[{\"position\":1,\"title\":\"TRTEST Test ve De\\u011ferlendirme A\\u015e\",\"address\":\"Serhat Mahallesi 2224. Cadde Teknopark Ankara C Blok, 13.Kat, \\u0130vedik OSB, 06374\",\"latitude\":39.9958715,\"longitude\":32.752486499999996,\"rating\":4.8,\"ratingCount\":12,\"category\":\"End\\u00fcstriyel Dan\\u0131\\u015fman\",\"phoneNumber\":\"(0312) 923 99 99\",\"cid\":\"18415125773412281021\"},{\"position\":2,\"title\":\"Testo Ltd. \\u015eti.\",\"address\":\"Fulya, Vefa Deresi Sk. Gayrettepe \\u0130\\u015f Merkezi D:5\\/1 D:2-3-4-5, 34394 \\u015ei\\u015fli\\/\\u0130stanbul\",\"latitude\":41.063906599999996,\"longitude\":29.002208699999997,\"rating\":4.8,\"ratingCount\":29,\"category\":\"Kurumsal Ofis\",\"phoneNumber\":\"(0212) 217 01 55\",\"website\":\"http:\\/\\/www.testo.com.tr\\/\",\"cid\":\"14465449926429057056\"},{\"position\":3,\"title\":\"COTEST TEST C\\u0130HAZLARI VE DANI\\u015eMANLIK\",\"address\":\"Orta, 34880 Kartal\\/\\u0130stanbul\",\"latitude\":40.9143683,\"longitude\":29.2053192,\"rating\":2.8,\"ratingCount\":6,\"category\":\"Elektronik \\u00dcreticisi\",\"phoneNumber\":\"(0216) 370 12 66\",\"website\":\"http:\\/\\/www.cotest.com.tr\\/\",\"cid\":\"10671994569854978566\"},{\"position\":4,\"title\":\"Test At\\u00f6lyesi\",\"rating\":4.9,\"ratingCount\":28,\"category\":\"E\\u011fitim Dan\\u0131\\u015fman\\u0131\",\"phoneNumber\":\"0533 203 99 77\",\"website\":\"http:\\/\\/www.testatolyesi.com\\/\",\"cid\":\"12253643374500171828\"},{\"position\":5,\"title\":\"Test Laboratuvar Cihazlar\\u0131\",\"address\":\"\\u0130kitelli OSB, Esot San. Sit, \\u0130kitelli OSB Mah. S\\u00fcleyman Demirel Bulvar\\u0131 No:6, L Blok No:1, 34490 Ba\\u015fak\\u015fehir\\/\\u0130stanbul\",\"latitude\":41.066717399999995,\"longitude\":28.8027683,\"rating\":5,\"ratingCount\":4,\"category\":\"Laboratuar Ekipman\\u0131 Tedarik\\u00e7ileri\",\"phoneNumber\":\"(0212) 549 19 40\",\"website\":\"http:\\/\\/www.testlab.com.tr\\/\",\"cid\":\"17404587841073786440\"},{\"position\":6,\"title\":\"TESTED BELGELENDIRME\",\"address\":\"FERHATPA\\u015eA MAH YED\\u0130TEPE CAD. NO:118-3-ISTANBUL, 34888 ATA\\u015eEH\\u0130R\\/\\u0130stanbul\",\"latitude\":40.9857763,\"longitude\":29.1773709,\"rating\":5,\"ratingCount\":2,\"category\":\"Sertifika Ajans\\u0131\",\"phoneNumber\":\"(0216) 545 58 51\",\"website\":\"http:\\/\\/www.testede.net\\/\",\"cid\":\"2006065555985005434\"},{\"position\":7,\"title\":\"Testlerimiz.com\",\"address\":\"\\u0130lyask\\u00f6y, \\u015eair Baki Sk. No:9 Kat:2, 55050 \\u0130lkad\\u0131m\\/Samsun\",\"latitude\":41.27842280000001,\"longitude\":36.3189464,\"phoneNumber\":\"0546 496 86 21\",\"cid\":\"4602255141526868632\"},{\"position\":8,\"title\":\"test i\\u015fletmesi\",\"address\":\"Fatih, 1778. Sk No:1, 34218 Ba\\u011fc\\u0131lar\\/\\u0130stanbul\",\"latitude\":41.049362599999995,\"longitude\":28.846255199999995,\"cid\":\"1570216278112114888\"},{\"position\":9,\"title\":\"Testtesis A.\\u015e.\",\"address\":\"\\u0130\\u00e7erenk\\u00f6y, Eston \\u00c7aml\\u0131 Evler, Da\\u011f\\u00e7am\\u0131 Apt. D.2, 34752 Ata\\u015fehir\\/\\u0130stanbul\",\"latitude\":40.9721127,\"longitude\":29.109957899999998,\"phoneNumber\":\"(0216) 469 05 50\",\"website\":\"http:\\/\\/testtesis.com.tr\\/\",\"cid\":\"2220901692714710768\"},{\"position\":10,\"title\":\"TA Test Analiz Sistemleri ve Kimyasal Maddeler San. Tic. Ltd. \\u015eti.\",\"address\":\"Esentepe, Monumento Plaza, Milangaz Cd. no:75A, 34870 Kartal\\/\\u0130stanbul\",\"latitude\":40.9081153,\"longitude\":29.198611999999997,\"phoneNumber\":\"(0216) 546 10 95\",\"website\":\"https:\\/\\/takimya.com\\/\",\"cid\":\"2323818829149130740\"}]', '2024-10-20 16:57:21'),
(6, 6, '[{\"position\":1,\"title\":\"Adeks\",\"address\":\"Cihann\\u00fcma, Barbaros Blv. No:59, 34353 Be\\u015fikta\\u015f\\/\\u0130stanbul\",\"latitude\":41.0467569,\"longitude\":29.0074077,\"rating\":4.4,\"ratingCount\":2,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"(0212) 227 57 78\",\"website\":\"https:\\/\\/www.adeks.net\\/\",\"cid\":\"3228000122697663166\"},{\"position\":2,\"title\":\"Ku\\u011fu \\u0130nternet ve Playstation kafe\",\"address\":\"Ba\\u011flarba\\u015f\\u0131, Ba\\u011flarba\\u015f\\u0131 mah. \\u0130n\\u00f6n\\u00fc cad, Karanfil Sk. 14 \\/A, 34844 Maltepe\\/\\u0130stanbul\",\"latitude\":40.9218286,\"longitude\":29.1338592,\"rating\":4.4,\"ratingCount\":511,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"(0216) 441 28 56\",\"cid\":\"2919229633405612085\"},{\"position\":3,\"title\":\"MET\\u0130NLER E-SPOR CAFE\",\"address\":\"Sancaktepe \\u00c7ar\\u015f\\u0131 Cad, 899. Sk 25\\/A, 34200 Ba\\u011fc\\u0131lar\\/\\u0130stanbul\",\"latitude\":41.0363348,\"longitude\":28.856537600000003,\"rating\":4.3,\"ratingCount\":252,\"category\":\"\\u0130nternet Kafe\",\"phoneNumber\":\"0543 947 55 51\",\"cid\":\"13426023293077468039\"},{\"position\":4,\"title\":\"CLASS GAM\\u0130NG ARENA\",\"address\":\"So\\u011fanl\\u0131, Turgut Sk. No:7, 34183 Bah\\u00e7elievler\\/\\u0130stanbul\",\"latitude\":41.008603,\"longitude\":28.854968999999997,\"rating\":4.9,\"ratingCount\":452,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"0546 733 36 47\",\"cid\":\"13418557198664951165\"},{\"position\":5,\"title\":\"Bal \\u0130nternet Cafe\",\"address\":\"\\u00c7eliktepe, \\u0130malat Sk. No:2\\/D, 34413 K\\u00e2\\u011f\\u0131thane\\/\\u0130stanbul\",\"latitude\":41.083245999999995,\"longitude\":29.003616,\"rating\":4.7,\"ratingCount\":84,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"0546 886 90 36\",\"website\":\"http:\\/\\/instagram.com\\/4leventbalcafe\",\"cid\":\"11235854189506601651\"},{\"position\":6,\"title\":\"Elit Cafe (EL\\u0130T GAMING)\",\"address\":\"Mecidiyek\\u00f6y, \\u015eht. Er Cihan Naml\\u0131 Cd 21\\/A, 34381 \\u015ei\\u015fli\\/\\u0130stanbul\",\"latitude\":41.0696562,\"longitude\":28.997447899999997,\"rating\":4.5,\"ratingCount\":232,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"0538 861 79 31\",\"website\":\"https:\\/\\/www.facebook.com\\/EL%C4%B0T-KAFE-256397071078634\\/\",\"cid\":\"6546391367141146185\"},{\"position\":7,\"title\":\"X Gaming Arena E-Spor\",\"address\":\"Yavuzt\\u00fcrk, Karadeniz Cd. No:82, 34000 \\u00dcsk\\u00fcdar\\/\\u0130stanbul\",\"latitude\":41.0363778,\"longitude\":29.0844677,\"rating\":4.6,\"ratingCount\":259,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"0531 602 11 27\",\"cid\":\"12056271277526637950\"},{\"position\":8,\"title\":\"BEST-TEAM E-SPOR GAMER ARENA (\\u0130nternet Cafe)\",\"address\":\"Kemalpa\\u015fa, Kemalpa\\u015fa mah. 2, Gen\\u00e7t\\u00fcrk Sk. No:8\\/A, 34295 K\\u00fc\\u00e7\\u00fck\\u00e7ekmece\\/\\u0130stanbul\",\"latitude\":41.0029752,\"longitude\":28.797492499999997,\"rating\":4.4,\"ratingCount\":57,\"category\":\"\\u0130nternet Kafe\",\"phoneNumber\":\"(0212) 580 92 46\",\"cid\":\"5686363490823444683\"},{\"position\":9,\"title\":\"Zocco\'s \\u0130nternet Cafe & E-Spor Merkezi\",\"address\":\"Osmana\\u011fa, Sak\\u0131z Sk. No:9\\/A, 34714 Kad\\u0131k\\u00f6y\\/\\u0130stanbul\",\"latitude\":40.9889699,\"longitude\":29.0266795,\"rating\":4.2,\"ratingCount\":799,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"(0216) 330 00 97\",\"website\":\"http:\\/\\/www.zoccos.com\\/\",\"cid\":\"14870774790522448979\"},{\"position\":10,\"title\":\"\\u0130nternet Cafe & Playstation Cafe\",\"address\":\"T\\u00fcrkali mahallesi Ihlamurdere Caddesi, Yeniyol Soka\\u011f\\u0131 No: 2\\/A, 34357 Be\\u015fikta\\u015f\\/\\u0130stanbul\",\"latitude\":41.045617299999996,\"longitude\":29.0026647,\"rating\":4.2,\"ratingCount\":93,\"category\":\"\\u0130nternet Kafe\",\"phoneNumber\":\"0542 369 30 38\",\"cid\":\"15354783373025347981\"}]', '2024-10-21 13:53:56'),
(23, 23, '[{\"position\":1,\"title\":\"Adeks\",\"address\":\"Cihann\\u00fcma, Barbaros Blv. No:59, 34353 Be\\u015fikta\\u015f\\/\\u0130stanbul\",\"latitude\":41.0467569,\"longitude\":29.0074077,\"rating\":4.4,\"ratingCount\":2,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"(0212) 227 57 78\",\"website\":\"https:\\/\\/www.adeks.net\\/\",\"cid\":\"3228000122697663166\"},{\"position\":2,\"title\":\"Ku\\u011fu \\u0130nternet ve Playstation kafe\",\"address\":\"Ba\\u011flarba\\u015f\\u0131, Ba\\u011flarba\\u015f\\u0131 mah. \\u0130n\\u00f6n\\u00fc cad, Karanfil Sk. 14 \\/A, 34844 Maltepe\\/\\u0130stanbul\",\"latitude\":40.9218286,\"longitude\":29.1338592,\"rating\":4.4,\"ratingCount\":511,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"(0216) 441 28 56\",\"cid\":\"2919229633405612085\"},{\"position\":3,\"title\":\"MET\\u0130NLER E-SPOR CAFE\",\"address\":\"Sancaktepe \\u00c7ar\\u015f\\u0131 Cad, 899. Sk 25\\/A, 34200 Ba\\u011fc\\u0131lar\\/\\u0130stanbul\",\"latitude\":41.0363348,\"longitude\":28.856537600000003,\"rating\":4.3,\"ratingCount\":252,\"category\":\"\\u0130nternet Kafe\",\"phoneNumber\":\"0543 947 55 51\",\"cid\":\"13426023293077468039\"},{\"position\":4,\"title\":\"CLASS GAM\\u0130NG ARENA\",\"address\":\"So\\u011fanl\\u0131, Turgut Sk. No:7, 34183 Bah\\u00e7elievler\\/\\u0130stanbul\",\"latitude\":41.008603,\"longitude\":28.854968999999997,\"rating\":4.9,\"ratingCount\":452,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"0546 733 36 47\",\"cid\":\"13418557198664951165\"},{\"position\":5,\"title\":\"Bal \\u0130nternet Cafe\",\"address\":\"\\u00c7eliktepe, \\u0130malat Sk. No:2\\/D, 34413 K\\u00e2\\u011f\\u0131thane\\/\\u0130stanbul\",\"latitude\":41.083245999999995,\"longitude\":29.003616,\"rating\":4.7,\"ratingCount\":84,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"0546 886 90 36\",\"website\":\"http:\\/\\/instagram.com\\/4leventbalcafe\",\"cid\":\"11235854189506601651\"},{\"position\":6,\"title\":\"Elit Cafe (EL\\u0130T GAMING)\",\"address\":\"Mecidiyek\\u00f6y, \\u015eht. Er Cihan Naml\\u0131 Cd 21\\/A, 34381 \\u015ei\\u015fli\\/\\u0130stanbul\",\"latitude\":41.0696562,\"longitude\":28.997447899999997,\"rating\":4.5,\"ratingCount\":232,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"0538 861 79 31\",\"website\":\"https:\\/\\/www.facebook.com\\/EL%C4%B0T-KAFE-256397071078634\\/\",\"cid\":\"6546391367141146185\"},{\"position\":7,\"title\":\"X Gaming Arena E-Spor\",\"address\":\"Yavuzt\\u00fcrk, Karadeniz Cd. No:82, 34000 \\u00dcsk\\u00fcdar\\/\\u0130stanbul\",\"latitude\":41.0363778,\"longitude\":29.0844677,\"rating\":4.6,\"ratingCount\":259,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"0531 602 11 27\",\"cid\":\"12056271277526637950\"},{\"position\":8,\"title\":\"BEST-TEAM E-SPOR GAMER ARENA (\\u0130nternet Cafe)\",\"address\":\"Kemalpa\\u015fa, Kemalpa\\u015fa mah. 2, Gen\\u00e7t\\u00fcrk Sk. No:8\\/A, 34295 K\\u00fc\\u00e7\\u00fck\\u00e7ekmece\\/\\u0130stanbul\",\"latitude\":41.0029752,\"longitude\":28.797492499999997,\"rating\":4.4,\"ratingCount\":57,\"category\":\"\\u0130nternet Kafe\",\"phoneNumber\":\"(0212) 580 92 46\",\"cid\":\"5686363490823444683\"},{\"position\":9,\"title\":\"Zocco\'s \\u0130nternet Cafe & E-Spor Merkezi\",\"address\":\"Osmana\\u011fa, Sak\\u0131z Sk. No:9\\/A, 34714 Kad\\u0131k\\u00f6y\\/\\u0130stanbul\",\"latitude\":40.9889699,\"longitude\":29.0266795,\"rating\":4.2,\"ratingCount\":799,\"category\":\"\\u0130nternet kafe\",\"phoneNumber\":\"(0216) 330 00 97\",\"website\":\"http:\\/\\/www.zoccos.com\\/\",\"cid\":\"14870774790522448979\"},{\"position\":10,\"title\":\"\\u0130nternet Cafe & Playstation Cafe\",\"address\":\"T\\u00fcrkali mahallesi Ihlamurdere Caddesi, Yeniyol Soka\\u011f\\u0131 No: 2\\/A, 34357 Be\\u015fikta\\u015f\\/\\u0130stanbul\",\"latitude\":41.045617299999996,\"longitude\":29.0026647,\"rating\":4.2,\"ratingCount\":93,\"category\":\"\\u0130nternet Kafe\",\"phoneNumber\":\"0542 369 30 38\",\"cid\":\"15354783373025347981\"}]', '2024-10-22 12:29:38');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'propjoe', 'info@google.com', '$2y$10$xi8OJtf4StbCri7/gh5bQ.jB3THlyEAEBNapjOz1qafQIj5bkGAye', '2024-10-20 16:39:57');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `query_results`
--
ALTER TABLE `query_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `query_id` (`query_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `query_results`
--
ALTER TABLE `query_results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `queries`
--
ALTER TABLE `queries`
  ADD CONSTRAINT `queries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `query_results`
--
ALTER TABLE `query_results`
  ADD CONSTRAINT `query_results_ibfk_1` FOREIGN KEY (`query_id`) REFERENCES `queries` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
