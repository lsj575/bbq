-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-05-04 16:01:39
-- 服务器版本： 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbq`
--

-- --------------------------------------------------------

--
-- 表的结构 `article_comments`
--

DROP TABLE IF EXISTS `article_comments`;
CREATE TABLE IF NOT EXISTS `article_comments` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) DEFAULT NULL,
  `article_id` int(64) DEFAULT NULL,
  `mentioned_user_id` bigint(64) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4,
  `type` smallint(6) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`),
  KEY `mentioned_user_id` (`mentioned_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `article_comments_img`
--

DROP TABLE IF EXISTS `article_comments_img`;
CREATE TABLE IF NOT EXISTS `article_comments_img` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `article_comments_id` bigint(64) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_comments_id` (`article_comments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `article_comments_reply`
--

DROP TABLE IF EXISTS `article_comments_reply`;
CREATE TABLE IF NOT EXISTS `article_comments_reply` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `article_comment_id` bigint(64) DEFAULT NULL,
  `reply_user_id` bigint(64) DEFAULT NULL,
  `user_id` bigint(64) DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4,
  `created_time` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_comment_id` (`article_comment_id`),
  KEY `reply_user_id` (`reply_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `article_img`
--

DROP TABLE IF EXISTS `article_img`;
CREATE TABLE IF NOT EXISTS `article_img` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `aritcle_id` bigint(64) DEFAULT NULL,
  `path` varchar(300) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aritcle_id` (`aritcle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `reply_img`
--

DROP TABLE IF EXISTS `reply_img`;
CREATE TABLE IF NOT EXISTS `reply_img` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `reply_id` bigint(64) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reply_id` (`reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) DEFAULT NULL,
  `theme_name` varchar(50) DEFAULT NULL,
  `background_img` varchar(200) DEFAULT NULL,
  `theme_introduction` text,
  `follower` int(11) DEFAULT '0',
  `created_time` int(11) DEFAULT NULL,
  `number_of_message` int(11) DEFAULT '0',
  `status` smallint(6) DEFAULT '1',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(30) DEFAULT NULL,
  `cardno` varchar(10) NOT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `realname` varchar(32) DEFAULT NULL,
  `sex` smallint(6) DEFAULT NULL,
  `home_img` varchar(200) DEFAULT NULL,
  `theme_introduction` text,
  `fans` int(11) DEFAULT '0',
  `follows` int(11) DEFAULT '0',
  `likes` int(11) DEFAULT '0',
  `themes` int(11) DEFAULT '0',
  `college` varchar(32) DEFAULT NULL,
  `collections` int(11) DEFAULT '0',
  `reg_time` int(11) DEFAULT NULL,
  `last_login_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cardno` (`cardno`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `nickname`, `cardno`, `avatar`, `realname`, `sex`, `home_img`, `theme_introduction`, `fans`, `follows`, `likes`, `themes`, `college`, `collections`, `reg_time`, `last_login_time`) VALUES
(1, '259962', '259962', NULL, '龙思杰', 0, NULL, NULL, 0, 0, 0, 0, '计算机科学与技术学院', 0, 1525314015, 1525315437);

-- --------------------------------------------------------

--
-- 表的结构 `user_article`
--

DROP TABLE IF EXISTS `user_article`;
CREATE TABLE IF NOT EXISTS `user_article` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) DEFAULT NULL,
  `mentioned_user_id` bigint(64) DEFAULT NULL,
  `content` text,
  `likes` int(11) DEFAULT NULL,
  `comments` int(11) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `mentioned_user_id` (`mentioned_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_attention_theme`
--

DROP TABLE IF EXISTS `user_attention_theme`;
CREATE TABLE IF NOT EXISTS `user_attention_theme` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) DEFAULT NULL,
  `theme_id` bigint(64) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `theme_id` (`theme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_attention_user`
--

DROP TABLE IF EXISTS `user_attention_user`;
CREATE TABLE IF NOT EXISTS `user_attention_user` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `attention_user_id` bigint(64) DEFAULT NULL,
  `followed_user_id` bigint(64) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attention_user_id` (`attention_user_id`),
  KEY `followed_user_id` (`followed_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_collection`
--

DROP TABLE IF EXISTS `user_collection`;
CREATE TABLE IF NOT EXISTS `user_collection` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) DEFAULT NULL,
  `article_id` bigint(64) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_forward_article`
--

DROP TABLE IF EXISTS `user_forward_article`;
CREATE TABLE IF NOT EXISTS `user_forward_article` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `article_id` bigint(64) DEFAULT NULL,
  `user_id` bigint(64) DEFAULT NULL,
  `content` text,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
