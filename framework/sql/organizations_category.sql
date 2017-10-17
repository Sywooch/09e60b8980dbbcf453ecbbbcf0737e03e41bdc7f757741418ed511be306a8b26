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

 Date: 06/29/2017 02:13:46 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `organizations_category`
-- ----------------------------
DROP TABLE IF EXISTS `organizations_category`;
CREATE TABLE `organizations_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `root` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` smallint(5) NOT NULL,
  `name` varchar(60) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `icon_type` smallint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `selected` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `collapsed` tinyint(1) NOT NULL DEFAULT '0',
  `movable_u` tinyint(1) NOT NULL DEFAULT '1',
  `movable_d` tinyint(1) NOT NULL DEFAULT '1',
  `movable_l` tinyint(1) NOT NULL DEFAULT '1',
  `movable_r` tinyint(1) NOT NULL DEFAULT '1',
  `removable` tinyint(1) NOT NULL DEFAULT '1',
  `removable_all` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tree_NK1` (`root`),
  KEY `tree_NK2` (`lft`),
  KEY `tree_NK3` (`rgt`),
  KEY `tree_NK4` (`lvl`),
  KEY `tree_NK5` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `organizations_category`
-- ----------------------------
BEGIN;
INSERT INTO `organizations_category` VALUES ('1', '1', '1', '6', '0', 'Еда', '/uploads/images/icons/Farm-Fresh_pizza.png', '1', '1', '0', '0', '0', '1', '0', '1', '1', '1', '1', '0', '0'), ('2', '1', '2', '5', '1', 'Рестораны', '', '1', '1', '0', '0', '0', '1', '0', '1', '1', '1', '1', '1', '0'), ('3', '1', '3', '4', '2', 'Доставка', '', '1', '1', '0', '0', '0', '1', '0', '1', '1', '1', '1', '1', '0'), ('4', '4', '1', '6', '0', 'Самовывоз', '', '1', '1', '0', '0', '0', '1', '0', '1', '1', '1', '1', '1', '0'), ('5', '4', '2', '3', '1', 'На дом', '', '1', '1', '0', '0', '0', '1', '0', '1', '1', '1', '1', '1', '0'), ('6', '4', '4', '5', '1', 'По адрессу', '', '1', '1', '0', '0', '0', '1', '0', '1', '1', '1', '1', '1', '0');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
