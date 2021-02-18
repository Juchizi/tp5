/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : tp5

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2020-01-10 09:30:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for about
-- ----------------------------
DROP TABLE IF EXISTS `about`;
CREATE TABLE `about` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `count` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='关于我们';

-- ----------------------------
-- Records of about
-- ----------------------------
INSERT INTO `about` VALUES ('1', 0x3C70207374796C653D22746578742D616C69676E3A206C6566743B223E3C7370616E207374796C653D226261636B67726F756E642D636F6C6F723A20726762283235352C203235352C20323535293B223E3C7370616E207374796C653D22636F6C6F723A207267622838342C203134312C20323132293B223E266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703BE585B3E4BA8EE68891E4BBAC266E6273703B203C2F7370616E3E266E6273703B3C7370616E207374796C653D226261636B67726F756E642D636F6C6F723A20726762283235352C203235352C20323535293B20636F6C6F723A20726762283235352C203235352C2030293B223E3C2F7370616E3E3C2F7370616E3E3C2F703E3C70207374796C653D22746578742D616C69676E3A206C6566743B223E266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B3C696D67207372633D22687474703A2F2F3139322E3136382E312E3130353A383037382F75706C6F6164732F696D616765732F32303230303130392F313537383535303631342E6A706722207469746C653D22313537383535303631342E6A70672220616C743D22382E6A7067222F3E3C2F703E3C703E266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B20266E6273703B266E6273703B3C2F703E3C703E3C62722F3E3C2F703E);

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `phone` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(35) NOT NULL DEFAULT '' COMMENT '密码',
  `avatar` varchar(100) DEFAULT '' COMMENT '头像',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `login_at` timestamp NULL DEFAULT NULL COMMENT '登录时间',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `logout_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `token` varchar(59) NOT NULL DEFAULT '' COMMENT 'Session标识',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `update_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员表';

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '13377875828', 'adc3949ba59abbe56e057f20f8', '', '164875052@qq.com', '2020-01-09 09:06:31', '2018-12-10 10:42:59', '0000-00-00 00:00:00', '2020010909063155100505', '1', null);
INSERT INTO `admins` VALUES ('4', '鞠尚池', '17604242696', 'adc3949ba59abbe56e057f20f8', '', '17604242696@163.com', '2019-12-20 15:56:52', '2019-12-18 15:32:52', null, '2019122015565252489798', '1', '2019-12-18 15:32:52');

-- ----------------------------
-- Table structure for apply_record
-- ----------------------------
DROP TABLE IF EXISTS `apply_record`;
CREATE TABLE `apply_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `customers_id` int(10) NOT NULL COMMENT '用户ID',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '（0：办公用品领用）（1：用车）（2：补卡）（3：会议室使用）（4：请假）（5：外出）',
  `articles_name` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '用品名称',
  `department` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '申请部门',
  `str_time` datetime DEFAULT NULL COMMENT '申请开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '申请结束时间',
  `vehicle_num` char(35) COLLATE utf8_bin DEFAULT '' COMMENT '用车数量',
  `license_plate` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '车牌号',
  `cause` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '事由',
  `meeting_name` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '会议名称',
  `people_num` char(35) COLLATE utf8_bin DEFAULT '' COMMENT '会议人数',
  `company_name` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '承办单位名称',
  `room_name` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '会议室名称',
  `company_form` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '会议形式',
  `approver` char(35) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '审批人',
  `copy_person` char(35) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '抄送人',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '（0：审核中）（1：审核通过）（2：审核驳回）（3：已撤销）',
  `create_at` timestamp NULL DEFAULT NULL COMMENT '录入时间',
  `update_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `leave_type` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '请假类型',
  `days` char(35) COLLATE utf8_bin DEFAULT '' COMMENT '请假天数',
  `duration` char(35) COLLATE utf8_bin DEFAULT '' COMMENT '外出时长',
  `out_address` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '外出地点',
  `abnormal` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '补卡时间',
  `patch_status` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '异常状态',
  `opinion` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '审批意见',
  `turn` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '转审人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of apply_record
