-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2022 at 02:53 AM
-- Server version: 5.7.34
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(100) NOT NULL PRIMARY KEY,
  `email` varchar(100) NOT NULL COMMENT 'emailアドレス ユーザーのログイン時に使用',
  `password` varchar(100) NOT NULL COMMENT 'hash化済みパスワード',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '投稿したdatetime',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '編集されたdatatime '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- TODO: updatetimeにする
--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO users (userid, email, password, created_at, updated_at) VALUES ('123456789', 'guest@example.com','$2y$10$i8/CX5q489.6dLEFsQ8h.O55EuNA27JTEvcYjDFmVRQtGbHpE.rG.', DEFAULT, DEFAULT);
INSERT INTO users (userid, email, password, created_at, updated_at) VALUES ('987654321', 'dummy@example.com','$2y$10$imfnzlvvHZInudDl72115uLErEzqTzmJ72vCulmDBT30sT64nWoHm', DEFAULT, DEFAULT);