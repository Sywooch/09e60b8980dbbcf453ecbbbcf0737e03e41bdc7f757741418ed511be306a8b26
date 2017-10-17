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

 Date: 06/05/2017 10:47:51 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

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
--  Records of `organizations_telephones`
-- ----------------------------
BEGIN;
INSERT INTO `organizations_telephones` VALUES ('72', '+7678-666-8676'), ('72', '+7787-879-8787'), ('73', '+7678-666-8676'), ('73', '+7787-879-8787'), ('74', '+7000-000-0000'), ('74', '+7999-876-8678');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
