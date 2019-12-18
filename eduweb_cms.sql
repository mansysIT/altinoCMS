-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 01 Cze 2012, 16:10
-- Wersja serwera: 5.1.61
-- Wersja PHP: 5.3.3-7+squeeze9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `eduweb_cms`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `administrator`
--

CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `nick` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `privileges` varchar(100) COLLATE utf8_polish_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `administrator`
--

INSERT INTO `administrator` (`id`, `imie`, `nazwisko`, `nick`, `pass`, `privileges`) VALUES
(1, 'Mateusz', 'Manaj', 'administrator', '9056c0bbcb4075ff82dd99efe295922f', 'admin'),
(2, 'Mateusz', 'Manaj', 'user', '24c9e15e52afc47c225b757e7bee1f9d', 'user');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) COLLATE utf8_polish_ci NOT NULL,
  `text` longtext COLLATE utf8_polish_ci NOT NULL,
  `date` datetime NOT NULL,
  `author` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `articles`
--

INSERT INTO `articles` (`id`, `title`, `text`, `date`, `author`) VALUES
(1, 'Kawa jest zdrowa', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare scelerisque nisl a ultricies. Nulla vitae volutpat nulla. Morbi consectetur euismod nulla, eget tincidunt massa auctor sit amet. Suspendisse potenti. In hac habitasse platea dictumst. Sed vulputate blandit nisl, nec interdum nibh fermentum eu. Vivamus semper fringilla nulla, sit amet euismod tortor dapibus nec. Maecenas id lacus mi. Aliquam egestas, odio a vestibulum ultricies, dolor magna ornare massa, sit amet hendrerit enim augue nec arcu. Phasellus quam leo, blandit eget vulputate et, cursus sit amet tellus. Phasellus facilisis iaculis pellentesque. Phasellus sed aliquam ligula. Mauris semper fringilla augue quis tincidunt. Nullam vel augue massa. Vestibulum luctus magna vel felis mollis et venenatis libero suscipit. Nunc convallis accumsan neque non vestibulum. Nullam pellentesque convallis arcu eget facilisis. Aenean id lorem non elit sodales sagittis eget eu augue. Fusce massa nibh, varius sed mollis vitae, pulvinar a nulla. Aliquam facilisis varius viverra. ', '2011-02-03 00:23:48', 'Mateusz Manaj'),
(2, 'Nowe kursy na eduweb.pl !', 'Sed vulputate blandit nisl, nec interdum nibh fermentum eu. Vivamus semper fringilla nulla, sit amet euismod tortor dapibus nec. Maecenas id lacus mi. Aliquam egestas, odio a vestibulum ultricies, dolor magna ornare massa, sit amet hendrerit enim augue nec arcu. Phasellus quam leo, blandit eget vulputate et, cursus sit amet tellus. Phasellus facilisis iaculis pellentesque. Phasellus sed aliquam ligula. Mauris semper fringilla augue quis tincidunt. Nullam vel augue massa. Vestibulum luctus magna vel felis mollis et venenatis libero suscipit. Nunc convallis accumsan neque non vestibulum. Nullam pellentesque convallis arcu eget facilisis. Aenean id lorem non elit sodales sagittis eget eu augue. Fusce massa nibh, varius sed mollis vitae, pulvinar a nulla. Aliquam facilisis varius viverra. ', '2011-03-08 13:10:48', 'Grzegorz Róg'),
(3, 'Ryby głosu nie mają', ' Nulla vitae volutpat nulla. Morbi consectetur euismod nulla, eget tincidunt massa auctor sit amet. Suspendisse potenti. In hac habitasse platea dictumst. Sed vulputate blandit nisl, nec interdum nibh fermentum eu. Vivamus semper fringilla nulla, sit amet euismod tortor dapibus nec. Maecenas id lacus mi. Aliquam egestas, odio a pellentesque. Phasellus sed aliquam ligula. Mauris semper fringilla augue quis tincidunt. Nullam vel augue massa. Vestibulum luctus magna vel felis mollis et venenatis libero suscipit. Nunc convallis accumsan neque non vestibulum. Nullam pellentesque convallis arcu eget facilisis. Aenean id lorem non elit sodales sagittis eget eu augue. Fusce massa nibh, varius sed mollis vitae, pulvinar a nulla. Aliquam facilisis varius viverra. ', '2011-04-13 09:42:52', 'Mateusz Manaj'),
(4, 'Nowoczesne podejście do klienta', 'Aliquam egestas, odio a vestibulum ultricies, dolor magna ornare massa, sit amet hendrerit enim augue nec arcu. Phasellus quam leo, blandit eget vulputate et, cursus sit amet tellus. Phasellus facilisis iaculis pellentesque. Phasellus sed aliquam ligula. Mauris semper fringilla augue quis tincidunt. Nullam vel augue massa. Vestibulum luctus magna vel felis mollis et venenatis libero suscipit. Nunc convallis accumsan neque non vestibulum. Nullam pellentesque convallis arcu eget facilisis. Aenean id lorem non elit sodales sagittis eget eu augue. Fusce massa nibh, varius sed mollis vitae, pulvinar a nulla. Aliquam facilisis varius viverra. ', '2011-05-06 10:17:54', 'Mateusz Manaj');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `meta_tags`
--

CREATE TABLE IF NOT EXISTS `meta_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `security` mediumtext COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `meta_tags`
--

INSERT INTO `meta_tags` (`id`, `content_type`, `keywords`, `description`, `author`, `distribution`, `robots`, `revisit`, `copyrights`, `googlebot`, `classification`, `publisher`, `page_topic`, `rating`, `security`) VALUES
(1, 'UTF-8', 'SuperCMS Eduweb System CMS', 'System CMS napisany na potrzeby kursu Eduweb', 'Mateusz Manaj - Eduweb.pl', 'global', 'index,follow,all', '2 days', '&copy; Eduweb 2012', 'index,follow,all', 'Eduweb', 'eduweb.pl', 'Eduweb, SuperCMS', 'general', 'public');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `meta_tags_index`
--

CREATE TABLE IF NOT EXISTS `meta_tags_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_tags_id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `meta_tags_index`
--

INSERT INTO `meta_tags_index` (`id`, `meta_tags_id`, `name`) VALUES
(1, 1, 'default');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `tr_global`
--

CREATE TABLE IF NOT EXISTS `tr_global` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `test1` longtext COLLATE utf8_polish_ci NOT NULL,
  `test2` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst5` longtext COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `tr_global`
--

INSERT INTO `tr_global` (`id`, `lang`, `test1`, `test2`, `tekst5`) VALUES
(1, 'pl', 'dfdfsdf sdfdfs', '', ''),
(2, 'en', '33333', '', ''),
(3, 'ge', '            \n            ', '', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `tr_home_index`
--

CREATE TABLE IF NOT EXISTS `tr_home_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) COLLATE utf8_polish_ci NOT NULL,
  `tekst1` longtext COLLATE utf8_polish_ci NOT NULL,
  `slider` longtext COLLATE utf8_polish_ci NOT NULL,
  `kwalifikacje` longtext COLLATE utf8_polish_ci NOT NULL,
  `rozwoj` longtext COLLATE utf8_polish_ci NOT NULL,
  `test` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst8` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst9` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst10` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst11` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst12` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst13` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst14` longtext COLLATE utf8_polish_ci NOT NULL,
  `test222` longtext COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `tr_home_index`
--

INSERT INTO `tr_home_index` (`id`, `lang`, `tekst1`, `slider`, `kwalifikacje`, `rozwoj`, `test`, `tekst8`, `tekst9`, `tekst10`, `tekst11`, `tekst12`, `tekst13`, `tekst14`, `test222`) VALUES
(1, 'pl', '<h2>Wprowadzenie</h2>\r\n                    <p>222Nasza firma powstała po to, aby oferować usługi dla biznesu na najwyższym poziomie. Istniejąc na raynku od 2009 roku staramy się stale ulepszać jakość naszych usług oraz oferować coraz więcej atrakcyjnych usług dla Twojej firmy.</p>\r\n                    <p>Nasza marka opiera się na zaufaniu zadowolonych klientów, których referencje zamieszczamy w dziale Portfolio.</p>', '<h2>O firmie</h2>\r\n                        \r\n               	    <div id="slider">\r\n                        <ul class="navigation" style="display: none;">\r\n                            <li><a href="#sites">Sites</a></li>\r\n                            <li><a href="#files">Files</a></li>\r\n                            <li><a href="#editor">Editor</a></li>   \r\n                        </ul>\r\n                        \r\n                        <div class="scroll">\r\n                            <div class="scrollContainer">\r\n                            \r\n                                <div class="panel" id="sites">\r\n                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris luctus \r\n                                vehicula tortor, in imperdiet eros tempus vel. Suspendisse id arcu leo\r\n                                </div>\r\n                              \r\n                                <div class="panel" id="files">\r\n                                ac aliquet nibh. Cras eu enim sit amet libero consectetur venenatis. \r\n                                Morbi volutpat elementum ante, in rutrum ipsum pretium ultrices. Morbi libero\r\n                                </div>\r\n                              \r\n                                <div class="panel" id="editor">\r\n                                    egestas volutpat nunc arcu et sapien. Vivamus congue, eros dictum fermentum \r\n                                    laoreet, velit quam mollis lacus, in tristique dui nunc a mauris\r\n                                </div>\r\n                              \r\n                            </div>\r\n                        </div>\r\n                    </div>', '<h2>Najwyższe kwalifikacje</h2>\r\n                <p>Naszym celem jest oferowanie skutecznych usług dla Twojego biznesu. Liczą się dla nas konkretne rezultaty, które osiąga Twoja firma. Dlatego stale doskonalimy nasze umiejętności oraz kwalifikacje merytoryczne.</p>    ', '                                    <h2>Rozwijamy Twój biznes</h2>\n                <p>Jesteśmy po to, aby pomóc w rozwoju Twojemu biznesowi. Wspólnie postaramy się ustalić strategię dla Twoje firmy aby strona intenetowa była inwestycją, która się zwraca.</p>\n                <p>Jeśli jesteś zainteresowany naszymi usługami prześlij formularz w dziale kontakt. Wycena Twojego zapytania nic nie kosztuje!</p>\n            ', '', '', '', '', '', '', '', '', 'gfhfgh'),
(2, 'en', '<h2>Introducing</h2>\r\n<p>Our company was established in order to offer services to business at the highest level. Being on raynku since 2009 we strive to continually improve the quality of our services and offer more attractive services for your business. </p>\r\n                    <p> Our brand is based on trust of satisfied clients whose testimonials we present in the Portfolio section.</p>', '<h2>About</h2>\r\n                       \r\n                     <div id="slider">\r\n                       <ul class="navigation" style="display: none;">\r\n                           <li><a href="#sites">Sites</a></li>\r\n                           <li><a href="#files">Files</a></li>\r\n                           <li><a href="#editor">Editor</a></li>  \r\n                       </ul>\r\n                       \r\n                       <div class="scroll">\r\n                           <div class="scrollContainer">\r\n                           \r\n                               <div class="panel" id="sites">\r\n                               Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris luctus\r\n                               vehicula tortor, in imperdiet eros tempus vel. Suspendisse id arcu leo\r\n                               </div>\r\n                             \r\n                               <div class="panel" id="files">\r\n                               ac aliquet nibh. Cras eu enim sit amet libero consectetur venenatis.\r\n                               Morbi volutpat elementum ante, in rutrum ipsum pretium ultrices. Morbi libero\r\n                               </div>\r\n                             \r\n                               <div class="panel" id="editor">\r\n                                   egestas volutpat nunc arcu et sapien. Vivamus congue, eros dictum fermentum\r\n                                   laoreet, velit quam mollis lacus, in tristique dui nunc a mauris\r\n                               </div>\r\n                             \r\n                           </div>\r\n                       </div>\r\n                   </div>', '<h2>highest qualification</h2>\r\n                <p> Our goal is to provide effective services for your business. Count for us concrete results, which reaches your company. That is why we keep improving our skills and substantive qualifications. </p>', '            vvvvvvv<h2> develop your business </h2>\n                <p> We are here to help you grow your business. Together we will determine a strategy for your company to intenetowa page was an investment that pays off. </p>\n                <p> If you are interested in our services, please send the form in the contact section. Valuation of your inquiry''s free! </p>\ngggggg\n            ', '', '', '', '', '', '', '', '', 'fghfgh');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `tr_nowastrona_index`
--

CREATE TABLE IF NOT EXISTS `tr_nowastrona_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `fghfgh` longtext COLLATE utf8_polish_ci NOT NULL,
  `ghjghjgj` longtext COLLATE utf8_polish_ci NOT NULL,
  `ertetert` longtext COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `tr_nowastrona_index`
