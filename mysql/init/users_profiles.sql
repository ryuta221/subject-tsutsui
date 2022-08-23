-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2022 at 03:02 AM
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
-- Table structure for table `users_profiles`
--

CREATE TABLE `users_profiles` (
  `userid` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `profile_image_url` varchar(100) NOT NULL COMMENT 'ユーザーのアイコンの画像',
  `autobiography` varchar(300) NOT NULL COMMENT '自己紹介文',
  `profile_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_edit_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `twitter_url` varchar(256) NOT NULL DEFAULT '',
  `github_url` varchar(256) NOT NULL DEFAULT '',
  `display_email` varchar(256) NOT NULL DEFAULT '' COMMENT '表示用のemailアドレス'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_profiles`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_profiles`
--
ALTER TABLE `users_profiles`
  ADD PRIMARY KEY (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO users_profiles (userid, username, profile_image_url, autobiography, profile_created_at, profile_edit_at, twitter_url, github_url, display_email) VALUES ('123456789', 'guest', '', 'guestユーザーです。', DEFAULT, DEFAULT, 'https://twitterXXX.com/guest', 'https://githubXXX.com/guest', 'guest_display_email@example.com');
INSERT INTO users_profiles (userid, username, profile_image_url, autobiography, profile_created_at, profile_edit_at, twitter_url, github_url, display_email) VALUES ('987654321', 'dummy', '', 'よろしくお願いします。', DEFAULT, DEFAULT, 'https://twitterXXX.com/dummy', 'https://githubXXX.com/dummy', 'dummy_display_email@example.com');