-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 01 Ağu 2023, 02:03:15
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `godless`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `login_log`
--

CREATE TABLE `login_log` (
  `login_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `IP` varchar(255) NOT NULL,
  `device` varchar(500) NOT NULL,
  `browser` varchar(100) NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `pic_path` text NOT NULL,
  `link1` text DEFAULT NULL,
  `link2` text DEFAULT NULL,
  `link3` text DEFAULT NULL,
  `link4` text DEFAULT NULL,
  `link5` text DEFAULT NULL,
  `link6` text DEFAULT NULL,
  `visit_count` int(20) NOT NULL,
  `last_visit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `eposta` varchar(50) NOT NULL,
  `IP` varchar(255) NOT NULL,
  `unique_id` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_time` datetime NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `eposta`, `IP`, `unique_id`, `password`, `reg_time`, `last_login`) VALUES
(8, 'byk1lla', 'cozanqel0811@gmail.com', '::1', '31072023045956-4ctFr', '$2y$10$538lU8d6TGz3mBQFdWDfZeJP9xZ4BLo3BZduDGKQGDPCzHsuJyxJS', '2023-07-31 05:59:56', '2023-07-31 05:59:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uservisitors`
--

CREATE TABLE `uservisitors` (
  `id` int(11) NOT NULL,
  `userid` varchar(25) NOT NULL,
  `visitcount` int(20) NOT NULL,
  `last_visit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniques` (`link1`,`link2`,`link3`,`link4`,`link5`,`link6`) USING HASH,
  ADD KEY `fk_user` (`user_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`unique_id`,`last_login`) USING BTREE,
  ADD UNIQUE KEY `unique` (`unique_id`,`username`,`eposta`) USING BTREE;

--
-- Tablo için indeksler `uservisitors`
--
ALTER TABLE `uservisitors`
  ADD KEY `fk_user_id` (`userid`,`last_visit`,`visitcount`) USING BTREE;

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `login_log`
--
ALTER TABLE `login_log`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `login_log`
--
ALTER TABLE `login_log`
  ADD CONSTRAINT `login_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`unique_id`);

--
-- Tablo kısıtlamaları `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`unique_id`);

--
-- Tablo kısıtlamaları `uservisitors`
--
ALTER TABLE `uservisitors`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`userid`) REFERENCES `users` (`unique_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
