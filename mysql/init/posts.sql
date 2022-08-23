-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2022 at 03:05 AM
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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postid` varchar(100) NOT NULL PRIMARY KEY,
  `userid` varchar(100) NOT NULL COMMENT '投稿者のuserid',
  `article_title` varchar(100) NOT NULL COMMENT 'タイトル名',
  `article_overview` varchar(500) NOT NULL COMMENT '記事の内容、本文検索の対象',
  `recluting_skill` varchar(100) NOT NULL COMMENT '募集したいスキル、 スキル検索の対象',
  `job_description` varchar(500) NOT NULL COMMENT 'してほしい業務内容',
  `expiration_date` datetime NOT NULL COMMENT '募集終了するdatetime',
  `comment` varchar(200) NOT NULL COMMENT '一言メッセージ',
  `post_update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '投稿を更新したdatetime',
  `post_create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_status` int(11) NOT NULL DEFAULT '0' COMMENT '投稿の状態\r\n0-->>下書き\r\n1-->>公開'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO posts VALUES('aaaaaaaa', '123456789', 'test post', 'this is a test', 'Python PHP', 'backend', CURDATE(), 'I’m looking forward to hearing', default, default, 1);
INSERT INTO posts VALUES('bbbbbbbb', '123456789', 'Unityゲーム開発', 'ゲームを作りたい', 'Unity MAYA', 'backend', CURDATE(), '待ってます', default, default, 1);
INSERT INTO posts VALUES('cccccccc', '123456789', 'モバイルアプリ開発', 'XXXXX', 'Swift Kotolin', 'backend PM', CURDATE(), 'XXXXXX', default, default, 1);
INSERT INTO posts VALUES('ddddddd', '987654321', 'TODOアプリ', '勉強も兼ねて', 'React', 'バックエンド フロントエンド', CURDATE(), '', default, default, 1);
INSERT INTO posts VALUES('eeeeeee', '987654321', 'モバイルゲーム開発', '広告でよくある存在しないゲームを作る', 'Unity', 'backend', CURDATE(), '', default, default, 1);
INSERT INTO posts VALUES('fffffff', '987654321', 'Webサイトフロントエンド', 'ああああ', 'Bootstrap5', 'Frontend', CURDATE(), '', default, default, 1);