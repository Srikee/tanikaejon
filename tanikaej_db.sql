/*
 Navicat Premium Data Transfer

 Source Server         : tanikaejon
 Source Server Type    : MySQL
 Source Server Version : 50505 (5.5.5-10.6.12-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : tanikaej_db

 Target Server Type    : MySQL
 Target Server Version : 50505 (5.5.5-10.6.12-MariaDB)
 File Encoding         : 65001

 Date: 03/11/2025 08:56:49
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `customer_id` int(11) NOT NULL COMMENT 'รหัส auto',
  `customer_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ชื่อ',
  `customer_sname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'นามสกุล',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'เบอร์มือถือ',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'รหัสผ่าน',
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ที่อยู่',
  `occupation_id` int(11) NULL DEFAULT NULL COMMENT 'อาชีพ -> occupation',
  `status` enum('1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'สถานะ\r\n1: รอตรวจสอบ\r\n2: ตรวจสอบแล้ว\r\n3: ยกเลิก',
  `add_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ผู้เพิ่ม',
  `add_when` datetime NULL DEFAULT NULL COMMENT 'วันที่เพิ่ม',
  `edit_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `edit_when` datetime NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'ข้อมูลลูกค้า' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------

-- ----------------------------
-- Table structure for occupation
-- ----------------------------
DROP TABLE IF EXISTS `occupation`;
CREATE TABLE `occupation`  (
  `occupation_id` int(11) NOT NULL COMMENT 'รหัสอาชีพ',
  `occupation_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT 'อาชีพ',
  `add_by` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `add_when` datetime NULL DEFAULT NULL,
  `edit_by` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `edit_when` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`occupation_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci COMMENT = 'ข้อมูลอาชีพ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of occupation
-- ----------------------------
INSERT INTO `occupation` VALUES (1, 'ข้าราชการ', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (2, 'เกษียณอายุราชการ', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (3, 'ข้าราชการบำนาญ', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (4, 'พนักงานราชการ', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (5, 'พนักงานรัฐ', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (6, 'พนักงานรัฐวิสาหกิจ', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (7, 'พนักงานเอกชน', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (8, 'พนักงานมหาวิทยาลัย', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (9, 'ลูกจ้าง', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (10, 'พนักงานบริษัท', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (11, 'ธุรกิจส่วนตัว', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (12, 'ค้าขาย', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (13, 'ชาวประมง', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (14, 'ชาวนา', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (15, 'ชาวสวน', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (16, 'รับจ้างทั่วไป', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (17, 'พ่อบ้านหรือแม่บ้าน', NULL, NULL, NULL, NULL);
INSERT INTO `occupation` VALUES (18, 'ไม่ทราบข้อมูล', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for user_line
-- ----------------------------
DROP TABLE IF EXISTS `user_line`;
CREATE TABLE `user_line`  (
  `userId` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รหัส user id ของ line oa',
  `displayName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ชื่อไลน์',
  `pictureUrl` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'รูปโปรไฟล์ไลน์',
  `customer_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสลูกค้า -> customer',
  `add_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ผู้เพิ่ม',
  `add_when` datetime NULL DEFAULT NULL COMMENT 'วันที่เพิ่ม',
  `edit_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `edit_when` datetime NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  PRIMARY KEY (`userId`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'ข้อมูลไลน์ลูกค้าที่ Login แล้ว' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_line
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
