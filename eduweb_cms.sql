-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Sty 2020, 15:40
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
(3, 0, 'adres3', '111', '222', '333', 'nazwisko3', '', '0000-00-00', 'kod3', '2019-12-14', '', '', '', '', '', '', '', '', 1),
(4, 4, 'adres4', '11', '22', '33', 'nazwisko4', '', '0000-00-00', 'kod4', '2019-12-08', '', '', '', '', '', '', '', '', 0),
(5, 0, 'adres5', '1111', '2222', '3333', 'nazwisko5', '', '0000-00-00', 'kod5', '2019-12-16', '', '', '', '', '', '', '', '', 0),
(6, 6, 'adres6', '1', '2', '3', 'nazwisko6', '', '0000-00-00', 'kod6', '2019-12-02', '', '', '', '', '', '', '', '', 0),
(7, 0, 'testsql', 'testsql', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(8, 4, '', 'test1', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(9, 0, 'test10', 'test10', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 1),
(14, 15, 'test', 'test', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 1),
(15, 15, 'aatest', 'aapostcode', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(16, 0, 'gggadres', 'gggpostcode', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 1),
(18, 0, 'testadres', 'testpostcode', 'testprivatename', 'testprivateachtname', 'testidkadr', '', '2019-12-01', '', '', '', '', '', '', '', '', 'testemail', 'testrekaring', 1),
(19, 0, 'testbedrijf', 'testbedrijf', '', '', '', '', '0000-00-00', 'testberdijfbedrijf', 'testadresbedrijf', 'testpostcodebedrijf', 'teststadbedrijf', 'testkvkbedrijf', 'testbtwbedrijf', '', '', 'testemailbedrijf', 'testrekaringbedrijf', 1),
(21, 1, 'jjjj', 'jjjj', 'jjj', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', 'jjjj', 'jjj', 0),
(22, 1, 'tefdgdfd', 'fgdfgd', 'dfgdf', 'gdfgdf', 'dfgdf', '123', '2020-01-01', 'dfg', 'dfg', 'df', 'dfgd', 'fg', 'dfg', '321', '', 'dfgdfg', 'dfgd', 0),
(23, 0, 'adresM', 'postcodeM', 'nameM', 'achtnameM', 'kartaM', 'M123456789', '2020-01-01', '', 'bedrijfAdresM', 'bedrijfPostcodeM', 'bedrijfStadM', 'kvkM', 'btwM', 'bedrijfTelM', '', 'emailM', 'rekaringM', 0),
(24, 1, 'aasd', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(25, 1, 'ffffffff', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(26, 1, 'hhhhh', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(27, 0, 'ooo', 'pppp', 'op', 'iopi', '', '', '0000-00-00', '', '', '', '', '', '', '', '', 'iop', 'iop', 1),
(28, 15, 'aaf', 'sdfdf', 'sdfsdf', 'sdfsf', 'sdfs', 'dfsd', '2020-01-09', '', '', '', '', '', '', '', '', 'sdf', 'sdf', 0),
(29, 1, 'adasdad', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(30, 0, 'dddd', 'dddd', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 1),
(31, 0, 'gggadres', 'gggpostcode', 'aaaa', 'bbbb', 'ccc', 'dddd', '2020-01-01', '', '', '', '', '', '', '', '', 'eeee', 'rrrr', 0),
(32, 0, 'test1888', '12-123777', '', '', '', '', '0000-00-00', 'fff', 'aaaas', 'sss', 'dd', 'ddd', 'sss', 'aaa', '', 'test@gmail.com555', 'rekaringTest1666', 1),
(33, 20, 'rrrrrr', 'sssss', '', '', '', '', '0000-00-00', 'dddd', 'ssss', 'aaa', 'dddss', 'ss', 'aas', 'ddd', '', '', '', 0),
(34, 20, 'test1', '12-123', 'tomasz666', 'testowy', '12-3214321', '123456789', '1996-03-14', '', '', '', '', '', '', '', '', 'test@gmail.com', 'rekaringTest1', 0),
(35, 20, 'hhh', 'jjjj', 'kkkk', 'llll', 'zzzzx', 'xxxxxx', '2020-01-01', '', '', '', '', '', '', '', '', 'cccc', 'vvvv', 0),
(36, 20, 'aaa', 'bbb', '', '', '', '', '0000-00-00', '332', '123', '123', '123', '', '', '', '', 'gg', 'bb', 0),
(37, 0, 'asdasd', 'asdas', 'dasd', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0),
(38, 20, 'aaaaaa', 'bbbbb', 'ttt', 'rrr', 'eee', 'www', '2020-01-11', '', '', '', '', '', '', '', '', 'asdsa', 'dasd', 0);

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
(20, 'testcity'),
(21, 'miasto');

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
(30, 10, 6, 5, '0000-00-00'),
(31, 23, 6, 24, '2020-01-08'),
(32, 23, 1, 25, '2020-01-10'),
(33, 23, 1, 26, '2020-01-10'),
(34, 1, 1, 27, '2020-01-10'),
(35, 1, 1, 28, '2020-01-10'),
(36, 1, 1, 29, '2020-01-10'),
(37, 23, 1, 30, '2020-01-10'),
(38, 16, 2, 31, '2020-01-10'),
(39, 23, 3, 32, '2020-01-10'),
(40, 23, 1, 33, '2020-01-01'),
(41, 0, 0, 34, '2020-01-10'),
(42, 23, 1, 35, '2020-01-09'),
(43, 23, 1, 36, '2020-01-09'),
(44, 23, 1, 37, '2020-01-09'),
(47, 23, 1, 38, '2020-01-11'),
(50, 9, 0, 39, '2020-01-12'),
(51, 9, 0, 40, '2020-01-12'),
(52, 23, 1, 41, '2020-01-11'),
(53, 19, 2, 42, '2020-01-13'),
(54, 19, 2, 43, '2020-01-14'),
(55, 32, 6, 44, '2020-01-14'),
(56, 32, 7, 45, '2020-01-13'),
(57, 32, 7, 46, '2020-01-13'),
(58, 32, 7, 47, '2020-01-09'),
(59, 32, 7, 48, '2020-01-02'),
(60, 32, 7, 49, '2020-01-07'),
(61, 32, 7, 50, '2020-01-08'),
(62, 32, 7, 51, '2020-01-08'),
(63, 32, 7, 52, '2020-01-05'),
(64, 32, 7, 53, '2020-01-01'),
(65, 32, 7, 54, '2020-01-03'),
(66, 32, 7, 55, '2020-01-03'),
(67, 32, 7, 56, '2020-01-04'),
(68, 16, 7, 57, '2020-01-14'),
(69, 2, 7, 58, '2020-01-14'),
(70, 2, 8, 59, '2020-01-14'),
(71, 32, 8, 60, '2020-01-14'),
(72, 2, 7, 61, '2020-01-14'),
(73, 32, 7, 62, '2020-01-15'),
(74, 5, 0, 63, '2020-01-15'),
(75, 9, 8, 64, '2020-01-15'),
(76, 9, 8, 65, '2020-01-15'),
(77, 9, 8, 66, '2020-01-15'),
(78, 9, 8, 67, '2020-01-15'),
(79, 9, 8, 68, '2020-01-15'),
(80, 9, 8, 69, '2020-01-15'),
(81, 9, 8, 70, '2020-01-15'),
(82, 9, 8, 71, '2020-01-15'),
(83, 9, 8, 72, '2020-01-15'),
(84, 9, 8, 73, '2020-01-15'),
(85, 9, 8, 74, '2020-01-15'),
(86, 9, 8, 75, '2020-01-15'),
(87, 9, 8, 76, '2020-01-15'),
(88, 9, 8, 77, '2020-01-15'),
(89, 32, 7, 78, '2020-01-15'),
(90, 2, 8, 79, '2020-01-15'),
(91, 0, 0, 80, '2020-01-15'),
(93, 0, 0, 82, '2020-01-15'),
(94, 9, 11, 83, '2020-01-15'),
(95, 2, 6, 84, '2020-01-15'),
(96, 35, 6, 85, '2020-01-17'),
(97, 2, 16, 86, '2020-01-17'),
(100, 32, 8, 89, '2020-01-17'),
(101, 32, 8, 90, '2020-01-17'),
(102, 2, 0, 91, '2020-01-20'),
(103, 2, 16, 92, '2020-01-21'),
(104, 2, 16, 93, '2020-01-21'),
(105, 2, 16, 94, '2020-01-21'),
(106, 2, 16, 95, '2020-01-21'),
(107, 2, 20, 96, '2020-01-21'),
(108, 7, 0, 97, '2020-01-21');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_factur_details`
--

CREATE TABLE `bouw_factur_details` (
  `id` int(11) NOT NULL,
  `factur_nr` int(11) NOT NULL,
  `waarvoor_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `price` float NOT NULL,
  `opmerkingen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_factur_details`
--

INSERT INTO `bouw_factur_details` (`id`, `factur_nr`, `waarvoor_id`, `quantity`, `price`, `opmerkingen`) VALUES
(1, 1, 1, 100, 10, ''),
(2, 1, 1, 100, 10, ''),
(3, 23, 1, 5, 10, ''),
(4, 23, 1, 5, 10, ''),
(7, 23, 1, 5, 10, ''),
(8, 23, 1, 5, 10, ''),
(9, 23, 1, 5, 10, ''),
(10, 23, 1, 5, 10, ''),
(11, 23, 1, 5, 10, ''),
(12, 23, 1, 5, 10, ''),
(13, 23, 1, 5, 10, ''),
(14, 23, 1, 5, 10, ''),
(15, 23, 1, 5, 10, ''),
(16, 23, 1, 5, 10, ''),
(17, 23, 1, 5, 10, ''),
(18, 23, 1, 5, 10, ''),
(19, 23, 1, 5, 10, ''),
(20, 23, 1, 5, 10, ''),
(21, 23, 1, 5, 10, ''),
(22, 23, 1, 5, 10, ''),
(23, 23, 1, 5, 10, ''),
(24, 23, 1, 5, 10, ''),
(25, 23, 1, 5, 10, ''),
(26, 23, 1, 5, 10, ''),
(27, 23, 1, 5, 10, ''),
(28, 23, 1, 5, 10, ''),
(29, 23, 1, 5, 10, ''),
(30, 23, 1, 5, 10, ''),
(31, 23, 1, 5, 10, ''),
(32, 23, 1, 5, 10, ''),
(33, 23, 1, 5, 10, ''),
(34, 25, 1, 20, 40, ''),
(35, 26, 2, 70, 80, ''),
(36, 24, 2, 12, 1, ''),
(37, 25, 2, 70, 80, ''),
(38, 25, 2, 40, 40, ''),
(39, 26, 2, 40, 40, ''),
(40, 25, 1, 10, 10, ''),
(41, 26, 2, 5, 5, ''),
(44, 32, 1, 1, 1, ''),
(45, 33, 1, 11, 80, ''),
(47, 33, 3, 60, 40, ''),
(48, 33, 2, 40, 10, ''),
(50, 38, 1, 44, 5, ''),
(53, 39, 1, 20, 5, ''),
(54, 40, 1, 25, 5, ''),
(55, 41, 1, 44, 5, ''),
(56, 42, 1, 10, 10, ''),
(57, 42, 4, 5, 5, ''),
(58, 43, 1, 10, 10, ''),
(59, 43, 4, 5, 100, ''),
(60, 44, 1, 1, 1, ''),
(61, 44, 2, 2, 2, ''),
(62, 46, 1, 5, 5, ''),
(63, 47, 1, 60, 52, ''),
(64, 48, 1, 5, 5, ''),
(65, 49, 1, 5, 5, ''),
(66, 50, 1, 55, 5, ''),
(67, 51, 1, 55, 5, ''),
(68, 52, 1, 5, 5, ''),
(69, 53, 1, 5, 5, ''),
(70, 54, 1, 57, 58, ''),
(71, 55, 1, 56, 54, ''),
(72, 56, 1, 51, 52, ''),
(73, 57, 1, 44, 444, ''),
(74, 58, 3, 5, 4, ''),
(75, 59, 3, 8, 6, ''),
(76, 60, 4, 4, 2, ''),
(77, 62, 1, 10, 5, ''),
(78, 63, 1, 8, 9, ''),
(79, 64, 1, 6, 5, ''),
(80, 65, 1, 6, 5, ''),
(81, 66, 1, 6, 5, ''),
(82, 67, 1, 6, 5, ''),
(83, 68, 1, 6, 5, ''),
(84, 69, 1, 6, 5, ''),
(85, 70, 1, 6, 5, ''),
(86, 71, 1, 6, 5, ''),
(87, 72, 1, 6, 5, ''),
(88, 73, 1, 6, 5, ''),
(89, 74, 1, 6, 5, ''),
(90, 75, 1, 6, 5, ''),
(91, 76, 1, 6, 5, ''),
(92, 77, 1, 6, 5, ''),
(93, 78, 1, 1, 1, ''),
(95, 83, 1, 3, 3, ''),
(100, 86, 1, 10, 10, ''),
(101, 86, 2, 2, 2, ''),
(102, 86, 1, 200, 200, ''),
(103, 87, 1, 4, 55, ''),
(104, 87, 1, 3, 5, ''),
(105, 88, 5, 10, 10, ''),
(106, 89, 1, 10, 10, ''),
(107, 89, 5, 20, 25, ''),
(108, 90, 1, 30, 10, ''),
(109, 90, 1, 7, 8, ''),
(110, 91, 1, 4, 3, ''),
(111, 92, 1, 2, 2, 'aaa'),
(112, 93, 1, 333, 332, 'bbbcccddd'),
(113, 94, 1, 1, 1, 'aaaaaaaaaa'),
(114, 94, 1, 1, 11, 'bbbbb'),
(115, 94, 1, 1, 111, 'ffffff'),
(116, 94, 4, 1, 1111, 'sdfsdfsdf'),
(117, 94, 5, 1, 11111, 'dsfdf'),
(118, 94, 3, 1, 111111, 'asdasdad'),
(119, 95, 1, 3, 2.4, ''),
(120, 96, 1, 2, 2.8, 'asdasd'),
(121, 97, 1, 50, 1, 'jhhhhjjh'),
(122, 97, 4, 50, 1, 'fdsfsd');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_factur_mail`
--

CREATE TABLE `bouw_factur_mail` (
  `id` int(11) NOT NULL,
  `factur_id` int(11) NOT NULL,
  `data_czas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_factur_mail`
--

INSERT INTO `bouw_factur_mail` (`id`, `factur_id`, `data_czas`) VALUES
(1, 40, '2020-01-11 11:21:44'),
(2, 40, '2020-01-11 11:22:16'),
(3, 53, '2020-01-13 10:52:27'),
(4, 51, '2020-01-14 12:05:33'),
(5, 40, '2020-01-14 12:05:47'),
(6, 40, '2020-01-14 12:06:45'),
(7, 54, '2020-01-14 12:24:07'),
(8, 94, '2020-01-15 13:40:13'),
(9, 94, '2020-01-15 13:42:04'),
(10, 94, '2020-01-15 13:52:57'),
(11, 94, '2020-01-15 13:56:43'),
(12, 94, '2020-01-15 13:57:56'),
(13, 100, '2020-01-17 14:18:08');

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
-- Struktura tabeli dla tabeli `bouw_oferten`
--

CREATE TABLE `bouw_oferten` (
  `id` int(11) NOT NULL,
  `adres_id` int(11) NOT NULL,
  `in_progres` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `oferten_numer` int(11) NOT NULL,
  `data` date NOT NULL,
  `planned_date` date NOT NULL,
  `data_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_oferten`
--

INSERT INTO `bouw_oferten` (`id`, `adres_id`, `in_progres`, `status`, `oferten_numer`, `data`, `planned_date`, `data_end`) VALUES
(6, 32, 0, 1, 0, '2020-01-01', '2020-01-17', '0000-00-00'),
(9, 32, 0, 2, 3, '2020-01-14', '2020-01-18', '2020-01-20'),
(10, 32, 0, 2, 4, '2020-01-14', '2020-01-16', '2020-01-20'),
(12, 32, 0, 2, 6, '2020-01-01', '2020-01-07', '2020-01-17'),
(14, 35, 0, 2, 8, '2020-01-03', '2020-01-18', '2020-01-17'),
(16, 2, 0, 0, 10, '2020-01-21', '2020-01-21', '0000-00-00'),
(17, 2, 0, 0, 11, '2020-01-21', '2020-01-21', '0000-00-00'),
(20, 2, 0, 1, 14, '2020-01-21', '2020-01-21', '0000-00-00'),
(21, 9, 0, 0, 15, '2020-01-21', '2020-01-21', '0000-00-00'),
(22, 33, 0, 0, 16, '2020-01-21', '2020-01-21', '0000-00-00'),
(23, 2, 0, 0, 17, '2020-01-21', '2020-01-21', '0000-00-00'),
(24, 9, 0, 0, 18, '2020-01-21', '2020-01-21', '0000-00-00'),
(25, 34, 0, 0, 19, '2020-01-21', '2020-01-21', '0000-00-00'),
(26, 5, 0, 0, 20, '2020-01-21', '2020-01-21', '0000-00-00'),
(27, 33, 0, 0, 21, '2020-01-21', '2020-01-21', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_oferten_details`
--

CREATE TABLE `bouw_oferten_details` (
  `id` int(11) NOT NULL,
  `oferten_nr` int(11) NOT NULL,
  `waarvoor_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `price` float NOT NULL,
  `opmerkingen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_oferten_details`
--

INSERT INTO `bouw_oferten_details` (`id`, `oferten_nr`, `waarvoor_id`, `quantity`, `price`, `opmerkingen`) VALUES
(1, 0, 2, 10, 10, ''),
(5, 0, 1, 5, 5, ''),
(6, 0, 2, 6, 6, ''),
(7, 0, 3, 7, 7, ''),
(8, 0, 4, 8, 8, ''),
(9, 4, 1, 1, 1, ''),
(10, 4, 2, 2, 2, ''),
(11, 4, 3, 4, 30, ''),
(12, 6, 1, 10, 10, ''),
(14, 6, 1, 6, 6, ''),
(15, 6, 1, 4, 5, ''),
(23, 7, 1, 6, 7, ''),
(24, 8, 1, 2, 3, ''),
(27, 10, 1, 11, 11, 'rrr'),
(28, 11, 1, 3, 3, 'ddd'),
(36, 14, 1, 1, 1, 'qqq'),
(37, 14, 2, 1, 11, 'www'),
(38, 14, 3, 1, 111, 'eee'),
(39, 14, 4, 1, 1111, 'rrr'),
(40, 14, 5, 1, 11111, 'tttt'),
(41, 14, 1, 1, 111111, 'yyy'),
(42, 15, 1, 2, 2, 'fkf'),
(43, 16, 1, 2, 2, 'sdfsdf'),
(44, 17, 1, 100, 1, 'werwer'),
(45, 18, 1, 1, 1, 'asdasd'),
(46, 19, 1, 2, 2, 'asdas'),
(47, 20, 1, 2, 2, 'asdasd'),
(48, 21, 1, 50, 1, 'dasd'),
(49, 21, 4, 50, 1, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_oferten_mail`
--

CREATE TABLE `bouw_oferten_mail` (
  `id` int(11) NOT NULL,
  `oferten_id` int(11) NOT NULL,
  `data_czas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_oferten_mail`
--

INSERT INTO `bouw_oferten_mail` (`id`, `oferten_id`, `data_czas`) VALUES
(1, 10, '2020-01-14 11:03:34'),
(2, 10, '2020-01-14 11:03:59'),
(3, 10, '2020-01-14 11:04:37'),
(4, 10, '2020-01-14 11:05:06'),
(5, 10, '2020-01-14 11:05:10'),
(6, 10, '2020-01-14 11:21:49'),
(7, 10, '2020-01-14 11:22:08'),
(8, 10, '2020-01-14 11:22:29'),
(9, 10, '2020-01-14 11:22:54'),
(10, 10, '2020-01-14 11:23:42'),
(11, 10, '2020-01-14 11:24:12'),
(12, 10, '2020-01-14 11:24:43'),
(13, 10, '2020-01-14 11:26:17'),
(14, 10, '2020-01-14 11:27:11'),
(15, 10, '2020-01-14 11:27:27'),
(16, 10, '2020-01-14 11:28:26'),
(17, 10, '2020-01-14 11:28:41'),
(18, 10, '2020-01-14 11:28:58'),
(19, 10, '2020-01-14 11:29:05'),
(20, 11, '2020-01-14 13:38:59'),
(21, 11, '2020-01-14 13:39:07');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_proforma`
--

CREATE TABLE `bouw_proforma` (
  `id` int(11) NOT NULL,
  `adres_id` int(11) NOT NULL,
  `oferten_id` int(11) NOT NULL,
  `proforma_numer` int(11) NOT NULL,
  `data` date NOT NULL,
  `data_betalen` date NOT NULL,
  `is_factur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_proforma`
--

INSERT INTO `bouw_proforma` (`id`, `adres_id`, `oferten_id`, `proforma_numer`, `data`, `data_betalen`, `is_factur`) VALUES
(2, 30, 6, 1, '2020-01-09', '0000-00-00', 0),
(3, 2, 2, 2, '2020-01-01', '2020-01-02', 1),
(4, 2, 6, 3, '2020-01-10', '0000-00-00', 0),
(5, 23, 1, 4, '2020-01-06', '2020-01-11', 1),
(6, 23, 3, 5, '2020-01-11', '0000-00-00', 1),
(7, 19, 2, 6, '2020-01-13', '2020-01-14', 1),
(8, 32, 6, 7, '2020-01-14', '0000-00-00', 0),
(9, 32, 8, 8, '2020-01-14', '0000-00-00', 0),
(10, 32, 6, 9, '2020-01-14', '0000-00-00', 0),
(11, 32, 7, 10, '2020-01-14', '0000-00-00', 0),
(12, 32, 7, 11, '2020-01-14', '0000-00-00', 0),
(13, 32, 7, 12, '2020-01-14', '0000-00-00', 0),
(14, 32, 7, 13, '2020-01-14', '2020-01-04', 1),
(15, 32, 7, 14, '2020-01-14', '2020-01-03', 1),
(16, 32, 7, 15, '2020-01-14', '2020-01-03', 1),
(17, 32, 7, 16, '2020-01-14', '2020-01-01', 1),
(18, 32, 7, 17, '2020-01-14', '2020-01-05', 1),
(19, 32, 7, 18, '2020-01-14', '2020-01-08', 1),
(20, 32, 7, 19, '2020-01-14', '2020-01-07', 1),
(21, 32, 7, 20, '2020-01-14', '2020-01-02', 1),
(22, 32, 7, 21, '2020-01-14', '2020-01-09', 1),
(23, 32, 7, 22, '2020-01-14', '2020-01-13', 1),
(27, 32, 8, 26, '2020-01-17', '2020-01-17', 1),
(28, 2, 0, 27, '2020-01-21', '2020-01-21', 1),
(29, 2, 0, 28, '2020-01-21', '2020-01-21', 1),
(30, 0, 0, 29, '2020-01-21', '0000-00-00', 0),
(31, 2, 16, 30, '2020-01-21', '0000-00-00', 0),
(32, 2, 16, 31, '2020-01-21', '0000-00-00', 0),
(34, 3, 0, 32, '2020-01-21', '0000-00-00', 0),
(35, 5, 26, 33, '2020-01-21', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_proforma_details`
--

CREATE TABLE `bouw_proforma_details` (
  `id` int(11) NOT NULL,
  `proforma_nr` int(11) NOT NULL,
  `waarvoor_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `price` float NOT NULL,
  `opmerkingen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_proforma_details`
--

INSERT INTO `bouw_proforma_details` (`id`, `proforma_nr`, `waarvoor_id`, `quantity`, `price`, `opmerkingen`) VALUES
(1, 0, 1, 10, 20, ''),
(2, 1, 2, 80, 1, ''),
(3, 1, 1, 100, 1, ''),
(4, 2, 1, 20, 5, ''),
(5, 3, 1, 10, 20, ''),
(7, 4, 1, 44, 5, ''),
(8, 5, 3, 50, 50, ''),
(10, 6, 1, 10, 10, ''),
(11, 6, 4, 5, 5, ''),
(13, 7, 3, 7, 7, ''),
(18, 9, 2, 7, 8, ''),
(19, 10, 1, 5, 5, ''),
(20, 11, 1, 5, 5, ''),
(21, 12, 1, 5, 5, ''),
(22, 13, 1, 51, 52, ''),
(23, 14, 1, 56, 54, ''),
(24, 15, 1, 57, 58, ''),
(25, 16, 1, 5, 5, ''),
(26, 17, 1, 5, 5, ''),
(27, 18, 1, 55, 5, ''),
(28, 19, 1, 5, 5, ''),
(29, 20, 1, 5, 5, ''),
(30, 21, 1, 60, 52, ''),
(31, 22, 1, 5, 5, ''),
(32, 23, 1, 5, 10, ''),
(38, 24, 1, 4, 55, ''),
(39, 24, 1, 3, 5, ''),
(40, 25, 1, 40, 3, ''),
(41, 26, 1, 30, 10, ''),
(43, 26, 1, 7, 8, ''),
(44, 27, 1, 2, 2, 'aaa'),
(45, 28, 1, 33, 33, 'bbbccc'),
(46, 29, 1, 1, 1, 'qqq'),
(47, 29, 1, 1, 11, 'wwww'),
(48, 29, 1, 1, 111, 'eeee'),
(49, 29, 1, 1, 1111, 'rrrr'),
(50, 29, 1, 1, 11111, 'ttttt'),
(51, 29, 1, 1, 111111, 'yyyyy'),
(52, 30, 1, 1, 1, 'qqq'),
(53, 30, 2, 1, 11, 'www'),
(54, 30, 3, 1, 111, 'eee'),
(55, 30, 4, 1, 1111, 'rrrr'),
(56, 30, 5, 1, 11111, 'tttt'),
(57, 30, 1, 1, 111111, 'yyyyy'),
(58, 31, 1, 1, 2, 'eee'),
(59, 32, 1, 2, 2.9, 'asdasd'),
(60, 33, 1, 50, 1, ''),
(61, 33, 1, 50, 1, 'asdasd');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_proforma_mail`
--

CREATE TABLE `bouw_proforma_mail` (
  `id` int(11) NOT NULL,
  `proforma_id` int(11) NOT NULL,
  `data_czas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_proforma_mail`
--

INSERT INTO `bouw_proforma_mail` (`id`, `proforma_id`, `data_czas`) VALUES
(24, 5, '2020-01-11 10:28:59'),
(25, 5, '2020-01-11 10:29:05'),
(26, 5, '2020-01-11 10:36:08'),
(27, 5, '2020-01-11 10:36:14'),
(28, 6, '2020-01-13 08:41:45'),
(94, 2, '2020-01-13 13:59:29'),
(95, 4, '2020-01-13 13:59:29'),
(96, 7, '2020-01-13 13:59:29'),
(97, 2, '2020-01-13 13:59:35'),
(98, 4, '2020-01-13 13:59:35'),
(99, 7, '2020-01-13 13:59:35'),
(100, 24, '2020-01-14 12:07:48'),
(101, 24, '2020-01-14 12:08:06'),
(102, 24, '2020-01-15 13:55:46'),
(103, 27, '2020-01-17 14:22:27');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bouw_uitgaven`
--

CREATE TABLE `bouw_uitgaven` (
  `id` int(11) NOT NULL,
  `adres_id` int(11) NOT NULL,
  `oferte_numer` int(11) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `waarvoor_id` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_uitgaven`
--

INSERT INTO `bouw_uitgaven` (`id`, `adres_id`, `oferte_numer`, `price`, `waarvoor_id`, `data`) VALUES
(1, 28, 7, '1.00', 0, '2020-01-01'),
(3, 28, 9, '2.00', 0, '2020-01-01'),
(4, 28, 9, '3.00', 0, '2020-01-08'),
(5, 1, 9, '2020.00', 0, '0000-00-00'),
(6, 1, 9, '11.00', 0, '2020-01-08'),
(7, 0, 9, '11.00', 0, '2020-01-08'),
(8, 0, 9, '12.00', 0, '2020-01-08'),
(9, 27, 1, '125.00', 1, '2020-01-15'),
(10, 3, 1, '50.00', 2, '2020-01-15'),
(11, 16, 0, '80.00', 3, '2020-01-15'),
(12, 32, 0, '111.00', 1, '2020-01-15'),
(13, 32, 0, '22.00', 2, '2020-01-15'),
(14, 2, 0, '555.00', 1, '2020-01-15'),
(15, 2, 2, '66.00', 1, '2020-01-15'),
(16, 2, 1, '444.00', 2, '2020-01-15'),
(17, 2, 1, '44.00', 2, '2020-01-15'),
(19, 3, 0, '4444.00', 1, '2020-01-15'),
(20, 32, 8, '111.00', 1, '2020-01-17'),
(21, 32, 8, '100.00', 5, '2020-01-17');

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
(2, ' aaaa', 20),
(3, 'tttt', 12),
(4, 'jjj', 5),
(5, 'water', 9);

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
-- Indeksy dla tabeli `bouw_factur_mail`
--
ALTER TABLE `bouw_factur_mail`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_insteligen_company_data`
--
ALTER TABLE `bouw_insteligen_company_data`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_oferten`
--
ALTER TABLE `bouw_oferten`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_oferten_details`
--
ALTER TABLE `bouw_oferten_details`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bouw_oferten_mail`
--
ALTER TABLE `bouw_oferten_mail`
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
-- Indeksy dla tabeli `bouw_proforma_mail`
--
ALTER TABLE `bouw_proforma_mail`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT dla tabeli `bouw_city`
--
ALTER TABLE `bouw_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `bouw_factur`
--
ALTER TABLE `bouw_factur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT dla tabeli `bouw_factur_details`
--
ALTER TABLE `bouw_factur_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT dla tabeli `bouw_factur_mail`
--
ALTER TABLE `bouw_factur_mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `bouw_insteligen_company_data`
--
ALTER TABLE `bouw_insteligen_company_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `bouw_oferten`
--
ALTER TABLE `bouw_oferten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `bouw_oferten_details`
--
ALTER TABLE `bouw_oferten_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT dla tabeli `bouw_oferten_mail`
--
ALTER TABLE `bouw_oferten_mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `bouw_proforma`
--
ALTER TABLE `bouw_proforma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT dla tabeli `bouw_proforma_details`
--
ALTER TABLE `bouw_proforma_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT dla tabeli `bouw_proforma_mail`
--
ALTER TABLE `bouw_proforma_mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT dla tabeli `bouw_uitgaven`
--
ALTER TABLE `bouw_uitgaven`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `bouw_waarvoor`
--
ALTER TABLE `bouw_waarvoor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
