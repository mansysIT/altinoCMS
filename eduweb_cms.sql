-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Gru 2019, 16:38
-- Wersja serwera: 10.4.8-MariaDB
-- Wersja PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `eduweb_cms`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `imie` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `nick` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `privileges` varchar(100) COLLATE utf8_polish_ci NOT NULL DEFAULT 'user'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `administrator`
--

INSERT INTO `administrator` (`id`, `imie`, `nazwisko`, `nick`, `pass`, `privileges`) VALUES
(1, 'Mateusz', 'Manaj', 'administrator', '9056c0bbcb4075ff82dd99efe295922f', 'admin'),
(2, 'Mateusz', 'Manaj', 'user', '24c9e15e52afc47c225b757e7bee1f9d', 'user');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bedrijf_adresy`
--

CREATE TABLE `bedrijf_adresy` (
  `id` int(11) NOT NULL,
  `miasto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bedrijf_adresy`
--

INSERT INTO `bedrijf_adresy` (`id`, `miasto`) VALUES
(1, 'aaa'),
(2, 'bbb');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `meta_tags`
--

CREATE TABLE `meta_tags` (
  `id` int(11) NOT NULL,
  `content_type` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `keywords` longtext COLLATE utf8_polish_ci NOT NULL,
  `description` longtext COLLATE utf8_polish_ci NOT NULL,
  `author` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `distribution` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `robots` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `revisit` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `copyrights` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `googlebot` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `classification` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `publisher` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `page_topic` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `rating` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `security` mediumtext COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `meta_tags`
--

INSERT INTO `meta_tags` (`id`, `content_type`, `keywords`, `description`, `author`, `distribution`, `robots`, `revisit`, `copyrights`, `googlebot`, `classification`, `publisher`, `page_topic`, `rating`, `security`) VALUES
(1, 'UTF-8', 'SuperCMS Eduweb System CMS', 'System CMS napisany na potrzeby kursu Eduweb', 'Mateusz Manaj - Eduweb.pl', 'global', 'index,follow,all', '2 days', '&copy; Eduweb 2012', 'index,follow,all', 'Eduweb', 'eduweb.pl', 'Eduweb, SuperCMS', 'general', 'public');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `meta_tags_index`
--

CREATE TABLE `meta_tags_index` (
  `id` int(11) NOT NULL,
  `meta_tags_id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `meta_tags_index`
--

INSERT INTO `meta_tags_index` (`id`, `meta_tags_id`, `name`) VALUES
(1, 1, 'default');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(300) COLLATE utf8_polish_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `mail` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `mail`, `birthdate`) VALUES
(13, 'aaa', 'aaa', '123', 'aaa@aaa.com', '2019-12-01');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bedrijf_adresy`
--
ALTER TABLE `bedrijf_adresy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `meta_tags`
--
ALTER TABLE `meta_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `meta_tags_index`
--
ALTER TABLE `meta_tags_index`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `bedrijf_adresy`
--
ALTER TABLE `bedrijf_adresy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `meta_tags`
--
ALTER TABLE `meta_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `meta_tags_index`
--
ALTER TABLE `meta_tags_index`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
