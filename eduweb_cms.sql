-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 27 Gru 2019, 15:57
-- Wersja serwera: 10.1.38-MariaDB
-- Wersja PHP: 5.6.40

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
-- Struktura tabeli dla tabeli `bouw_adresy`
--

CREATE TABLE `bouw_adresy` (
  `id` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `adres` text NOT NULL,
  `borg` int(11) NOT NULL,
  `varfor` int(11) NOT NULL,
  `water` int(11) NOT NULL,
  `najemca_imie` text NOT NULL,
  `najemca_nazwisko` text NOT NULL,
  `email` text NOT NULL,
  `kod` text NOT NULL,
  `date` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bouw_adresy`
--

INSERT INTO `bouw_adresy` (`id`, `city`, `adres`, `borg`, `varfor`, `water`, `najemca_imie`, `najemca_nazwisko`, `email`, `kod`, `date`, `active`) VALUES
(1, 1, 'test1', 100, 200, 300, 'imieaaa', 'nazwiskoaaa', 'aaa@aaa.com', 'kod', '2019-12-01', 1),
(2, 2, 'test2', 300, 150, 100, 'imiebbb', 'nazwiskobb', 'bbb@bbb.com', 'kod2', '2019-12-05', 1),
(3, 3, 'adres3', 111, 222, 333, 'imie3', 'nazwisko3', 'emial3', 'kod3', '2019-12-14', 0),
(4, 4, 'adres4', 11, 22, 33, 'imie4', 'nazwisko4', 'emial4', 'kod4', '2019-12-08', 0),
(5, 5, 'adres5', 1111, 2222, 3333, 'imie5', 'nazwisko5', 'emial5', 'kod5', '2019-12-16', 0),
(6, 6, 'adres6', 1, 2, 3, 'imie6', 'nazwisko6', 'emial5', 'kod6', '2019-12-02', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `bouw_adresy`
--
ALTER TABLE `bouw_adresy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `bouw_adresy`
--
ALTER TABLE `bouw_adresy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
