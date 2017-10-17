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

 Date: 06/26/2017 11:27:58 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `buttons`
-- ----------------------------
DROP TABLE IF EXISTS `buttons`;
CREATE TABLE `buttons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `published` tinyint(4) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `buttons`
-- ----------------------------
BEGIN;
INSERT INTO `buttons` VALUES ('1', 'sadasdasd', 'sadasdasd', '1', '', '', null, null, '1', '2017-06-21 19:48:48', '2017-06-21 20:03:22'), ('2', 'Проверка', '', '0', '', '/uploads/images/123.png', '0', '23', '0', '2017-06-26 11:23:09', '2017-06-26 11:24:44');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
