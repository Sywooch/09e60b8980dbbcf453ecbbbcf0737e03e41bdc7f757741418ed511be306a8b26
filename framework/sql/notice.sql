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

 Date: 06/26/2017 11:58:03 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `notice`
-- ----------------------------
DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `platform` tinyint(4) DEFAULT '0',
  `text` text NOT NULL,
  `section` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `send_status` int(11) DEFAULT NULL,
  `send_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `notice`
-- ----------------------------
BEGIN;
INSERT INTO `notice` VALUES ('1', 'ывфывфывфыв', null, 'фывфывфывфвфв', '0', '1', null, null, null, null), ('2', 'ывфывфывфывqwewqeqweqwe', null, 'фывфывфывфвфв', '0', '1', null, null, null, null), ('3', 'ывфывфывфывqwewqeqweqwe', null, 'фывфывфывфвфв', '2', '1', null, null, null, null), ('4', 'ывфывфывфывqwewqeqweqwe', '0', 'фывфывфывфвфв', '2', '1', null, '2017-06-26 11:55:00', '2017-06-26 11:56:33', '2017-06-26 11:56:33');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
