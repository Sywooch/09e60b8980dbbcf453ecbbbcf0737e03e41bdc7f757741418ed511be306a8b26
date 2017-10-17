/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50545
Source Host           : 127.0.0.1:3306
Source Database       : goroda

Target Server Type    : MYSQL
Target Server Version : 50545
File Encoding         : 65001

Date: 2017-04-12 15:13:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `news_image`
-- ----------------------------
DROP TABLE IF EXISTS `news_image`;
CREATE TABLE `news_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_image
-- ----------------------------
