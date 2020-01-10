-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 10 Sty 2020, 08:23
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `bouw_bd`
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
(2, 'Mateusz', 'Manaj', 'user', '24c9e15e52afc47c225b757e7bee1f9d', 'user'),
(5, 'test', 'test', 'test', '202cb962ac59075b964b07152d234b70', 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_adresy`
--

CREATE TABLE `bouw_adresy` (
  `id` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `adres` text NOT NULL,
  `postcode` text NOT NULL,
  `private_naam` text NOT NULL,
  `private_achternaam` text NOT NULL,
  `private_id_kaart` text NOT NULL,
  `private_tel` text NOT NULL,
  `private_geboortedatum` date NOT NULL,
  `bedrijf_bedrijf` text NOT NULL,
  `bedrijf_adres` text NOT NULL,
  `bedrijf_postcode` text NOT NULL,
  `bedrijf_stad` text NOT NULL,
  `bedrijf_kvk` text NOT NULL,
  `bedrijf_btw` text NOT NULL,
  `bedrijf_tel` text NOT NULL,
  `tel` text NOT NULL,
  `email` text NOT NULL,
  `rekening` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_adresy`
--

INSERT INTO `bouw_adresy` (`id`, `city`, `adres`, `postcode`, `private_naam`, `private_achternaam`, `private_id_kaart`, `private_tel`, `private_geboortedatum`, `bedrijf_bedrijf`, `bedrijf_adres`, `bedrijf_postcode`, `bedrijf_stad`, `bedrijf_kvk`, `bedrijf_btw`, `bedrijf_tel`, `tel`, `email`, `rekening`, `active`) VALUES
(1, 1, 'test1', '100', '200', '300', 'nazwiskoaaa', '', '0000-00-00', 'kod', '2019-12-01', '', '', '', '', '', '', '', '', 0),
(2, 0, 'test2', '300', '150', '100', 'nazwiskobb', '', '0000-00-00', 'kod2', '2019-12-05', '', '', '', '', '', '', '', '', 1),
(3, 0, 'adres3', '111', '222', '333', 'nazwisko3', '', '0000-00-00', 'kod3', '2019-12-14', '', '', '', '', '', '', '', '', 0),
(4, 4, 'adres4', '11', '22', '33', 'nazwisko4', '', '0000-00-00', 'kod4', '2019-12-08', '', '', '', '', '', '', '', '', 0),
(5, 0, 'adres5', '1111', '2222', '3333', 'nazwisko5', '', '0000-00-00', 'kod5', '2019-12-16', '', '', '', '', '', '', '', '', 0),
(6, 6, 'adres6', '1', '2', '3', 'nazwisko6', '', '0000-00-00', 'kod6', '2019-12-02', '', '', '', '', '', '', '', '', 0),
(7, 0, 'testsql', 'testsql', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(8, 4, '', 'test1', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(9, 0, 'test10', 'test10', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 1),
(14, 15, 'test', 'test', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 1),
(15, 15, 'aatest', 'aapostcode', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(16, 14, 'gggadres', 'gggpostcode', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 1),
(18, 0, 'testadres', 'testpostcode', 'testprivatename', 'testprivateachtname', 'testidkadr', '', '2019-12-01', '', '', '', '', '', '', '', '', 'testemail', 'testrekaring', 1),
(19, 14, 'testbedrijf', 'testbedrijf', '', '', '', '', '0000-00-00', 'testberdijfbedrijf', 'testadresbedrijf', 'testpostcodebedrijf', 'teststadbedrijf', 'testkvkbedrijf', 'testbtwbedrijf', '', '', 'testemailbedrijf', 'testrekaringbedrijf', 1),
(21, 1, 'jjjj', 'jjjj', 'jjj', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', 'jjjj', 'jjj', 0),
(22, 1, 'tefdgdfd', 'fgdfgd', 'dfgdf', 'gdfgdf', 'dfgdf', '123', '2020-01-01', 'dfg', 'dfg', 'df', 'dfgd', 'fg', 'dfg', '321', '', 'dfgdfg', 'dfgd', 0),
(23, 14, 'adresM', 'postcodeM', 'nameM', 'achtnameM', 'kartaM', 'M123456789', '2020-01-01', '', 'bedrijfAdresM', 'bedrijfPostcodeM', 'bedrijfStadM', 'kvkM', 'btwM', 'bedrijfTelM', '', 'emailM', 'rekaringM', 0),
(24, 1, 'aasd', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(25, 1, 'ffffffff', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(26, 1, 'hhhhh', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(27, 0, 'ooo', 'pppp', 'op', 'iopi', '', '', '0000-00-00', '', '', '', '', '', '', '', '', 'iop', 'iop', 0),
(28, 15, 'aaf', 'sdfdf', 'sdfsdf', 'sdfsf', 'sdfs', 'dfsd', '2020-01-09', '', '', '', '', '', '', '', '', 'sdf', 'sdf', 0),
(29, 1, 'adasdad', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(30, 18, 'dddd', 'dddd', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 1),
(31, 14, 'gggadres', 'gggpostcode', 'aaaa', 'bbbb', 'ccc', 'dddd', '2020-01-01', '', '', '', '', '', '', '', '', 'eeee', 'rrrr', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_city`
--

CREATE TABLE `bouw_city` (
  `city_id` int(11) NOT NULL,
  `city` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `bouw_city`
--

INSERT INTO `bouw_city` (`city_id`, `city`) VALUES
(0, 'Zonder Stad'),
(14, 'ggg'),
(18, 'mmm');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_factur`
--

CREATE TABLE `bouw_factur` (
  `id` int(11) NOT NULL,
  `adres_id` int(11) NOT NULL,
  `oferten_id` int(11) NOT NULL,
  `factur_numer` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_factur`
--

INSERT INTO `bouw_factur` (`id`, `adres_id`, `oferten_id`, `factur_numer`, `data`) VALUES
(1, 16, 6, 1, '2019-02-02'),
(4, 10, 6, 10, '0000-00-00'),
(5, 16, 9, 12, '2019-02-02'),
(6, 30, 9, 8, '2019-02-02'),
(7, 16, 0, 8, '2019-02-02'),
(8, 16, 0, 8, '2019-02-02'),
(9, 30, 6, 0, '2019-02-02'),
(10, 16, 6, 1, '2019-02-02'),
(11, 16, 6, 1, '2019-02-02'),
(12, 16, 6, 1, '2019-02-02'),
(13, 30, 6, 12, '2019-02-02'),
(14, 16, 6, 12, '2019-02-02'),
(15, 16, 6, 12, '2019-02-02'),
(16, 30, 6, 12, '2019-02-02'),
(17, 16, 6, 13, '2019-02-02'),
(18, 30, 6, 14, '2019-02-02'),
(19, 2, 6, 15, '2019-02-02'),
(20, 10, 6, 5, '0000-00-00'),
(21, 7, 6, 17, '2019-02-02'),
(22, 999, 6, 18, '2019-02-02'),
(24, 10, 6, 5, '0000-00-00'),
(25, 10, 6, 5, '0000-00-00'),
(26, 10, 6, 5, '0000-00-00'),
(27, 30, 6, 21, '2020-01-01'),
(28, 30, 6, 22, '2020-01-02'),
(29, 30, 6, 23, '2019-12-05'),
(30, 10, 6, 5, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_factur_details`
--

CREATE TABLE `bouw_factur_details` (
  `id` int(11) NOT NULL,
  `factur_nr` int(11) NOT NULL,
  `waarvoor_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_factur_details`
--

INSERT INTO `bouw_factur_details` (`id`, `factur_nr`, `waarvoor_id`, `quantity`, `price`) VALUES
(1, 1, 1, 100, 10),
(2, 1, 1, 100, 10),
(3, 23, 1, 5, 10),
(4, 23, 1, 5, 10),
(5, 23, 1, 5, 10),
(7, 23, 1, 5, 10),
(8, 23, 1, 5, 10),
(9, 23, 1, 5, 10),
(10, 23, 1, 5, 10),
(11, 23, 1, 5, 10),
(12, 23, 1, 5, 10),
(13, 23, 1, 5, 10),
(14, 23, 1, 5, 10),
(15, 23, 1, 5, 10),
(16, 23, 1, 5, 10),
(17, 23, 1, 5, 10),
(18, 23, 1, 5, 10),
(19, 23, 1, 5, 10),
(20, 23, 1, 5, 10),
(21, 23, 1, 5, 10),
(22, 23, 1, 5, 10),
(23, 23, 1, 5, 10),
(24, 23, 1, 5, 10),
(25, 23, 1, 5, 10),
(26, 23, 1, 5, 10),
(27, 23, 1, 5, 10),
(28, 23, 1, 5, 10),
(29, 23, 1, 5, 10),
(30, 23, 1, 5, 10),
(31, 23, 1, 5, 10),
(32, 23, 1, 5, 10),
(33, 23, 1, 5, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_insteligen_company_data`
--

CREATE TABLE `bouw_insteligen_company_data` (
  `id` int(11) NOT NULL,
  `naam` text NOT NULL,
  `stad` text NOT NULL,
  `postcode` text NOT NULL,
  `straat` text NOT NULL,
  `tel` text NOT NULL,
  `email` text NOT NULL,
  `btw` text NOT NULL,
  `kvk` text NOT NULL,
  `datum` date NOT NULL,
  `iban` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_insteligen_company_data`
--

INSERT INTO `bouw_insteligen_company_data` (`id`, `naam`, `stad`, `postcode`, `straat`, `tel`, `email`, `btw`, `kvk`, `datum`, `iban`) VALUES
(1, 'KH Bemiddeling', 'Eindhoven', '5654LS', 'Tinelstraat 5', '040 844 50 07', 'info@khbemiddeling.nl', 'NL859557923B01', '73523097', '2020-01-09', 'NL29RABO0152307478');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_proforma`
--

CREATE TABLE `bouw_proforma` (
  `id` int(11) NOT NULL,
  `adres_id` int(11) NOT NULL,
  `oferten_id` int(11) NOT NULL,
  `proforma_numer` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_proforma`
--

INSERT INTO `bouw_proforma` (`id`, `adres_id`, `oferten_id`, `proforma_numer`, `data`) VALUES
(2, 30, 6, 1, '2020-01-09'),
(3, 9, 6, 2, '2020-01-09');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_proforma_details`
--

CREATE TABLE `bouw_proforma_details` (
  `id` int(11) NOT NULL,
  `proforma_nr` int(11) NOT NULL,
  `waarvoor_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_proforma_details`
--

INSERT INTO `bouw_proforma_details` (`id`, `proforma_nr`, `waarvoor_id`, `quantity`, `price`) VALUES
(1, 0, 1, 10, 20),
(2, 1, 2, 80, 1),
(3, 1, 1, 100, 1),
(4, 2, 1, 20, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_uitgaven`
--

CREATE TABLE `bouw_uitgaven` (
  `id` int(11) NOT NULL,
  `adres_id` int(11) NOT NULL,
  `oferten_id` int(11) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_uitgaven`
--

INSERT INTO `bouw_uitgaven` (`id`, `adres_id`, `oferten_id`, `price`, `data`) VALUES
(1, 28, 7, '1.00', '2020-01-01'),
(3, 28, 9, '2.00', '2020-01-01'),
(4, 28, 9, '3.00', '2020-01-08'),
(5, 1, 9, '2020.00', '0000-00-00'),
(6, 1, 9, '11.00', '2020-01-08'),
(7, 0, 9, '11.00', '2020-01-08'),
(8, 0, 9, '12.00', '2020-01-08'),
(9, 27, 9, '123.00', '2020-01-08');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_waarvoor`
--

CREATE TABLE `bouw_waarvoor` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `btw` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_waarvoor`
--

INSERT INTO `bouw_waarvoor` (`id`, `name`, `btw`) VALUES
(1, 'time', 10),
(2, ' aaaa', 20);

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
(13, 'aaa', 'aaa', '123', 'aaa@aaa.com', '2019-12-01'),
(17, 'test', 'test', '202cb962ac59075b964b07152d234b70', 'test@test.com', '2019-12-03'),
(19, 'marcel test', 'marcelo', '5a105e8b9d40e1329780d62ea2265d8a', 'test@test.com', '1990-01-01');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_adresy`
--
ALTER TABLE `bouw_adresy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_city`
--
ALTER TABLE `bouw_city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indeksy dla tabeli `bouw_factur`
--
ALTER TABLE `bouw_factur`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_factur_details`
--
ALTER TABLE `bouw_factur_details`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_insteligen_company_data`
--
ALTER TABLE `bouw_insteligen_company_data`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_proforma`
--
ALTER TABLE `bouw_proforma`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_proforma_details`
--
ALTER TABLE `bouw_proforma_details`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_uitgaven`
--
ALTER TABLE `bouw_uitgaven`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_waarvoor`
--
ALTER TABLE `bouw_waarvoor`
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
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `bouw_adresy`
--
ALTER TABLE `bouw_adresy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT dla tabeli `bouw_city`
--
ALTER TABLE `bouw_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `bouw_factur`
--
ALTER TABLE `bouw_factur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `bouw_factur_details`
--
ALTER TABLE `bouw_factur_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT dla tabeli `bouw_insteligen_company_data`
--
ALTER TABLE `bouw_insteligen_company_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `bouw_proforma`
--
ALTER TABLE `bouw_proforma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `bouw_proforma_details`
--
ALTER TABLE `bouw_proforma_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `bouw_uitgaven`
--
ALTER TABLE `bouw_uitgaven`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `bouw_waarvoor`
--
ALTER TABLE `bouw_waarvoor`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
