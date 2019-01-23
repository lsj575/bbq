-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `bbq`;
CREATE DATABASE `bbq` /*!40100 DEFAULT CHARACTER SET utf32 */;
USE `bbq`;

DROP TABLE IF EXISTS `accesstoken_log`;
CREATE TABLE `accesstoken_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `source` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '鏉ユ簮 0-鐢ㄦ埛1-绠＄悊鍛',
  `accesstoken` char(64) NOT NULL,
  `create_time` int(11) unsigned NOT NULL COMMENT '鍒涘缓鏃堕棿',
  `update_time` int(11) unsigned NOT NULL COMMENT '鏇存柊鏃堕棿',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `accesstoken_log` (`id`, `user_id`, `source`, `accesstoken`, `create_time`, `update_time`) VALUES
(1,	3,	0,	'663df16a9b60e26f4c51dd059e577955',	1538832913,	1538832913),
(2,	3,	0,	'c56fb107f48a51c4e3a072c43b41d14c',	1538832930,	1538832930),
(3,	3,	0,	'c1adf1d866aec2fd93124425a4cf8a6f',	1538833014,	1538833014),
(4,	3,	0,	'a8a53b8c8b5c45f0e4e1233c65090797',	1538833051,	1538833051),
(5,	3,	0,	'e09014ca16e9fafb1ff0ab2a16a5fbf1',	1538833068,	1538833068),
(6,	3,	0,	'e9333b82f5f02bedd582f5e8974b7a99',	1538833092,	1538833092),
(7,	3,	0,	'd4a173f973b0d6a6673734ccb33d03fc',	1538833101,	1538833101),
(8,	3,	0,	'f690caa768b27b31ccc56fbba67ce6ae',	1538833120,	1538833120),
(9,	3,	0,	'0708f53b44d8e6944259087b911c7f9a',	1538833130,	1538833130),
(10,	3,	0,	'deb4f4e1d0c02103d2c1250fe0b826bb',	1538833167,	1538833167),
(11,	3,	0,	'c488a700e760c77dce9323382ff9720a',	1538833361,	1538833361),
(12,	3,	0,	'0b57bf0a6f8072320bf8e13521ddf7f9',	1538833403,	1538833403),
(13,	3,	0,	'923e5250118d39e893d2227418297a78',	1538833435,	1538833435),
(14,	3,	0,	'6dccde4a4f1ad072e105dd59874dd97a',	1538833469,	1538833469),
(15,	3,	0,	'089adde7ed96a37eb734e6393f285ca1',	1538833754,	1538833754),
(16,	3,	0,	'e185343085a2df81e8138f2eb8f9d2ab',	1538833765,	1538833765),
(17,	3,	0,	'1604f7020ef2791e2fa5d36d8b0c6eb3',	1538833778,	1538833778),
(18,	3,	0,	'4c7d9081b9211fb96951bde71b40e976',	1538833793,	1538833793),
(19,	3,	0,	'39432509d0232e14f8867e4bcd393ba9',	1538833897,	1538833897),
(20,	3,	0,	'f8c3771948c4c88d0b48940f3fe1e4c8',	1538833928,	1538833928),
(21,	3,	0,	'52dc1cb9f3f682e0146736bf885f8560',	1538833930,	1538833930),
(22,	3,	0,	'87b38f0888d03208e01352dafcc14ace',	1538833932,	1538833932),
(23,	3,	0,	'064e9a5431987f9a2abc456c493b19b6',	1538833932,	1538833932),
(24,	3,	0,	'709e874e95e18f8b29379e376f088fb0',	1538833950,	1538833950),
(25,	3,	0,	'687798364b23027b606106e3027ff18a',	1538833957,	1538833957),
(26,	3,	0,	'9369ccce88567e33343b74977104df10',	1538834001,	1538834001),
(27,	3,	0,	'5caeedfeecaa76cf098cfae60aa39b48',	1538834037,	1538834037),
(28,	3,	0,	'0bd42e8f1258a2b3eb5a544e8542e40e',	1538834056,	1538834056),
(29,	3,	0,	'21baa44c702379f26cbe243183d7ffb5',	1538834218,	1538834218),
(30,	3,	0,	'03635d0d270e57ad2146caf5c7915b67',	1538834652,	1538834652),
(31,	3,	0,	'9da5f17d707af0611d197889dd018765',	1538834690,	1538834690),
(32,	3,	0,	'fb02ef923bcb2159645d3e3d5dcbecfb',	1538834691,	1538834691),
(33,	3,	0,	'12d05fff1d16c4934743ded611cb3f06',	1538834691,	1538834691),
(34,	3,	0,	'b1410ac559f1504fd4503cfc608e853a',	1538834691,	1538834691),
(35,	3,	0,	'd6e0d2fd0ef38ba3ef65ca1cb027e749',	1538834692,	1538834692),
(36,	3,	0,	'989bc64dc92b1e078f9e801f762b33cf',	1538834692,	1538834692),
(37,	3,	0,	'44d2f340f08b9e22f5f8e0a587c3f632',	1538834693,	1538834693),
(38,	3,	0,	'bfde3c89cb2edc7bd043d0f098317abd',	1538834693,	1538834693),
(39,	3,	0,	'31e4b3000df5f5cf3aec87d983728466',	1538834694,	1538834694),
(40,	3,	0,	'455d985e7e2d2768a4940933c79c7998',	1538834895,	1538834895),
(41,	3,	0,	'd2e955917c6a945c5fd9d2cf2fc31fa0',	1538834896,	1538834896),
(42,	3,	0,	'f5b3cfb7a9fac2b2a1b607e7e839f022',	1538834897,	1538834897),
(43,	3,	0,	'0836f759d105e40c1ff1d9bdf677f265',	1538834897,	1538834897),
(44,	3,	0,	'e1c26326c337f37954faa79b89e75d8e',	1538834898,	1538834898),
(45,	3,	0,	'30470bb4fdba2f8c26204355770f15ee',	1538834899,	1538834899),
(46,	3,	0,	'5b7fa07e4c553b900982a95a1837720e',	1538834899,	1538834899),
(47,	3,	0,	'0322bfd8526d309cb361aa6efc5fca29',	1538834900,	1538834900),
(48,	3,	0,	'6f8d706996a13591f0babc423b9dda6a',	1538834901,	1538834901),
(49,	3,	0,	'07bcab1e5452fda5e4186df4d896af91',	1538834901,	1538834901),
(50,	3,	0,	'4a9d8c1cd3ed0c8fb170b8ba947d60ea',	1538834983,	1538834983),
(51,	3,	0,	'0999789cc5e8d0478e77ebdfcc94d548',	1538834986,	1538834986),
(52,	3,	0,	'2267784c88b90ac21c1d5759986f0892',	1538834987,	1538834987),
(53,	3,	0,	'abd03a223c1a42108f8975e3f471b431',	1538834988,	1538834988),
(54,	3,	0,	'3e92cd0a481684058cce3c5b412e0528',	1538834989,	1538834989),
(55,	3,	0,	'273fc5699dc0cbf0bf79592a1185df7d',	1538834990,	1538834990),
(56,	3,	0,	'a714fd50b9d122aa732c0e6f40ffcdc3',	1538834990,	1538834990),
(57,	3,	0,	'1975124e054343e818a7217ec88a712f',	1538834991,	1538834991),
(58,	3,	0,	'c6670c6e7289726fddae285f148ccc7d',	1538834992,	1538834992),
(59,	3,	0,	'af96197271bea856ae43cd98837d0f0b',	1538834992,	1538834992),
(60,	3,	0,	'04f3adff84625877d8a9ae09401da9e6',	1538835103,	1538835103),
(61,	3,	0,	'760a9645b26f2df00c059dbcee825f7a',	1538835103,	1538835103),
(62,	3,	0,	'a2138c0c88167d957d46b29fd01faf67',	1538835104,	1538835104),
(63,	3,	0,	'd9e2a2fdf712e979f20f7b0a43d66ad2',	1538835104,	1538835104),
(64,	3,	0,	'f30dddfc518a49010e6655fcbfa1bc84',	1538835105,	1538835105),
(65,	3,	0,	'04056d0115d57ea77311dc3f7404ede7',	1538835105,	1538835105),
(66,	3,	0,	'bfaa3ea7db0f398a8d2af863b5ec4b53',	1538835106,	1538835106),
(67,	3,	0,	'cf6218f88d597844fc9f45dd87d99c92',	1538835107,	1538835107),
(68,	3,	0,	'fdb4141ed4db16c2f2f6b11d52d0c6cf',	1538835108,	1538835108),
(69,	3,	0,	'6eeff2956d3b4d57ea0f7fba5a843f52',	1538835108,	1538835108),
(70,	3,	0,	'f3d623e13b223d7ef6242259764cac44',	1538835374,	1538835374),
(71,	3,	0,	'4404016a0fb20904cd28a65e6ee305ee',	1538921169,	1538921169),
(72,	2,	0,	'62498b6b462d6ebc4f912e548ebd69c8',	1543805752,	1543805752),
(73,	2,	0,	'5772f1c023daefcb7848f39874c72b4a',	1543805792,	1543805792),
(74,	2,	0,	'feb6369c55b70723a61bdc2169829678',	1543846080,	1543846080),
(75,	2,	0,	'88f20a4ee93c097b13d8824328b68456',	1543846221,	1543846221),
(76,	2,	0,	'8597757fdb740c240eb0db0fe8ed5fd9',	1547974692,	1547974692),
(77,	2,	0,	'45667a09868bc2322e6577377a8f43fd',	1547974711,	1547974711),
(78,	2,	0,	'5cfdd8b77f0698b9cbded9379396f6af',	1547974877,	1547974877),
(79,	2,	0,	'3fb3924b9d8662e35f84c90d43b3b2a8',	1547974884,	1547974884),
(80,	2,	0,	'82b2f829a7358e2b4012bfed445e988f',	1547974912,	1547974912),
(81,	2,	0,	'89f8fd9f7440ee7c5839f5eb4ac6bcbf',	1548244479,	1548244479),
(82,	2,	0,	'302a72f27169d0b5200b3d4bce2ba0da',	1548244483,	1548244483),
(83,	2,	0,	'2f463deec7ad6de1a88fe141a6b8151d',	1548244814,	1548244814),
(84,	2,	0,	'484817abe239b5179b17ee16fe24bc5c',	1548244829,	1548244829),
(85,	2,	0,	'8722a610ce27448f6f2d17c33f391f2f',	1548244830,	1548244830),
(86,	2,	0,	'985c8c08cfc3139980a26bc5827e8b51',	1548244837,	1548244837),
(87,	2,	0,	'ff553b064afecf6008322a60143d9d3c',	1548244860,	1548244860),
(88,	2,	0,	'4f7000383a29b16e0266375866cea074',	1548244862,	1548244862),
(89,	2,	0,	'0b68b34237118f66dff1a0ca6a48c076',	1548245006,	1548245006),
(90,	2,	0,	'e4af5b1f763af29b84a6aaf94c611fb9',	1548245066,	1548245066),
(91,	2,	0,	'3f3515c26cec13fe0dbe145438bd0d31',	1548245277,	1548245277),
(92,	2,	0,	'1aaf3e484a4ef36aab9c21e9d54ff8ed',	1548245376,	1548245376);

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL COMMENT '鐢ㄦ埛鍚',
  `password` char(32) DEFAULT NULL COMMENT '瀵嗙爜',
  `last_login_ip` varchar(30) DEFAULT NULL,
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` int(8) unsigned DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_2` (`username`),
  KEY `username` (`username`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin_user` (`id`, `username`, `password`, `last_login_ip`, `last_login_time`, `listorder`, `status`, `create_time`, `update_time`) VALUES
