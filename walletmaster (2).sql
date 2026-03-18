-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Jan 29. 10:48
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
  `hatarido` date NOT NULL,
  `letrehozas_datum` datetime NOT NULL DEFAULT current_timestamp(),
  `modositas_datum` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `statusz` enum('aktív','kész','törölve') NOT NULL DEFAULT 'aktív'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fix`
--

CREATE TABLE `fix` (
  `id` int(11) NOT NULL,
  `szamla_id` int(11) NOT NULL,
  `tipus` enum('heti','havi','féléves','éves') NOT NULL DEFAULT 'havi',
  `osszeg` int(11) NOT NULL,
  `letrehozas` date DEFAULT NULL,
  `befiz_datum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 6, 2100, 'Lidl', 'Thermo kabát', '2025-01-08 00:00:00', 'nem', 0, 'Egyéb'),
(3, 6, 1000, 'Aldi', 'Bacon', '2025-01-07 00:00:00', 'nem', 0, 'Egyéb'),
(4, 6, 12000, 'Részvény piac', 'GitHub részvények(3db)', '2025-01-08 00:00:00', 'nem', 0, 'egyeb'),
(5, 6, 80000, 'Logiscool Rákoskeresztur', 'Havi logiscool fizetés', '2025-01-05 00:00:00', 'nem', 1, 'fizetes'),
(6, 6, 160, 'Aldi', NULL, '2026-01-08 00:00:00', 'nem', 0, 'elelmiszer'),
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
(18, 28, 30000, 'BP', NULL, '2026-01-10 00:00:00', '0', 1, 'Befektetés');

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
  `status` enum('függőben','elfogadva','elutasítva','rendezve') NOT NULL DEFAULT 'függőben',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `tartozasok`
--

