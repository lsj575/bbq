-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2018 at 07:51 PM
-- Server version: 5.7.23
-- PHP Version: 7.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bbq`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesstoken_log`
--

CREATE TABLE `accesstoken_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `source` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '来源 0-用户1-管理员',
  `accesstoken` char(64) NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accesstoken_log`
--

INSERT INTO `accesstoken_log` (`id`, `user_id`, `source`, `accesstoken`, `create_time`, `update_time`) VALUES
(1, 3, 0, '663df16a9b60e26f4c51dd059e577955', 1538832913, 1538832913),
(2, 3, 0, 'c56fb107f48a51c4e3a072c43b41d14c', 1538832930, 1538832930),
(3, 3, 0, 'c1adf1d866aec2fd93124425a4cf8a6f', 1538833014, 1538833014),
(4, 3, 0, 'a8a53b8c8b5c45f0e4e1233c65090797', 1538833051, 1538833051),
(5, 3, 0, 'e09014ca16e9fafb1ff0ab2a16a5fbf1', 1538833068, 1538833068),
(6, 3, 0, 'e9333b82f5f02bedd582f5e8974b7a99', 1538833092, 1538833092),
(7, 3, 0, 'd4a173f973b0d6a6673734ccb33d03fc', 1538833101, 1538833101),
(8, 3, 0, 'f690caa768b27b31ccc56fbba67ce6ae', 1538833120, 1538833120),
(9, 3, 0, '0708f53b44d8e6944259087b911c7f9a', 1538833130, 1538833130),
(10, 3, 0, 'deb4f4e1d0c02103d2c1250fe0b826bb', 1538833167, 1538833167),
(11, 3, 0, 'c488a700e760c77dce9323382ff9720a', 1538833361, 1538833361),
(12, 3, 0, '0b57bf0a6f8072320bf8e13521ddf7f9', 1538833403, 1538833403),
(13, 3, 0, '923e5250118d39e893d2227418297a78', 1538833435, 1538833435),
(14, 3, 0, '6dccde4a4f1ad072e105dd59874dd97a', 1538833469, 1538833469),
(15, 3, 0, '089adde7ed96a37eb734e6393f285ca1', 1538833754, 1538833754),
(16, 3, 0, 'e185343085a2df81e8138f2eb8f9d2ab', 1538833765, 1538833765),
(17, 3, 0, '1604f7020ef2791e2fa5d36d8b0c6eb3', 1538833778, 1538833778),
(18, 3, 0, '4c7d9081b9211fb96951bde71b40e976', 1538833793, 1538833793),
(19, 3, 0, '39432509d0232e14f8867e4bcd393ba9', 1538833897, 1538833897),
(20, 3, 0, 'f8c3771948c4c88d0b48940f3fe1e4c8', 1538833928, 1538833928),
(21, 3, 0, '52dc1cb9f3f682e0146736bf885f8560', 1538833930, 1538833930),
(22, 3, 0, '87b38f0888d03208e01352dafcc14ace', 1538833932, 1538833932),
(23, 3, 0, '064e9a5431987f9a2abc456c493b19b6', 1538833932, 1538833932),
(24, 3, 0, '709e874e95e18f8b29379e376f088fb0', 1538833950, 1538833950),
(25, 3, 0, '687798364b23027b606106e3027ff18a', 1538833957, 1538833957),
(26, 3, 0, '9369ccce88567e33343b74977104df10', 1538834001, 1538834001),
(27, 3, 0, '5caeedfeecaa76cf098cfae60aa39b48', 1538834037, 1538834037),
(28, 3, 0, '0bd42e8f1258a2b3eb5a544e8542e40e', 1538834056, 1538834056),
(29, 3, 0, '21baa44c702379f26cbe243183d7ffb5', 1538834218, 1538834218),
(30, 3, 0, '03635d0d270e57ad2146caf5c7915b67', 1538834652, 1538834652),
(31, 3, 0, '9da5f17d707af0611d197889dd018765', 1538834690, 1538834690),
(32, 3, 0, 'fb02ef923bcb2159645d3e3d5dcbecfb', 1538834691, 1538834691),
(33, 3, 0, '12d05fff1d16c4934743ded611cb3f06', 1538834691, 1538834691),
(34, 3, 0, 'b1410ac559f1504fd4503cfc608e853a', 1538834691, 1538834691),
(35, 3, 0, 'd6e0d2fd0ef38ba3ef65ca1cb027e749', 1538834692, 1538834692),
(36, 3, 0, '989bc64dc92b1e078f9e801f762b33cf', 1538834692, 1538834692),
(37, 3, 0, '44d2f340f08b9e22f5f8e0a587c3f632', 1538834693, 1538834693),
(38, 3, 0, 'bfde3c89cb2edc7bd043d0f098317abd', 1538834693, 1538834693),
(39, 3, 0, '31e4b3000df5f5cf3aec87d983728466', 1538834694, 1538834694),
(40, 3, 0, '455d985e7e2d2768a4940933c79c7998', 1538834895, 1538834895),
(41, 3, 0, 'd2e955917c6a945c5fd9d2cf2fc31fa0', 1538834896, 1538834896),
(42, 3, 0, 'f5b3cfb7a9fac2b2a1b607e7e839f022', 1538834897, 1538834897),
(43, 3, 0, '0836f759d105e40c1ff1d9bdf677f265', 1538834897, 1538834897),
(44, 3, 0, 'e1c26326c337f37954faa79b89e75d8e', 1538834898, 1538834898),
(45, 3, 0, '30470bb4fdba2f8c26204355770f15ee', 1538834899, 1538834899),
(46, 3, 0, '5b7fa07e4c553b900982a95a1837720e', 1538834899, 1538834899),
(47, 3, 0, '0322bfd8526d309cb361aa6efc5fca29', 1538834900, 1538834900),
(48, 3, 0, '6f8d706996a13591f0babc423b9dda6a', 1538834901, 1538834901),
(49, 3, 0, '07bcab1e5452fda5e4186df4d896af91', 1538834901, 1538834901),
(50, 3, 0, '4a9d8c1cd3ed0c8fb170b8ba947d60ea', 1538834983, 1538834983),
(51, 3, 0, '0999789cc5e8d0478e77ebdfcc94d548', 1538834986, 1538834986),
(52, 3, 0, '2267784c88b90ac21c1d5759986f0892', 1538834987, 1538834987),
(53, 3, 0, 'abd03a223c1a42108f8975e3f471b431', 1538834988, 1538834988),
(54, 3, 0, '3e92cd0a481684058cce3c5b412e0528', 1538834989, 1538834989),
(55, 3, 0, '273fc5699dc0cbf0bf79592a1185df7d', 1538834990, 1538834990),
(56, 3, 0, 'a714fd50b9d122aa732c0e6f40ffcdc3', 1538834990, 1538834990),
(57, 3, 0, '1975124e054343e818a7217ec88a712f', 1538834991, 1538834991),
(58, 3, 0, 'c6670c6e7289726fddae285f148ccc7d', 1538834992, 1538834992),
(59, 3, 0, 'af96197271bea856ae43cd98837d0f0b', 1538834992, 1538834992),
(60, 3, 0, '04f3adff84625877d8a9ae09401da9e6', 1538835103, 1538835103),
(61, 3, 0, '760a9645b26f2df00c059dbcee825f7a', 1538835103, 1538835103),
(62, 3, 0, 'a2138c0c88167d957d46b29fd01faf67', 1538835104, 1538835104),
(63, 3, 0, 'd9e2a2fdf712e979f20f7b0a43d66ad2', 1538835104, 1538835104),
(64, 3, 0, 'f30dddfc518a49010e6655fcbfa1bc84', 1538835105, 1538835105),
(65, 3, 0, '04056d0115d57ea77311dc3f7404ede7', 1538835105, 1538835105),
(66, 3, 0, 'bfaa3ea7db0f398a8d2af863b5ec4b53', 1538835106, 1538835106),
(67, 3, 0, 'cf6218f88d597844fc9f45dd87d99c92', 1538835107, 1538835107),
(68, 3, 0, 'fdb4141ed4db16c2f2f6b11d52d0c6cf', 1538835108, 1538835108),
(69, 3, 0, '6eeff2956d3b4d57ea0f7fba5a843f52', 1538835108, 1538835108),
(70, 3, 0, 'f3d623e13b223d7ef6242259764cac44', 1538835374, 1538835374),
(71, 3, 0, '4404016a0fb20904cd28a65e6ee305ee', 1538921169, 1538921169),
(72, 2, 0, '62498b6b462d6ebc4f912e548ebd69c8', 1543805752, 1543805752),
(73, 2, 0, '5772f1c023daefcb7848f39874c72b4a', 1543805792, 1543805792),
(74, 2, 0, 'feb6369c55b70723a61bdc2169829678', 1543846080, 1543846080),
(75, 2, 0, '88f20a4ee93c097b13d8824328b68456', 1543846221, 1543846221);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `last_login_ip` varchar(30) DEFAULT NULL,
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `listorder` int(8) UNSIGNED DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `username`, `password`, `last_login_ip`, `last_login_time`, `listorder`, `status`, `create_time`, `update_time`) VALUES
(1, 'lsj575', 'c9d8fd152b782446b5c2da0896bea713', NULL, 0, 0, 1, 0, 0),
(2, 'admin', 'b90167b6bf42bb9b749f7b7e4227491d', NULL, 0, 0, 1, 1530271838, 1530271838),
(3, 'root', '71165577e60e7d4c491d9bfe0e1d3517', '0.0.0.0', 1544787143, 0, 1, 1530271923, 1544787143),
(4, 'zcf', '1695eb1808c7dbad715605b7af54f42d', NULL, 0, 0, 1, 1531316571, 1531316571);