(1,	'lsj575',	'c9d8fd152b782446b5c2da0896bea713',	NULL,	0,	0,	1,	0,	0),
(2,	'admin',	'b90167b6bf42bb9b749f7b7e4227491d',	'0.0.0.0',	1547802998,	0,	1,	1530271838,	1547802998),
(4,	'zcf',	'1695eb1808c7dbad715605b7af54f42d',	NULL,	0,	0,	1,	1531316571,	1531316571),
(6,	'lxh001',	'def78593dde7cf19a65acb3abe5cfb1b',	'127.0.0.1',	1547977299,	0,	1,	1547803023,	1547977299);

DROP TABLE IF EXISTS `app_active`;
CREATE TABLE `app_active` (
  `id` bigint(64) unsigned NOT NULL AUTO_INCREMENT,
  `version` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '鐗堟湰鍙',
  `app_type` varchar(20) DEFAULT NULL COMMENT 'app绫诲瀷',
  `version_code` varchar(10) DEFAULT NULL,
  `did` varchar(100) DEFAULT NULL COMMENT '璁惧?鍙',
  `model` varchar(20) DEFAULT NULL COMMENT '鏈哄瀷',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='璁板綍鐢ㄦ埛鐧诲綍鏁版嵁琛';


DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `theme_id` int(10) unsigned NOT NULL,
  `content` text,
  `img` text COMMENT '瀛樻斁鍥剧墖锛屽?鍥剧敤,鍙峰垎鍓',
  `allow_watermark` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '鏄?惁娣诲姞姘村嵃0-鍚?-鏄',
  `read_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '闃呰?鏁',
  `comments` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '璇勮?鏁',
  `likes` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '鐐硅禐鏁伴噺',
  `is_position` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '绫诲瀷锛屽師鍒涙垨杞?彂绛',
  `allow_comment` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '鏄?惁鍏佽?璇勮?1-鍏佽?0-涓嶅厑璁',
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `theme_id` (`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `article` (`id`, `user_id`, `theme_id`, `content`, `img`, `allow_watermark`, `read_count`, `comments`, `likes`, `is_position`, `create_time`, `update_time`, `type`, `allow_comment`, `status`) VALUES
(1,	2,	1,	'鏇存柊鍔ㄦ?娴嬭瘯',	'',	1,	0,	0,	1,	0,	1543062598,	1543670073,	0,	1,	1),
(2,	2,	1,	'bbq鍙戝竷鍔ㄦ?娴嬭瘯1',	'',	0,	0,	0,	1,	1,	1543458104,	1543458104,	0,	0,	1),
(3,	3,	1,	'bbq鍙戝竷鍔ㄦ?娴嬭瘯2',	'',	0,	0,	0,	1,	0,	1543458109,	1543458109,	0,	0,	1);

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `article_comment`;
CREATE TABLE `article_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT '0',
  `article_id` int(10) unsigned DEFAULT '0',
  `to_user_id` int(10) unsigned DEFAULT '0' COMMENT '璇勮?鐩?爣鐢ㄦ埛',
  `parent_id` int(10) unsigned DEFAULT '0' COMMENT '鐖剁被id',
  `content` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `create_time` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`),
  KEY `mentioned_user_id` (`to_user_id`),
  KEY `user_id_2` (`user_id`),
  KEY `article_id_2` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `article_mentionuser`;
