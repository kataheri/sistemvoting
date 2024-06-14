-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 03:49 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `votesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_on` date NOT NULL,
  `otp` varchar(100) NOT NULL,
  `expired_otp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `fullname`, `email`, `created_on`, `otp`, `expired_otp`) VALUES
(1, 'admin', '$2y$10$qtV7KnOIcj9vO3wEzwsB2.EFMSTNXcYV4z.sCGHAOrt3jCcxmqj5a', 'Admin Utama', 'felix.swift916@gmail.com', '2019-07-12', '$2y$10$KdJiKgvDlvN08qWOI/zpVeMhGNNVoK/2qxx.joEhlsS/HXJSurG8y', '2024-06-12 15:34:44'),
(2, 'yudha', '$2y$10$WRmme/gY29Uxpq6fqoKA0euL5gvJidDr2ZoN9WXP8FGCF7eFMTzgC', 'Yudha Admin', '3332170036@untirta.ac.id', '2023-10-20', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `platform` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `position_id`, `group_id`, `fullname`, `photo`, `platform`) VALUES
(41, 11, 7, 'YULIA ELLYDA', 'YULIA ELLYDA.jpg', 'Memandu menuju Indonesia berkah'),
(43, 11, 10, 'NUSRON WAHID', 'Nusron Wahid.jpg', 'Harapkan suara Golkar suara rakyat'),
(44, 11, 8, 'Edhie Baskoro Yudhoyono', 'Edhie Baskoro Yudhoyono.jpg', 'Bertekad memberi bukti bukan janji'),
(45, 11, 9, 'Karolin Margret Natasa', 'Karolin Margret Natasa.jpg', 'Teriakan Indonesia hebat'),
(46, 11, 6, 'Ahmad Hanafi Rais', 'Ahmad Hanafi Rais.jpg', 'Terus bekerja untuk rakyat');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `description` varchar(30) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `description`, `priority`) VALUES
(6, 'Partai Amanat Nasional', 1),
(7, 'Partai Persatuan Pembangunan', 2),
(8, 'Partai Demokrat', 3),
(9, 'PDIP', 4),
(10, 'Partai Golkar', 5);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `max_vote` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `description`, `max_vote`, `priority`) VALUES
(10, 'Presiden', 1, 1),
(11, 'DPR', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `president`
--

CREATE TABLE `president` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `platform` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `president`
--

INSERT INTO `president` (`id`, `position_id`, `fullname`, `photo`, `platform`) VALUES
(6, 10, 'Prabowo Subianto & M. Hatta Rajasa', '170px-Capres_2014-2019_Prabowo_Hatta.jpg', 'Membangun Indonesia yang bersatu, berdaulat, adil, dan makmur serta bermatabat\r\n\r\nMISI:\r\n- Mewujudkan NKRI yang aman dan stabil, sejahtera, demokratis, dan berdaulat, serta berperan aktif dalam menciptakan perdamaian dunia, serta konsisten melaksanakan pancasila dan UUD 1945\r\n\r\nKoalisi: PAN, Golkar'),
(7, 10, 'Joko Widodo & Jusuf Kalla', 'Capres_2014-2019_Jokowi-JK.jpg', 'Terwujudnya Indonesia berdaulat, mandiri dan berkepribadian berlandaskan gotong-royong\r\n\r\nMISI:\r\n- Mewujudkan bangsa berdaya-saing\r\n- Mewujudkan kualitas hidup manusia Indonesia yang maju, tinggi, dan sejahtera\r\n\r\nKoalisi: PDIP, Nasdem');

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE `voters` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(60) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp` varchar(100) NOT NULL DEFAULT '0',
  `expired_otp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `username`, `password`, `fullname`, `email`, `otp`, `expired_otp`) VALUES
(43, '1234', '$2y$10$FZYSXPoIgtuBngnnuVt8ouWRYCpZ0Z0kCKQYHjtFLtPO0hqj1KQm6', 'Iqbal', 'balzoom16@gmail.com', '$2y$10$oh7nxsKvRjH7HkXgTeOImOK0DdM4H2Nu93OdnC0O7.N4tDACjn462', '2023-07-30 09:53:16'),
(44, '1486', '$2y$10$U3l2i3hvEjnwcBDmd3wEWO35Sp7wTXSQCMAHztSIDNoTU6VUMe0FC', 'Heri Setyo Aji', 'heriaji72@gmail.com', '$2y$10$WWBFrho3mw3X3H6qDh8tZOV30YLM1qa3AX9hqsqBui7muIhpeWNfG', '2024-06-13 10:08:13'),
(45, '1111', '$2y$10$qVWzn1whxW/Gf9MB9VmPKOPN2x0.pXT.rlnxaBezdj9lWPbjyM0/i', 'ferhatz', 'aswatamalord@gmail.com', '$2y$10$ofPfZXGDEcERnK1DDXXpSeE9keltK84Tp/7MAbEcSuzOo6yB6y67G', '2023-08-02 08:53:02'),
(46, '0002', '$2y$10$G5gNE6GVbz3vNsF.HuE1Z.Rt7dxfdYaozJtri7Wfwx4tB0P.FmA1.', 'Fuad', 'fuadevil007@gmail.com', '$2y$10$YNUlw3pKyjd4KYAJmkJzz.zRUK9zZUiMWoD0EXY.JBqg94RO1UIQq', '2023-07-28 10:02:16'),
(47, '2222', '$2y$10$/0gkM5ru1Du1/KiI3wT7q.kGV9ohsh1Hn6k3njRLC6L4hpEj.PKzy', 'Taufik', 'mtaufikrahmatullah@gmail.com', '$2y$10$iCfzTulBroHV/x0OZJpDMureFRFRwCmJ1ABfh7ZqIl2FXVTYxUikm', '2023-08-01 18:22:12'),
(48, '0099', '$2y$10$1eBms4ourDvOQ6gLIO80F.VIsWTftUQo7Nc2C.2UTwI65m8WkVD9a', 'Fhery Aprilliana ', '3332170099@untirta.ac.id', '$2y$10$S3AR5I2lA2lH7LHcCcH3zeSDYJtacVKk6RZPE3vbY8Xkr90A4vjRa', '2023-07-28 12:49:28'),
(49, '14022', '$2y$10$6gam550e1tprkGEqJtyRGeC8QazvN.5VQCaarkGrP0JI0.zVILWv.', 'Muhammad Zainal Arifin ', 'zainalafin9@gmail.com', '$2y$10$9.ZW1aF1TzBiPAIRvvHIJOJc6/5vWa8408CGOyI5SaCvqcJh9pcsG', '2023-07-28 15:32:59'),
(50, '9988', '$2y$10$Bg7f04HcVjc3RyzKoDRhHeFD3ty/3YbyMBS9EBZVRuxGBQLwNbePW', 'Yudha Iskana', '3332170036@untirta.ac.id', '$2y$10$i9pjoZX96svRASvNkeJFceF6nCLlnv134z1W9nm.J5Gu23cTYRiy6', '2023-07-29 10:19:36'),
(51, '0007', '$2y$10$D4POEdXXYmPMgwSJmTBbT.dsKwwwt06MxzUkcDhMkg/.nbryu0tt.', 'Rizal Amri', 'rizalamri406@gmail.com', '$2y$10$9ng6OFh0QyrotvKt8vZH8uXmlLOjqGZT1utkEhBRYuFDVABtOOQYa', '2023-07-29 13:41:15'),
(52, '0005', '$2y$10$0vDgXF641iBczGYdH7icZ.p162Ox5ZA8hPpCClstmrcUso3gletIC', 'Fadli Robby', 'fadli.robby@ms.mii.co.id', '$2y$10$wltVyIKUkVcVsXeLRy/85eHAu3qByJqPYyu8YxNETwQxsW7Nhz6Iu', '2023-07-30 08:02:58'),
(53, '0132', '$2y$10$OSI/RXZfaRYb1krjyToFIuLZ3vTkVpa7jDCJWhkgVClNTvD9lccUW', 'Anehali', 'Aliizar84@gmail.com', '$2y$10$qoEKQOHHCU753U/EiQUv6.2Z86myuweg8hgFrTC0.yxAvyxJJ.m5m', '2023-07-30 10:58:23'),
(55, '9876', '$2y$10$fpT9iNw6QR8K5eda3Z185OfhFgnPOQWw1s599/c53klp6aI/b3TBa', 'Akbar', 'sidiq8018@gmail.com', '0', NULL),
(56, '12345', '$2y$10$HScayXKf7ODL4gnlgYF8duEN1BAdJFmViAAf7Kgp8hWU5xMtL87Ua', 'Mr akbar', 'sidiq8018@gmail.com', '$2y$10$x45QffVnhQVLh4LQmNxDsunHoz4WstOCZUXXe8LuDp0JEPHLn1G8.', '2023-07-30 13:00:48'),
(57, '9898', '$2y$10$0F5IMYFYb7EfpkKf3aitOuzLga/SaQnx67CNyCzHN/WtEtUDkpapW', 'Rangga AS', 'steffy.rg32@gmail.com', '$2y$10$4HIo3ulo5bhoeYrgRgsUMuS716y9cAa6cZPWcjdC6czy2ZIEU50ia', '2023-07-30 17:54:45'),
(58, '0055', '$2y$10$/rCJwUDT2Wx2Q3ObXufiHuZdfEt2FgX0TLW1pdDIDAI7SmihmM/fm', 'Bagas Surya', 'bagassurya25@gmail.com', '$2y$10$Qped/oRYErZFVs/zzHx7Nuin9Qop8a99ZRU4robjXrtFngfyEJUmS', '2023-07-30 19:12:46'),
(59, '0004', '$2y$10$jnqWfPytXG7F0e1pm8s2mu6bcgObP3K5H0g2jQ4wCu/MlwtOtgK1.', 'Rizqi', 'achmadrizqinurdian@gmail.com', '$2y$10$RxAi6eFPmDsSMU42XcWsz.lFAkoZFeVLD/mxaucYBjTxF6C2Gbe/e', '2023-07-30 19:22:38'),
(60, '0069', '$2y$10$n1WnQi9FNI5l/hxnf7YlZeC4NKacBRDfdB3pEeFoCImRgrtLTz7y6', 'milal', 'milalmihfad@gmail.com', '$2y$10$GTUGWw1rgHPL8g4FeAj.Nu8x9Y0uxCpBO.hPd3iiGFQ4CC/rIqM26', '2023-08-02 04:39:28'),
(61, '6666', '$2y$10$svgnlcetyn0qyJVVFdEKX.DbL4WtaGSDctFaifXKJVduhzLxxWZUO', 'Khoirul Umam', 'mapwebfile2@gmail.com', '$2y$10$EYvc9Jk24xXY6NHOOLkW7OiPs/kRva02jTgFtl6v4FmXMr6NfomSe', '2023-07-30 19:48:33'),
(63, '3672', '$2y$10$c7ps6EDpYceSE/mWFGFQuOIUJEpLluuRJLqvOkaM6rNfq4YSOjOQa', 'Alwan', 'alwanfnurjamil@gmail.com', '0', NULL),
(64, '0897', '$2y$10$SXlvtoIagWRyg//sIp2ibuc9WAEuFFOBsVi.Awm.fiDiTQmQTZsoq', 'Retry', 'ryanobelix4@gmail.com', '$2y$10$nI9sHvYgbGRndrjiFAyQtunlF2qXglHjc36zwbT7PBRQnkSyuTUWK', '2023-07-30 21:19:27'),
(68, '3851', '$2y$10$tOnb1XK.DoP7QZv3MfZ6cuoKBkvKYwWQgQcE78wLbgHbALcBF01qy', 'noval', 'dobeg55@gmail.com', '$2y$10$jJW/gI.oCwfpvps6guDb..NUb4r0UCdsqy8yXJjnps4yfde2u/mvW', '2023-07-31 13:59:39'),
(69, '6942', '$2y$10$H/86ktCJQyd9hNZD9OS7ReRfOOH/8qCxvYXlFzh4s11Ry.BnCHBIO', 'Alvin Raehan', 'alvinraehan76@gmail.com', '$2y$10$/S1c24vVeQ8N0tFSD.k44.BJHLUMUngexsqhp1Eg1OBXzNJ7oUxTC', '2023-07-31 18:15:57'),
(70, '0006', '$2y$10$2fXzXuvyobyb28RvQeXe2.o232O/W1w.eLa6P8i/.mw3LDlxhIGua', 'Mohamad Hendriawan', 'hendriawan770@gmail.com', '$2y$10$haVCvI8ZCEIdS3fv4N0IZ.f/wO1pa8beMUhyMPJkJV6ofJG6hVkX6', '2023-07-31 18:28:14'),
(71, '4753', '$2y$10$ezytH4xMZy.Jp3L.8nuz8.Tf0ubcuhw0llZd7O8x29KlM.PuNu6iu', 'Farhan', 'Farhannauzi007@gmail.com', '$2y$10$MUwn/thOGdVAWpQ4EqH7gO1myD8gO90Ck2OUTd6m/.VWZNW9T2WtG', '2023-07-31 19:13:33'),
(72, '0082', '$2y$10$Xkzghj7wDxEIE6UkjUBOZel9FqPE2MOwJP5alBO/GevPPMVpxevya', 'Nadya', '3332170082@untirta.ac.id', '$2y$10$8c.EQ67q7/vBqzxMU0c8vu8Fe63D95qKqLukAUudKdL8a08lqwwd2', '2023-07-31 19:28:11'),
(73, '9051', '$2y$10$45xiOY80XiJ9ZqvCONM4suxH/mNJXxIY22WoRFEPq4EiNy500d7YW', 'Rofie', 'kautzarrofi768383@gmail.com', '$2y$10$PQSyIZRI0C2UfKH74nacaOVjjGhTPd/p0gYke3kKY8.I71/vJxI92', '2023-07-31 19:37:22'),
(74, '0031', '$2y$10$mpmn/lYcaDs8eOpSDo3Mq.7IOJf3lKaCOAC1B8tYB14f9sFy1l6GC', 'aditya', 'soranohikari_chess@hotmail.com', '$2y$10$vlnleWPNV381FGZRi.4LZeP7krhunB3A7iiO5V5lKFIKu//x2tw/G', '2023-07-31 22:08:47'),
(75, '5566', '$2y$10$dgf5JS.0uYjLBYqf.cyNueAesFPt5IrJyg7zQp6aPxzekIwtly.yS', 'Ferry Hanifah', 'tendousouji_ten_no_michi@yahoo.co.id', '$2y$10$0KklHnCP8abjyJVwfmoRrOCr/QSyKD0u2MROsCP5iVZ2zWqDZXw0e', '2023-08-01 11:49:03'),
(76, '0105', '$2y$10$/aLt3gFp82a6FT/PdMipAenciQ9oQUG8C1aLWbGT3DIGbkgEHn1lC', 'Allan Yusuf', 'allanyusuf2308@gmail.com', '$2y$10$zgXPGFe3TLTKftVWCV2AEuP0XXbr5vt5BIoKFzzhd42HcBoE02iEC', '2023-08-01 12:06:11'),
(77, '5678', '$2y$10$W3YckZGL.mpbtD7Ks5VJL.i1BYAYVSvP1W9ff7dmum7OJpa3wMUSS', 'Irfan ', 'Irvanmandala2@gmail.com', '$2y$10$slgSar6HrfzVey1G3IloEeyPEP.18bESSJ4c/LTNp8yW1oRAYVLre', '2023-08-01 17:05:56'),
(78, '9753', '$2y$10$slPYD.Pyjt5xlaWecDl9Puo.2LggzqdNnCwVmQFpxdHTRpyrWLZUe', 'Adam Abdul Malik', 'Adamabdulmalik2102@gmail.com', '$2y$10$QqrQ2TuyavteChsmGh7Ev.6sA4OClY2Key1giXGBEx9yV9jbUTTvu', '2023-08-01 17:13:18'),
(79, '0466', '$2y$10$0tuZLcZ2Ov3F2s17ccpofuJlAhbEbMmngM9DibvwhA9tjS1PC2gSy', 'Rizki', 'eremesnet13@gmail.com', '$2y$10$.WiGYlNeAJxf20asV2ksMuPdg7ACQy8Ms0l61Z3ibfTEN/7lXrPGG', '2023-08-01 17:32:49'),
(80, '8521', '$2y$10$WkMmNQMGkI5wyAiP3pPuJebExo/7RcWSgZ8/cGM/xch/NVR81Nmfq', 'sarif', 'felix.swift916@gmail.com', '$2y$10$sB7T0QMyC.GqszwPGdAo4eVtZQr4sixahaAqjm5qLubNvbAq.CWky', '2023-08-01 18:28:19'),
(81, '0001', '$2y$10$zRrofLYOAZRrSCqvKpAEqunNq5xURW9cBaCwz37fdrCKuCKkVmLqa', 'Rio ', 'unnamed4120@gmail.com', '$2y$10$Y5sol.HGKtjgXb3M6Wed1ew7yg5PNTaXMkU4OUd1L29IBlYckszWm', '2023-08-02 08:41:10'),
(83, '1258', '$2y$10$Dp6wpXz0Nl7YSJosuJqTX.M1GqD7vT0rjEMCz3rLn6yjT.5BOh9Eq', 'fadil', 'fadil.muhammad@untirta.ac.id', '$2y$10$GjLMvkaqLyr5JqBlZsBPquHIPAw2aqsKvvgfShRbW1w8tvNhLFDoO', '2023-08-02 13:59:22'),
(84, '2468', '$2y$10$4FTJ71b5DDyd1vdPFensDugxCYnOUjVcKUZLC3CBcEPNmRsquZYQe', 'Aditya Dharmawan', 'adityaminoz29@gmail.com', '$2y$10$K6aS39KPOyieQWRmEdFiue2g9gYTBp8O5X9P4P8kuxfn6JrXLo6Hq', '2023-08-03 21:44:57'),
(85, '0000', '$2y$10$QfB1rhYTzc5CjODV0f.nBO5HlVMSrZjgFWItZwLyP1/cG0Cpw2T3W', 'pemilih', 'felix.swift916@gmail.com', '$2y$10$DXcKsOsb5AL5BOeHcVOQSODF6nF13zJi8N7HzFZ5/MnZJlLgbNwAq', '2023-08-09 11:22:28'),
(86, '0011', '$2y$10$jYCyLQ0h6nLIbM6CRkDoxOURXRcv0ORiDQA8gl64OtitcixRfzxTq', 'samsul', 'samsuelsem@gmail.com', '$2y$10$LMwc1ucLqJ926C3W7fNb7./Hh/PqdJ.RR4TcmJMRMOMq7u94IUPRe', '2023-08-21 14:05:48'),
(87, '9999', '$2y$10$nD1PTIaM.C6hQxi6Np10A.qSdqRcOSuuLCXw9.NGtlVSrj3kSLcd.', 'tester', 'felix.swift916@gmail.com', '$2y$10$c/MGbavTIYA5FswXRQvdOeK.OGEDtcijBDSap/VLcpBSMWOydd3XS', '2023-10-31 13:23:45'),
(89, '4321', '$2y$10$V9JpTTdBoVIs4Nn5uMdKkuo9qCNurQjEXUKHiRYMFjuhlUu/ItoQ2', 'Tester', '3332170036@gmail.com', '$2y$10$1uF0k8Fvo13qjFqfO/H7eOsvXg8a9GsXIOrL7QN2U3c0sdWtIGMAS', '2023-11-27 20:15:32'),
(90, '6547', '$2y$10$FFjMnfqmWA4lwrwCkb3RYe9Rw8biTr7lvuMCbfeYfYCo6rgBAh0ia', 'TesterDua', '3332170036@untirta.ac.id', '$2y$10$gLF9h5N6e3I8e8wvLXRXgu252FJlldfruKcLUhYZE2MsyyTfzZto6', '2023-11-27 20:22:36'),
(94, '2998', '$2y$10$oAdeqmQrejH3sKYszWMXh.eIRfJ5MH8MdsyqJ4UX/Lu.wBrhENubC', 'tester', 'felix.swift916@gmail.com', '$2y$10$FSjTIyFvrWvtwEUaPvHte.QQtRDCNgLLYccklnsS0l0/SSyZuQB3u', '2024-02-28 16:43:23'),
(96, '0642', '$2y$10$Mnuxw6NU86y30sfanTD31Otg7GTwpqVRAh2tlcFubf/JqG9nMUOau', 'tester', 'felix.swift916@gmail.com', '$2y$10$xobX0UlBqcQ09ynq0Gg44.Ia/dnkwk3RpgbmYYZdr8ZSSombqR2tW', '2024-06-12 06:47:09'),
(97, '0864', '$2y$10$MXBG4JSeyUMDfrD0K9bEZeOGKx5aAUioYx.WfwgFAL/xMVFiBQLG6', 'tester', 'felix.swift916@gmail.com', '$2y$10$eHfcvNCXCWXfuOowadIxeeG89saMb8Qu9gDQJmUi8HFBd6ln3hHCC', '2024-06-12 15:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `voters_id` int(11) NOT NULL,
  `president_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `voters_id`, `president_id`, `candidate_id`, `position_id`, `group_id`) VALUES
