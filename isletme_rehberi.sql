-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 01 Haz 2026, 20:40:36
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `isletme_rehberi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `arama_istatistikleri`
--

CREATE TABLE `arama_istatistikleri` (
  `id` int(11) NOT NULL,
  `aranan_kelime` varchar(100) NOT NULL,
  `il_id` int(11) NOT NULL,
  `ilce_id` int(11) NOT NULL,
  `bulunan_isletme_sayisi` int(11) DEFAULT 0,
  `arama_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `arama_istatistikleri`
--

INSERT INTO `arama_istatistikleri` (`id`, `aranan_kelime`, `il_id`, `ilce_id`, `bulunan_isletme_sayisi`, `arama_tarihi`) VALUES
(1, 'çilingir', 1, 0, 0, '2026-05-31 20:54:58'),
(2, 'çilingir', 1, 0, 0, '2026-05-31 20:54:59'),
(3, 'çilingir', 1, 0, 0, '2026-05-31 20:56:25'),
(4, 'çilingir', 1, 0, 0, '2026-05-31 20:56:26'),
(5, 'çilingir', 1, 0, 0, '2026-05-31 20:56:26'),
(6, 'çilingir', 1, 0, 0, '2026-05-31 20:56:26'),
(7, 'çilingir', 1, 0, 0, '2026-05-31 20:56:27'),
(8, 'çilingir', 1, 0, 0, '2026-05-31 20:56:34'),
(9, 'çilingir', 1, 0, 0, '2026-05-31 20:56:35'),
(10, 'çilingir', 1, 0, 0, '2026-05-31 20:56:35'),
(11, 'çiçekçi', 1, 3, 0, '2026-05-31 20:57:00'),
(12, 'lokanta', 2, 0, 1, '2026-05-31 20:57:20'),
(13, 'lokanta', 4, 0, 0, '2026-05-31 20:57:28'),
(14, 'lokanta', 10, 0, 0, '2026-05-31 20:57:35'),
(15, 'çiçekçi', 15, 0, 0, '2026-05-31 20:57:48'),
(16, 'çiçekçi', 1, 7, 0, '2026-05-31 20:57:56'),
(17, 'çiçekçi', 1, 7, 0, '2026-05-31 21:03:47'),
(18, 'çiçekçi', 1, 7, 0, '2026-05-31 21:06:54'),
(19, 'çiçekçi', 1, 7, 0, '2026-05-31 21:06:57'),
(20, 'çiçekçi', 1, 7, 0, '2026-05-31 21:06:58'),
(21, 'çiçekçi', 1, 7, 0, '2026-05-31 21:06:58'),
(22, 'çiçekçi', 1, 7, 0, '2026-05-31 21:06:58'),
(23, 'lokanta', 1, 0, 1, '2026-05-31 21:07:23'),
(24, 'çiçekçi', 13, 0, 0, '2026-05-31 21:07:54'),
(25, 'çiçekçi', 1, 2, 0, '2026-05-31 21:08:02'),
(26, 'çiçekçi', 1, 2, 0, '2026-05-31 21:12:15'),
(27, 'çiçekçi', 1, 4, 0, '2026-05-31 21:18:13'),
(28, 'çiçekçi', 1, 4, 0, '2026-05-31 21:18:25'),
(29, 'çiçekçi', 1, 4, 0, '2026-05-31 21:19:16'),
(30, 'çiçekçi', 1, 4, 0, '2026-05-31 21:19:49'),
(31, 'çiçekçi', 1, 4, 0, '2026-05-31 21:20:08'),
(32, 'çiçekçi', 1, 4, 0, '2026-05-31 21:20:08'),
(33, 'çiçekçi', 1, 4, 0, '2026-05-31 21:20:42'),
(34, 'çiçekçi', 1, 4, 0, '2026-05-31 21:20:43'),
(35, 'çiçekçi', 1, 4, 0, '2026-05-31 21:20:52'),
(36, 'çiçekçi', 1, 4, 0, '2026-05-31 21:20:53'),
(37, 'çiçekçi', 1, 4, 0, '2026-05-31 21:20:53'),
(38, 'çiçekçi', 1, 4, 0, '2026-05-31 21:20:59'),
(39, 'çiçekçi', 1, 4, 0, '2026-05-31 21:21:00'),
(40, 'çiçekçi', 1, 4, 0, '2026-05-31 21:21:09'),
(41, 'çiçekçi', 1, 4, 0, '2026-05-31 21:21:10'),
(42, 'çiçekçi', 1, 4, 0, '2026-05-31 21:21:10'),
(43, 'çiçekçi', 1, 4, 0, '2026-05-31 21:21:10'),
(44, 'çiçekçi', 1, 4, 0, '2026-05-31 21:21:37'),
(45, 'çiçekçi', 1, 4, 0, '2026-05-31 21:21:38'),
(46, 'çiçekçi', 1, 4, 0, '2026-05-31 21:21:38'),
(47, 'berber', 1, 0, 0, '2026-06-01 18:12:38'),
(48, 'lokanta', 1, 0, 1, '2026-06-01 18:12:41'),
(49, 'lokanta', 1, 0, 1, '2026-06-01 18:13:04'),
(50, 'lokanta', 1, 0, 1, '2026-06-01 18:13:12'),
(51, 'lokanta', 1, 0, 1, '2026-06-01 18:13:34'),
(52, 'lokanta', 1, 0, 1, '2026-06-01 18:13:46'),
(53, 'lokanta', 1, 0, 1, '2026-06-01 18:13:46'),
(54, 'lokanta', 4, 0, 0, '2026-06-01 18:14:01'),
(55, 'çiçekçi', 1, 2, 0, '2026-06-01 18:14:22'),
(56, 'çiçekçi', 1, 2, 0, '2026-06-01 18:15:45'),
(57, 'çiçekçi', 1, 2, 0, '2026-06-01 18:16:05'),
(58, 'çiçekçi', 1, 2, 0, '2026-06-01 18:16:06'),
(59, 'çiçekçi', 1, 2, 0, '2026-06-01 18:16:06'),
(60, 'çiçekçi', 1, 2, 0, '2026-06-01 18:16:07'),
(61, 'çiçekçi', 1, 2, 0, '2026-06-01 18:16:18'),
(62, 'çiçekçi', 1, 2, 0, '2026-06-01 18:16:19'),
(63, 'çiçekçi', 1, 2, 0, '2026-06-01 18:16:19'),
(64, 'çiçekçi', 1, 2, 0, '2026-06-01 18:16:20'),
(65, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:14'),
(66, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:14'),
(67, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:15'),
(68, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:16'),
(69, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:16'),
(70, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:16'),
(71, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:16'),
(72, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:23'),
(73, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:24'),
(74, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:24'),
(75, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:53'),
(76, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:53'),
(77, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:53'),
(78, 'çiçekçi', 1, 2, 0, '2026-06-01 18:17:54'),
(79, 'çiçekçi', 1, 2, 0, '2026-06-01 18:18:10'),
(80, 'çiçekçi', 1, 2, 0, '2026-06-01 18:18:11'),
(81, 'çiçekçi', 1, 2, 0, '2026-06-01 18:18:11'),
(82, 'çiçekçi', 1, 2, 0, '2026-06-01 18:18:11'),
(83, 'çiçekçi', 1, 2, 0, '2026-06-01 18:18:19'),
(84, 'çiçekçi', 1, 2, 0, '2026-06-01 18:18:19'),
(85, 'çiçekçi', 1, 2, 0, '2026-06-01 18:18:20'),
(86, 'çiçekçi', 1, 2, 0, '2026-06-01 18:20:06'),
(87, 'çiçekçi', 1, 2, 0, '2026-06-01 18:20:28'),
(88, 'çiçekçi', 1, 2, 0, '2026-06-01 18:20:29'),
(89, 'lokanta', 1, 0, 1, '2026-06-01 18:20:51');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ilceler`
--

CREATE TABLE `ilceler` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `il_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ilceler`
--

INSERT INTO `ilceler` (`id`, `ad`, `il_id`) VALUES
(1, 'Konak', 1),
(2, 'Bornova', 1),
(3, 'Karşıyaka', 1),
(4, 'Buca', 1),
(5, 'Çiğli', 1),
(6, 'Gaziemir', 1),
(7, 'Balçova', 1),
(8, 'Narlıdere', 1),
(9, 'Kadıköy', 2),
(10, 'Beşiktaş', 2),
(11, 'Şişli', 2),
(12, 'Fatih', 2),
(13, 'Üsküdar', 2),
(14, 'Sarıyer', 2),
(15, 'Bakırköy', 2),
(16, 'Beyoğlu', 2),
(17, 'Çankaya', 3),
(18, 'Keçiören', 3),
(19, 'Yenimahalle', 3),
(20, 'Mamak', 3),
(21, 'Etimesgut', 3),
(22, 'Sincan', 3),
(23, 'Altındağ', 3),
(24, 'Gölbaşı', 3),
(25, 'Nilüfer', 4),
(26, 'Osmangazi', 4),
(27, 'Yıldırım', 4),
(28, 'Mudanya', 4),
(29, 'Gürsu', 4),
(30, 'Kestel', 4),
(31, 'Gemlik', 4),
(32, 'İnegöl', 4),
(33, 'Muratpaşa', 5),
(34, 'Kepez', 5),
(35, 'Konyaaltı', 5),
(36, 'Alanya', 5),
(37, 'Manavgat', 5),
(38, 'Serik', 5),
(39, 'Kemer', 5),
(40, 'Aksu', 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iller`
--

CREATE TABLE `iller` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `iller`
--

INSERT INTO `iller` (`id`, `ad`) VALUES
(1, 'İzmir'),
(2, 'İstanbul'),
(3, 'Ankara'),
(4, 'Bursa'),
(5, 'Antalya'),
(6, 'Adana'),
(7, 'Trabzon'),
(8, 'Eskişehir'),
(9, 'Gaziantep'),
(10, 'Konya'),
(11, 'Mersin'),
(12, 'Diyarbakır'),
(13, 'Samsun'),
(14, 'Denizli'),
(15, 'Sakarya');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `isletmeler`
--

CREATE TABLE `isletmeler` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `mahalle_id` int(11) NOT NULL,
  `adres` text DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `calisma_saatleri` varchar(100) DEFAULT '09:00 - 18:00',
  `hizmet_turu` varchar(100) DEFAULT 'Genel',
  `tiklanma_sayisi` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `isletmeler`
--

INSERT INTO `isletmeler` (`id`, `ad`, `kategori_id`, `mahalle_id`, `adres`, `telefon`, `calisma_saatleri`, `hizmet_turu`, `tiklanma_sayisi`) VALUES
(1, 'Güven Kundura', 1, 1, 'Göztepe Mah. 12. Sokak No:5', '02321112233', '08:30 - 19:00', 'Tamirat', 0),
(2, 'Usta Kundura Bornova', 1, 9, 'Kazımdirik Mah. Sanayi Sitesi', '02324445566', '09:00 - 18:00', 'Tamirat', 0),
(3, 'Mis Kokulu Çiçek Evi', 2, 1, 'Göztepe Cd. No:84/A', '02325551122', '08:00 - 22:00', 'Çiçekçi', 4),
(4, 'Alsancak Çiçek Sarayı', 2, 2, 'Alsancak Donanma Sokak No:3', '02329998877', '07:30 - 00:00', 'Çiçekçi', 1),
(5, 'Kordon Lezzet Evi', 3, 2, 'Mithatpaşa Caddesi No:104', '02327778899', '10:00 - 22:00', 'Gıda', 1),
(6, 'Moda Kahvecisi', 3, 17, 'Moda Cd. No:12', '02163334455', '08:00 - 23:00', 'Gıda', 0),
(7, 'Moda Sihirli Çiçek', 2, 17, 'Moda Sahil Yolu No:9', '02167776655', '08:30 - 21:00', 'Çiçekçi', 0),
(8, 'Bebek Çiçek Tasarım', 2, 25, 'Bebek Mh. Cevdetpaşa Cd.', '02128889911', '09:00 - 20:00', 'Çiçekçi', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`id`, `ad`) VALUES
(1, 'Ayakkabı Tamiri & Kundura'),
(2, 'Çiçekçi & Peyzaj'),
(3, 'Gıda & Restoran'),
(4, 'Kişisel Bakım & Berber'),
(5, 'Anahtarcı & Çilingir');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mahalleler`
--

CREATE TABLE `mahalleler` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `ilce_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `mahalleler`
--

INSERT INTO `mahalleler` (`id`, `ad`, `ilce_id`) VALUES
(1, 'Göztepe', 1),
(2, 'Alsancak', 1),
(3, 'Kültür', 1),
(4, 'Kahramanlar', 1),
(5, 'Mithatpaşa', 1),
(6, 'Güzelyalı', 1),
(7, 'Murat', 1),
(8, 'Akdeniz', 1),
(9, 'Kazımdirik', 2),
(10, 'Erzene', 2),
(11, 'Evka-3', 2),
(12, 'Atatürk', 2),
(13, 'Mevlana', 2),
(14, 'Doğanlar', 2),
(15, 'Kızılay', 2),
(16, 'Merkez', 2),
(17, 'Moda', 9),
(18, 'Caferağa', 9),
(19, 'Feneryolu', 9),
(20, 'Göztepe', 9),
(21, 'Suadiye', 9),
(22, 'Bostancı', 9),
(23, 'Erenköy', 9),
(24, 'Acıbadem', 9),
(25, 'Bebek', 10),
(26, 'Levent', 10),
(27, 'Ortaköy', 10),
(28, 'Arnavutköy', 10),
(29, 'Etiler', 10),
(30, 'Abbasaga', 10),
(31, 'Dikilitaş', 10),
(32, 'Yıldız', 10);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `arama_istatistikleri`
--
ALTER TABLE `arama_istatistikleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ilceler`
--
ALTER TABLE `ilceler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `iller`
--
ALTER TABLE `iller`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `isletmeler`
--
ALTER TABLE `isletmeler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mahalleler`
--
ALTER TABLE `mahalleler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `arama_istatistikleri`
--
ALTER TABLE `arama_istatistikleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Tablo için AUTO_INCREMENT değeri `ilceler`
--
ALTER TABLE `ilceler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Tablo için AUTO_INCREMENT değeri `iller`
--
ALTER TABLE `iller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `isletmeler`
--
ALTER TABLE `isletmeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `mahalleler`
--
ALTER TABLE `mahalleler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
