/*
 Navicat Premium Data Transfer

 Source Server         : Golden openserver Home
 Source Server Type    : MySQL
 Source Server Version : 50545
 Source Host           : 94.230.207.21
 Source Database       : goroda

 Target Server Type    : MySQL
 Target Server Version : 50545
 File Encoding         : utf-8

 Date: 04/30/2017 12:02:26 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `account_email` varchar(128) NOT NULL,
  `admin_name` varchar(128) NOT NULL,
  `admin_type` varchar(128) NOT NULL,
  `profile` int(11) DEFAULT '1',
  `status` int(11) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `projects` text,
  `servers` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `admins`
-- ----------------------------
BEGIN;
INSERT INTO `admins` VALUES ('1', 'admin', 'a91e1ff851a8788f365a8accc3892c61b3942293a6a50df7f0731a8c75fecd552771d6758760e50d0388a1915083e85560c2e010a9ba3465996658ee5676f538', '82552506055721492256900.05110639', 'John', 'Doe', 'slims@ukr.net', '', '', '1', '1', null, null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('3', 'Demo', '24e1e415bb78b136d643f0070dc65ce0cc837dff062d3d14f8ed51892c7539d4d4656fad6fb496c92d77d5d178769d274e464f862354a5a3fd096aacc23bcca1', 'MQOxI-feN60kn74qbCcrvaQjNv7zMKX5.1491551969', '', '', 'slims35@yandex.ru', '', '', '1', '0', null, null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('4', 'Demo', '7dd3507beff4e098edc6d1a3d32ac0b7f7ec69b1257bedfe982d850d6d51567da1b0e03b3b7fa1f11aef3a4291d791087262ee478d38a1590ccc1b0455edd21b', 'GT5Y0V4aIdk6LgaZqlAimZMhuF8mVb0F.1491554479', '', '', 'slims35@yandex.ru', '', '', '1', '1', null, null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `author` text NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `comments`
-- ----------------------------
BEGIN;
INSERT INTO `comments` VALUES ('1', '29', 'Андрей', 'фывфывфывфывфывфывыфвфыв', '0', '2017-04-10 12:50:15', '0000-00-00 00:00:00'), ('2', '29', 'Коля', 'вфывплкопоелроетлтетрлоер', '1', '2017-04-10 12:50:31', '0000-00-00 00:00:00'), ('4', '14', 'Никита', 'фывфвфлдывфылвофылводлфыв', '2', '2017-04-04 12:51:26', '0000-00-00 00:00:00'), ('5', '14', 'Дима', 'фывфывфыв', '1', '2017-04-05 13:06:50', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `help`
-- ----------------------------
DROP TABLE IF EXISTS `help`;
CREATE TABLE `help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `text` longtext NOT NULL,
  `link` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `help`
-- ----------------------------
BEGIN;
INSERT INTO `help` VALUES ('1', 'asdadadadasdasd', 'asdasdasdasdasdasdasdasd<br />\r\nasd<br />\r\nas<br />\r\nda<br />\r\nsd<br />\r\nas<br />\r\nd<br />\r\nas<br />\r\ndasd', 'http://aeszxa.axshare.com/#g=1&p=помощь');
COMMIT;

-- ----------------------------
--  Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` varchar(255) DEFAULT 'NONE',
  `server` varchar(255) DEFAULT 'NONE',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT 'Тип новости (акция, вакансия, новость, важная новость)',
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_author` varchar(32) NOT NULL COMMENT 'ID автора',
  `updated_at` datetime DEFAULT NULL,
  `published_date` datetime DEFAULT NULL,
  `updated_author` varchar(32) DEFAULT NULL,
  `comments` int(11) DEFAULT NULL,
  `pic_url` varchar(255) DEFAULT NULL,
  `pic_loc` varchar(255) DEFAULT NULL,
  `video_url` text,
  `source_url` text,
  PRIMARY KEY (`id`),
  KEY `ix_id` (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `news`
-- ----------------------------
BEGIN;
INSERT INTO `news` VALUES ('14', 'NONE', 'NONE', '1', '0', null, null, null, '2017-04-06 13:24:22', '1', '2017-04-10 16:47:42', null, null, null, null, null, null, null), ('15', 'NONE', 'NONE', '1', '1', null, null, null, '2017-04-06 16:03:26', '1', '2017-04-10 16:47:07', null, null, null, '/uploads/15_1491557725.png', null, null, null), ('18', 'NONE', 'NONE', '1', '0', null, null, null, '2017-04-06 16:50:41', '1', '2017-04-10 16:47:51', null, null, null, null, null, 'zxczc', 'zxczxc'), ('28', 'NONE', 'NONE', '2', '1', null, null, null, '2017-04-07 18:09:18', '1', '2017-04-10 16:46:43', null, null, null, '/uploads/28.jpg', null, 'asdasdasd', 'asdasd'), ('29', 'NONE', 'NONE', '1', '99', null, null, null, '2017-04-07 19:55:05', '1', '2017-04-07 19:55:05', null, null, null, '/uploads/29.jpg', null, 'dsfdfsdf', 'sdfsdfsdf');
COMMIT;

-- ----------------------------
--  Table structure for `news_data`
-- ----------------------------
DROP TABLE IF EXISTS `news_data`;
CREATE TABLE `news_data` (
  `nid` int(11) NOT NULL,
  `language` varchar(32) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `description` text,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nid`,`language`),
  KEY `nid` (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `news_data`
-- ----------------------------
BEGIN;
INSERT INTO `news_data` VALUES ('14', 'ru', 'фыфывыфвыв21312312313', 'фывыфвфывфыв', null, '', '', ''), ('15', 'ru', 'ФЫвфывфывфывыфвфыв', 'ывфывфывфывфывфывфыв', null, null, null, null), ('18', 'ru', 'zxczczxcz', 'xczxczxczxcxzczxc', null, null, null, null), ('28', 'ru', 'sdasdasd', 'adasdasdasdasd', null, null, null, null), ('29', 'ru', 'sdfsdfsdf', 'sdfsdfdsfsdfsdfsdfdsfdsfdfdsfsdfdfdf', null, null, null, null);
COMMIT;

-- ----------------------------
--  Table structure for `news_image`
-- ----------------------------
DROP TABLE IF EXISTS `news_image`;
CREATE TABLE `news_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `organizations`
-- ----------------------------
DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `category` int(11) NOT NULL,
  `image` text,
  `site` text,
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `organizations_address`
-- ----------------------------
DROP TABLE IF EXISTS `organizations_address`;
CREATE TABLE `organizations_address` (
  `organization_id` int(11) NOT NULL,
  `address` text,
  `working_days` varchar(255) DEFAULT NULL,
  `weekend` varchar(255) DEFAULT NULL,
  `working hours
working hours
working hours
working_hours` varchar(255) DEFAULT NULL,
  `lunch_time` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `organizations_image`
-- ----------------------------
DROP TABLE IF EXISTS `organizations_image`;
CREATE TABLE `organizations_image` (
  `organization_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `organizations_telephones`
-- ----------------------------
DROP TABLE IF EXISTS `organizations_telephones`;
CREATE TABLE `organizations_telephones` (
  `organization_id` int(11) NOT NULL,
  `number` varchar(255) NOT NULL,
  PRIMARY KEY (`organization_id`,`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `poster`
-- ----------------------------
DROP TABLE IF EXISTS `poster`;
CREATE TABLE `poster` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url_video` varchar(255) DEFAULT NULL,
  `url_descrition` varchar(255) DEFAULT NULL,
  `pin_main` int(11) DEFAULT NULL,
  `pin_poster` int(11) DEFAULT NULL,
  `pin_filter` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `settings`
-- ----------------------------
BEGIN;
INSERT INTO `settings` VALUES ('1', 'receiving_email', 'slims35@yandex.ru');
COMMIT;

-- ----------------------------
--  Table structure for `shares`
-- ----------------------------
DROP TABLE IF EXISTS `shares`;
CREATE TABLE `shares` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url_video` varchar(255) DEFAULT NULL,
  `url_descrition` varchar(255) DEFAULT NULL,
  `pin_main` int(11) DEFAULT NULL,
  `pin_poster` int(11) DEFAULT NULL,
  `pin_filter` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_name` varchar(64) NOT NULL DEFAULT '' COMMENT 'Имя',
  `email` varchar(255) DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '' COMMENT 'Телефон',
  `password_hash` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL COMMENT 'Шифратор паролей',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `activate` int(11) NOT NULL COMMENT '0 - Не активирован, 1 - Активирован',
  `status` int(11) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `profile` text NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `auth_id` varchar(255) NOT NULL,
  `auth_service` varchar(32) NOT NULL DEFAULT 'default',
  `auth_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'name2', 'demo@exp.com', '1255125', '$2y$13$x0o1Q/PLqrxQvb8ugOC/2OE/iJoGVjtFR8egr5xyRUuc8NXywItiu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '1', 'QWrfov5oE36d-mDzCyzcEhUIEXOmT6yw', '', null, '', 'default', ''), ('2', 'qwe', 'pobuta12@gmail.com', '096891454', '$2y$13$HKukNITfR/wNiYSKsa53U.U1j.SyGmQBKwPphTK4S9Lab/x8VnfHm', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '1', '0iCJ3gEm94w8eBETr8A4JGTzu87s0Ovo', '', 'U_Qu359aai5l1nvTye0dcmzDUWN91IQ3_1465210909', '', 'default', ''), ('7', 'Владислав Игоревич', 'admin@admin.ru', '23424', '', '', '0000-00-00 00:00:00', '2017-04-07 16:02:45', '0', '1', 'pRLNFp4o3ynEVgAXgrl6KV2iwSnJBTzx', '', null, '114351844964793229357', 'google_oauth', 'https://plus.google.com/114351844964793229357');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
