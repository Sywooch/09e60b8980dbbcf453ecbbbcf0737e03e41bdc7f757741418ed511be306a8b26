/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50635
 Source Host           : localhost
 Source Database       : goroda

 Target Server Type    : MySQL
 Target Server Version : 50635
 File Encoding         : utf-8

 Date: 06/08/2017 00:21:36 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` varchar(255) DEFAULT 'NONE',
  `server` varchar(255) DEFAULT 'NONE',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT 'Тип новости (акция, вакансия, новость, важная новость)',
  `category_id` int(11) NOT NULL DEFAULT '0',
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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `news`
-- ----------------------------
BEGIN;
INSERT INTO `news` VALUES ('14', 'NONE', 'NONE', '1', '0', '0', null, null, null, '2017-04-06 13:24:22', '1', '2017-04-10 16:47:42', null, null, null, null, null, null, null), ('15', 'NONE', 'NONE', '1', '3', '1', null, null, null, '2017-04-06 16:03:26', '1', '2017-06-08 00:18:47', null, null, null, '/uploads/15_1491557725.png', null, '', ''), ('18', 'NONE', 'NONE', '1', '0', '0', null, null, null, '2017-04-06 16:50:41', '1', '2017-04-10 16:47:51', null, null, null, null, null, 'zxczc', 'zxczxc'), ('28', 'NONE', 'NONE', '2', '0', '99', null, null, null, '2017-04-07 18:09:18', '1', '2017-05-17 14:34:09', null, null, null, '/uploads/28.jpg', null, 'asdasdasd', 'asdasd'), ('29', 'NONE', 'NONE', '1', '0', '99', null, null, null, '2017-04-07 19:55:05', '1', '2017-04-07 19:55:05', null, null, null, '/uploads/29.jpg', null, 'dsfdfsdf', 'sdfsdfsdf'), ('30', 'NONE', 'NONE', '2', '0', '1', null, null, null, '2017-05-01 09:43:07', '1', '2017-05-17 14:34:16', null, null, null, null, null, '', '');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