-- --------------------------------------------------------

--
-- Table structure for table `app_active`
--

CREATE TABLE `app_active` (
  `id` bigint(64) UNSIGNED NOT NULL,
  `version` int(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '版本号',
  `app_type` varchar(20) DEFAULT NULL COMMENT 'app类型',
  `version_code` varchar(10) DEFAULT NULL,
  `did` varchar(100) DEFAULT NULL COMMENT '设备号',
  `model` varchar(20) DEFAULT NULL COMMENT '机型',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='记录用户登录数据表';

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `theme_id` int(10) UNSIGNED NOT NULL,
  `content` text,
  `img` text COMMENT '存放图片，多图用,号分割',
  `allow_watermark` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否添加水印0-否1-是',
  `read_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '阅读数',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数',
  `likes` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点赞数量',
  `is_position` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '类型，原创或转发等',
  `allow_comment` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否允许评论1-允许0-不允许',
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `user_id`, `theme_id`, `content`, `img`, `allow_watermark`, `read_count`, `comments`, `likes`, `is_position`, `create_time`, `update_time`, `type`, `allow_comment`, `status`) VALUES
(1, 2, 1, '更新动态测试', '', 1, 0, 0, 1, 0, 1543062598, 1543670073, 0, 1, 1),
(2, 2, 1, 'bbq发布动态测试1', '', 0, 0, 0, 1, 1, 1543458104, 1543458104, 0, 0, 1),
(3, 3, 1, 'bbq发布动态测试2', '', 0, 0, 0, 1, 0, 1543458109, 1543458109, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `article_comment`
--

CREATE TABLE `article_comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT '0',
  `article_id` int(10) UNSIGNED DEFAULT '0',
  `to_user_id` int(10) UNSIGNED DEFAULT '0' COMMENT '评论目标用户',
  `parent_id` int(10) UNSIGNED DEFAULT '0' COMMENT '父类id',
  `content` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `create_time` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_mentionuser`
--

CREATE TABLE `article_mentionuser` (
  `id` bigint(20) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `create_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '反馈用户',
  `content` text CHARACTER SET utf8mb4 COMMENT '反馈内容',
  `feedback_type_id` int(10) UNSIGNED NOT NULL COMMENT '反馈类型的id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-待审1-已处理',
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户反馈表';

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `content`, `feedback_type_id`, `status`, `create_time`, `update_time`) VALUES
(1, 2, '成锋蛇皮', 1, 0, 1544011712, 1544011712);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_type`
--

CREATE TABLE `feedback_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_name` varchar(30) NOT NULL COMMENT '反馈类型名',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1-删除0-未启用1-启用',
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback_type`
--

INSERT INTO `feedback_type` (`id`, `type_name`, `status`, `create_time`, `update_time`) VALUES
(1, '软件BUG', 1, 1540731603, 1540732377),
(2, '功能改进', 0, 1540732460, 1540732460);

-- --------------------------------------------------------

--
-- Table structure for table `reply_img`
--

CREATE TABLE `reply_img` (
  `id` bigint(64) NOT NULL,
  `reply_id` bigint(64) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `id` bigint(64) NOT NULL,
  `user_id` bigint(64) DEFAULT NULL,
  `theme_name` varchar(50) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `theme_introduction` varchar(200) DEFAULT NULL,
  `is_position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `listorder` int(8) DEFAULT NULL,
  `attention` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '关注数',
  `source_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '来源',
  `status` tinyint(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `user_id`, `theme_name`, `img`, `theme_introduction`, `is_position`, `listorder`, `attention`, `source_type`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 'BBQ开发交流', '20180509\\dc425e3b159797af24bf97a6a247cb51.jpg', '本主题专注于对BBQ的建议提供，欢迎和BBQ开发人员交流', 0, NULL, 1, 0, 1, 1525836440, 1525836440),
(2, 1, 'Test', '20180510\\6593fae5a61a7c96eb6283fb7ffdf167.jpg', '本主题专门用来进行BBQ测试', 1, NULL, 0, 0, -1, 1525941950, 1534817841),
(13, 3, 'test3', '20180713\\503a6560989c81c0996b89b08c9be559.PNG', '123', 0, NULL, 0, 0, -1, 1531448601, 1531562555);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(64) NOT NULL,
  `nickname` varchar(30) NOT NULL DEFAULT '',
  `password` char(32) DEFAULT NULL,
  `sno` varchar(20) DEFAULT NULL,
  `phone` varchar(11) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT NULL,
  `realname` varchar(32) DEFAULT NULL,
  `sex` tinyint(1) UNSIGNED DEFAULT '2' COMMENT '0男1女2未知',
  `home_img` varchar(255) DEFAULT NULL,
  `signature` varchar(200) DEFAULT NULL COMMENT '个性签名',
  `college` varchar(32) DEFAULT NULL,
  `token` varchar(100) NOT NULL,
  `time_out` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'token失效时间',
  `is_position` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(10) UNSIGNED DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_login_time` int(11) DEFAULT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0-普通用户1-机构号2-token官方号',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0待审1正常-1删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nickname`, `password`, `sno`, `phone`, `avatar`, `realname`, `sex`, `home_img`, `signature`, `college`, `token`, `time_out`, `is_position`, `create_time`, `update_time`, `last_login_time`, `type`, `status`) VALUES
(2, 'BBQ首席烧烤师', NULL, NULL, '17396177273', NULL, NULL, 2, NULL, '123', NULL, '2e7696f8e0426fc5d901f7557b67862a6addf298', 1558403830, 0, 1542851830, 1543910660, 1542851830, 0, 1),
(3, '小Q15717515314', NULL, NULL, '15717515314', NULL, NULL, 2, NULL, NULL, NULL, '0fcff34ffc1edf911a59d93d9d6a56f9472b1685', 1559097471, 0, 1543545471, 1543545471, 1543545471, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_advice`
--

CREATE TABLE `user_advice` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT '通知来源',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_articles`
--

CREATE TABLE `user_articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `article_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户点赞表';

--
-- Dumping data for table `user_articles`
--

INSERT INTO `user_articles` (`id`, `user_id`, `article_id`, `create_time`) VALUES
(1, 2, 1, 1544232480),
(2, 2, 2, 1544232536),
(3, 2, 3, 1544232539);

-- --------------------------------------------------------

--
-- Table structure for table `user_attention_theme`
--

CREATE TABLE `user_attention_theme` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `theme_id` int(10) UNSIGNED DEFAULT NULL,
  `create_time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_attention_theme`
--

INSERT INTO `user_attention_theme` (`id`, `user_id`, `theme_id`, `create_time`) VALUES
(1, 2, 1, 1543718741);

-- --------------------------------------------------------

--
-- Table structure for table `user_attention_user`
--

CREATE TABLE `user_attention_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `attention_user_id` int(10) UNSIGNED DEFAULT NULL COMMENT '关注用户id',
  `be_attention_user_id` int(10) UNSIGNED DEFAULT NULL COMMENT '被关注用户id',
  `create_time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_attention_user`
--

INSERT INTO `user_attention_user` (`id`, `attention_user_id`, `be_attention_user_id`, `create_time`) VALUES
(2, 2, 3, 1543547633);

-- --------------------------------------------------------

--
-- Table structure for table `user_collection`
--

CREATE TABLE `user_collection` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `article_id` int(10) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_forward_article`
--

CREATE TABLE `user_forward_article` (
  `id` bigint(64) NOT NULL,
  `article_id` bigint(64) DEFAULT NULL,
  `user_id` bigint(64) DEFAULT NULL,
  `content` text,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE `version` (
  `id` int(10) UNSIGNED NOT NULL,
  `creator_id` int(10) UNSIGNED NOT NULL COMMENT '创建者id',
  `app_type` varchar(20) DEFAULT NULL COMMENT 'app类型 ios Android',
  `version` int(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '内部版本号',
  `version_code` varchar(20) DEFAULT NULL COMMENT '外部版本号 如1.2.2',
  `is_force` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否强制更新 0否1是',
  `apk_url` varchar(255) DEFAULT NULL COMMENT 'apk的地址',
  `upgrade_point` varchar(500) DEFAULT NULL COMMENT '升级提示',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='版本表';

--
-- Dumping data for table `version`
--

INSERT INTO `version` (`id`, `creator_id`, `app_type`, `version`, `version_code`, `is_force`, `apk_url`, `upgrade_point`, `status`, `create_time`, `update_time`) VALUES
(1, 0, 'android', 2, '1.2', 0, 'xxx.com/1/3.html', '1、优化了网络数据\r\n2、增加了新闻内容', 1, 0, 1534817595),
(2, 3, 'iOS', 2, '1.2.3', 0, 'www.baidu.com', '123', 0, 1534839374, 1534839374),
(3, 3, 'iOS', 2, '1.2.4', 0, 'www.baidu.com2', '345', 0, 1534839473, 1534903118),
(4, 3, 'iOS', 2, '1.2.4', 1, 'www.baidu.com', '345', -1, 1534902994, 1534903076),
(5, 3, 'iOS', 2, '1.2.4', 1, 'www.baidu.com', '345', -1, 1534903081, 1534903104),
(6, 3, 'Android', 1, '1.2.15', 0, 'www.baidu.com', '123123', 0, 1538834184, 1538834184);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesstoken_log`
--
ALTER TABLE `accesstoken_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `username` (`username`),
  ADD KEY `create_time` (`create_time`);

--
-- Indexes for table `app_active`
--
ALTER TABLE `app_active`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `theme_id` (`theme_id`);

--
-- Indexes for table `article_comment`
--
ALTER TABLE `article_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `mentioned_user_id` (`to_user_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `article_id_2` (`article_id`);

--
-- Indexes for table `article_mentionuser`
--
ALTER TABLE `article_mentionuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_type`
--
ALTER TABLE `feedback_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reply_img`
--
ALTER TABLE `reply_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reply_id` (`reply_id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `theme_name_2` (`theme_name`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `theme_name` (`theme_name`),
  ADD KEY `create_time` (`create_time`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `cardno` (`sno`) USING BTREE,
  ADD KEY `phone` (`phone`),
  ADD KEY `phone_2` (`phone`);

--
-- Indexes for table `user_advice`
--
ALTER TABLE `user_advice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_articles`
--
ALTER TABLE `user_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_attention_theme`
--
ALTER TABLE `user_attention_theme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `theme_id` (`theme_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `theme_id_2` (`theme_id`);

--
-- Indexes for table `user_attention_user`
--
ALTER TABLE `user_attention_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attention_user_id` (`attention_user_id`),
  ADD KEY `followed_user_id` (`be_attention_user_id`);

--
-- Indexes for table `user_collection`
--
ALTER TABLE `user_collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `user_forward_article`
--
ALTER TABLE `user_forward_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesstoken_log`
--
ALTER TABLE `accesstoken_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `app_active`
--
ALTER TABLE `app_active`
  MODIFY `id` bigint(64) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `article_comment`
--
ALTER TABLE `article_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_mentionuser`
--
ALTER TABLE `article_mentionuser`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback_type`
--
ALTER TABLE `feedback_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reply_img`
--
ALTER TABLE `reply_img`
  MODIFY `id` bigint(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` bigint(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_advice`
--
ALTER TABLE `user_advice`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_articles`
--
ALTER TABLE `user_articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_attention_theme`
--
ALTER TABLE `user_attention_theme`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_attention_user`
--
ALTER TABLE `user_attention_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_collection`
--
ALTER TABLE `user_collection`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_forward_article`
--
ALTER TABLE `user_forward_article`
  MODIFY `id` bigint(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `version`
--
ALTER TABLE `version`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
