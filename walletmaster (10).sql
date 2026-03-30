-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Már 17. 16:47
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `walletmaster`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `celok`
--

CREATE TABLE `celok` (
  `cel_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cel_nev` varchar(150) NOT NULL,
  `cel_osszeg` decimal(12,2) NOT NULL,
  `budzse` int(11) NOT NULL,
  `hatarido` date NOT NULL,
  `letrehozas_datum` datetime NOT NULL DEFAULT current_timestamp(),
  `modositas_datum` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `statusz` enum('aktív','kész','törölve') NOT NULL DEFAULT 'aktív'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `celok`
--

INSERT INTO `celok` (`cel_id`, `user_id`, `cel_nev`, `cel_osszeg`, `budzse`, `hatarido`, `letrehozas_datum`, `modositas_datum`, `statusz`) VALUES
(4, 31, 'Egyetem', 400000.00, 10000, '2026-08-31', '2026-02-02 00:00:00', '2026-02-02 00:00:00', 'aktív'),
(5, 28, 'Felni', 160000.00, 70000, '2026-05-30', '2026-02-20 00:00:00', '2026-02-20 00:00:00', 'aktív');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznaloi_velemenyek`
--

CREATE TABLE `felhasznaloi_velemenyek` (
  `velemeny_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `szoveg` text NOT NULL,
  `tipus` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `felhasznaloi_velemenyek`
--

INSERT INTO `felhasznaloi_velemenyek` (`velemeny_id`, `user_id`, `szoveg`, `tipus`, `created_at`, `updated_at`) VALUES
(1, 28, 'Több kategória', 'advice', '2026-03-16 16:03:39', '2026-03-16 16:03:39'),
(2, 28, 'Android app', 'fejlesztes', '2026-03-16 16:12:34', '2026-03-16 16:12:34'),
(3, 28, 'iOS app lehetne szerintem.', 'otlet', '2026-03-16 18:10:29', '2026-03-16 18:10:29');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo_kodok`
--

CREATE TABLE `felhasznalo_kodok` (
  `kod_id` bigint(20) UNSIGNED NOT NULL,
  `felhasznalo_id` bigint(20) UNSIGNED NOT NULL,
  `kod` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `felhasznalo_kodok`
--

INSERT INTO `felhasznalo_kodok` (`kod_id`, `felhasznalo_id`, `kod`, `created_at`, `updated_at`) VALUES
(1, 28, '314042', '2026-03-15 19:13:11', '2026-03-15 19:13:11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fix`
--

CREATE TABLE `fix` (
  `fix_id` int(11) NOT NULL,
  `szamla_id` int(11) NOT NULL,
  `tipus` enum('havi','féléves','éves') NOT NULL DEFAULT 'havi',
  `osszeg` int(11) NOT NULL,
  `letrehozas` date DEFAULT NULL,
  `fizetve` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `koltseg_limit`
--

CREATE TABLE `koltseg_limit` (
  `koltseg_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `szamla_id` int(11) DEFAULT NULL,
  `osszeg` int(11) DEFAULT NULL,
  `tipus` tinyint(1) NOT NULL DEFAULT 1,
  `start_datum` date DEFAULT NULL,
  `vege_datum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `koltseg_limit`
--

INSERT INTO `koltseg_limit` (`koltseg_id`, `user_id`, `szamla_id`, `osszeg`, `tipus`, `start_datum`, `vege_datum`) VALUES
(2, 28, NULL, NULL, 0, '2026-02-01', '2026-02-28'),
(5, 28, NULL, NULL, 0, '2026-02-01', '2026-02-28'),
(6, 28, NULL, NULL, 0, '2026-02-01', '2026-02-28'),
(7, 28, NULL, NULL, 0, '2026-02-01', '2026-02-28'),
(8, 28, NULL, 1, 0, '2026-02-01', '2026-02-28'),
(9, 28, NULL, 2, 0, '2026-02-01', '2026-02-28'),
(10, 28, NULL, 1, 0, '2026-02-01', '2026-02-28'),
(11, 28, NULL, 0, 0, '2026-02-01', '2026-02-28'),
(12, 28, NULL, 15000, 0, '2026-02-01', '2026-02-28'),
(13, 28, NULL, NULL, 0, '2026-02-01', '2026-02-28');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('kauba.zira7@gmail.com', '$2y$12$XYyqDC7.y1/GmZss9D2VBe/YkBx2abo8yT2aRDudi3EpN5.NbbExy', '2026-01-22 18:08:05');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szamla`
--

CREATE TABLE `szamla` (
  `szamla_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `osszeg` int(11) NOT NULL,
  `honnan` varchar(50) DEFAULT NULL,
  `leiras` varchar(200) DEFAULT NULL,
  `datum` datetime NOT NULL DEFAULT curdate(),
  `fix` varchar(10) DEFAULT '0',
  `tipus` tinyint(1) NOT NULL DEFAULT 1,
  `kategoria_nev` varchar(50) NOT NULL DEFAULT 'Egyéb'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `szamla`
--

INSERT INTO `szamla` (`szamla_id`, `user_id`, `osszeg`, `honnan`, `leiras`, `datum`, `fix`, `tipus`, `kategoria_nev`) VALUES
(1, 6, 2100, 'Lidl', 'Thermo kabát', '2025-01-08 00:00:00', 'nem', 0, 'Egyéb'),
(3, 6, 1000, 'Aldi', 'Bacon', '2025-01-07 00:00:00', 'nem', 0, 'Egyéb'),
(4, 6, 12000, 'Részvény piac', 'GitHub részvények(3db)', '2025-01-08 00:00:00', 'nem', 0, 'egyeb'),
(5, 6, 80000, 'Logiscool Rákoskeresztur', 'Havi logiscool fizetés', '2025-01-05 00:00:00', 'nem', 1, 'fizetes'),
(7, 7, 10000, 'Fahéjas torta', 'Nagyon finooooom 🤪', '2026-01-03 00:00:00', 'nem', 0, 'elelmiszer'),
(8, 6, 2300, 'Lidl', 'Fahéjas pizza, baba olaj, uborka, energia ital', '2026-01-10 00:00:00', 'nem', 0, 'elelmiszer'),
(9, 6, 1500, 'Lidl', '0.5kg fehér kenyér', '2026-01-15 00:00:00', 'nem', 0, 'elelmiszer'),
(10, 28, 10000, 'Lidl', 'Víz, pizza, kává', '2025-01-12 00:00:00', '0', 0, 'elelmiszer'),
(11, 28, 5000, 'Spar', 'adwsdascyscas', '2026-01-10 00:00:00', '0', 0, 'Élelmiszer'),
(12, 28, 60000, 'Alza', 'akkumulátor', '2026-01-01 00:00:00', '0', 0, 'Elektronika'),
(13, 28, 13000, 'eMag', 'Szappan', '2025-01-10 00:00:00', '0', 0, 'Háztartas'),
(14, 28, 50000, 'Ikea', 'szekrény', '2025-08-10 00:00:00', '0', 0, 'Lakhatás'),
(15, 28, 10000, 'Lidl', 'kaja', '2026-01-01 00:00:00', '0', 0, '0'),
(16, 28, 20000, 'Netflix', NULL, '2026-01-02 00:00:00', 'havi', 0, 'Élelmiszer'),
(17, 28, 10000, 'Alza', 'pendrive', '2025-01-15 00:00:00', '0', 0, 'Elektronika'),
(18, 28, 30000, 'BP', NULL, '2026-01-10 00:00:00', '0', 1, 'Befektetés'),
(19, 6, 1790, 'StarB', 'Valami kávé', '2026-01-29 00:00:00', 'nem', 0, 'Szórakozás'),
(20, 6, 860, 'Spar', 'Fehér monster\r\nA vadállatok itala🤪', '2026-01-29 00:00:00', 'nem', 0, 'Élelmiszer'),
(21, 6, 800, 'Spar', 'Gumclicucli', '2026-01-29 00:00:00', 'nem', 0, 'Élelmiszer'),
(24, 31, 690, 'Google', 'Google one előfizetés', '2026-02-01 00:00:00', 'havi', 0, 'Előfizetés'),
(25, 31, 1743, 'Lidl', 'Tökmag, Túrórudi, 5db goudás sonkás buci', '2026-02-02 00:00:00', 'nem', 0, 'Élelmiszer'),
(26, 28, 18450, 'Aldi', 'Heti bevásárlás (zöldség, tejtermék, hús)', '2026-02-08 18:22:00', 'nem', 1, 'Élelmiszer'),
(27, 28, 6790, 'DM', 'Mosószer + papírtörlő', '2026-02-06 16:11:00', 'nem', 1, 'Háztartás'),
(28, 28, 12990, 'eMAG', 'USB-C töltő + kábel', '2026-01-29 20:05:00', 'nem', 1, 'Elektronika'),
(29, 28, 165000, 'Főbérlő', 'Albérlet - február', '2026-02-01 09:00:00', 'havi', 1, 'Lakhatás'),
(30, 28, 32450, 'Bank', 'Személyi kölcsön törlesztő', '2026-02-03 08:14:00', 'havi', 1, 'Hitel'),
(31, 28, 18990, 'H&M', 'Pulóver + póló', '2026-01-24 14:37:00', 'nem', 1, 'Ruházat'),
(32, 28, 4320, 'BENU', 'Vitamin + fájdalomcsillapító', '2026-02-07 12:08:00', 'nem', 1, 'Gyógyszer'),
(33, 28, 12990, 'Gym', 'Havi bérlet', '2026-02-02 07:40:00', 'havi', 1, 'Edzés'),
(34, 28, 24800, 'OMV', 'Üzemanyag tankolás', '2026-02-05 19:12:00', 'nem', 1, 'Autó'),
(35, 28, 7990, 'Libri', 'Vizsgafelkészítő könyv', '2026-01-18 17:26:00', 'nem', 1, 'Tanulmányok'),
(36, 28, 15400, 'MÁV', 'Vonatjegy oda-vissza', '2026-01-31 06:55:00', 'nem', 1, 'Utazás'),
(37, 28, 5690, 'Cinema City', 'Mozi + popcorn', '2026-02-09 20:10:00', 'nem', 1, 'Szórakozás'),
(39, 1, 18450, 'Aldi', 'Heti bevásárlás (zöldség, tejtermék, hús)', '2026-02-08 18:22:00', 'nem', 1, 'Élelmiszer'),
(40, 1, 6790, 'DM', 'Mosószer + papírtörlő', '2026-02-06 16:11:00', 'nem', 1, 'Háztartás'),
(41, 1, 12990, 'eMAG', 'USB-C töltő + kábel', '2026-01-29 20:05:00', 'nem', 1, 'Elektronika'),
(42, 1, 165000, 'Főbérlő', 'Albérlet - február', '2026-02-01 09:00:00', 'havi', 1, 'Lakhatás'),
(43, 1, 32450, 'Bank', 'Személyi kölcsön törlesztő', '2026-02-03 08:14:00', 'havi', 1, 'Hitel'),
(44, 1, 18990, 'H&M', 'Pulóver + póló', '2026-01-24 14:37:00', 'nem', 1, 'Ruházat'),
(45, 1, 4320, 'BENU', 'Vitamin + fájdalomcsillapító', '2026-02-07 12:08:00', 'nem', 1, 'Gyógyszer'),
(46, 1, 12990, 'Gym', 'Havi bérlet', '2026-02-02 07:40:00', 'havi', 1, 'Edzés'),
(47, 1, 24800, 'OMV', 'Üzemanyag tankolás', '2026-02-05 19:12:00', 'nem', 1, 'Autó'),
(48, 1, 7990, 'Libri', 'Vizsgafelkészítő könyv', '2026-01-18 17:26:00', 'nem', 1, 'Tanulmányok'),
(49, 1, 15400, 'MÁV', 'Vonatjegy oda-vissza', '2026-01-31 06:55:00', 'nem', 1, 'Utazás'),
(50, 1, 5690, 'Cinema City', 'Mozi + popcorn', '2026-02-09 20:10:00', 'nem', 1, 'Szórakozás'),
(51, 1, 3500, 'Revolut', 'App előfizetés', '2026-02-04 21:03:00', 'nem', 1, 'Egyéb'),
(52, 1, 21340, 'Tesco', 'Nagybevásárlás', '2026-01-12 17:45:00', 'nem', 1, 'Élelmiszer'),
(53, 1, 8450, 'OBI', 'Tisztítószerek', '2026-01-18 15:22:00', 'nem', 1, 'Háztartás'),
(54, 1, 89900, 'MediaMarkt', 'Monitor vásárlás', '2026-01-25 19:10:00', 'nem', 1, 'Elektronika'),
(55, 1, 170000, 'Főbérlő', 'Albérlet - január', '2026-01-01 09:00:00', 'havi', 1, 'Lakhatás'),
(56, 1, 31500, 'OTP Bank', 'Lakáshitel törlesztő', '2026-01-05 08:00:00', 'havi', 1, 'Hitel'),
(57, 1, 22490, 'Zara', 'Kabát vásárlás', '2026-02-02 14:30:00', 'nem', 1, 'Ruházat'),
(58, 1, 5320, 'Pingvin Patika', 'Gyógyszerek', '2026-02-03 11:15:00', 'nem', 1, 'Gyógyszer'),
(59, 1, 13990, 'Fitness Club', 'Havi bérlet', '2026-02-01 07:50:00', 'havi', 1, 'Edzés'),
(60, 1, 27200, 'Shell', 'Tankolás', '2026-02-06 18:40:00', 'nem', 1, 'Autó'),
(61, 1, 12500, 'Bookline', 'Programozás könyv', '2026-02-07 20:12:00', 'nem', 1, 'Tanulmányok'),
(62, 1, 18900, 'WizzAir', 'Repülőjegy foglalás', '2026-01-28 13:05:00', 'nem', 1, 'Utazás'),
(63, 1, 7400, 'Steam', 'Játék vásárlás', '2026-02-04 22:10:00', 'nem', 1, 'Szórakozás'),
(64, 1, 2900, 'Apple', 'iCloud előfizetés', '2026-02-01 06:00:00', 'havi', 1, 'Egyéb'),
(65, 28, 16780, 'Lidl', 'Heti bevásárlás', '2026-01-10 18:05:00', 'nem', 1, 'Élelmiszer'),
(66, 28, 5930, 'Rossmann', 'Háztartási cikkek', '2026-01-15 16:45:00', 'nem', 1, 'Háztartás'),
(67, 28, 45990, 'Alza', 'Fejhallgató', '2026-02-01 21:30:00', 'nem', 1, 'Elektronika'),
(68, 28, 155000, 'Tulajdonos', 'Albérlet - január', '2026-01-02 09:10:00', 'havi', 1, 'Lakhatás'),
(69, 28, 28400, 'Erste Bank', 'Hitel törlesztés', '2026-01-06 08:20:00', 'havi', 1, 'Hitel'),
(70, 28, 15990, 'Reserved', 'Farmer nadrág', '2026-02-03 13:20:00', 'nem', 1, 'Ruházat'),
(71, 28, 3890, 'Gyógyszertár', 'Vitamin', '2026-02-04 10:05:00', 'nem', 1, 'Gyógyszer'),
(72, 28, 11990, 'Gym City', 'Edzőterem bérlet', '2026-02-01 07:30:00', 'havi', 1, 'Edzés'),
(74, 28, 9800, 'Udemy', 'Online kurzus', '2026-01-22 22:15:00', 'nem', 1, 'Tanulmányok'),
(75, 28, 13200, 'FlixBus', 'Buszjegy', '2026-01-30 06:40:00', 'nem', 1, 'Utazás'),
(76, 28, 6200, 'Netflix', 'Havi előfizetés', '2026-02-01 05:00:00', 'havi', 1, 'Szórakozás'),
(77, 28, 4500, 'Revolut', 'Premium díj', '2026-02-02 08:00:00', 'havi', 1, 'Egyéb'),
(78, 1, 22000, 'Tesco', 'Ár-visszatérítés / kupon jóváírás', '2026-01-11 13:20:00', 'nem', 0, 'Élelmiszer'),
(79, 1, 9000, 'OBI', 'Reklamáció jóváírás', '2026-01-16 10:05:00', 'nem', 0, 'Háztartás'),
(80, 1, 19500, 'eMAG', 'Garanciális visszatérítés', '2026-01-22 18:40:00', 'nem', 0, 'Elektronika'),
(81, 1, 45000, 'Főbérlő', 'Kaució rész-visszafizetés', '2026-01-28 09:15:00', 'nem', 0, 'Lakhatás'),
(82, 1, 12000, 'Bank', 'Túlfizetés visszautalás', '2026-02-03 08:55:00', 'nem', 0, 'Hitel'),
(83, 1, 15000, 'H&M', 'Visszáru jóváírás', '2026-02-04 16:10:00', 'nem', 0, 'Ruházat'),
(84, 1, 6500, 'BENU', 'Egészségpénztár elszámolás', '2026-02-06 11:30:00', 'nem', 0, 'Gyógyszer'),
(85, 1, 8000, 'Edzőterem', 'Bérlet sztornó / jóváírás', '2026-02-07 07:20:00', 'nem', 0, 'Edzés'),
(86, 1, 17300, 'Biztosító', 'Kárkifizetés (autó)', '2026-02-08 14:05:00', 'nem', 0, 'Autó'),
(87, 1, 12000, 'Udemy', 'Kurzus-visszatérítés', '2026-02-09 20:55:00', 'nem', 0, 'Tanulmányok'),
(88, 1, 25500, 'WizzAir', 'Járattörlés miatti refund', '2026-01-30 12:40:00', 'nem', 0, 'Utazás'),
(89, 1, 4990, 'Cinema City', 'Jegy visszatérítés', '2026-02-10 21:10:00', 'nem', 0, 'Szórakozás'),
(90, 1, 30000, 'Revolut', 'Bónusz / promóciós jóváírás', '2026-02-11 09:00:00', 'nem', 0, 'Egyéb'),
(91, 1, 22000, 'Tesco', 'Ár-visszatérítés / kupon jóváírás', '2026-01-11 13:20:00', 'nem', 0, 'Élelmiszer'),
(92, 1, 9000, 'OBI', 'Reklamáció jóváírás', '2026-01-16 10:05:00', 'nem', 0, 'Háztartás'),
(93, 1, 19500, 'eMAG', 'Garanciális visszatérítés', '2026-01-22 18:40:00', 'nem', 0, 'Elektronika'),
(94, 1, 45000, 'Főbérlő', 'Kaució rész-visszafizetés', '2026-01-28 09:15:00', 'nem', 0, 'Lakhatás'),
(95, 1, 12000, 'Bank', 'Túlfizetés visszautalás', '2026-02-03 08:55:00', 'nem', 0, 'Hitel'),
(96, 1, 15000, 'H&M', 'Visszáru jóváírás', '2026-02-04 16:10:00', 'nem', 0, 'Ruházat'),
(97, 1, 6500, 'BENU', 'Egészségpénztár elszámolás', '2026-02-06 11:30:00', 'nem', 0, 'Gyógyszer'),
(98, 1, 8000, 'Edzőterem', 'Bérlet sztornó / jóváírás', '2026-02-07 07:20:00', 'nem', 0, 'Edzés'),
(99, 1, 17300, 'Biztosító', 'Kárkifizetés (autó)', '2026-02-08 14:05:00', 'nem', 0, 'Autó'),
(100, 1, 12000, 'Udemy', 'Kurzus-visszatérítés', '2026-02-09 20:55:00', 'nem', 0, 'Tanulmányok'),
(101, 1, 25500, 'WizzAir', 'Járattörlés miatti refund', '2026-01-30 12:40:00', 'nem', 0, 'Utazás'),
(102, 1, 4990, 'Cinema City', 'Jegy visszatérítés', '2026-02-10 21:10:00', 'nem', 0, 'Szórakozás'),
(103, 1, 30000, 'Revolut', 'Bónusz / promóciós jóváírás', '2026-02-11 09:00:00', 'nem', 0, 'Egyéb'),
(104, 28, 18000, 'Lidl', 'Árgarancia jóváírás', '2026-01-10 19:05:00', 'nem', 0, 'Élelmiszer'),
(105, 28, 7500, 'Rossmann', 'Kupon jóváírás', '2026-01-14 15:35:00', 'nem', 0, 'Háztartás'),
(106, 28, 22000, 'Alza', 'Visszaküldés utáni refund', '2026-01-21 17:50:00', 'nem', 0, 'Elektronika'),
(107, 28, 60000, 'Tulajdonos', 'Kaució visszafizetés', '2026-01-27 09:25:00', 'nem', 0, 'Lakhatás'),
(108, 28, 9500, 'Erste Bank', 'Túlfizetés rendezése', '2026-02-02 08:10:00', 'nem', 0, 'Hitel'),
(109, 28, 12990, 'Reserved', 'Visszáru jóváírás', '2026-02-03 13:50:00', 'nem', 0, 'Ruházat'),
(110, 28, 5200, 'Gyógyszertár', 'Egészségpénztár visszatérítés', '2026-02-04 10:20:00', 'nem', 0, 'Gyógyszer'),
(111, 28, 9500, 'Gym City', 'Bérlet korrekció / jóváírás', '2026-02-05 07:35:00', 'nem', 0, 'Edzés'),
(113, 28, 16000, 'Coursera', 'Előfizetés visszatérítés', '2026-01-18 22:05:00', 'nem', 0, 'Tanulmányok'),
(114, 28, 19900, 'MÁV', 'Jegy visszatérítés', '2026-01-31 08:40:00', 'nem', 0, 'Utazás'),
(115, 28, 5990, 'Netflix', 'Dupla terhelés miatti refund', '2026-02-01 05:10:00', 'nem', 0, 'Szórakozás'),
(116, 28, 24000, 'Revolut', 'Promo bónusz', '2026-02-07 09:10:00', 'nem', 0, 'Egyéb'),
(117, 28, 10000, 'Alza', 'TV', '2026-01-20 00:00:00', 'nem', 0, 'Számla'),
(118, 28, 25000, 'Érdi pékség', 'kenyér, gyümölcslé, süti', '2026-02-17 00:00:00', '0', 0, 'Élelmiszer'),
(119, 28, 5000, 'Tesco', 'autó illatosító', '2026-02-17 00:00:00', 'nem', 0, 'Autó'),
(121, 28, 20000, 'Alza', 'töltő', '2026-01-10 00:00:00', 'nem', 0, 'Elektronika'),
(122, 32, 20000, 'eMag', 'mosószer', '2026-02-10 00:00:00', 'nem', 0, 'Háztartas'),
(123, 32, 35010, 'OBI', 'parketta', '2026-02-02 00:00:00', 'nem', 0, 'Lakhatás'),
(124, 32, 40000, 'Árukereső', 'Redmi Note 13', '2026-02-10 00:00:00', 'nem', 0, 'Elektronika'),
(125, 32, 15000, 'Mozi', 'mozijegy, popcorn', '2026-02-10 00:00:00', 'nem', 0, 'Szórakozás'),
(126, 32, 10000, 'Gouda', 'hamburgerek', '2026-02-01 00:00:00', 'nem', 0, 'Élelmiszer'),
(127, 32, 15000, 'Spar', 'pizza', '2026-02-05 00:00:00', 'nem', 0, 'Élelmiszer'),
(128, 32, 30000, 'Auchan', 'élelmiszerek', '2026-02-07 00:00:00', 'nem', 0, 'Élelmiszer'),
(129, 34, 20000, 'Szimdental', 'fogászat', '2026-02-18 00:00:00', 'nem', 0, 'Gyógyszer'),
(130, 34, 12500, 'Brandt virágüzlet', 'rózsák, örök rózsa', '2026-02-14 00:00:00', 'nem', 0, 'Szórakozás'),
(131, 34, 10000, 'Burger King', 'étel', '2026-02-17 00:00:00', 'nem', 0, 'Élelmiszer'),
(132, 34, 3248, 'Axel cukrászda', 'süti', '2026-02-14 00:00:00', 'nem', 0, 'Élelmiszer'),
(133, 31, 123, 'Teszthely', 'Teszt adat merge után', '2026-03-04 00:00:00', 'nem', 1, 'Egyéb'),
(134, 31, 123, 'Teszthely2', 'Teszt adat 2', '2026-03-03 00:00:00', 'nem', 0, 'Élelmiszer'),
(135, 31, 123, 'Youtube', 'Test adat 3', '2026-03-05 00:00:00', 'nem', 0, 'Szórakozás');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tartozasok`
--

CREATE TABLE `tartozasok` (
  `tartozasok_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `partner_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `partner_nev` varchar(100) DEFAULT NULL,
  `osszeg` int(11) NOT NULL,
  `tipus` tinyint(1) NOT NULL,
  `leiras` varchar(50) DEFAULT NULL,
  `datum` date NOT NULL,
  `statusz` enum('függőben','elfogadva','elutasítva','rendezve') NOT NULL DEFAULT 'függőben',
  `ki_irta` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `tartozasok`
--

INSERT INTO `tartozasok` (`tartozasok_id`, `user_id`, `partner_user_id`, `partner_nev`, `osszeg`, `tipus`, `leiras`, `datum`, `statusz`, `ki_irta`, `created_at`, `updated_at`) VALUES
(1, 28, NULL, 'Szabó Máté', 5000, 0, NULL, '2026-01-10', 'függőben', NULL, '2026-01-27 17:17:06', '2026-01-27 17:17:06'),
(2, 28, NULL, 'Szabó Máté', 5000, 1, NULL, '2026-01-10', 'függőben', NULL, '2026-01-27 17:24:30', '2026-01-27 17:24:30'),
(3, 28, NULL, 'Szabó Máté', 10000, 1, NULL, '2026-01-10', 'függőben', NULL, '2026-01-27 17:24:48', '2026-01-27 17:24:48'),
(4, 28, 4, 'Szabó Máté', 10000, 1, NULL, '2026-01-10', 'függőben', NULL, '2026-01-27 17:26:21', '2026-01-27 17:26:21'),
(5, 28, 4, 'Szabó Máté', 10000, 1, 'tartozik ez a pali', '2026-01-10', 'függőben', NULL, '2026-01-27 17:29:43', '2026-01-27 17:29:43'),
(7, 28, 29, 'Szabó Máté', 10000, 1, 'tartozik ez a teszter', '2026-01-10', 'függőben', NULL, '2026-01-28 08:10:19', '2026-01-28 08:10:19'),
(8, 28, 29, 'Szabó Máté', 10000, 0, 'tartozik ez a teszter', '2026-01-10', 'függőben', NULL, '2026-01-28 08:11:45', '2026-01-28 08:11:45'),
(9, 28, 29, 'Szabó Máté', 10000, 1, 'tartozik ez a teszter', '2026-01-10', 'függőben', NULL, '2026-01-28 08:12:29', '2026-01-28 08:12:29'),
(10, 28, 29, 'Szabó Máté', 10000, 1, 'tartozik ez a teszter', '2026-01-10', 'függőben', NULL, '2026-01-28 08:15:52', '2026-01-28 08:15:52'),
(11, 28, 10, 'Wallet Master', 10000000, 1, 'Goated', '2026-01-10', 'függőben', NULL, '2026-01-28 08:30:08', '2026-01-28 08:30:08'),
(12, 10, 28, 'Csiha Márk', 3000, 1, 'Netflix', '2026-01-15', 'függőben', NULL, '2026-01-28 08:54:18', '2026-01-28 08:54:18'),
(13, 28, 10, 'kissbela31', 3000, 0, 'Netflix', '2026-01-15', 'függőben', NULL, '2026-01-28 08:54:18', '2026-01-28 08:54:18'),
(14, 10, 28, 'Csiha Márk', 3000, 1, 'HBO Max', '2026-01-15', 'függőben', NULL, '2026-01-28 08:58:55', '2026-01-28 08:58:55'),
(15, 10, 28, 'Csiha Márkó', 4000, 0, 'Disney+', '2025-10-10', 'függőben', NULL, '2026-01-28 09:11:05', '2026-01-28 09:11:05'),
(16, 28, 10, 'kissbela31', 4000, 1, 'Disney+', '2025-10-10', 'függőben', NULL, '2026-01-28 09:11:05', '2026-01-28 09:11:05'),
(17, 28, 28, 'Csiha Márkó', 4000, 1, 'Disney+', '2025-10-10', 'függőben', NULL, '2026-01-28 09:14:30', '2026-01-28 09:14:30'),
(18, 28, 28, 'Csiha Márkó', 4000, 0, 'Disney+', '2025-10-10', 'függőben', NULL, '2026-01-28 09:14:30', '2026-01-28 09:14:30'),
(19, 10, 28, 'Csiha Márkó', 10000, 1, 'vásárlás', '2025-10-10', 'függőben', NULL, '2026-01-28 09:26:32', '2026-01-28 09:26:32'),
(20, 28, 10, '', 10000, 0, 'vásárlás', '2025-10-10', 'függőben', NULL, '2026-01-28 09:26:32', '2026-01-28 09:26:32'),
(21, 10, 28, 'Csiha Márkó', 1000000, 0, 'laptop', '2025-10-10', 'függőben', NULL, '2026-01-28 09:49:04', '2026-01-28 09:49:04'),
(22, 28, 10, '', 1000000, 1, 'laptop', '2025-10-10', 'függőben', NULL, '2026-01-28 09:49:04', '2026-01-28 09:49:04'),
(23, 10, 28, 'Csiha Márkó', 10000, 1, 'vásárlások', '2025-10-10', 'függőben', NULL, '2026-01-28 13:27:26', '2026-01-28 13:27:26'),
(24, 28, 10, 'Wallet Master', 10000, 0, 'vásárlások', '2025-10-10', 'függőben', NULL, '2026-01-28 13:27:26', '2026-01-28 13:27:26'),
(25, 28, 22, 'Kauba Zira', 15000, 1, 'fagyi', '2026-02-10', 'függőben', NULL, '2026-02-15 09:18:09', '2026-02-15 09:18:09'),
(26, 22, 28, 'Csiha Márkó', 15000, 0, 'fagyi', '2026-02-10', 'függőben', NULL, '2026-02-15 09:18:09', '2026-02-15 09:18:09'),
(27, 28, NULL, 'Kovács János', 1000, 1, 'Teszt tranzakció', '2026-02-19', 'függőben', NULL, '2026-02-19 18:04:10', '2026-02-19 18:04:10'),
(28, 28, NULL, 'Kovács János', 1000, 1, 'Teszt tranzakció', '2026-02-19', 'függőben', NULL, '2026-02-19 18:04:47', '2026-02-19 18:04:47'),
(29, 28, NULL, 'Kovács János', 1000, 1, 'Teszt tranzakció', '2026-02-19', 'függőben', NULL, '2026-02-19 18:05:03', '2026-02-19 18:05:03'),
(30, 28, NULL, 'Kovács János', 1000, 1, 'Teszt tranzakció', '2026-02-19', 'függőben', NULL, '2026-02-19 18:06:35', '2026-02-19 18:06:35');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vez_nev` varchar(100) DEFAULT NULL,
  `ker_nev` varchar(100) DEFAULT NULL,
  `email` varchar(190) NOT NULL,
  `telszam` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `regisztralt` datetime NOT NULL DEFAULT current_timestamp(),
  `utoljara_modositott` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `sotet` tinyint(1) DEFAULT 0,
  `felhasznalonev` varchar(30) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `torles_ido` timestamp NULL DEFAULT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `ketfaktor_hitelesites` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `vez_nev`, `ker_nev`, `email`, `telszam`, `password`, `remember_token`, `regisztralt`, `utoljara_modositott`, `sotet`, `felhasznalonev`, `email_verified_at`, `google_id`, `torles_ido`, `admin`, `ketfaktor_hitelesites`) VALUES
(4, 'Szabo', 'Mate', 'walletmaster@gmail.com', '06706289983', '$2y$12$aVJzSguYFm0QIZjvzkd.4exvXnkojTpoS/zs6xRqh3Y5dhyojk6Ci', NULL, '2025-12-23 20:59:30', '2025-12-23 20:59:30', 0, 'Teszt1', NULL, NULL, NULL, 0, 0),
(5, 'Szabo', 'Mate', 'bomboclat@gmail.com', '06706289982', '$2y$12$YbKXmXRH1KuFiPIP/ljKcOCwYivhCdVKDEy4qSAsCZF3p2zTQG.Q.', NULL, '2026-01-07 09:21:23', '2026-01-07 09:21:23', 0, 'Bomboclat', NULL, NULL, NULL, 0, 0),
(7, 'Scooby', 'Gooner', 'scoobydoo@gmail.com', '06706289989', '$2y$12$JMu7e9HCbhnEAl9of8ipv.k9FaT4LhHwWBnP2K5DICYVP/xKGnIDu', NULL, '2026-01-08 11:04:51', '2026-01-08 11:04:51', 0, 'GoonerMan22', NULL, NULL, NULL, 0, 0),
(8, 'Kovács', 'Béla', 'palmafa123@gmail.com', '06703213443', '$2y$12$qtQ6DjwkhDhfV5kjRxW9CeydYIxyLOBP5EOsORFQNwMmnNV2iF77S', NULL, '2026-01-15 09:26:13', '2026-01-15 09:26:13', 0, 'kissbela30', NULL, NULL, NULL, 0, 0),
(10, 'Wallet', 'Master', 'csiha.mark@verebelyszki.hu', '06705360256', '$2y$12$xAbxyjiqm1z2gQcWAfzeOOBkkmz8nT6AQWHUaXg1RhZ45xU15Y7oe', '9Pr25d5sJiK07qiL0pboGOXDHpHfc3PZwL6e3gdbsQmCRiqz4FitKixywO6E', '2026-01-15 10:13:12', '2026-01-28 15:27:30', 0, 'kissbela31', '2026-01-28 08:32:59', NULL, NULL, 0, 0),
(12, 'Kovács', 'Juli', 'kovacsjuli58@gmail.com', '06305360256', '$2y$12$LGSZ9h0fetkZaUi19xYJWOjfVrVaFExIbPYmma9UjPmTJstHI.st.', NULL, '2026-01-15 10:21:20', '2026-01-15 10:21:20', 0, 'kovacsjuli', NULL, NULL, NULL, 0, 0),
(13, 'Kovács', 'Béla', 'kovacsbela@gmail.com', '06305340256', '$2y$12$BgmLnsmZCh52A1dEk18.JOp3rUTZLe0qTnkkDEbDcTAKk9SNT5Ztu', NULL, '2026-01-15 10:28:35', '2026-01-15 10:28:35', 0, 'kovacsbela', NULL, NULL, NULL, 0, 0),
(14, 'Kovács', 'Béla', 'kissbela40@gmail.com', '06705360222', '$2y$12$ZCj9r66AbwU.x117rz/Yyu/5CIvPUL7eeQPSLTpXugHLiIFSfGt7C', NULL, '2026-01-15 10:45:51', '2026-01-15 10:45:51', 0, 'kissbela40', NULL, NULL, NULL, 0, 0),
(15, 'Kovács', 'Béla', 'kissbela50@gmail.com', '06705360223', '$2y$12$FDj1.ORcZwxGEith3IlkH.d72hQr8p02KAOfQeBZLcjGBSiWLWqya', NULL, '2026-01-15 10:48:27', '2026-03-17 16:19:22', 0, 'kissbela57', NULL, NULL, NULL, 0, 0),
(17, 'Kovács', 'Béla', 'markcsiha46@outlook.hu', '06205360257', '$2y$12$1b5lfj866xohSFg1wNQF1e3pdyCLSjGy77NumH2ckuGoc.KxXAPWu', NULL, '2026-01-15 13:56:06', '2026-01-15 13:56:06', 0, 'markcsiha4646', NULL, NULL, NULL, 0, 0),
(18, 'Kovács', 'Béla', 'markcsiha46@outlook.ro', '06205360258', '$2y$12$0mVRXlDoQwN/hGR8wPqSIeexsWbw9i9.ibU5Ipmmwr0ui28xnt20O', NULL, '2026-01-15 14:04:19', '2026-01-15 14:04:19', 0, 'markcsiha464646', NULL, NULL, NULL, 0, 0),
(19, 'Kovács', 'András', 'kissbelaasd@gmail.com', '06203334444', '$2y$12$tkHEHny3SzhoQN5uAb7tMOkIVPGyv6QKoHsYesoILT1sMqtxf0NSS', NULL, '2026-01-15 14:08:59', '2026-03-17 15:58:38', 0, 'kissbela20', '2026-03-17 14:58:38', NULL, NULL, 0, 0),
(21, 'Szabó', 'Máté', 'matejosz26@gmail.com', '06201234320', '$2y$12$yx/3XHpNMKGjwwD5zEAKNO8QiUWkm8w0qqjdroZr/fO8F49jfUqT', NULL, '2026-01-15 15:38:47', '2026-01-28 18:16:27', 0, 'szaboka', NULL, NULL, NULL, 0, 0),
(22, 'Kauba', 'Kazira', 'kauba.zira7@gmail.com', '06203334440', '$2y$12$sgIqbyEvUZlJjE.689VD.el9VLfQQjC5DS5DWk8m.r35MdOK7F7ke', NULL, '2026-01-15 19:59:36', '2026-01-28 18:17:23', 0, 'kaubazira7', NULL, NULL, NULL, 0, 0),
(26, 'Csiha', 'Márkó', 'markcsiha46@outlook.es', '06705630250', '$2y$12$gl5ZCxDPW.2Le8h8D..ybOo2PjeXkYB5jLbHSerwt2gDqkBgogv3G', NULL, '2026-01-19 18:13:30', '2026-01-19 19:39:07', 0, 'KovacsJuli10', '2026-01-19 17:14:29', NULL, NULL, 0, 0),
(27, 'Csiha', 'Márkó', 'sigmawallet01@gmail.hu', '06705630251', '$2y$12$mDXXtgvqwkKEhgL5bkvxRuJv5N8jhyspGuS3MJIFXkF.QMx6OvZaC', NULL, '2026-01-19 18:41:54', '2026-01-19 20:17:54', 0, 'KovacsJuliiiiii', NULL, NULL, NULL, 0, 0),
(28, 'Csiha', 'Márkóka', 'markcsiha46@outlook.com', '06705630240', '$2y$12$xIWqoJnTe8pr62QaJpBu5Oh9OWvEbteSbIxGdL56ss9.Jt2MRmUa.', 'YPj7LZVFUAwYKIqAeO4OtEKO3jV5oKhxsueFnOPtE35KGlzZvpogyWA5M1um', '2026-01-19 19:18:54', '2026-03-15 20:10:33', 0, 'CsihaMark', '2026-01-21 16:12:26', NULL, NULL, 0, 1),
(29, 'Teszt', 'User', 'asdasd@gmail.com', '06301112233', '$2y$12$4q3quTZxC40Uw0rg4IL/SepRBCXS5wBn7RnHmCoY7i4WSNt.AcdJy', NULL, '2026-01-19 21:17:17', '2026-01-19 21:53:28', 0, 'TestUser', NULL, NULL, NULL, 0, 0),
(31, 'Szabó', 'Máté', 'matejosz28@gmail.com', '06706289988', '$2y$12$/Lup/qYCow2mc3lQ7qvniOSMJNrd9aBsClxsTBzsrLNuM0uS3KvJ2', NULL, '2026-01-29 18:25:24', '2026-01-29 18:26:06', 0, 'BDBasszen', '2026-01-29 17:26:06', NULL, NULL, 0, 0),
(33, NULL, NULL, 'mako.csiha@gmail.com', NULL, '$2y$12$uvIdaG5LoHjVol63TYlFVun/ne/Z2nLFdbwH7pWlNQjL8plHRrxEW', NULL, '2026-02-17 11:38:04', '2026-02-17 11:38:04', 0, NULL, '2026-02-17 10:38:04', NULL, NULL, 0, 0),
(35, 'Teszt', 'Elo', 'tesztf27@gmail.com', '06703246587', '$2y$12$ibmXICGsFsiaPDwm1jHrEeua7EZ/Q6d0fJxb646lQ3AYX4psQ8omC', NULL, '2026-02-18 10:12:13', '2026-02-18 10:12:13', 0, 'Tesztelo2026', NULL, NULL, NULL, 0, 0),
(36, 'Teszt', 'Felhasznalo', 'teszt27@gmail.com', '06704327698', '$2y$12$aL4BQyo6CZcM64RK7xnDRONiH6s8VQWdZHhmnjSmWxuvBKNHkkYVa', NULL, '2026-02-18 10:22:55', '2026-02-18 10:22:55', 0, 'KovacsTeszt', NULL, NULL, NULL, 0, 0),
(38, 'Admin', 'Wallet', 'sigmawallet01@gmail.com', '06208367876', '$2y$12$dzXeobO3.MzinhbPHtX8U.sl5itjc4HMbkPMYThrBjTDSQ.kFoVw.', NULL, '2026-02-23 16:50:31', '2026-02-23 16:50:44', 0, 'WalletAdmin', '2026-02-23 15:50:44', NULL, NULL, 0, 0),
(39, 'Teszt', 'Felhasz', 'tesztf26@gmail.com', '06205439876', '$2y$12$kyRu3gs7YMclDBqs4I7ISO9xc6vcqnpy2bvx1IgZlryaO3q09muLm', NULL, '2026-02-23 18:39:38', '2026-02-23 19:01:36', 0, 'TesztF3', '2026-02-23 17:40:06', NULL, NULL, 0, 0),
(40, 'Admin', 'Mark', 'walletmasteradmin1@gmail.com', '06701659687', '$2y$12$ZQiksLbKojsWHEWTWeXGruK6cV5bprD15RrvMxDiG38BI85q/fwpG', NULL, '2026-02-24 17:34:59', NULL, 0, 'AdminMark', '2026-02-24 16:34:59', NULL, NULL, 1, 0),
(41, 'Te', 'szt', 'mateszabo3640@gmail.com', '06706289980', '$2y$12$C50T.9/DVKP8v0B7i9UHi.nQkI4SOPmMXUKmeYMAvLVdVb0EUUa4e', NULL, '2026-03-04 11:52:19', '2026-03-04 11:52:45', 0, 'mateszabo3640', '2026-03-04 10:52:36', NULL, '2026-03-04 10:52:45', 0, 0),
(42, 'Horváth', 'Attila', 'horvath.attila@verebelyszki.hu', '06703469825', '$2y$12$FnBLXrBdgbUa/SIlPLCyT.RxCYsjWJ6dykDiBh392rC60FXAKLY1S', NULL, '2026-03-05 08:15:41', '2026-03-05 08:15:41', 0, 'horvathat', NULL, NULL, NULL, 0, 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `celok`
--
ALTER TABLE `celok`
  ADD PRIMARY KEY (`cel_id`),
  ADD KEY `fk_celok_user` (`user_id`);

--
-- A tábla indexei `felhasznaloi_velemenyek`
--
ALTER TABLE `felhasznaloi_velemenyek`
  ADD PRIMARY KEY (`velemeny_id`);

--
-- A tábla indexei `felhasznalo_kodok`
--
ALTER TABLE `felhasznalo_kodok`
  ADD PRIMARY KEY (`kod_id`);

--
-- A tábla indexei `fix`
--
ALTER TABLE `fix`
  ADD PRIMARY KEY (`fix_id`) USING BTREE,
  ADD KEY `fk_fix_szamla` (`szamla_id`);

--
-- A tábla indexei `koltseg_limit`
--
ALTER TABLE `koltseg_limit`
  ADD PRIMARY KEY (`koltseg_id`),
  ADD KEY `fk_koltseg_limit_user` (`user_id`),
  ADD KEY `fk_koltseg_limit_szamla` (`szamla_id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `szamla`
--
ALTER TABLE `szamla`
  ADD PRIMARY KEY (`szamla_id`),
  ADD KEY `fk_szamla_user` (`user_id`);

--
-- A tábla indexei `tartozasok`
--
ALTER TABLE `tartozasok`
  ADD PRIMARY KEY (`tartozasok_id`),
  ADD KEY `fk_tartozas_user` (`user_id`),
  ADD KEY `fk_tartozas_partner` (`partner_user_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `felhasznalonev` (`felhasznalonev`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `celok`
--
ALTER TABLE `celok`
  MODIFY `cel_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `felhasznaloi_velemenyek`
--
ALTER TABLE `felhasznaloi_velemenyek`
  MODIFY `velemeny_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `felhasznalo_kodok`
--
ALTER TABLE `felhasznalo_kodok`
  MODIFY `kod_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `koltseg_limit`
--
ALTER TABLE `koltseg_limit`
  MODIFY `koltseg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `szamla`
--
ALTER TABLE `szamla`
  MODIFY `szamla_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT a táblához `tartozasok`
--
ALTER TABLE `tartozasok`
  MODIFY `tartozasok_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `celok`
--
ALTER TABLE `celok`
  ADD CONSTRAINT `fk_celok_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `fix`
--
ALTER TABLE `fix`
  ADD CONSTRAINT `fk_fix_szamla` FOREIGN KEY (`szamla_id`) REFERENCES `szamla` (`szamla_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `koltseg_limit`
--
ALTER TABLE `koltseg_limit`
  ADD CONSTRAINT `fk_koltseg_limit_szamla` FOREIGN KEY (`szamla_id`) REFERENCES `szamla` (`szamla_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_koltseg_limit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `tartozasok`
--
ALTER TABLE `tartozasok`
  ADD CONSTRAINT `fk_tartozas_partner` FOREIGN KEY (`partner_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_tartozas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
