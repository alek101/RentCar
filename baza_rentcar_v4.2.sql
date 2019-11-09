-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2019 at 10:02 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baza_rentcar_v4`
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
  `Servis` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `automobili`
--

INSERT INTO `automobili` (`Broj_sasije`, `Broj_saobracajne_dozvole`, `Broj_registarskih_tablica`, `Model`, `Godina_proizvodnje`, `Predjena_km`, `Datum_vazenja_registracije`, `Radjen_mali_servis_km`, `Radjen_veliki_servis_km`, `Aktivan`, `Servis`) VALUES
('153534', '343fsx3', '1Pezo', 'PEUGEOT 308 1.6 HDI', 2015, 82000, '2020-04-02', 82000, 0, 1, 0),
('223212', '22A323', '1Citroen', 'CITROEN C3 1.4 HDI', 2018, 55000, '2019-11-15', 50000, 0, 1, 0),
('22346494', '422ASD', '2Citroen', 'CITROEN C3 1.4 HDI', 2017, 106500, '2020-01-03', 100000, 100000, 1, 0),
('4R422G5312', '21211113', '1Pezo208', 'PEUGEOT 208 1.4 HDI', 2017, 45000, '2019-12-26', 45000, 45000, 1, 0),
('6321f23', '523232', '1Seat', 'SEAT IBIZA 1.2 TDI', 2019, 10500, '2019-12-03', 0, 0, 1, 0),
('ER4235Tr1', '123213213', '2Pezo208', 'PEUGEOT 208 1.4 HDI', 2017, 100000, '2019-12-18', 100000, 100000, 1, 0),
('Were34', '23213123', '1SeatLeon', 'SEAT LEON CARAVAN 1.6 TDI', 2019, 0, '2019-12-30', 0, 0, 1, 0);

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
(12, 'SEAT IBIZA 1.2 TDI', 12700, '27.00'),
(14, 'SEAT LEON CARAVAN 1.6 TDI', 3, '33.00'),
(15, 'SEAT LEON CARAVAN 1.6 TDI', 7, '28.00'),
(16, 'SEAT LEON CARAVAN 1.6 TDI', 12700, '28.00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

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
('CITROEN C3 1.4 HDI', 'mala', 'automatski', 4, 4, 3, '/images/citroen-c3-1-4-hdi.jpg', 'nema'),
('PEUGEOT 208 1.4 HDI', 'mala', 'manuelni', 4, 4, 2, '/images/peugeot-208-1-4-hdi.jpg', 'nema'),
('PEUGEOT 308 1.6 HDI', 'srednja', 'automatski', 5, 4, 4, '/images/peugeot-308-1-6-hdi.jpg', 'nema'),
('SEAT IBIZA 1.2 TDI', 'mala', 'manuelni', 4, 4, 1, '/images/seat-ibiza-1-2-tdi.jpg', 'nema'),
('SEAT LEON CARAVAN 1.6 TDI', 'srednja', 'automatski', 5, 4, 6, '/images/seat-leon-karavan-1-6-tdi.jpg', 'nema 45622');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(8, '6321f23', 'Dusko Dugousko', 'dusko@crtaci.net', '23123213', '2019-10-08', '2019-10-16', '10.00', 1, ''),
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
(24, 'ER4235Tr1', 'ADMIN', 'ADMIN', 'ADMIN', '2019-10-26', '2019-10-27', '0.00', 1, 'ADMIN'),
(25, '153534', 'ADMIN', 'ADMIN', 'ADMIN', '2019-10-30', '2019-11-01', '0.00', 1, 'SERVIS'),
(26, '6321f23', 'ADMIN', 'ADMIN', 'ADMIN', '2019-10-30', '2019-10-31', '0.00', 1, 'SERVIS'),
(27, '4R422G5312', 'ADMIN', 'ADMIN', 'ADMIN', '2019-10-30', '2019-11-01', '0.00', 1, 'SERVIS'),
(28, '4R422G5312', 'Hudini101', 'alekp111@gmail.com', '123', '2019-11-05', '2019-11-06', '29.00', 1, 'test'),
(29, '153534', 'Hudini11', 'alekp111@Gmail.com', '1225', '2019-11-08', '2019-11-10', '70.00', 1, 'test'),
(30, '153534', 'Aleksandar', 'Alekp111@gmail.com', '4545', '2019-11-20', '2019-11-22', '70.00', 1, 'gggegar'),
(31, 'ER4235Tr1', 'Aleksandar', 'Alekp111@gmail.com', '4545', '2019-11-20', '2019-11-22', '58.00', 1, 'gggegar3333'),
(32, '153534', 'Hudini10100', 'Alekp111@gmail.com', '61616', '2019-11-27', '2019-11-29', '70.00', 1, 'rewfrewrfew'),
(33, '4R422G5312', 'Aleksandar', 'Alekp111@Gmail.com', '564651', '2019-11-25', '2019-11-27', '58.00', 1, 'dwdwqd'),
(34, '223212', 'Aleksandar', 'alekp111@gmail.com', '266', '2019-11-20', '2019-11-21', '25.00', 1, 'efefef'),
(35, '22346494', 'Aleksandar', 'Alekp111@gmail.com', '4666', '2019-11-19', '2019-11-21', '50.00', 1, 'fefewf'),
(36, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-13', '2019-11-14', '35.00', 1, 'no comment'),
(37, '223212', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-13', '2019-11-14', '25.00', 1, 'no comment'),
(38, '22346494', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-13', '2019-11-14', '25.00', 1, 'no comment'),
(39, '4R422G5312', 'Aleksandar', 'Alekp111@gmail.com', '123', '2019-11-13', '2019-11-14', '29.00', 1, 'erte'),
(40, '6321f23', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-13', '2019-11-14', '32.00', 1, 'no comment'),
(41, '4R422G5312', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-21', '2019-11-22', '29.00', 1, 'no comment'),
(42, '6321f23', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-21', '2019-11-22', '32.00', 1, 'no comment'),
(43, '6321f23', 'Aleksandar', 'Alekp111@gmail.com', '111', '2019-11-27', '2019-11-29', '64.00', 1, 'test'),
(44, '22346494', 'Aleksandar', 'Alekp111@gmail.com', '1', '2019-11-27', '2019-11-29', '50.00', 1, 'tets'),
(45, '223212', 'Aleksandar', 'Alekp111@gmail.com', '1', '2019-11-27', '2019-11-29', '50.00', 1, 'tets'),
(46, 'ER4235Tr1', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-27', '2019-11-29', '58.00', 1, 'no comment'),
(47, '4R422G5312', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-29', '2019-11-30', '29.00', 1, 'no comment'),
(48, '223212', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-09', '2019-11-09', '0.00', 1, 'test'),
(49, '4R422G5312', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-09', '2019-11-09', '0.00', 1, 'test'),
(50, 'ER4235Tr1', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-09', '2019-11-09', '0.00', 1, 'no comment'),
(51, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-16', '2019-11-16', '0.00', 1, 'no comment'),
(52, 'ER4235Tr1', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-16', '2019-11-16', '0.00', 1, 'no comment'),
(53, '6321f23', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-16', '2019-11-16', '0.00', 1, 'no comment'),
(54, '223212', 'Aleksandar', 'Alekp111@gmail.com', '1234', '2019-11-01', '2019-11-01', '0.00', 1, 'efwefewf'),
(56, '153534', 'Aleksandar', 'Alekp111@gmail.com', '123456', '2019-11-23', '2019-11-24', '35.00', 1, 'test'),
(59, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-26', '2019-11-26', '0.00', 1, 'no comment'),
(60, '22346494', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-26', '2019-11-26', '0.00', 1, 'no comment'),
(61, '6321f23', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-26', '2019-11-26', '0.00', 1, 'no comment'),
(62, '223212', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-26', '2019-11-26', '0.00', 1, 'no comment'),
(63, 'ER4235Tr1', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-26', '2019-11-26', '0.00', 1, 'no comment'),
(64, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-11', '2019-11-12', '35.00', 1, 'no comment'),
(65, 'ER4235Tr1', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-11', '2019-11-12', '29.00', 1, 'no comment'),
(66, '22346494', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-11', '2019-11-12', '25.00', 1, 'no comment'),
(67, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-25', '2019-11-25', '0.00', 1, 'no comment'),
(68, '223212', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-25', '2019-11-25', '0.00', 1, 'no comment'),
(69, '22346494', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-11-25', '2019-11-25', '0.00', 1, 'no comment'),
(70, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-12-12', '2019-12-13', '35.00', 1, 'no comment'),
(71, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-12-19', '2019-12-19', '0.00', 1, 'test'),
(72, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-12-25', '2019-12-26', '35.00', 1, 'no comment'),
(73, '223212', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-12-25', '2019-12-26', '25.00', 1, 'no comment'),
(80, '4R422G5312', 'ADMIN', 'ADMIN', 'ADMIN', '2019-11-07', '2019-11-08', '0.00', 1, 'SERVIS'),
(81, '153534', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-12-27', '2019-12-29', '70.00', 1, 'test'),
(83, '22346494', 'Aleksandar', 'Alekp111@gmail.com', '0', '2019-12-21', '2019-12-22', '25.00', 1, 'no comment');

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
(3, 'ER4235Tr1', '2019-10-20', 100000, 'veliki', 'ovo je samo test!'),
(4, '153534', '2019-10-30', 82000, 'mali', 'test'),
(5, '4R422G5312', '2019-10-30', 45000, 'mali', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Alek', 'Alekp111@Gmail.com', 100, NULL, '$2y$10$NUVD8ZP3Pugog2a2n8NREeO20RmWxu0Yjw5bJnR/YroCava6vXmy.', '61IuZqlm8kwKyoZHhQanKeyLZijpqkq8io1ipW9RK4Fmw2CVOgabPgzvWtCU', '2019-11-07 15:26:10', '2019-11-07 15:26:10'),
(2, 'test1', 'test@Gmail.com', 0, NULL, '$2y$10$soMIT3wgD//qJTqIRN2rKeOFttAkVAwe/WobOqfgKGOUAp92gjRUW', NULL, '2019-11-07 20:40:16', '2019-11-07 20:40:16');

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`Model`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cenovnik`
--
ALTER TABLE `cenovnik`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rezervacija`
--
ALTER TABLE `rezervacija`
  MODIFY `ID_rezervacije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `servisna_knjizica`
--
ALTER TABLE `servisna_knjizica`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
