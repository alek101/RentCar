-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2019 at 09:28 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baza_rentcar_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `automobili`
--

CREATE TABLE `automobili` (
  `Broj_sasije` varchar(17) COLLATE utf8_unicode_ci NOT NULL,
  `Broj_saobracajne_dozvole` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `Broj_registarskih_tablica` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Godina_proizvodnje` year(4) NOT NULL,
  `Predjena_km` int(11) NOT NULL,
  `Datum_vazenja_registracije` date NOT NULL,
  `Radjen_mali_servis_km` int(11) NOT NULL,
  `Radjen_veliki_servis_km` int(11) NOT NULL,
  `Aktivan` tinyint(1) NOT NULL,
  `Servis` tinyint(1) NOT NULL,
  `Rashodovan` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `automobili`
--

INSERT INTO `automobili` (`Broj_sasije`, `Broj_saobracajne_dozvole`, `Broj_registarskih_tablica`, `Model`, `Godina_proizvodnje`, `Predjena_km`, `Datum_vazenja_registracije`, `Radjen_mali_servis_km`, `Radjen_veliki_servis_km`, `Aktivan`, `Servis`, `Rashodovan`) VALUES
('153534', '343fsx3', '1Pezo', 'PEUGEOT 308 1.6 HDI', 2015, 80000, '2020-04-02', 80000, 0, 1, 0, ''),
('223212', '22A323', '1Citroen', 'CITROEN C3 1.4 HDI', 2018, 55000, '2019-11-15', 50000, 0, 1, 0, ''),
('22346494', '422ASD', '2Citroen', 'CITROEN C3 1.4 HDI', 2017, 105000, '2020-01-03', 100000, 100000, 1, 0, ''),
('4R422G5312', '21211113', '1Pezo208', 'PEUGEOT 208 1.4 HDI', 2017, 45000, '2019-11-01', 40000, 0, 1, 0, ''),
('6321f23', '523232', '1Seat', 'SEAT IBIZA 1.2 TDI', 2019, 9000, '2019-10-30', 0, 0, 1, 0, ''),
('ER4235Tr1', '123213213', '2Pezo208', 'PEUGEOT 208 1.4 HDI', 2017, 100000, '2019-12-18', 100000, 100000, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `cenovnik`
--

CREATE TABLE `cenovnik` (
  `ID` int(11) NOT NULL,
  `Model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Max_broj_dana` smallint(6) NOT NULL,
  `cena_po_danu` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cenovnik`
--

INSERT INTO `cenovnik` (`ID`, `Model`, `Max_broj_dana`, `cena_po_danu`) VALUES
(1, 'CITROEN C3 1.4 HDI', 3, '25.00'),
(2, 'CITROEN C3 1.4 HDI', 7, '20.00'),
(3, 'PEUGEOT 208 1.4 HDI', 3, '29.00'),
(4, 'PEUGEOT 208 1.4 HDI', 7, '23.00'),
(5, 'PEUGEOT 308 1.6 HDI', 3, '35.00'),
(6, 'PEUGEOT 308 1.6 HDI', 7, '30.00'),
(7, 'SEAT IBIZA 1.2 TDI', 3, '32.00'),
(8, 'SEAT IBIZA 1.2 TDI', 7, '28.00'),
(9, 'CITROEN C3 1.4 HDI', 12700, '19.00'),
(10, 'PEUGEOT 208 1.4 HDI', 12700, '22.00'),
(11, 'PEUGEOT 308 1.6 HDI', 12700, '29.00'),
(12, 'SEAT IBIZA 1.2 TDI', 12700, '27.00');

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `Model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Klasa` enum('mala','srednja','velika','luksuzna') COLLATE utf8_unicode_ci NOT NULL,
  `Tip_menjaca` enum('manuelni','automatski','','') COLLATE utf8_unicode_ci NOT NULL,
  `Broj_sedista` tinyint(4) NOT NULL,
  `Broj_vrata` tinyint(4) NOT NULL,
  `Broj_torbi` tinyint(4) NOT NULL,
  `slika` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `opis` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`Model`, `Klasa`, `Tip_menjaca`, `Broj_sedista`, `Broj_vrata`, `Broj_torbi`, `slika`, `opis`) VALUES
