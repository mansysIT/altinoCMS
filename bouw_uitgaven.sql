-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Sty 2020, 15:35
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

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `bouw_uitgaven`
--
ALTER TABLE `bouw_uitgaven`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `bouw_uitgaven`
--
ALTER TABLE `bouw_uitgaven`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
