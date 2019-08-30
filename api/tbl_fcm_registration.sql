/*
Navicat MySQL Data Transfer

Source Server         : MySQL - Local
Source Server Version : 50625
Source Host           : 127.0.0.1:3306
Source Database       : tiketux_baraya

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2019-08-28 11:13:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_fcm_registration
-- ----------------------------
DROP TABLE IF EXISTS `tbl_fcm_registration`;
CREATE TABLE `tbl_fcm_registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fcm_reg_id` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fcm_reg_device` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fcm_reg_device_id` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fcm_reg_time` datetime DEFAULT NULL,
  `fcm_reg_client` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fcm_reg_indication` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Table structure for tbl_fcm_request_log
-- ----------------------------
DROP TABLE IF EXISTS `tbl_fcm_request_log`;
CREATE TABLE `tbl_fcm_request_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rl_code` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `rl_message` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `rl_response` text COLLATE latin1_general_ci,
  `rl_time` datetime DEFAULT NULL,
  `fcm_reg_id` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `rl_indication` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `rl_push_id` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `rl_receive_time` datetime DEFAULT NULL,
  `rl_read_time` datetime DEFAULT NULL,
  `rl_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
