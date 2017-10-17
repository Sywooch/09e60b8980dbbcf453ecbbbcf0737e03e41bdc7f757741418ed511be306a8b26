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

 Date: 06/29/2017 02:13:22 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `organizations_address`
-- ----------------------------
DROP TABLE IF EXISTS `organizations_address`;
CREATE TABLE `organizations_address` (
  `organization_id` int(11) NOT NULL,
  `address` text,
  `working_days` varchar(255) DEFAULT NULL,
  `weekend` varchar(255) DEFAULT NULL,
  `working_hours` varchar(255) DEFAULT NULL,
  `lunch_time` varchar(255) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