INSERT INTO `tartozasok` (`tartozasok_id`, `user_id`, `partner_user_id`, `partner_nev`, `osszeg`, `tipus`, `leiras`, `datum`, `status`, `created_at`, `updated_at`) VALUES
(1, 28, NULL, 'Szabó Máté', 5000, 0, NULL, '2026-01-10', 'függőben', '2026-01-27 17:17:06', '2026-01-27 17:17:06'),
(2, 28, NULL, 'Szabó Máté', 5000, 1, NULL, '2026-01-10', 'függőben', '2026-01-27 17:24:30', '2026-01-27 17:24:30'),
(3, 28, NULL, 'Szabó Máté', 10000, 1, NULL, '2026-01-10', 'függőben', '2026-01-27 17:24:48', '2026-01-27 17:24:48'),
(4, 28, 4, 'Szabó Máté', 10000, 1, NULL, '2026-01-10', 'függőben', '2026-01-27 17:26:21', '2026-01-27 17:26:21'),
(5, 28, 4, 'Szabó Máté', 10000, 1, 'tartozik ez a pali', '2026-01-10', 'függőben', '2026-01-27 17:29:43', '2026-01-27 17:29:43'),
(6, 28, 8, 'Szabó Máté', 10000, 1, 'tartozik ez a pali', '2026-01-10', 'függőben', '2026-01-27 17:44:21', '2026-01-27 17:44:21'),
(7, 28, 29, 'Szabó Máté', 10000, 1, 'tartozik ez a teszter', '2026-01-10', 'függőben', '2026-01-28 08:10:19', '2026-01-28 08:10:19'),
(8, 28, 29, 'Szabó Máté', 10000, 0, 'tartozik ez a teszter', '2026-01-10', 'függőben', '2026-01-28 08:11:45', '2026-01-28 08:11:45'),
(9, 28, 29, 'Szabó Máté', 10000, 1, 'tartozik ez a teszter', '2026-01-10', 'függőben', '2026-01-28 08:12:29', '2026-01-28 08:12:29'),
(10, 28, 29, 'Szabó Máté', 10000, 1, 'tartozik ez a teszter', '2026-01-10', 'függőben', '2026-01-28 08:15:52', '2026-01-28 08:15:52'),
(11, 28, 10, 'Wallet Master', 10000000, 1, 'Goated', '2026-01-10', 'függőben', '2026-01-28 08:30:08', '2026-01-28 08:30:08'),
(12, 10, 28, 'Csiha Márk', 3000, 1, 'Netflix', '2026-01-15', 'függőben', '2026-01-28 08:54:18', '2026-01-28 08:54:18'),
(13, 28, 10, 'kissbela31', 3000, 0, 'Netflix', '2026-01-15', 'függőben', '2026-01-28 08:54:18', '2026-01-28 08:54:18'),
(14, 10, 28, 'Csiha Márk', 3000, 1, 'HBO Max', '2026-01-15', 'függőben', '2026-01-28 08:58:55', '2026-01-28 08:58:55'),
(15, 10, 28, 'Csiha Márkó', 4000, 0, 'Disney+', '2025-10-10', 'függőben', '2026-01-28 09:11:05', '2026-01-28 09:11:05'),
(16, 28, 10, 'kissbela31', 4000, 1, 'Disney+', '2025-10-10', 'függőben', '2026-01-28 09:11:05', '2026-01-28 09:11:05'),
(17, 28, 28, 'Csiha Márkó', 4000, 1, 'Disney+', '2025-10-10', 'függőben', '2026-01-28 09:14:30', '2026-01-28 09:14:30'),
(18, 28, 28, 'Csiha Márkó', 4000, 0, 'Disney+', '2025-10-10', 'függőben', '2026-01-28 09:14:30', '2026-01-28 09:14:30'),
(19, 10, 28, 'Csiha Márkó', 10000, 1, 'vásárlás', '2025-10-10', 'függőben', '2026-01-28 09:26:32', '2026-01-28 09:26:32'),
(20, 28, 10, '', 10000, 0, 'vásárlás', '2025-10-10', 'függőben', '2026-01-28 09:26:32', '2026-01-28 09:26:32'),
(21, 10, 28, 'Csiha Márkó', 1000000, 0, 'laptop', '2025-10-10', 'függőben', '2026-01-28 09:49:04', '2026-01-28 09:49:04'),
(22, 28, 10, '', 1000000, 1, 'laptop', '2025-10-10', 'függőben', '2026-01-28 09:49:04', '2026-01-28 09:49:04'),
(23, 10, 28, 'Csiha Márkó', 10000, 1, 'vásárlások', '2025-10-10', 'függőben', '2026-01-28 13:27:26', '2026-01-28 13:27:26'),
(24, 28, 10, 'Wallet Master', 10000, 0, 'vásárlások', '2025-10-10', 'függőben', '2026-01-28 13:27:26', '2026-01-28 13:27:26');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vez_nev` varchar(100) NOT NULL,
  `ker_nev` varchar(100) NOT NULL,
  `email` varchar(190) NOT NULL,
  `telszam` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `regisztralt` datetime NOT NULL DEFAULT current_timestamp(),
  `utoljara_modositott` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `sotet` tinyint(1) DEFAULT 0,
  `felhasznalonev` varchar(30) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `vez_nev`, `ker_nev`, `email`, `telszam`, `password`, `remember_token`, `regisztralt`, `utoljara_modositott`, `sotet`, `felhasznalonev`, `email_verified_at`) VALUES
(4, 'Szabo', 'Mate', 'walletmaster@gmail.com', '06706289983', '$2y$12$aVJzSguYFm0QIZjvzkd.4exvXnkojTpoS/zs6xRqh3Y5dhyojk6Ci', NULL, '2025-12-23 20:59:30', '2025-12-23 20:59:30', 0, 'Teszt1', NULL),
(5, 'Szabo', 'Mate', 'bomboclat@gmail.com', '06706289982', '$2y$12$YbKXmXRH1KuFiPIP/ljKcOCwYivhCdVKDEy4qSAsCZF3p2zTQG.Q.', NULL, '2026-01-07 09:21:23', '2026-01-07 09:21:23', 0, 'Bomboclat', NULL),
(6, 'Szabo', 'Mate', 'teszt@gmail.com', '06706289981', '$2y$12$ouWxJ5jbxE0gkRpSXKirMOW59g8axGAuNUVJa.qmIKkU0TQcRqP92', NULL, '2026-01-08 08:21:19', '2026-01-08 08:21:19', 0, 'Nigger', NULL),
(7, 'Scooby', 'Gooner', 'scoobydoo@gmail.com', '06706289989', '$2y$12$JMu7e9HCbhnEAl9of8ipv.k9FaT4LhHwWBnP2K5DICYVP/xKGnIDu', NULL, '2026-01-08 11:04:51', '2026-01-08 11:04:51', 0, 'GoonerMan22', NULL),
(8, 'Kovács', 'Béla', 'palmafa123@gmail.com', '06703213443', '$2y$12$qtQ6DjwkhDhfV5kjRxW9CeydYIxyLOBP5EOsORFQNwMmnNV2iF77S', NULL, '2026-01-15 09:26:13', '2026-01-15 09:26:13', 0, 'kissbela30', NULL),
(10, 'Wallet', 'Master', 'csiha.mark@verebelyszki.hu', '06705360256', '$2y$12$xAbxyjiqm1z2gQcWAfzeOOBkkmz8nT6AQWHUaXg1RhZ45xU15Y7oe', '9Pr25d5sJiK07qiL0pboGOXDHpHfc3PZwL6e3gdbsQmCRiqz4FitKixywO6E', '2026-01-15 10:13:12', '2026-01-28 15:27:30', 0, 'kissbela31', '2026-01-28 08:32:59'),
(12, 'Kovács', 'Juli', 'kovacsjuli58@gmail.com', '06305360256', '$2y$12$LGSZ9h0fetkZaUi19xYJWOjfVrVaFExIbPYmma9UjPmTJstHI.st.', NULL, '2026-01-15 10:21:20', '2026-01-15 10:21:20', 0, 'kovacsjuli', NULL),
(13, 'Kovács', 'Béla', 'kovacsbela@gmail.com', '06305340256', '$2y$12$BgmLnsmZCh52A1dEk18.JOp3rUTZLe0qTnkkDEbDcTAKk9SNT5Ztu', NULL, '2026-01-15 10:28:35', '2026-01-15 10:28:35', 0, 'kovacsbela', NULL),
(14, 'Kovács', 'Béla', 'kissbela40@gmail.com', '06705360222', '$2y$12$ZCj9r66AbwU.x117rz/Yyu/5CIvPUL7eeQPSLTpXugHLiIFSfGt7C', NULL, '2026-01-15 10:45:51', '2026-01-15 10:45:51', 0, 'kissbela40', NULL),
(15, 'Kovács', 'Béla', 'kissbela50@gmail.com', '06705360223', '$2y$12$FDj1.ORcZwxGEith3IlkH.d72hQr8p02KAOfQeBZLcjGBSiWLWqya', NULL, '2026-01-15 10:48:27', '2026-01-15 10:48:27', 0, 'kissbela50', NULL),
(17, 'Kovács', 'Béla', 'markcsiha46@outlook.hu', '06205360257', '$2y$12$1b5lfj866xohSFg1wNQF1e3pdyCLSjGy77NumH2ckuGoc.KxXAPWu', NULL, '2026-01-15 13:56:06', '2026-01-15 13:56:06', 0, 'markcsiha4646', NULL),
(18, 'Kovács', 'Béla', 'markcsiha46@outlook.ro', '06205360258', '$2y$12$0mVRXlDoQwN/hGR8wPqSIeexsWbw9i9.ibU5Ipmmwr0ui28xnt20O', NULL, '2026-01-15 14:04:19', '2026-01-15 14:04:19', 0, 'markcsiha464646', NULL),
(19, 'Kovács', 'András', 'kissbelaasd@gmail.com', '06203334444', '$2y$12$tkHEHny3SzhoQN5uAb7tMOkIVPGyv6QKoHsYesoILT1sMqtxf0NSS', NULL, '2026-01-15 14:08:59', '2026-01-15 14:08:59', 0, 'kissbela20', NULL),
(21, 'Szabó', 'Máté', 'matejosz26@gmail.com', '06201234320', '$2y$12$yx/3XHpNMKGjwwD5zEAKNO8QiUWkm8w0qqjdroZr/fO8F49jfUqT', NULL, '2026-01-15 15:38:47', '2026-01-28 18:16:27', 0, 'szaboka', NULL),
(22, 'Kauba', 'Kazira', 'kauba.zira7@gmail.com', '06203334440', '$2y$12$sgIqbyEvUZlJjE.689VD.el9VLfQQjC5DS5DWk8m.r35MdOK7F7ke', NULL, '2026-01-15 19:59:36', '2026-01-28 18:17:23', 0, 'kaubazira7', NULL),
(26, 'Csiha', 'Márkó', 'markcsiha46@outlook.es', '06705630250', '$2y$12$gl5ZCxDPW.2Le8h8D..ybOo2PjeXkYB5jLbHSerwt2gDqkBgogv3G', NULL, '2026-01-19 18:13:30', '2026-01-19 19:39:07', 0, 'KovacsJuli10', '2026-01-19 17:14:29'),
(27, 'Csiha', 'Márkó', 'sigmawallet01@gmail.hu', '06705630251', '$2y$12$mDXXtgvqwkKEhgL5bkvxRuJv5N8jhyspGuS3MJIFXkF.QMx6OvZaC', NULL, '2026-01-19 18:41:54', '2026-01-19 20:17:54', 0, 'KovacsJuliiiiii', NULL),
(28, 'Csiha', 'Márkó', 'markcsiha46@outlook.com', '06705630240', '$2y$12$xIWqoJnTe8pr62QaJpBu5Oh9OWvEbteSbIxGdL56ss9.Jt2MRmUa.', 'EYbPaNrnm36FcQksZIwk2TAxMXcrftyEoIdxR6qZ2HgliC3YWJQok5KhQkKw', '2026-01-19 19:18:54', '2026-01-28 15:26:36', 0, 'CsihaMark', '2026-01-21 16:12:26'),
(29, 'Teszt', 'User', 'asdasd@gmail.com', '06301112233', '$2y$12$4q3quTZxC40Uw0rg4IL/SepRBCXS5wBn7RnHmCoY7i4WSNt.AcdJy', NULL, '2026-01-19 21:17:17', '2026-01-19 21:53:28', 0, 'TestUser', NULL);

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
-- A tábla indexei `fix`
--
ALTER TABLE `fix`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fix_szamla` (`szamla_id`);

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
  ADD UNIQUE KEY `felhasznalonev` (`felhasznalonev`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `celok`
--
ALTER TABLE `celok`
  MODIFY `cel_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `szamla`
--
ALTER TABLE `szamla`
  MODIFY `szamla_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT a táblához `tartozasok`
--
ALTER TABLE `tartozasok`
  MODIFY `tartozasok_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
-- Megkötések a táblához `szamla`
--
ALTER TABLE `szamla`
  ADD CONSTRAINT `fk_szamla_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
