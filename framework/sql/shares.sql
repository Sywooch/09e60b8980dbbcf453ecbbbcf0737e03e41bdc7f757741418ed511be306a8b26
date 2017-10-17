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

 Date: 06/07/2017 19:24:42 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `shares`
-- ----------------------------
DROP TABLE IF EXISTS `shares`;
CREATE TABLE `shares` (
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
  `pin_main` int(11) DEFAULT NULL,
  `pin_poster` int(11) DEFAULT NULL,
  `pin_filter` int(11) DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `shares`
-- ----------------------------
BEGIN;
INSERT INTO `shares` VALUES ('4', 'ыфвфвфв2', '', '', '', '1', null, '', '1', '', '', '', '0', '0', '0', null, null, null, null), ('5', 'asdasdasd', '', '', '', '1', null, '', '1', '', '', null, null, null, null, null, null, null, null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