-- ----------------------------
INSERT INTO `apply_record` VALUES ('1', '23', '1', '', '研发部', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '2', '辽H6666,H7777', '过年回家开', '', '', '', '', null, '23', '23,22', '1', '2019-12-20 14:38:38', '2020-01-06 14:32:22', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('2', '23', '0', '键盘', '研发部', null, null, '', '', '', '', '', '', '', null, '23', '23,22', '1', '2019-12-20 14:38:38', '2020-01-06 14:32:19', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('3', '23', '3', '', '', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '', '', '', '谈谈人生', '15', '大连科技', '爱笑会议室', '口述', '23', '23,22', '1', '2019-12-20 14:38:38', '2020-01-06 14:32:16', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('4', '23', '5', '', '', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '', '', '溜达', '', '', '', '', '', '23', '23,22', '1', '2019-12-20 14:38:38', '2020-01-06 14:26:00', '', '', '7', '旅顺口', '', '', '', '');
INSERT INTO `apply_record` VALUES ('5', '23', '4', '', '研发部', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '', '', '回家看看', '', '', '', '', '', '23', '23,22', '2', '2019-12-20 14:38:38', '2020-01-06 14:23:21', '事假', '2', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('6', '23', '2', '', '研发部', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '', '', '车晚了', '', '', '', '', '', '23', '23,22', '2', '2019-12-20 14:38:38', '2020-01-06 14:21:34', '', '', '', '', '2019-12-20 9:56:52', '迟到', '', '');
INSERT INTO `apply_record` VALUES ('7', '23', '4', '', '', '2019-12-31 00:00:00', '2020-01-10 00:00:00', '', '', '回家看看', '', '', '', '', null, '23', '23,22', '2', '2019-12-31 13:43:30', '2020-01-06 14:16:51', '事假', '1', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('8', '23', '5', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '3', '23,22', '0', '2019-12-31 13:51:38', '2019-12-31 13:51:38', '', '', '1', '高新区', '', '', '123', '');
INSERT INTO `apply_record` VALUES ('9', '23', '0', '记事本', '检查部', null, null, '', '', '', '', '', '', '', null, '3', '23,22', '0', '2019-12-31 13:57:55', '2019-12-31 13:57:55', '', '', '', '', '', '', '123', '');
INSERT INTO `apply_record` VALUES ('10', '23', '1', '', '检查部', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '2', '辽BH548,辽BH123', '买菜', '', '', '', '', null, '23', '23,22', '1', '2019-12-31 14:03:42', '2019-12-31 14:03:42', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('11', '23', '3', '', '检查部', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '', '项目需求探讨会', '5', '东软', '会议室1', '头脑风暴', '3', '23,22', '3', '2019-12-31 14:10:48', '2020-01-08 17:36:43', '', '', '', '', '', '', '啦啦啦', '');
INSERT INTO `apply_record` VALUES ('12', '23', '3', '', '检查部', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '', '项目需求探讨会', '5', '东软', '会议室1', '头脑风暴', '23', '23,22', '2', '2019-12-31 14:14:04', '2019-12-31 14:14:04', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('13', '23', '0', '键盘', '研发部', null, null, '', '', '', '', '', '', '', null, '23', '23,22', '2', '2019-12-20 14:38:38', '2019-12-20 14:38:38', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('14', '23', '1', '', '研发部', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '2', '辽H6666,H7777', '过年回家开', '', '', '', '', null, '23', '23,22', '1', '2019-12-20 14:38:38', '2019-12-20 14:38:42', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('15', '23', '3', '', '检查部', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '', '项目需求探讨会', '5', '东软', '会议室1', '头脑风暴', '23', '23,22', '1', '2019-12-31 14:14:04', '2019-12-31 14:14:04', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('16', '23', '1', '', '检查部', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '2', '辽BH548,辽BH123', '买菜', '', '', '', '', null, '23', '23,22', '1', '2019-12-31 14:03:42', '2019-12-31 14:03:42', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('17', '23', '5', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '23', '23,22', '1', '2019-12-31 13:51:38', '2019-12-31 13:51:38', '', '', '1', '高新区', '', '', '', '');
INSERT INTO `apply_record` VALUES ('18', '23', '4', '', '', '2019-12-31 00:00:00', '2020-01-10 00:00:00', '', '', '回家看看', '', '', '', '', null, '23', '23,22', '1', '2019-12-31 13:43:30', '2020-01-02 13:40:17', '事假', '1', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('19', '23', '2', '', '研发部', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '', '', '车晚了', '', '', '', '', '', '23', '23,22', '1', '2019-12-20 14:38:38', '2020-01-02 13:01:46', '', '', '', '', '2019-12-20 9:56:52', '迟到', '', '');
INSERT INTO `apply_record` VALUES ('20', '23', '5', '', '', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '', '', '溜达', '', '', '', '', '', '23', '23,22', '1', '2019-12-20 14:38:38', '2019-12-20 14:38:38', '', '', '7', '旅顺口', '', '', '', '');
INSERT INTO `apply_record` VALUES ('21', '23', '0', '键盘', '研发部', null, null, '', '', '', '', '', '', '', null, '23', '23,22', '1', '2019-12-20 14:38:38', '2019-12-20 14:38:38', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('22', '23', '1', '', '研发部', '2019-12-21 14:37:50', '2019-12-26 14:37:54', '2', '辽H6666,H7777', '过年回家开', '', '', '', '', null, '23', '23,22', '1', '2019-12-20 14:38:38', '2019-12-20 14:38:42', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('23', '23', '0', '键盘', '研发部', null, null, '', '', '', '', '', '', '', null, '23', '23,22', '0', '2019-12-20 14:38:38', '2019-12-20 14:38:38', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('24', '23', '0', '键盘', '研发部', null, null, '', '', '', '', '', '', '', null, '23', '23,22', '0', '2019-12-20 14:38:38', '2019-12-20 14:38:38', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('25', '23', '0', '键盘', '研发部', null, null, '', '', '', '', '', '', '', null, '23', '23,22', '0', '2019-12-20 14:38:38', '2019-12-20 14:38:38', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('26', '23', '0', '键盘', '研发部', null, null, '', '', '', '', '', '', '', null, '23', '23,22', '0', '2019-12-20 14:38:38', '2019-12-20 14:38:38', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('27', '23', '0', '键盘', '研发部', null, null, '', '', '', '', '', '', '', null, '23', '23,22', '3', '2019-12-20 14:38:38', '2020-01-06 16:07:28', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('28', '23', '4', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '3', '3', '0', '2020-01-06 16:35:36', '2020-01-06 16:35:36', '事假', '1', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('29', '22', '4', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '17', '17,21', '0', '2020-01-07 16:10:40', '2020-01-07 16:10:40', '事假', '2', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('30', '22', '4', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '17', '17', '0', '2020-01-07 16:10:53', '2020-01-07 16:10:53', '事假', '2', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('31', '23', '4', '', '', '2020-01-07 16:26:00', '2020-01-08 20:30:00', '', '', '123', '', '', '', '', null, '3', '', '0', '2020-01-07 16:26:31', '2020-01-07 16:26:31', '事假', '28.1', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('32', '23', '4', '', '', '2020-01-07 16:33:00', '2020-01-10 16:33:00', '', '', '123', '', '', '', '', null, '3', '', '0', '2020-01-07 16:33:12', '2020-01-07 16:33:12', '事假', '72.0', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('33', '22', '4', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '17', '17,21', '0', '2020-01-07 16:33:13', '2020-01-07 16:33:13', '事假', '2', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('34', '22', '4', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '17', '17,21', '0', '2020-01-07 16:33:37', '2020-01-07 16:33:37', '事假', '2', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('35', '22', '4', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '17', '17,21', '0', '2020-01-07 16:36:51', '2020-01-07 16:36:51', '事假', '2', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('36', '22', '4', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '17', '17,21', '0', '2020-01-07 16:37:25', '2020-01-07 16:37:25', '事假', '2', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('37', '22', '4', '', '', '2019-12-31 00:00:00', '2020-01-01 00:00:00', '', '', '回家看看', '', '', '', '', null, '17', '17,21', '0', '2020-01-07 16:37:36', '2020-01-07 16:37:36', '事假', '2', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('38', '23', '4', '', '', '2020-01-07 16:33:00', '2020-01-10 16:33:00', '', '', '123', '', '', '', '', null, '3', '21', '0', '2020-01-07 16:47:03', '2020-01-07 16:47:03', '事假', '72.0', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('39', '23', '4', '', '', '2020-01-07 16:33:00', '2020-01-10 16:33:00', '', '', '123', '', '', '', '', null, '3', '21,17', '0', '2020-01-07 16:50:17', '2020-01-07 16:50:17', '事假', '72.0', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('40', '23', '5', '', '', '2020-01-07 16:53:00', '2020-01-11 16:53:00', '', '', 'wqeweq', '', '', '', '', null, '3', '18,21', '0', '2020-01-07 16:53:46', '2020-01-07 16:53:46', '', '', '96.0', '123adsd', '', '', '', '');
INSERT INTO `apply_record` VALUES ('41', '23', '0', '胶棒', '院领导', null, null, '', '', '', '', '', '', '', null, '3', '3,18', '0', '2020-01-08 09:55:07', '2020-01-08 09:55:07', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('42', '23', '1', '', '院领导', '2020-01-08 00:00:00', '2020-03-08 00:00:00', '1', '1232131', '1321313', '', '', '', '', null, '3', '17,21', '0', '2020-01-08 10:09:31', '2020-01-08 10:09:31', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('43', '23', '3', '', '', '2020-01-08 00:00:00', '2020-01-08 00:00:00', '', '', '', 'qwe', '123', '院领导', '检委会会议室', '视频会议', '3', '17,22', '3', '2020-01-08 10:23:16', '2020-01-08 17:16:01', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('44', '23', '2', '', '', null, null, '', '', '123', '', '', '', '', null, '3', '', '3', '2020-01-08 15:45:09', '2020-01-09 09:18:38', '', '', '', '', '2020-01-08 00:00', '缺卡（2020-01-08）', '', '');
INSERT INTO `apply_record` VALUES ('45', '23', '3', '', '', '2020-01-08 00:00:00', '2020-01-08 00:00:00', '', '', '', '123', '123', '院领导', '检委会会议室', '视频会议', '3', '21,23', '3', '2020-01-08 17:22:57', '2020-01-08 17:23:00', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('46', '23', '3', '', '', '2020-01-08 00:00:00', '2020-01-08 00:00:00', '', '', '', '1', '12', '院领导', '检委会会议室', '视频会议', '3', '23,19', '3', '2020-01-08 17:25:53', '2020-01-08 17:25:56', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('47', '23', '2', '', '', null, null, '', '', '123', '', '', '', '', null, '3', '3,21', '3', '2020-01-09 09:20:43', '2020-01-09 09:20:47', '', '', '', '', '2020-01-06 00:00', '迟到（07:00:00）', '', '');
INSERT INTO `apply_record` VALUES ('48', '23', '2', '', '', null, null, '', '', '123', '', '', '', '', null, '3', '22,21', '3', '2020-01-09 09:21:42', '2020-01-09 09:21:47', '', '', '', '', '2020-01-06 00:00', '迟到（07:00:00）', '', '');
INSERT INTO `apply_record` VALUES ('49', '23', '2', '', '', null, null, '', '', '123', '', '', '', '', null, '3', '20,21', '3', '2020-01-09 09:23:34', '2020-01-09 09:23:36', '', '', '', '', '2020-01-06 00:00', '迟到（07:00:00）', '', '');
INSERT INTO `apply_record` VALUES ('50', '23', '4', '', '', '2020-01-09 09:24:00', '2020-01-09 10:24:00', '', '', '123', '', '', '', '', null, '3', '19,21', '3', '2020-01-09 09:24:17', '2020-01-09 09:27:50', '事假', '1.0', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('51', '23', '5', '', '', '2020-01-09 09:43:00', '2020-01-12 09:43:00', '', '', '123', '', '', '', '', null, '3', '21,22', '3', '2020-01-09 09:44:04', '2020-01-09 09:44:07', '', '', '72.0', '123', '', '', '', '');
INSERT INTO `apply_record` VALUES ('52', '23', '5', '', '', '2020-01-09 09:47:00', '2020-01-12 09:47:00', '', '', '123', '', '', '', '', null, '3', '21,23', '3', '2020-01-09 09:47:27', '2020-01-09 09:47:30', '', '', '72.0', '123', '', '', '', '');
INSERT INTO `apply_record` VALUES ('53', '23', '0', '胶棒', '院领导', null, null, '', '', '', '', '', '', '', null, '3', '21,22', '3', '2020-01-09 10:06:10', '2020-01-09 10:06:23', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('54', '23', '1', '', '院领导', '2020-01-09 00:00:00', '2020-04-09 00:00:00', '1', '23123', '123', '', '', '', '', null, '3', '19,21', '3', '2020-01-09 10:09:09', '2020-01-09 10:09:19', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('55', '23', '1', '', '院领导', '2020-01-09 00:00:00', '2020-04-09 00:00:00', '123', '112323', '14141', '', '', '', '', null, '3', '21,22', '3', '2020-01-09 10:10:01', '2020-01-09 10:10:03', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('56', '23', '3', '', '', '2020-01-09 00:00:00', '2020-01-10 00:00:00', '', '', '', '123', '432', '院领导', '检委会会议室', '视频会议', '3', '21,22', '3', '2020-01-09 10:12:40', '2020-01-09 10:12:43', '', '', '', '', '', '', '', '');
INSERT INTO `apply_record` VALUES ('57', '23', '3', '', '', '2020-01-09 00:00:00', '2020-01-11 00:00:00', '', '', '', '324', '12', '院领导', '检委会会议室', '视频会议', '3', '21,23', '3', '2020-01-09 10:13:21', '2020-01-09 10:13:23', '', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for areas
-- ----------------------------
DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='地区';

-- ----------------------------
-- Records of areas
-- ----------------------------
INSERT INTO `areas` VALUES ('8', '东西湖区');
INSERT INTO `areas` VALUES ('27', '仙桃市');
INSERT INTO `areas` VALUES ('17', '十堰市');
INSERT INTO `areas` VALUES ('24', '咸宁市');
INSERT INTO `areas` VALUES ('29', '天门市');
INSERT INTO `areas` VALUES ('22', '孝感市');
INSERT INTO `areas` VALUES ('31', '安徽省');
INSERT INTO `areas` VALUES ('19', '宜昌市');
INSERT INTO `areas` VALUES ('26', '恩施市');
INSERT INTO `areas` VALUES ('13', '新洲区');
INSERT INTO `areas` VALUES ('5', '武昌区');
INSERT INTO `areas` VALUES ('14', '武汉市');
INSERT INTO `areas` VALUES ('9', '汉南区');
INSERT INTO `areas` VALUES ('4', '汉阳区');
INSERT INTO `areas` VALUES ('11', '江夏区');
INSERT INTO `areas` VALUES ('1', '江岸区');
INSERT INTO `areas` VALUES ('2', '江汉区');
INSERT INTO `areas` VALUES ('33', '河南省');
INSERT INTO `areas` VALUES ('7', '洪山区');
INSERT INTO `areas` VALUES ('32', '湖南省');
INSERT INTO `areas` VALUES ('28', '潜江市');
INSERT INTO `areas` VALUES ('30', '省外');
INSERT INTO `areas` VALUES ('3', '硚口区');
INSERT INTO `areas` VALUES ('18', '荆州市');
INSERT INTO `areas` VALUES ('20', '荆门市');
INSERT INTO `areas` VALUES ('10', '蔡甸区');
INSERT INTO `areas` VALUES ('16', '襄樊市');
INSERT INTO `areas` VALUES ('21', '鄂州市');
INSERT INTO `areas` VALUES ('25', '随州市');
INSERT INTO `areas` VALUES ('6', '青山区');
INSERT INTO `areas` VALUES ('23', '黄冈市');
INSERT INTO `areas` VALUES ('15', '黄石市');
INSERT INTO `areas` VALUES ('12', '黄陂区');

-- ----------------------------
-- Table structure for attendance_card
-- ----------------------------
DROP TABLE IF EXISTS `attendance_card`;
CREATE TABLE `attendance_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `customers_id` int(11) NOT NULL COMMENT '用户ID',
  `create_at` datetime NOT NULL COMMENT '插入时间',
  `update_at` datetime NOT NULL COMMENT '修改时间',
  `str_status` int(10) NOT NULL DEFAULT '0' COMMENT '上班打卡状态：（0：未打卡）（1：已打卡）(2：已打卡-迟到）',
  `end_status` int(10) NOT NULL DEFAULT '0' COMMENT '下班打卡状态：（0：未打卡）（1：已打卡）（2：早退）',
  `str_time` timestamp NULL DEFAULT NULL COMMENT '上班打卡时间',
  `end_time` datetime DEFAULT NULL COMMENT '下班打卡时间',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '打卡类型：（0：正常考勤）（1：外出）（2：请假）（3：缺卡）（4：旷工）（5：迟到）（6：早退）（7：休息）',
  `late_time` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '迟到时间/分钟',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='考勤记录';

-- ----------------------------
-- Records of attendance_card
-- ----------------------------
INSERT INTO `attendance_card` VALUES ('1', '3', '2019-12-24 13:59:16', '2019-12-24 13:59:19', '1', '0', '2019-12-24 08:59:42', null, '0', '0');
INSERT INTO `attendance_card` VALUES ('2', '22', '2019-12-30 14:04:05', '2019-12-30 14:04:53', '2', '2', '2019-12-30 14:04:05', '2019-12-30 14:04:53', '0', '424');
INSERT INTO `attendance_card` VALUES ('7', '23', '2020-01-02 10:11:39', '2020-01-02 10:11:51', '2', '2', '2020-01-02 10:11:39', '2020-01-02 10:11:51', '0', '191');
INSERT INTO `attendance_card` VALUES ('10', '0', '2019-12-31 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '0', '');
INSERT INTO `attendance_card` VALUES ('9', '5', '2019-12-20 09:56:52', '2020-01-02 00:00:00', '1', '0', null, null, '0', '');
INSERT INTO `attendance_card` VALUES ('21', '22', '2019-12-31 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('22', '22', '2020-01-01 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('23', '22', '2020-01-02 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('24', '22', '2020-01-03 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('25', '22', '2020-01-04 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('26', '22', '2020-01-05 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('27', '22', '2020-01-06 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('28', '22', '2020-01-07 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('29', '22', '2020-01-08 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('30', '22', '2020-01-09 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('31', '22', '2020-01-10 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '2', '');
INSERT INTO `attendance_card` VALUES ('40', '23', '2019-12-21 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '1', '');
INSERT INTO `attendance_card` VALUES ('41', '23', '2019-12-22 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '1', '');
INSERT INTO `attendance_card` VALUES ('42', '23', '2019-12-23 00:00:00', '0000-00-00 00:00:00', '0', '0', null, null, '1', '');
INSERT INTO `attendance_card` VALUES ('43', '23', '2019-12-24 00:00:00', '0000-00-00 00:00:00', '1', '2', null, null, '1', '');
INSERT INTO `attendance_card` VALUES ('44', '23', '2019-12-25 00:00:00', '0000-00-00 00:00:00', '2', '1', null, null, '1', '');
INSERT INTO `attendance_card` VALUES ('45', '23', '2019-12-26 00:00:00', '0000-00-00 00:00:00', '1', '1', null, null, '3', '');
INSERT INTO `attendance_card` VALUES ('46', '23', '2020-01-08 00:00:00', '0000-00-00 00:00:00', '1', '1', null, null, '3', '');
INSERT INTO `attendance_card` VALUES ('47', '23', '2020-01-07 00:00:00', '0000-00-00 00:00:00', '2', '1', null, null, '0', '');

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `lng` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '经度',
  `lat` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '纬度',
  `address` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '地址名称',
  `create_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `range` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '允许打卡范围/米',
  `go_to` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '上班时间',
  `go_off` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '下班时间',
  `department_id` int(11) NOT NULL COMMENT '部门id',
  `working_day` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '工作日',
  `legal` int(255) NOT NULL DEFAULT '0' COMMENT '法定假日是否休息（0：是）（1：否）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='公司打卡范围';

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('0000000002', '121.60700552165508', '38.90846694265057', '中国辽宁省大连市西岗区中山路9号', '2019-12-24 09:48:54', null, '1000', '07:00:00', '20:00:00', '2', '1,2,3,4,5', '0');
INSERT INTO `company` VALUES ('0000000003', '121.513596', '38.843384', '中国辽宁省大连市甘井子区黄浦路', '2019-12-24 10:08:48', null, '500', '09:00:00', '20:00:00', '4', '1,2,3,4,5', '1');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `phone` char(11) NOT NULL COMMENT '手机号',
  `phone2` char(11) DEFAULT NULL,
  `phone3` char(11) DEFAULT NULL,
  `wx` varchar(255) NOT NULL COMMENT '微信号',
  `area_id` smallint(5) DEFAULT NULL COMMENT '地域',
  `create_at` timestamp NULL DEFAULT NULL COMMENT '录入时间',
  `update_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `certificates` varchar(255) NOT NULL DEFAULT '' COMMENT '证件号',
  `portrait_url` varchar(255) NOT NULL COMMENT '头像',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `department` varchar(35) NOT NULL DEFAULT '' COMMENT '部门',
  `sex` int(1) NOT NULL DEFAULT '1' COMMENT '（0：女）（1：男）',
  `salt` varchar(255) NOT NULL DEFAULT '' COMMENT '盐值',
  `position` int(1) NOT NULL DEFAULT '0' COMMENT '（0：员工）（1：部门领导）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COMMENT='客资表';

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('3', '鞠尚池', '17604242696', '', '', 'boys', '1', '2019-12-19 15:53:20', '2019-12-24 14:03:09', '2108822020202132', '20181217010337_622326.png', '', '2', '1', '', '1');
INSERT INTO `customers` VALUES ('5', '上课了', '13377875828', null, null, '111111', '3', '2019-12-19 15:53:20', '2019-12-19 15:53:20', '', '20181217010337_622326.png', '', '', '0', '', '0');
INSERT INTO `customers` VALUES ('6', '890890890', '15907193281', null, null, '', '3', '2018-12-22 11:09:52', '2019-12-19 15:53:20', '', '20181217010337_622326.png', '', '', '1', '', '0');
INSERT INTO `customers` VALUES ('11', '谢广坤', '17604242699', null, null, '12156456', null, '2019-12-19 13:42:05', '2019-12-19 15:40:45', '210882200201234', '5dfb297d3c8ee.jpg', '', '研发部', '1', '', '0');
INSERT INTO `customers` VALUES ('12', 'cz', '17604242696', null, null, 'prrtyyps', null, '2019-12-19 15:41:12', '2019-12-19 15:41:54', '210882202023', '5dfb29c263e5b.jpg', '', '研发部', '0', '', '0');
INSERT INTO `customers` VALUES ('13', '刘能', '1761051561', null, null, 'prettys', null, '2019-12-19 15:42:22', '2019-12-19 15:53:20', '210882202023', '5dfb2c70a88fd.jpg', '', '研发部', '1', '', '0');
INSERT INTO `customers` VALUES ('14', '890890890', '15907193281', null, null, '', '3', '2019-12-19 15:53:20', '2019-12-19 15:53:20', '', '20181217010337_622326.png', '', '', '1', '', '0');
INSERT INTO `customers` VALUES ('15', '890890890', '15907193281', null, null, '', '3', '2019-12-19 15:53:20', '2019-12-19 15:53:20', '', '20181217010337_622326.png', '', '2', '1', '', '0');
INSERT INTO `customers` VALUES ('16', '鞠尚池', '17604242696', null, null, 'boys', '1', '2019-12-19 15:53:20', '2019-12-19 15:53:20', '2108822020202132', '20181217010337_622326.png', '', '研发部', '1', '', '0');
INSERT INTO `customers` VALUES ('17', '鞠尚池', '17604242696', null, null, 'boys', '1', '2019-12-19 15:53:20', '2019-12-19 15:53:20', '2108822020202132', '20181217010337_622326.png', '', '4', '1', '', '0');
INSERT INTO `customers` VALUES ('18', '鞠尚池', '17604242696', null, null, 'boys', '1', '2019-12-19 15:53:20', '2019-12-19 15:53:20', '2108822020202132', '20181217010337_622326.png', '', '4', '1', '', '0');
INSERT INTO `customers` VALUES ('19', '鞠尚池', '17604242696', null, null, 'boys', '1', '2019-12-19 15:53:20', '2019-12-19 15:53:20', '2108822020202132', '20181217010337_622326.png', '', '2', '1', '', '0');
INSERT INTO `customers` VALUES ('20', '鞠尚池', '17604242696', null, null, 'boys', '1', '2019-12-19 15:53:20', '2019-12-19 15:53:20', '2108822020202132', '20181217010337_622326.png', '', '2', '1', '', '0');
INSERT INTO `customers` VALUES ('21', '冯小刚', '17604242269', '17604242269', '17604242269', 'wx99954', null, '2019-12-19 17:11:21', '2020-01-06 16:19:49', '210882200201234', '5e12eda5b30d6.jpg', '', '2', '1', '', '0');
INSERT INTO `customers` VALUES ('22', 'zz', '17604242695', '12315648941', '12315645645', 'prooty', null, '2019-12-24 11:16:22', '2019-12-24 13:31:52', '210882200201234', '5e0184875b136.jpg', '224eade67349aefd0cc2cedba0fd29a1', '2', '1', 'WGUXLu7yZR', '1');
INSERT INTO `customers` VALUES ('23', '刘玉', '18210941603', '18210941603', '18210941603', 'prrtyyps', null, '2019-12-31 14:20:25', null, '210882200201234', '5e0ae8a90ff95.jpg', '426e8bc870d150ea4752c6ebcff50b9d', '2', '0', 'feMsjzOJyd', '1');

-- ----------------------------
-- Table structure for customer_logs
-- ----------------------------
DROP TABLE IF EXISTS `customer_logs`;
CREATE TABLE `customer_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '客资ID',
  `name` varchar(35) DEFAULT NULL COMMENT '姓名',
  `log` varchar(255) DEFAULT NULL COMMENT '日志记录',
  `create_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COMMENT='客资列表操作日志';

-- ----------------------------
-- Records of customer_logs
-- ----------------------------
INSERT INTO `customer_logs` VALUES ('1', '6', 'admin', 'admin录入客资6', '2018-12-22 11:09:52', null);
INSERT INTO `customer_logs` VALUES ('2', '6', 'admin', 'admin更新客资6phone为15907193281', '2018-12-22 11:17:17', null);
INSERT INTO `customer_logs` VALUES ('7', '6', 'admin', 'admin更新客资6地区为武昌区', '2018-12-22 11:51:54', null);
INSERT INTO `customer_logs` VALUES ('8', '6', 'admin', 'admin更新客资6渠道确认为有效客资', '2018-12-22 11:52:49', null);
INSERT INTO `customer_logs` VALUES ('9', '6', 'admin', 'admin更新客资6客资类型为C', '2018-12-22 11:52:59', null);
INSERT INTO `customer_logs` VALUES ('10', '6', 'admin', 'admin更新客资6客户需求为单订跟妆', '2018-12-22 11:53:03', null);
INSERT INTO `customer_logs` VALUES ('11', '6', 'admin', 'admin更新客资6网销为user1', '2018-12-22 11:55:27', null);
INSERT INTO `customer_logs` VALUES ('12', '6', 'admin', 'admin更新客资6姓名1为艾斯德斯', '2018-12-22 11:57:18', null);
INSERT INTO `customer_logs` VALUES ('13', '5', 'admin', 'admin更新客资5渠道确认为无效毛客资', '2018-12-22 13:52:26', null);
INSERT INTO `customer_logs` VALUES ('14', '3', 'admin', 'admin更新客资3[地区]为东西湖区', '2018-12-22 13:53:28', null);
INSERT INTO `customer_logs` VALUES ('15', '1', 'admin', 'admin更新客资1[备注]为888889678678', '2018-12-22 13:57:27', null);
INSERT INTO `customer_logs` VALUES ('16', '7', 'admin', 'admin录入客资7', '2018-12-24 13:10:00', null);
INSERT INTO `customer_logs` VALUES ('17', '7', 'admin', 'admin更新客资7[网销]为user1', '2018-12-24 13:10:23', null);
INSERT INTO `customer_logs` VALUES ('18', '0', 'admin', 'admin删除了客资7', '2018-12-24 13:12:41', null);
INSERT INTO `customer_logs` VALUES ('19', '8', 'admin', 'admin录入客资8', '2018-12-24 13:13:12', null);
INSERT INTO `customer_logs` VALUES ('20', '0', 'admin', 'admin删除了客资8', '2018-12-24 13:14:26', null);
INSERT INTO `customer_logs` VALUES ('21', '9', 'admin', 'admin录入客资9', '2018-12-24 13:14:37', null);
INSERT INTO `customer_logs` VALUES ('22', '0', 'admin', 'admin删除了客资9', '2018-12-24 13:16:24', null);
INSERT INTO `customer_logs` VALUES ('23', '10', 'admin', 'admin录入客资10', '2018-12-24 13:16:32', null);
INSERT INTO `customer_logs` VALUES ('24', '10', 'admin', 'admin更新客资10[网销]为user1', '2018-12-24 13:16:55', null);
INSERT INTO `customer_logs` VALUES ('25', '11', 'admin', 'admin录入客资11', '2018-12-24 13:32:07', null);
INSERT INTO `customer_logs` VALUES ('26', '0', 'admin', 'admin删除了客资11', '2018-12-24 13:35:24', null);
INSERT INTO `customer_logs` VALUES ('27', '0', 'admin', 'admin删除了客资1', '2019-12-19 09:30:45', null);
INSERT INTO `customer_logs` VALUES ('28', null, 'admin', 'admin修改人员', '2019-12-19 13:40:54', null);
INSERT INTO `customer_logs` VALUES ('29', null, 'admin', 'admin修改人员', '2019-12-19 13:41:36', null);
INSERT INTO `customer_logs` VALUES ('30', '11', 'admin', 'admin录入人员11', '2019-12-19 13:42:06', null);
INSERT INTO `customer_logs` VALUES ('31', null, 'admin', 'admin修改人员', '2019-12-19 14:40:14', null);
INSERT INTO `customer_logs` VALUES ('32', null, 'admin', 'admin修改人员', '2019-12-19 15:15:50', null);
INSERT INTO `customer_logs` VALUES ('33', null, 'admin', 'admin修改人员', '2019-12-19 15:40:45', null);
INSERT INTO `customer_logs` VALUES ('34', '12', 'admin', 'admin录入人员12', '2019-12-19 15:41:12', null);
INSERT INTO `customer_logs` VALUES ('35', null, 'admin', 'admin修改人员', '2019-12-19 15:41:54', null);
INSERT INTO `customer_logs` VALUES ('36', '13', 'admin', 'admin录入人员13', '2019-12-19 15:42:22', null);
INSERT INTO `customer_logs` VALUES ('37', '0', 'admin', 'admin删除了人员{{$customer.id},{{$customer.id}', '2019-12-19 15:47:17', null);
INSERT INTO `customer_logs` VALUES ('38', '0', 'admin', 'admin删除了人员{{$customer.id}', '2019-12-19 15:47:26', null);
INSERT INTO `customer_logs` VALUES ('39', '0', 'admin', 'admin删除了人员{{$customer.id}', '2019-12-19 15:47:35', null);
INSERT INTO `customer_logs` VALUES ('40', '0', 'admin', 'admin删除了人员{{$customer.id}', '2019-12-19 15:47:48', null);
INSERT INTO `customer_logs` VALUES ('41', '0', 'admin', 'admin删除了人员10', '2019-12-19 15:49:49', null);
INSERT INTO `customer_logs` VALUES ('42', '13', 'admin', 'admin修改人员13', '2019-12-19 15:53:20', null);
INSERT INTO `customer_logs` VALUES ('43', '21', '鞠尚池', '鞠尚池录入人员21', '2019-12-19 17:11:21', null);
INSERT INTO `customer_logs` VALUES ('44', '22', 'admin', 'admin录入人员22', '2019-12-24 11:16:22', null);
INSERT INTO `customer_logs` VALUES ('45', '22', 'admin', 'admin修改人员22', '2019-12-24 11:19:37', null);
INSERT INTO `customer_logs` VALUES ('46', '22', 'admin', 'admin修改人员22', '2019-12-24 11:21:59', null);
INSERT INTO `customer_logs` VALUES ('47', '22', 'admin', 'admin修改人员22', '2019-12-24 11:22:05', null);
INSERT INTO `customer_logs` VALUES ('48', '22', 'admin', 'admin修改人员22', '2019-12-24 11:22:34', null);
INSERT INTO `customer_logs` VALUES ('49', '22', 'admin', 'admin修改人员22', '2019-12-24 11:22:47', null);
INSERT INTO `customer_logs` VALUES ('50', '22', 'admin', 'admin修改人员22', '2019-12-24 11:24:04', null);
INSERT INTO `customer_logs` VALUES ('51', '22', 'admin', 'admin修改人员22', '2019-12-24 11:24:12', null);
INSERT INTO `customer_logs` VALUES ('52', '22', 'admin', 'admin修改人员22', '2019-12-24 11:24:18', null);
INSERT INTO `customer_logs` VALUES ('53', '22', 'admin', 'admin修改人员22', '2019-12-24 11:31:30', null);
INSERT INTO `customer_logs` VALUES ('54', '21', 'admin', 'admin修改人员21', '2019-12-24 11:37:29', null);
INSERT INTO `customer_logs` VALUES ('55', '1', 'admin', 'admin上传文件1', '2019-12-24 13:13:05', null);
INSERT INTO `customer_logs` VALUES ('56', '2', 'admin', 'admin上传文件2', '2019-12-24 13:17:18', null);
INSERT INTO `customer_logs` VALUES ('57', '3', 'admin', 'admin上传文件3', '2019-12-24 13:20:05', null);
INSERT INTO `customer_logs` VALUES ('58', '0', 'admin', 'admin删除了文件3', '2019-12-24 13:27:51', null);
INSERT INTO `customer_logs` VALUES ('59', '0', 'admin', 'admin删除了文件1', '2019-12-24 13:27:58', null);
INSERT INTO `customer_logs` VALUES ('60', '22', 'admin', 'admin修改人员22', '2019-12-24 13:31:52', null);
INSERT INTO `customer_logs` VALUES ('61', '3', 'admin', 'admin修改人员3', '2019-12-24 14:03:09', null);
INSERT INTO `customer_logs` VALUES ('62', '21', 'admin', 'admin修改人员21', '2019-12-24 16:49:15', null);
INSERT INTO `customer_logs` VALUES ('63', '23', 'admin', 'admin录入人员23', '2019-12-31 14:20:25', null);
INSERT INTO `customer_logs` VALUES ('64', '4', 'admin', 'admin上传文件4', '2019-12-31 15:57:29', null);
INSERT INTO `customer_logs` VALUES ('65', '5', 'admin', 'admin上传文件5', '2020-01-03 14:01:55', null);
INSERT INTO `customer_logs` VALUES ('66', '6', 'admin', 'admin上传文件6', '2020-01-03 14:06:11', null);
INSERT INTO `customer_logs` VALUES ('67', '7', 'admin', 'admin上传文件7', '2020-01-03 14:25:05', null);
INSERT INTO `customer_logs` VALUES ('68', '8', 'admin', 'admin上传文件8', '2020-01-03 14:25:47', null);
INSERT INTO `customer_logs` VALUES ('69', '21', 'admin', 'admin修改人员21', '2020-01-06 16:19:49', null);

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='部门';

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('2', '检查部', '2019-12-24 09:34:47', '0000-00-00 00:00:00');
INSERT INTO `department` VALUES ('4', '办公室', '2019-12-24 10:08:48', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for duty
-- ----------------------------
DROP TABLE IF EXISTS `duty`;
CREATE TABLE `duty` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `customers_id` int(11) NOT NULL COMMENT '用户ID',
  `create_at` datetime NOT NULL COMMENT '值班时间',
  `update_at` datetime NOT NULL COMMENT '修改时间',
  `week` char(35) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '周',
  `time` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '时间戳',
  `code` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='值班表';

-- ----------------------------
-- Records of duty
-- ----------------------------
INSERT INTO `duty` VALUES ('1', '3', '2019-12-23 00:00:00', '0000-00-00 00:00:00', '周一', '1577030400', '1');
INSERT INTO `duty` VALUES ('2', '5', '2019-12-24 00:00:00', '0000-00-00 00:00:00', '周二', '1577116800', '1');
INSERT INTO `duty` VALUES ('3', '6', '2019-12-25 00:00:00', '0000-00-00 00:00:00', '周三', '1577203200', '1');
INSERT INTO `duty` VALUES ('4', '11', '2019-12-26 00:00:00', '0000-00-00 00:00:00', '周四', '1577289600', '1');
INSERT INTO `duty` VALUES ('5', '12', '2019-12-27 00:00:00', '0000-00-00 00:00:00', '周五', '1577376000', '1');
INSERT INTO `duty` VALUES ('6', '13', '2019-12-28 00:00:00', '0000-00-00 00:00:00', '周六', '1577462400', '1');
INSERT INTO `duty` VALUES ('7', '21', '2019-12-29 00:00:00', '0000-00-00 00:00:00', '周日', '1577548800', '1');
INSERT INTO `duty` VALUES ('8', '5', '2019-12-30 00:00:00', '0000-00-00 00:00:00', '周一', '1577635200', '2020011702');
INSERT INTO `duty` VALUES ('9', '11', '2019-12-31 00:00:00', '0000-00-00 00:00:00', '周二', '1577721600', '2020011702');
INSERT INTO `duty` VALUES ('10', '11', '2020-01-01 00:00:00', '0000-00-00 00:00:00', '周三', '1577808000', '2020011702');
INSERT INTO `duty` VALUES ('11', '23', '2020-01-02 00:00:00', '0000-00-00 00:00:00', '周四', '1577894400', '2020011702');
INSERT INTO `duty` VALUES ('12', '3', '2020-01-03 00:00:00', '0000-00-00 00:00:00', '周五', '1577980800', '2020011702');
INSERT INTO `duty` VALUES ('13', '5', '2020-01-04 00:00:00', '0000-00-00 00:00:00', '周六', '1578067200', '2020011702');
INSERT INTO `duty` VALUES ('14', '3', '2020-01-05 00:00:00', '0000-00-00 00:00:00', '周日', '1578153600', '2020011702');
INSERT INTO `duty` VALUES ('15', '3', '2020-01-06 00:00:00', '0000-00-00 00:00:00', '周一', '1578240000', '2020011300');
INSERT INTO `duty` VALUES ('16', '5', '2020-01-07 00:00:00', '0000-00-00 00:00:00', '周二', '1578326400', '2020011300');
INSERT INTO `duty` VALUES ('17', '6', '2020-01-08 00:00:00', '0000-00-00 00:00:00', '周三', '1578412800', '2020011300');
INSERT INTO `duty` VALUES ('18', '11', '2020-01-09 00:00:00', '0000-00-00 00:00:00', '周四', '1578499200', '2020011300');
INSERT INTO `duty` VALUES ('19', '12', '2020-01-10 00:00:00', '0000-00-00 00:00:00', '周五', '1578585600', '2020011300');
INSERT INTO `duty` VALUES ('20', '13', '2020-01-11 00:00:00', '0000-00-00 00:00:00', '周六', '1578672000', '2020011300');
INSERT INTO `duty` VALUES ('21', '21', '2020-01-12 00:00:00', '0000-00-00 00:00:00', '周日', '1578758400', '2020011300');

-- ----------------------------
-- Table structure for duty_if
-- ----------------------------
DROP TABLE IF EXISTS `duty_if`;
CREATE TABLE `duty_if` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `customer_id` int(11) NOT NULL COMMENT '用户ID',
  `sign_code` varchar(11) COLLATE utf8_bin NOT NULL COMMENT '值班标记COde',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='是否查看本周值班标记';

-- ----------------------------
-- Records of duty_if
-- ----------------------------
INSERT INTO `duty_if` VALUES ('00000000004', '3', '2020011702');
INSERT INTO `duty_if` VALUES ('00000000005', '23', '2020011702');
INSERT INTO `duty_if` VALUES ('00000000006', '23', '');
INSERT INTO `duty_if` VALUES ('00000000007', '23', '2020011300');

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '文件路径',
  `type` char(35) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '文件格式',
  `admin` char(35) COLLATE utf8_bin NOT NULL COMMENT '录入人',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `size` char(35) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of file
-- ----------------------------
INSERT INTO `file` VALUES ('2', '5e019f5e09c67.jpg', 'jpg', '', '2019-12-24 13:17:18', null, null);
INSERT INTO `file` VALUES ('4', '5e0aff6977eca.pdf', 'pdf', 'admin', '2019-12-31 15:57:29', null, null);
INSERT INTO `file` VALUES ('5', '5e0ed8d3c0a46.jpg', 'jpg', 'admin', '2020-01-03 14:01:55', null, null);
INSERT INTO `file` VALUES ('6', '5e0ed9d3adcea.jpg', 'jpg', 'admin', '2020-01-03 14:06:11', null, null);
INSERT INTO `file` VALUES ('7', '5e0ede4189ce5.jpg', 'jpg', 'admin', '2020-01-03 14:25:05', null, null);
INSERT INTO `file` VALUES ('8', '5e0ede6bc5691.jpg', 'jpg', 'admin', '2020-01-03 14:25:47', null, '32.87 KB');

-- ----------------------------
-- Table structure for holiday_list
-- ----------------------------
DROP TABLE IF EXISTS `holiday_list`;
CREATE TABLE `holiday_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '节日名称',
  `startday` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of holiday_list
-- ----------------------------
INSERT INTO `holiday_list` VALUES ('1', '元旦', '2020-1-1');
INSERT INTO `holiday_list` VALUES ('2', '除夕', '2020-1-24');
INSERT INTO `holiday_list` VALUES ('3', '春节', '2020-1-25');
INSERT INTO `holiday_list` VALUES ('4', '清明节', '2020-4-4');
INSERT INTO `holiday_list` VALUES ('5', '劳动节', '2020-5-1');
INSERT INTO `holiday_list` VALUES ('6', '端午节', '2020-6-25');
INSERT INTO `holiday_list` VALUES ('7', '中秋节', '2020-10-1');
INSERT INTO `holiday_list` VALUES ('8', '国庆节', '2020-10-1');
INSERT INTO `holiday_list` VALUES ('9', '测试', '2020-1-2');

-- ----------------------------
-- Table structure for login_log
-- ----------------------------
DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `customers_id` int(11) NOT NULL COMMENT '登入用户id',
  `create_at` datetime DEFAULT NULL COMMENT '插入时间',
  `update_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户登入log';

-- ----------------------------
-- Records of login_log
-- ----------------------------
INSERT INTO `login_log` VALUES ('1', '3', '2019-12-20 10:22:32', '2019-12-20 10:22:38');
INSERT INTO `login_log` VALUES ('2', '5', '2019-12-20 10:22:32', '2019-12-20 10:22:38');
INSERT INTO `login_log` VALUES ('3', '20', '2019-12-20 10:22:32', '2019-12-20 10:22:38');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(11) unsigned DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `icon` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` tinyint(2) DEFAULT '99',
  `create_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', '0', '首页', '/admin/index/main', 'fa fa-home', '99', '2018-12-11 14:32:43', '2018-12-11 17:32:50');
INSERT INTO `permissions` VALUES ('3', '0', '系统设置', 'systems', 'fa fa-gears', '96', '2018-12-11 14:52:18', null);
INSERT INTO `permissions` VALUES ('21', '3', '用户列表', '/admin/admins/index', 'fa fa-users', '99', '2018-12-11 17:35:29', null);
INSERT INTO `permissions` VALUES ('22', '21', '新增', '/admin/admins/create', null, '99', '2018-12-11 17:35:57', null);
INSERT INTO `permissions` VALUES ('23', '21', '保存', '/admin/admins/save', null, '99', '2018-12-11 17:36:21', null);
INSERT INTO `permissions` VALUES ('24', '21', '编辑', '/admin/admins/edit', '', '99', '2018-12-15 13:43:18', null);
INSERT INTO `permissions` VALUES ('25', '21', '更新', '/admin/admins/update', '', '11', '2018-12-15 13:42:32', null);
INSERT INTO `permissions` VALUES ('26', '21', '删除', '/admin/admins/delete', null, '99', '2018-12-15 13:43:21', null);
INSERT INTO `permissions` VALUES ('27', '21', '改变属性', '/admin/admins/change', null, '99', '2018-12-15 13:43:59', null);
INSERT INTO `permissions` VALUES ('28', '21', '多选删除', '/admin/admins/delete_all', null, '99', '2018-12-15 13:44:35', null);
INSERT INTO `permissions` VALUES ('29', '3', '用户组', '/admin/roles/index', 'fa fa-vcard', '99', '2018-12-15 13:45:37', null);
INSERT INTO `permissions` VALUES ('30', '29', '新增', '/admin/roles/create', null, '99', '2018-12-15 13:46:07', null);
INSERT INTO `permissions` VALUES ('31', '29', '保存', '/admin/roles/save', null, '99', '2018-12-15 13:46:34', null);
INSERT INTO `permissions` VALUES ('32', '29', '编辑', '/admin/roles/edit', null, '99', '2018-12-15 13:46:53', null);
INSERT INTO `permissions` VALUES ('33', '29', '更新', '/admin/roles/update', null, '99', '2018-12-15 13:47:17', null);
INSERT INTO `permissions` VALUES ('34', '29', '删除', '/admin/roles/delete', null, '99', '2018-12-15 13:47:39', null);
INSERT INTO `permissions` VALUES ('35', '29', '改变属性', '/admin/roles/change', null, '99', '2018-12-15 13:48:10', null);
INSERT INTO `permissions` VALUES ('36', '29', '多选删除', '/admin/roles/delete_all', null, '99', '2018-12-15 13:48:32', null);
INSERT INTO `permissions` VALUES ('37', '3', '菜单权限', '/admin/permissions/index', 'fa fa-user-circle', '99', '2018-12-15 13:49:36', null);
INSERT INTO `permissions` VALUES ('38', '37', '新增', '/admin/permissions/create', null, '99', '2018-12-15 13:50:08', null);
INSERT INTO `permissions` VALUES ('39', '37', '保存', '/admin/permissions/save', null, '99', '2018-12-15 13:50:24', null);
INSERT INTO `permissions` VALUES ('40', '37', '编辑', '/admin/permissions/edit', null, '99', '2018-12-15 13:50:38', null);
INSERT INTO `permissions` VALUES ('41', '37', '更新', '/admin/permissions/update', null, '99', '2018-12-15 13:51:01', null);
INSERT INTO `permissions` VALUES ('42', '37', '删除', '/admin/permissions/delete', null, '99', '2018-12-15 13:51:32', null);
INSERT INTO `permissions` VALUES ('43', '37', '排序', '/admin/permissions/sort', null, '99', '2018-12-15 13:52:04', null);
INSERT INTO `permissions` VALUES ('50', '0', '人员管理', '/customers', 'fa fa-user-plus', '99', '2018-12-21 17:01:24', null);
INSERT INTO `permissions` VALUES ('51', '50', '人员列表', '/admin/customers/index', 'fa fa-user-plus', '99', '2018-12-21 17:03:02', null);
INSERT INTO `permissions` VALUES ('52', '51', '详情', '/admin/customers/create', '', '99', '2018-12-21 17:03:27', null);
INSERT INTO `permissions` VALUES ('55', '51', '修改', '/admin/customers/edit', '', '99', '2018-12-21 17:04:51', null);
INSERT INTO `permissions` VALUES ('56', '51', '删除', '/admin/customers/delete_all', null, '99', '2018-12-21 17:05:27', null);
INSERT INTO `permissions` VALUES ('57', '51', '导出', '/admin/customers/export_customer', null, '98', '2018-12-21 17:06:42', null);
INSERT INTO `permissions` VALUES ('72', '51', '保存', '/admin/customers/save', '', '98', '2019-12-19 17:10:16', null);
INSERT INTO `permissions` VALUES ('73', '0', '数据统计', 'statistics', 'fa fa-dashboard', '99', '2019-12-20 09:36:55', null);
INSERT INTO `permissions` VALUES ('74', '73', '授权统计', '/admin/Authorization/index', 'fa fa-bar-chart-o', '99', '2019-12-20 09:56:57', null);
INSERT INTO `permissions` VALUES ('75', '73', '用车统计', '/admin/Vehicle/index', 'fa fa-cab', '0', '2019-12-20 14:18:22', null);
INSERT INTO `permissions` VALUES ('76', '74', '导出', '/admin/Authorization/export_customer', '', '0', '2019-12-20 15:55:18', null);
INSERT INTO `permissions` VALUES ('77', '75', '导出', '/admin/Vehicle/export_customer', '', '0', '2019-12-20 15:56:02', null);
INSERT INTO `permissions` VALUES ('78', '73', '办公用品领用统计', '/admin/work/index', 'fa fa-suitcase', '0', '2019-12-20 16:02:19', null);
INSERT INTO `permissions` VALUES ('79', '78', '导出', '/admin/Wort/export_customer', '', '0', '2019-12-20 16:23:24', null);
INSERT INTO `permissions` VALUES ('80', '73', '会议室使用统计', '/admin/Room/index', 'fa fa-window-restore', '0', '2019-12-20 16:36:23', null);
INSERT INTO `permissions` VALUES ('81', '80', '导出', '/admin/Room/export_customer', '', '0', '2019-12-20 17:03:36', null);
INSERT INTO `permissions` VALUES ('82', '73', '外出统计', '/admin/Out/index', 'fa fa-map-marker', '0', '2019-12-20 17:05:13', null);
INSERT INTO `permissions` VALUES ('83', '82', '导出', '/admin/Out/export_customer', '', '0', '2019-12-20 17:17:30', null);
INSERT INTO `permissions` VALUES ('85', '73', '请假统计', '/admin/Leave/index', 'fa fa-eyedropper', '0', '2019-12-23 10:34:26', null);
INSERT INTO `permissions` VALUES ('86', '85', '导出', '/admin/Leave/export_customer', '', '0', '2019-12-23 10:36:08', null);
INSERT INTO `permissions` VALUES ('87', '93', '设置详情', '/admin/Company/index', '', '0', '2019-12-23 10:48:57', null);
INSERT INTO `permissions` VALUES ('89', '50', '值班管理', '/admin/Duty/index', 'fa fa-calendar', '0', '2019-12-23 15:14:44', null);
INSERT INTO `permissions` VALUES ('90', '89', '详情', '/admin/Duty/create', '', '0', '2019-12-23 16:54:34', null);
INSERT INTO `permissions` VALUES ('91', '89', '修改', '/admin/Duty/update', '', '0', '2019-12-23 16:55:01', null);
INSERT INTO `permissions` VALUES ('92', '89', '导出', '/admin/Duty/export_customer', '', '0', '2019-12-23 16:55:53', null);
INSERT INTO `permissions` VALUES ('93', '50', '部门管理', '/admin/Department/index', 'fa fa-user-circle-o', '0', '2019-12-24 09:21:20', null);
INSERT INTO `permissions` VALUES ('94', '93', '详情', '/admin/Department/create', '', '0', '2019-12-24 09:39:15', null);
INSERT INTO `permissions` VALUES ('95', '93', '添加', '/admin/Department/save', '', '0', '2019-12-24 09:39:33', null);
INSERT INTO `permissions` VALUES ('96', '93', '修改', '/admin/Department/edit', '', '0', '2019-12-24 09:39:50', null);
INSERT INTO `permissions` VALUES ('97', '93', '删除', '/admin/Department/delete', '', '0', '2019-12-24 09:40:09', null);
INSERT INTO `permissions` VALUES ('98', '93', '设置修改', '/admin/Company/update', '', '0', '2019-12-24 09:54:37', null);
INSERT INTO `permissions` VALUES ('99', '50', '文件管理', '/admin/File/index', 'fa fa-print', '0', '2019-12-24 12:01:26', null);
INSERT INTO `permissions` VALUES ('100', '99', '详情', '/admin/File/create', '', '0', '2019-12-24 13:39:09', null);
INSERT INTO `permissions` VALUES ('101', '99', '添加', '/admin/File/save', '添加', '0', '2019-12-24 13:39:29', null);
INSERT INTO `permissions` VALUES ('102', '99', '删除', '/admin/File/delete_all', '', '0', '2019-12-24 13:39:47', null);
INSERT INTO `permissions` VALUES ('103', '73', '考勤统计', '/admin/Attendance/index', 'fa fa-calendar-check-o', '0', '2019-12-24 13:58:25', null);
INSERT INTO `permissions` VALUES ('104', '103', '导出', '/admin/Attendance/export_customer', '', '0', '2019-12-24 14:37:44', null);
INSERT INTO `permissions` VALUES ('105', '73', '补卡统计', '/admin/Patch/index', 'fa fa-calendar-plus-o', '0', '2019-12-24 16:37:57', null);
INSERT INTO `permissions` VALUES ('106', '105', '导出', '/admin/Patch/export_customer', '', '0', '2019-12-24 16:38:47', null);
INSERT INTO `permissions` VALUES ('107', '3', '关于我们', '/admin/About/index', 'fa fa-hand-lizard-o', '0', '2020-01-03 13:41:45', null);
INSERT INTO `permissions` VALUES ('108', '107', '修改', '/admin/About/update', '', '0', '2020-01-06 14:08:47', null);

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(8) DEFAULT NULL,
  `role_id` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1');
INSERT INTO `permission_role` VALUES ('2', '1');
INSERT INTO `permission_role` VALUES ('4', '1');
INSERT INTO `permission_role` VALUES ('5', '1');
INSERT INTO `permission_role` VALUES ('6', '1');
INSERT INTO `permission_role` VALUES ('7', '1');
INSERT INTO `permission_role` VALUES ('8', '1');
INSERT INTO `permission_role` VALUES ('9', '1');
INSERT INTO `permission_role` VALUES ('10', '1');
INSERT INTO `permission_role` VALUES ('11', '1');
INSERT INTO `permission_role` VALUES ('12', '1');
INSERT INTO `permission_role` VALUES ('13', '1');
INSERT INTO `permission_role` VALUES ('14', '1');
INSERT INTO `permission_role` VALUES ('15', '1');
INSERT INTO `permission_role` VALUES ('16', '1');
INSERT INTO `permission_role` VALUES ('17', '1');
INSERT INTO `permission_role` VALUES ('18', '1');
INSERT INTO `permission_role` VALUES ('19', '1');
INSERT INTO `permission_role` VALUES ('20', '1');
INSERT INTO `permission_role` VALUES ('44', '1');
INSERT INTO `permission_role` VALUES ('45', '1');
INSERT INTO `permission_role` VALUES ('46', '1');
INSERT INTO `permission_role` VALUES ('47', '1');
INSERT INTO `permission_role` VALUES ('48', '1');
INSERT INTO `permission_role` VALUES ('49', '1');
INSERT INTO `permission_role` VALUES ('3', '1');
INSERT INTO `permission_role` VALUES ('21', '1');
INSERT INTO `permission_role` VALUES ('22', '1');
INSERT INTO `permission_role` VALUES ('23', '1');
INSERT INTO `permission_role` VALUES ('24', '1');
INSERT INTO `permission_role` VALUES ('1', '2');
INSERT INTO `permission_role` VALUES ('50', '2');
INSERT INTO `permission_role` VALUES ('51', '2');
INSERT INTO `permission_role` VALUES ('52', '2');
INSERT INTO `permission_role` VALUES ('55', '2');
INSERT INTO `permission_role` VALUES ('72', '2');

-- ----------------------------
-- Table structure for photos
-- ----------------------------
DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of photos
-- ----------------------------
INSERT INTO `photos` VALUES ('24', 'http://tp5.test/uploads/20181208\\8abc6d1adb85d1d6f841c156dabb7688.png', '2018-12-08 17:28:10', '2018-12-08 17:28:10');
INSERT INTO `photos` VALUES ('25', 'http://tp5.test/uploads/20181217\\1cfcb2192e5ca917b8d758e2c5790d17.png', '2018-12-17 09:46:54', '2018-12-17 09:46:54');
INSERT INTO `photos` VALUES ('26', 'http://tp5.test/uploads/20181217\\5152334172a1df1d9e55de48c1a20487.png', '2018-12-17 11:02:55', '2018-12-17 11:02:55');
INSERT INTO `photos` VALUES ('27', 'http://tp5.test/uploads/20181217\\dae8ccc6e322e578d627dc6e7b8c05bd.png', '2018-12-17 11:04:04', '2018-12-17 11:04:04');
INSERT INTO `photos` VALUES ('28', 'http://tp5.test/uploads/20181217\\2ebdf7bbd624253db3678be194ba8d01.png', '2018-12-17 11:05:54', '2018-12-17 11:05:54');
INSERT INTO `photos` VALUES ('29', 'http://tp5.test/uploads/20181217\\ece170c9168eaba98024c4ecc1e8e156.png', '2018-12-17 11:06:43', '2018-12-17 11:06:43');
INSERT INTO `photos` VALUES ('30', 'http://tp5.test/uploads/20181217\\09b90d86dd31b01d92f332bc7c915ca7.png', '2018-12-17 11:11:32', '2018-12-17 11:11:32');
INSERT INTO `photos` VALUES ('31', 'http://tp5.test/uploads/20181217\\9d844ecdad1333d627f352d7ceeced8a.png', '2018-12-17 11:11:51', '2018-12-17 11:11:51');
INSERT INTO `photos` VALUES ('32', 'http://tp5.test/uploads/20181217\\d892f42a546e6d65177ee5cb91c42fbd.png', '2018-12-17 11:12:13', '2018-12-17 11:12:13');
INSERT INTO `photos` VALUES ('33', 'http://tp5.test/uploads/20181217\\b7a883af80f7ce2af0f62572a2973b04.png', '2018-12-17 11:13:05', '2018-12-17 11:13:05');
INSERT INTO `photos` VALUES ('34', 'http://tp5.test/uploads/20181217\\de269ef44d79bf4ed77c466ed9b90486.png', '2018-12-17 11:16:10', '2018-12-17 11:16:10');
INSERT INTO `photos` VALUES ('35', 'http://tp5.test/uploads/20181217\\8903af5476172b05dadd9aff7a0b3c20.png', '2018-12-17 13:14:12', '2018-12-17 13:14:12');
INSERT INTO `photos` VALUES ('36', 'http://tp5.test/uploads/20181217\\339595829544c521baeb8566ec8aee40.png', '2018-12-17 13:14:23', '2018-12-17 13:14:23');
INSERT INTO `photos` VALUES ('37', 'http://jc.com/uploads/20191218\\7f92effe2e1917691547a292cb494eef.jpg', '2019-12-18 16:46:35', '2019-12-18 16:46:35');
INSERT INTO `photos` VALUES ('38', 'http://jc.com/uploads/20191218\\e150d0673e0a61c611b64aa406177ae9.jpg', '2019-12-18 17:01:23', '2019-12-18 17:01:23');
INSERT INTO `photos` VALUES ('39', 'http://jc.com/uploads/20191218\\7363a1ee09619fc8bb14a21429488677.jpg', '2019-12-18 17:01:26', '2019-12-18 17:01:26');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '用户组名',
  `description` text COMMENT '权限描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `create_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `update_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '超级管理员', '所有权限', '1', '2018-12-11 09:50:13', '2018-12-15 17:09:17');
INSERT INTO `roles` VALUES ('2', '员工', '仅此于管理员的权限', '1', '2018-12-10 14:15:11', '2019-12-20 15:56:41');

-- ----------------------------
-- Table structure for role_admin
-- ----------------------------
DROP TABLE IF EXISTS `role_admin`;
CREATE TABLE `role_admin` (
  `admin_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of role_admin
-- ----------------------------
INSERT INTO `role_admin` VALUES ('1', '1');
INSERT INTO `role_admin` VALUES ('4', '2');

-- ----------------------------
-- Table structure for sign
-- ----------------------------
DROP TABLE IF EXISTS `sign`;
CREATE TABLE `sign` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `customer_id` int(11) NOT NULL COMMENT '标记人',
  `relative_id` int(11) NOT NULL COMMENT '被标记人id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='标星联系人';

-- ----------------------------
-- Records of sign
-- ----------------------------
INSERT INTO `sign` VALUES ('3', '22', '21');
INSERT INTO `sign` VALUES ('4', '22', '15');
INSERT INTO `sign` VALUES ('15', '23', '15');
INSERT INTO `sign` VALUES ('18', '23', '17');
INSERT INTO `sign` VALUES ('19', '23', '23');

-- ----------------------------
-- Table structure for sms
-- ----------------------------
DROP TABLE IF EXISTS `sms`;
CREATE TABLE `sms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `phone` char(11) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '发送验证吗电话',
  `code` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '验证码',
  `create_at` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '录入时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='短信验证码';

-- ----------------------------
-- Records of sms
-- ----------------------------
INSERT INTO `sms` VALUES ('1', '17604242695', '7193', '1577433797');
INSERT INTO `sms` VALUES ('2', '17604242695', '2103', '1577434784');
INSERT INTO `sms` VALUES ('3', '17604242695', '9426', '1577667706');