CREATE TABLE `article_mentionuser` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `article_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) NOT NULL COMMENT '鍙嶉?鐢ㄦ埛',
  `content` text CHARACTER SET utf8mb4 COMMENT '鍙嶉?鍐呭?',
  `feedback_type_id` int(10) unsigned NOT NULL COMMENT '鍙嶉?绫诲瀷鐨刬d',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-寰呭?1-宸插?鐞',
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='鐢ㄦ埛鍙嶉?琛';

INSERT INTO `feedback` (`id`, `user_id`, `content`, `feedback_type_id`, `status`, `create_time`, `update_time`) VALUES
(1,	2,	'鎴愰攱铔囩毊',	1,	0,	1544011712,	1544011712);

DROP TABLE IF EXISTS `feedback_type`;
CREATE TABLE `feedback_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(30) NOT NULL COMMENT '鍙嶉?绫诲瀷鍚',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1-鍒犻櫎0-鏈?惎鐢?-鍚?敤',
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `feedback_type` (`id`, `type_name`, `status`, `create_time`, `update_time`) VALUES
(1,	'杞?欢BUG',	1,	1540731603,	1540732377),
(2,	'鍔熻兘鏀硅繘',	0,	1540732460,	1540732460);

DROP TABLE IF EXISTS `reply_img`;
CREATE TABLE `reply_img` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `reply_id` bigint(64) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reply_id` (`reply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `slide_img`;
CREATE TABLE `slide_img` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) DEFAULT NULL COMMENT '管理员id',
  `description` varchar(200) CHARACTER SET utf32 DEFAULT NULL,
  `img` varchar(200) CHARACTER SET utf32 DEFAULT NULL COMMENT '存放图片地址',
  `img_type` varchar(200) CHARACTER SET utf32 DEFAULT NULL COMMENT '0：主题   1：动态   2：用户',
  `status` tinyint(1) DEFAULT '1' COMMENT '1：未发布   -1：已发布',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `slide_img` (`id`, `user_id`, `description`, `img`, `img_type`, `status`, `create_time`) VALUES