(23, 46, 7, 0, 10, 0),
(24, 46, 0, 46, 11, 0),
(25, 48, 7, 0, 10, 0),
(26, 48, 0, 45, 11, 0),
(27, 49, 6, 0, 10, 0),
(28, 49, 0, 44, 11, 0),
(29, 50, 6, 0, 10, 0),
(30, 50, 0, 46, 11, 0),
(31, 51, 6, 0, 10, 0),
(32, 51, 0, 44, 11, 0),
(33, 52, 6, 0, 10, 0),
(34, 52, 0, 44, 11, 0),
(35, 43, 7, 0, 10, 0),
(36, 43, 0, 45, 11, 0),
(37, 53, 6, 0, 10, 0),
(38, 53, 0, 46, 11, 0),
(39, 56, 6, 0, 10, 0),
(40, 56, 0, 41, 11, 0),
(41, 57, 6, 0, 10, 0),
(42, 57, 0, 44, 11, 0),
(43, 58, 6, 0, 10, 0),
(44, 58, 0, 45, 11, 0),
(45, 59, 6, 0, 10, 0),
(46, 59, 0, 41, 11, 0),
(47, 61, 6, 0, 10, 0),
(48, 61, 0, 41, 11, 0),
(49, 63, 6, 0, 10, 0),
(50, 63, 0, 44, 11, 0),
(51, 64, 6, 0, 10, 0),
(52, 64, 0, 45, 11, 0),
(53, 47, 6, 0, 10, 0),
(54, 47, 0, 46, 11, 0),
(55, 68, 7, 0, 10, 0),
(56, 68, 0, 46, 11, 0),
(57, 69, 7, 0, 10, 0),
(58, 69, 0, 45, 11, 0),
(59, 70, 6, 0, 10, 0),
(60, 70, 0, 46, 11, 0),
(61, 71, 7, 0, 10, 0),
(62, 71, 0, 44, 11, 0),
(63, 72, 7, 0, 10, 0),
(64, 72, 0, 45, 11, 0),
(65, 73, 7, 0, 10, 0),
(66, 73, 0, 43, 11, 0),
(67, 74, 7, 0, 10, 0),
(68, 74, 0, 43, 11, 0),
(69, 75, 6, 0, 10, 0),
(70, 75, 0, 43, 11, 0),
(71, 76, 7, 0, 10, 0),
(72, 76, 0, 44, 11, 0),
(73, 77, 6, 0, 10, 0),
(74, 77, 0, 46, 11, 0),
(75, 78, 7, 0, 10, 0),
(76, 78, 0, 43, 11, 0),
(77, 79, 7, 0, 10, 0),
(78, 79, 0, 44, 11, 0),
(79, 80, 6, 0, 10, 0),
(80, 80, 0, 41, 11, 0),
(81, 60, 7, 0, 10, 0),
(82, 60, 0, 46, 11, 0),
(83, 81, 7, 0, 10, 0),
(84, 81, 0, 44, 11, 0),
(85, 45, 7, 0, 10, 0),
(86, 45, 0, 44, 11, 0),
(87, 83, 6, 0, 10, 0),
(88, 83, 0, 43, 11, 0),
(89, 84, 6, 0, 10, 0),
(90, 84, 0, 44, 11, 0),
(91, 85, 7, 0, 10, 0),
(92, 85, 0, 44, 11, 0),
(93, 86, 6, 0, 10, 0),
(94, 86, 0, 44, 11, 0),
(95, 44, 7, 0, 10, 0),
(96, 44, 0, 44, 11, 0),
(97, 90, 6, 0, 10, 0),
(98, 90, 0, 41, 11, 0),
(101, 96, 6, 0, 10, 0),
(102, 96, 0, 44, 11, 0),
(103, 97, 6, 0, 10, 0),
(104, 97, 0, 45, 11, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `president`
--
ALTER TABLE `president`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `president`
--
ALTER TABLE `president`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
