-- phpMyAdmin SQL Dump
-- version 3.3.10.5
-- http://www.phpmyadmin.net
--
-- ホスト: mysql501.db.sakura.ne.jp
-- 生成時間: 2015 年 2 月 25 日 22:05
-- サーバのバージョン: 5.5.38
-- PHP のバージョン: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `kamie-fan_kamie`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `illustrations`
--

DROP TABLE IF EXISTS `illustrations`;
CREATE TABLE IF NOT EXISTS `illustrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filename_thumb` varchar(255) NOT NULL,
  `mime` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- テーブルのデータをダンプしています `illustrations`
--


-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- テーブルのデータをダンプしています `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'SHINYA', 'e05m1206@yahoo.co.jp', '$2y$10$nNaDfMqD15Zs2TbvqWv7NOtdxuX3a9fF1jR91LbwXvZkLoccQ4G2u', '2015-02-19 21:03:52');
