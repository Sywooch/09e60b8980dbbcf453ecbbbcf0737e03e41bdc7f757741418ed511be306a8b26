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

 Date: 06/07/2017 19:24:31 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `poster`
-- ----------------------------
DROP TABLE IF EXISTS `poster`;
CREATE TABLE `poster` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `image` text,
  `category_id` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `published` tinyint(4) DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `url_video` varchar(255) DEFAULT NULL,
  `url_descrition` varchar(255) DEFAULT NULL,
  `pin_main` int(11) DEFAULT '0',
  `pin_poster` int(11) DEFAULT '0',
  `pin_filter` int(11) DEFAULT '0',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `poster`
-- ----------------------------
BEGIN;
INSERT INTO `poster` VALUES ('1', 'asdadasd', '', '', '', '1', null, '', '1', '', '', null, '0', '0', '0', '2017-06-16 18:00:00', '2017-06-24 22:00:00', null, null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