(5,	2,	'qasdfasdf',	'e44378ac-0237-4331-aaf2-63b8818e5c34-300-80.jpg',	'1',	1,	1548051791),
(10,	2,	'aaaaaaaaaa1',	'6a0dec74-dc25-47a6-9326-ce1e93825b37',	'1',	1,	1548245379);

DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) DEFAULT NULL,
  `theme_name` varchar(50) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `theme_introduction` varchar(200) DEFAULT NULL,
  `is_position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '鏄?惁鎺ㄨ崘',
  `listorder` int(8) DEFAULT NULL,
  `attention` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '鍏虫敞鏁',
  `source_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '鏉ユ簮',
  `status` tinyint(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `theme_name_2` (`theme_name`),
  KEY `user_id` (`user_id`),
  KEY `theme_name` (`theme_name`),
  KEY `create_time` (`create_time`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `theme` (`id`, `user_id`, `theme_name`, `img`, `theme_introduction`, `is_position`, `listorder`, `attention`, `source_type`, `status`, `create_time`, `update_time`) VALUES
(1,	1,	'BBQ寮?彂浜ゆ祦',	'20180509\\dc425e3b159797af24bf97a6a247cb51.jpg',	'鏈?富棰樹笓娉ㄤ簬瀵笲BQ鐨勫缓璁?彁渚涳紝娆㈣繋鍜孊BQ寮?彂浜哄憳浜ゆ祦',	0,	NULL,	1,	0,	1,	1525836440,	1525836440),
(2,	1,	'Test',	'20180510\\6593fae5a61a7c96eb6283fb7ffdf167.jpg',	'鏈?富棰樹笓闂ㄧ敤鏉ヨ繘琛孊BQ娴嬭瘯',	1,	NULL,	0,	0,	-1,	1525941950,	1534817841),
(13,	3,	'test3',	'20180713\\503a6560989c81c0996b89b08c9be559.PNG',	'123',	0,	NULL,	0,	0,	-1,	1531448601,	1531562555),
(23,	2,	'klajsadsf',	'41aac534-9fc8-445e-8603-87b739619c6f',	'asdfsadfsadf',	1,	NULL,	0,	0,	1,	1547974916,	1547974916),
(26,	2,	'klajsadsf22',	'41aac534-9fc8-445e-8603-87b739619c6f',	'asdfsadfsadf',	1,	NULL,	0,	0,	1,	1547974984,	1547974984),
(27,	2,	'asdasdasdasdfasf',	'856c3e64-d10b-4ca0-8a10-ef26f0dc52f2',	'sdgdfgdsfgdsfg',	0,	NULL,	0,	0,	1,	1548245071,	1548245071);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(30) NOT NULL DEFAULT '',
  `password` char(32) DEFAULT NULL,
  `sno` varchar(20) DEFAULT NULL,
  `phone` varchar(11) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT NULL,
  `realname` varchar(32) DEFAULT NULL,
  `sex` tinyint(1) unsigned DEFAULT '2' COMMENT '0鐢?濂?鏈?煡',
  `home_img` varchar(255) DEFAULT NULL,
  `signature` varchar(200) DEFAULT NULL COMMENT '涓??绛惧悕',
  `college` varchar(32) DEFAULT NULL,
  `token` varchar(100) NOT NULL,
  `time_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'token澶辨晥鏃堕棿',
  `is_position` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login_time` int(11) DEFAULT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0-鏅??鐢ㄦ埛1-鏈烘瀯鍙?-token瀹樻柟鍙',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '鐘舵?0寰呭?1姝ｅ父-1鍒犻櫎',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname` (`nickname`),
  UNIQUE KEY `cardno` (`sno`) USING BTREE,
  KEY `phone` (`phone`),
  KEY `phone_2` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `nickname`, `password`, `sno`, `phone`, `avatar`, `realname`, `sex`, `home_img`, `signature`, `college`, `token`, `time_out`, `is_position`, `create_time`, `update_time`, `last_login_time`, `type`, `status`) VALUES
(2,	'BBQ棣栧腑鐑х儰甯',	NULL,	NULL,	'17396177273',	NULL,	NULL,	2,	NULL,	'123',	NULL,	'2e7696f8e0426fc5d901f7557b67862a6addf298',	1558403830,	0,	1542851830,	1543910660,	1542851830,	0,	1),
(3,	'灏廞15717515314',	NULL,	NULL,	'15717515314',	NULL,	NULL,	2,	NULL,	NULL,	NULL,	'0fcff34ffc1edf911a59d93d9d6a56f9472b1685',	1559097471,	0,	1543545471,	1543545471,	1543545471,	0,	1);

DROP TABLE IF EXISTS `user_advice`;
CREATE TABLE `user_advice` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT '閫氱煡鏉ユ簮',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user_articles`;
CREATE TABLE `user_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `article_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='鐢ㄦ埛鐐硅禐琛';

INSERT INTO `user_articles` (`id`, `user_id`, `article_id`, `create_time`) VALUES
(1,	2,	1,	1544232480),
(2,	2,	2,	1544232536),
(3,	2,	3,	1544232539);

DROP TABLE IF EXISTS `user_attention_theme`;
CREATE TABLE `user_attention_theme` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `theme_id` int(10) unsigned DEFAULT NULL,
  `create_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `theme_id` (`theme_id`),
  KEY `user_id_2` (`user_id`),
  KEY `theme_id_2` (`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_attention_theme` (`id`, `user_id`, `theme_id`, `create_time`) VALUES
(1,	2,	1,	1543718741);

DROP TABLE IF EXISTS `user_attention_user`;
CREATE TABLE `user_attention_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attention_user_id` int(10) unsigned DEFAULT NULL COMMENT '鍏虫敞鐢ㄦ埛id',
  `be_attention_user_id` int(10) unsigned DEFAULT NULL COMMENT '琚?叧娉ㄧ敤鎴穒d',
  `create_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attention_user_id` (`attention_user_id`),
  KEY `followed_user_id` (`be_attention_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_attention_user` (`id`, `attention_user_id`, `be_attention_user_id`, `create_time`) VALUES
(2,	2,	3,	1543547633);

DROP TABLE IF EXISTS `user_collection`;
CREATE TABLE `user_collection` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `article_id` int(10) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user_forward_article`;
CREATE TABLE `user_forward_article` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `article_id` bigint(64) DEFAULT NULL,
  `user_id` bigint(64) DEFAULT NULL,
  `content` text,
  `status` smallint(6) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `version`;
CREATE TABLE `version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creator_id` int(10) unsigned NOT NULL COMMENT '鍒涘缓鑰卛d',
  `app_type` varchar(20) DEFAULT NULL COMMENT 'app绫诲瀷 ios Android',
  `version` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '鍐呴儴鐗堟湰鍙',
  `version_code` varchar(20) DEFAULT NULL COMMENT '澶栭儴鐗堟湰鍙?濡?.2.2',
  `is_force` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '鏄?惁寮哄埗鏇存柊 0鍚?鏄',
  `apk_url` varchar(255) DEFAULT NULL COMMENT 'apk鐨勫湴鍧',
  `upgrade_point` varchar(500) DEFAULT NULL COMMENT '鍗囩骇鎻愮ず',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '鐘舵?',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '鍒涘缓鏃堕棿',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '鏇存柊鏃堕棿',
  PRIMARY KEY (`id`),
  KEY `creator_id` (`creator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='鐗堟湰琛';

INSERT INTO `version` (`id`, `creator_id`, `app_type`, `version`, `version_code`, `is_force`, `apk_url`, `upgrade_point`, `status`, `create_time`, `update_time`) VALUES
(1,	0,	'android',	2,	'1.2',	0,	'xxx.com/1/3.html',	'1銆佷紭鍖栦簡缃戠粶鏁版嵁\r\n2銆佸?鍔犱簡鏂伴椈鍐呭?',	1,	0,	1534817595),
(2,	3,	'iOS',	2,	'1.2.3',	0,	'www.baidu.com',	'123',	0,	1534839374,	1534839374),
(3,	3,	'iOS',	2,	'1.2.4',	0,	'www.baidu.com2',	'345',	0,	1534839473,	1534903118),
(4,	3,	'iOS',	2,	'1.2.4',	1,	'www.baidu.com',	'345',	-1,	1534902994,	1534903076),
(5,	3,	'iOS',	2,	'1.2.4',	1,	'www.baidu.com',	'345',	-1,	1534903081,	1534903104),
(6,	3,	'Android',	1,	'1.2.15',	0,	'www.baidu.com',	'123123',	0,	1538834184,	1538834184);

-- 2019-01-23 12:26:45
