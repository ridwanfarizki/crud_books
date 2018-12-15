-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 15 Des 2018 pada 04.46
-- Versi Server: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mplus_test`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `md_books`
--

CREATE TABLE IF NOT EXISTS `md_books` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date_published` date NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `type_of_book` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `md_books`
--

INSERT INTO `md_books` (`id`, `title`, `author`, `date_published`, `number_of_pages`, `type_of_book`) VALUES
(1, 'A: Aku, Benci, & Cinta', 'Wulan Fadli', '2018-12-14', 200, 'Other'),
(3, 'Dear Nathan', 'Erisca Febriani', '2016-03-01', 300, 'Other'),
(4, 'Danur', 'Risa Saraswati', '2012-01-01', 200, 'One of novel'),
(5, 'Trinity', 'Trinity', '2017-07-01', 300, 'One of novel'),
(6, 'Surga yang Tak Dirindukan 2 ', 'Asma Nadia', '2016-11-01', 600, 'Documentation'),
(7, 'Promise', 'Tisa TS & Dwitasari', '2016-08-01', 300, 'Other'),
(8, 'Jakarta Undercover', 'Moammar Emka', '2015-01-01', 3000, 'Documentation'),
(9, 'Critical Eleven', 'Ika Natassa', '2015-08-01', 872, 'One of novel'),
(10, 'Gita Cinta dari SMA', 'Eddy D. Iskandar', '2018-12-14', 8613, 'One of novel'),
(11, 'Gee', 'Chairul ANwar', '2018-12-14', 576, 'Documentation'),
(12, 'Angin', 'Iwan Fals', '2018-12-14', 8734, 'Documentation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `md_books`
--
ALTER TABLE `md_books`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `md_books`
--
ALTER TABLE `md_books`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
