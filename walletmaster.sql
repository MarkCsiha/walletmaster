-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Dec 21. 13:26
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
-- Tábla szerkezet ehhez a táblához `kategoriak`
--

CREATE TABLE `kategoriak` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kategoria_nev` varchar(100) NOT NULL,
  `tipus` tinyint(1) DEFAULT 0,
  `datum` datetime NOT NULL DEFAULT current_timestamp(),
  `szin_hex` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `fix` tinyint(1) DEFAULT 0,
  `tipus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `password_hash` varchar(255) NOT NULL,
  `regisztralt` datetime NOT NULL DEFAULT current_timestamp(),
  `utoljara_modositott` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `sotet` tinyint(1) DEFAULT 0,
  `felhasznalonev` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `celok`
--
ALTER TABLE `celok`
  ADD PRIMARY KEY (`cel_id`);

--
-- A tábla indexei `fix`
--
ALTER TABLE `fix`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `kategoriak`
--
ALTER TABLE `kategoriak`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `szamla`
--
ALTER TABLE `szamla`
  ADD PRIMARY KEY (`szamla_id`);

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
-- AUTO_INCREMENT a táblához `kategoriak`
--
ALTER TABLE `kategoriak`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `szamla`
--
ALTER TABLE `szamla`
  MODIFY `szamla_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