--

INSERT INTO `tr_nowastrona_index` (`id`, `lang`, `fghfgh`, `ghjghjgj`, `ertetert`) VALUES
(1, 'pl', 'qqqqqqq', '', ''),
(2, 'en', 'english', 'sdfsfsdfsdfsdfsdf', 'erwrewrew');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `tr_nowaTesting_index`
--

CREATE TABLE IF NOT EXISTS `tr_nowaTesting_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `gh` longtext COLLATE utf8_polish_ci NOT NULL,
  `tekst4` longtext COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `tr_nowaTesting_index`
--

INSERT INTO `tr_nowaTesting_index` (`id`, `lang`, `gh`, `tekst4`) VALUES
(1, 'pl', 'xcvxcv', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `tr_produkty_index`
--

CREATE TABLE IF NOT EXISTS `tr_produkty_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `wprowadzenie` longtext COLLATE utf8_polish_ci NOT NULL,
  `rozwoj` longtext COLLATE utf8_polish_ci NOT NULL,
  `testowe` longtext COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `tr_produkty_index`
--

INSERT INTO `tr_produkty_index` (`id`, `lang`, `wprowadzenie`, `rozwoj`, `testowe`) VALUES
(1, 'pl', '<h2>Wprowadzenie</h2>\r\n                    <p>Nasza firma powstała po to, aby oferować usługi dla biznesu na najwyższym poziomie. Istniejąc na raynku od 2009 roku staramy się stale ulepszać jakość naszych usług oraz oferować coraz więcej atrakcyjnych usług dla Twojej firmy.</p>\r\n					<p>Nasza marka opiera się na zaufaniu zadowolonych klientów, których referencje zamieszczamy w dziale Portfolio.</p>\r\n                	<ul>\r\n                    	<li>Przykładowa treść</li>\r\n                    	<li>Przykładowa treść</li>\r\n                    	<li>Przykładowa treść</li>\r\n                    </ul>', '<h2>Rozwijamy Twój biznes</h2>\r\n                    <p class="produkt1">Jesteśmy po to, aby pomóc w rozwoju Twojemu biznesowi. Wspólnie postaramy się ustalić strategię dla Twoje firmy aby strona intenetowa była inwestycją, która się zwraca.</p>\r\n					<p class="produkt2">Jeśli jesteś zainteresowany naszymi usługami prześlij formularz w dziale kontakt. Wycena Twojego zapytania nic nie kosztuje!</p>', '<br /><h2>to jest test tłumaczenia</h2>');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(300) COLLATE utf8_polish_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `mail` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `birthdate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=13 ;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `mail`, `birthdate`) VALUES
(1, 'Mateusz Manaj', 'Mateusz', '8d667c5c0121e45944d8dcc01caa4918', 'mateusz@eduweb.pl', '1987-05-27'),
(2, 'Janek Janecki', 'Janek', '124e20aad7628b8bb458685f6c806345', 'janek@exxample.com', '1984-07-10'),
(3, 'Ania Zannopola', 'Ania', '7437e2f5c764eace2f0ba0d8f5bc49e2', 'ania@exxample.com', '1990-03-26'),
(4, 'Michał Kawka', 'Michał', '8237fcfcf087154b25502fa448c9f908', 'michal@example.com', '1985-07-14'),
(7, 'Zenek Gościu', 'Zenek', '91073e8701f6cedebaf3822b5bf3250e6d88d6bb', 'zenek@example.com', '1991-06-23'),
(8, 'Jacek Jackowiak', 'jackD', 'b38726b388553a926a3d8ce3fa79b84f', 'jack@wp.pl', '1944-01-01'),
(9, 'Majorek dfgdfg', '', '827ccb0eea8a706c4c34a16891f84e7b', 'mateusz.manaj@softgraf.pl', '1987-05-27'),
(10, 'Majorek dfgdfg', 'MateuszM', '689cb8b98ee3effe756539af1f2c8553', 'mateusz.manaj@softgraf.pl', '1987-05-27'),
(11, 'Mate Manaj', 'Master_PHP', '37bfb6b1ef5c3ab6f7dbd539cedc27f6', 'mateusz.manaj@softgraf.pl', '1987-05-27'),
(12, 'Zenobiusz zenek', 'zenuś', '40fb7e6030851ad33b9c770f8fe3b14d', 'zenek@wp.pl', '1940-01-01');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_artykul` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `ocena` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=21 ;

--
-- Zrzut danych tabeli `votes`
--

INSERT INTO `votes` (`id`, `id_artykul`, `id_user`, `ocena`) VALUES
(1, 1, 1, 30),
(2, 2, 1, 40),
(6, 3, 1, 60),
(7, 6, 1, 20),
(8, 1, 2, 30),
(9, 1, 3, 60),
(10, 1, 4, 50),
(13, 0, 1, 0),
(14, 0, 1, 0),
(15, 0, 1, 0),
(16, 0, 1, 0),
(20, 4, 1, 60);
