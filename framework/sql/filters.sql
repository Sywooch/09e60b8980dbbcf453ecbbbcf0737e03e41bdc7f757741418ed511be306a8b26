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

 Date: 06/08/2017 01:22:57 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `filters`
-- ----------------------------
DROP TABLE IF EXISTS `filters`;
CREATE TABLE `filters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `filters`
-- ----------------------------
BEGIN;
INSERT INTO `filters` VALUES ('1', null, 'фывфыв', '1', '', null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
