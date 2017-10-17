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

 Date: 06/26/2017 15:49:36 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admins_access`
-- ----------------------------
DROP TABLE IF EXISTS `admins_access`;
CREATE TABLE `admins_access` (
  `admin_id` int(11) NOT NULL,
  `access` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`,`access`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `admins_access`
-- ----------------------------
BEGIN;
INSERT INTO `admins_access` VALUES ('1', 'advertising_banner', '1'), ('1', 'clients', '1'), ('1', 'filters', '1'), ('1', 'news', '1'), ('1', 'notice', '1'), ('1', 'shares', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
