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

 Date: 06/29/2017 02:13:29 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `organizations`
-- ----------------------------
DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `category_id` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT '',
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `order` int(11) DEFAULT '0',
  `url` varchar(255) DEFAULT '',
  `url_facebook` varchar(255) DEFAULT '',
  `url_vk` varchar(255) DEFAULT '',
  `url_ok` varchar(255) DEFAULT '',
  `url_instagram` varchar(255) DEFAULT '',
  `url_twitter` varchar(255) DEFAULT '',
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