('CITROEN C3 1.4 HDI', 'mala', 'automatski', 4, 4, 3, '', ''),
('PEUGEOT 208 1.4 HDI', 'mala', 'manuelni', 4, 4, 2, '', ''),
('PEUGEOT 308 1.6 HDI', 'srednja', 'automatski', 5, 4, 4, '', ''),
('SEAT IBIZA 1.2 TDI', 'mala', 'manuelni', 4, 4, 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE `rezervacija` (
  `ID_rezervacije` int(11) NOT NULL,
  `ID_vozila` varchar(17) COLLATE utf8_unicode_ci NOT NULL,
  `Ime_prezime_kupca` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Broj_telefona` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Datum_pocetka` date NOT NULL,
  `Datum_zavrsetka` date NOT NULL,
  `Cena` decimal(10,2) NOT NULL,
  `Aktivna` tinyint(1) NOT NULL,
  `Napomena` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rezervacija`
--

INSERT INTO `rezervacija` (`ID_rezervacije`, `ID_vozila`, `Ime_prezime_kupca`, `Email`, `Broj_telefona`, `Datum_pocetka`, `Datum_zavrsetka`, `Cena`, `Aktivna`, `Napomena`) VALUES
(8, '6321f23', 'Dusko Dugousko', 'dusko@crtaci.net', '23123213', '2019-10-08', '2019-10-15', '0.00', 1, ''),
(9, '153534', 'Paja Patak', 'Paja@crtaci.net', '23213213', '2019-10-15', '2019-10-23', '0.00', 1, ''),
(10, '223212', 'Elmer davez', 'Elmer@crtaci.net', '21324324', '2019-10-21', '2019-10-23', '0.00', 1, ''),
(11, '22346494', 'Ptica Trkacica', 'Ptica_trkacica@crtaci.net', '43243243', '2019-10-24', '2019-11-07', '0.00', 1, ''),
(12, '6321f23', 'Pera Kojot', 'supergeneije@crtaci.net', '3432432443', '2019-11-05', '2019-11-11', '0.00', 1, ''),
(13, '153534', 'Brzi Gonzales', 'arivaAriva@crtaci.net', '2214214424', '2019-11-02', '2019-11-05', '0.00', 1, ''),
(14, '223212', 'Petao Sofronije', 'petao@crtaci.net', '52523532', '2019-11-04', '2019-11-07', '0.00', 1, ''),
(15, '22346494', 'Macak Silvester', 'macor@crtaci.net', '112244144', '2019-11-05', '2019-11-10', '0.00', 1, ''),
(16, '4R422G5312', 'test', 'test@email.com', '22133', '2019-10-23', '2019-10-25', '0.00', 1, ''),
(17, 'ER4235Tr1', 'test', 'test', '123', '2019-11-01', '2019-11-02', '0.00', 1, 'testKoment'),
(18, 'ER4235Tr1', 'test', 'test', '123', '2019-11-03', '2019-11-04', '0.00', 1, 'testKoment'),
(21, 'ER4235Tr1', 'ADMIN', 'ADMIN', 'ADMIN', '2019-10-20', '2019-10-20', '0.00', 1, 'ADMIN'),
(22, '4R422G5312', 'test', 'test', '123', '2019-11-08', '2019-11-08', '0.00', 1, 'testKoment'),
(24, 'ER4235Tr1', 'ADMIN', 'ADMIN', 'ADMIN', '2019-10-26', '2019-10-27', '0.00', 1, 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `servisna_knjizica`
--

CREATE TABLE `servisna_knjizica` (
  `ID` int(11) NOT NULL,
  `ID_automobila` varchar(17) COLLATE utf8_unicode_ci NOT NULL,
  `Datum` date NOT NULL,
  `Kilometraza` int(11) NOT NULL,
  `Tip_servisa` enum('mali','veliki') COLLATE utf8_unicode_ci NOT NULL,
  `Opis` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `servisna_knjizica`
--

INSERT INTO `servisna_knjizica` (`ID`, `ID_automobila`, `Datum`, `Kilometraza`, `Tip_servisa`, `Opis`) VALUES
(1, 'ER4235Tr1', '2019-10-20', 0, 'mali', 'promenjeni filteri, ulje, nemam pojma, ovo je samo test!'),
(2, 'ER4235Tr1', '2019-10-20', 60000, 'mali', 'promenjeni filteri, ulje, nemam pojma, ovo je samo test!'),
(3, 'ER4235Tr1', '2019-10-20', 100000, 'veliki', 'ovo je samo test!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `automobili`
--
ALTER TABLE `automobili`
  ADD PRIMARY KEY (`Broj_sasije`),
  ADD UNIQUE KEY `Broj_saobracajne_dozvole` (`Broj_saobracajne_dozvole`),
  ADD KEY `Veza_vozilo_model` (`Model`);

--
-- Indexes for table `cenovnik`
--
ALTER TABLE `cenovnik`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Veza_cena_model` (`Model`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`Model`);

--
-- Indexes for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD PRIMARY KEY (`ID_rezervacije`),
  ADD KEY `Veza_ka_vozilu` (`ID_vozila`);

--
-- Indexes for table `servisna_knjizica`
--
ALTER TABLE `servisna_knjizica`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_automobila` (`ID_automobila`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cenovnik`
--
ALTER TABLE `cenovnik`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rezervacija`
--
ALTER TABLE `rezervacija`
  MODIFY `ID_rezervacije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `servisna_knjizica`
--
ALTER TABLE `servisna_knjizica`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `automobili`
--
ALTER TABLE `automobili`
  ADD CONSTRAINT `Veza_vozilo_model` FOREIGN KEY (`Model`) REFERENCES `model` (`Model`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cenovnik`
--
ALTER TABLE `cenovnik`
  ADD CONSTRAINT `Veza_cena_model` FOREIGN KEY (`Model`) REFERENCES `model` (`Model`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD CONSTRAINT `Veza_ka_vozilu` FOREIGN KEY (`ID_vozila`) REFERENCES `automobili` (`Broj_sasije`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `servisna_knjizica`
--
ALTER TABLE `servisna_knjizica`
  ADD CONSTRAINT `servisna_knjizica_ibfk_1` FOREIGN KEY (`ID_automobila`) REFERENCES `automobili` (`Broj_sasije`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
