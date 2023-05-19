/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3308
 Source Server Type    : MySQL
 Source Server Version : 80026 (8.0.26)
 Source Host           : localhost:3308
 Source Schema         : lab4_2020151048

 Target Server Type    : MySQL
 Target Server Version : 80026 (8.0.26)
 File Encoding         : 65001

 Date: 13/12/2022 20:19:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `salt` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin', 'e3ba997cad79995596602eb93b342501', 'fyrLab');

-- ----------------------------
-- Table structure for assignment
-- ----------------------------
DROP TABLE IF EXISTS `assignment`;
CREATE TABLE `assignment`  (
  `cid` int NOT NULL,
  `tid` int NOT NULL,
  `level_no` int NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of assignment
-- ----------------------------
INSERT INTO `assignment` VALUES (101, 1001, 2);
INSERT INTO `assignment` VALUES (102, 1002, 2);
INSERT INTO `assignment` VALUES (103, 1003, 1);
INSERT INTO `assignment` VALUES (104, 1003, 0);
INSERT INTO `assignment` VALUES (105, 1003, 1);
INSERT INTO `assignment` VALUES (106, 1001, 2);
INSERT INTO `assignment` VALUES (107, 1001, 2);
INSERT INTO `assignment` VALUES (108, 1002, 0);
INSERT INTO `assignment` VALUES (109, 1002, 0);
INSERT INTO `assignment` VALUES (110, 1003, 1);
INSERT INTO `assignment` VALUES (111, 1003, 1);

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `fitness_no` int NULL DEFAULT NULL,
  `exercise_no` int NULL DEFAULT NULL,
  `tid` int NULL DEFAULT NULL,
  `birth_date` date NULL DEFAULT NULL,
  `credit_card` int NULL DEFAULT NULL,
  `health_no` int NULL DEFAULT NULL,
  `level_no` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customer_ibfk_2`(`tid` ASC) USING BTREE,
  INDEX `customer_ibfk_3`(`level_no` ASC) USING BTREE,
  INDEX `customer_ibfk_4`(`fitness_no` ASC) USING BTREE,
  INDEX `customer_ibfk_5`(`exercise_no` ASC) USING BTREE,
  INDEX `customer_ibfk_6`(`health_no` ASC) USING BTREE,
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`id`) REFERENCES `person` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `trainer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `customer_ibfk_3` FOREIGN KEY (`level_no`) REFERENCES `level` (`no`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `customer_ibfk_4` FOREIGN KEY (`fitness_no`) REFERENCES `fitness` (`no`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `customer_ibfk_5` FOREIGN KEY (`exercise_no`) REFERENCES `exercise` (`no`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `customer_ibfk_6` FOREIGN KEY (`health_no`) REFERENCES `health` (`no`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 112 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (101, 2, 2, 1001, '1986-04-10', 4536, 2, 2);
INSERT INTO `customer` VALUES (102, 1, 1, 1002, '1958-07-12', 7624, 1, 2);
INSERT INTO `customer` VALUES (103, 0, 2, 1003, '1975-08-15', 1196, 1, 1);
INSERT INTO `customer` VALUES (104, 2, 2, 1003, '1960-09-25', 3746, 1, 0);
INSERT INTO `customer` VALUES (105, 0, 0, 1003, '1948-12-25', 2984, 0, 1);
INSERT INTO `customer` VALUES (106, 1, 2, 1001, '1989-02-02', 912, 2, 2);
INSERT INTO `customer` VALUES (107, 0, 1, 1001, '1975-03-16', 7864, 0, 2);
INSERT INTO `customer` VALUES (108, 2, 2, 1002, '1992-05-06', 3562, 1, 0);
INSERT INTO `customer` VALUES (109, 1, 1, 1002, '1967-11-26', 8475, 2, 0);
INSERT INTO `customer` VALUES (110, 1, 0, 1003, '1951-06-01', 911, 1, 1);
INSERT INTO `customer` VALUES (111, 1, 1, 1003, '1986-04-10', 1, 1, 1);

-- ----------------------------
-- Table structure for exercise
-- ----------------------------
DROP TABLE IF EXISTS `exercise`;
CREATE TABLE `exercise`  (
  `no` int NOT NULL,
  `text` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of exercise
-- ----------------------------
INSERT INTO `exercise` VALUES (0, 'None');
INSERT INTO `exercise` VALUES (1, 'Moderate');
INSERT INTO `exercise` VALUES (2, 'Frequent');

-- ----------------------------
-- Table structure for fitness
-- ----------------------------
DROP TABLE IF EXISTS `fitness`;
CREATE TABLE `fitness`  (
  `no` int NOT NULL,
  `text` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fitness
-- ----------------------------
INSERT INTO `fitness` VALUES (0, 'Unfit');
INSERT INTO `fitness` VALUES (1, 'Moderately Fit');
INSERT INTO `fitness` VALUES (2, 'Very Fit');

-- ----------------------------
-- Table structure for health
-- ----------------------------
DROP TABLE IF EXISTS `health`;
CREATE TABLE `health`  (
  `no` int NOT NULL,
  `text` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of health
-- ----------------------------
INSERT INTO `health` VALUES (0, 'Unhealthy');
INSERT INTO `health` VALUES (1, 'Somewhat healthy');
INSERT INTO `health` VALUES (2, 'Very healthy');

-- ----------------------------
-- Table structure for level
-- ----------------------------
DROP TABLE IF EXISTS `level`;
CREATE TABLE `level`  (
  `no` int NOT NULL,
  `text` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fee` float NULL DEFAULT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of level
-- ----------------------------
INSERT INTO `level` VALUES (0, 'Bronze', 18.5);
INSERT INTO `level` VALUES (1, 'Silver', 20);
INSERT INTO `level` VALUES (2, 'Gold', 30);

-- ----------------------------
-- Table structure for location
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `zipcode` int NULL DEFAULT NULL,
  `city` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `state` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  CONSTRAINT `location_ibfk_1` FOREIGN KEY (`id`) REFERENCES `person` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1004 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of location
-- ----------------------------
INSERT INTO `location` VALUES (101, 98119, 'Seattle', '138 Woodlawn Ave', 'WA');
INSERT INTO `location` VALUES (102, 10463, 'Bronx', '121 Chaucer Lane', 'NY');
INSERT INTO `location` VALUES (103, 19063, 'Media', '26 Julie Court', 'PA');
INSERT INTO `location` VALUES (104, 10566, 'Peekskill', '4001 Birch Street', 'NY');
INSERT INTO `location` VALUES (105, 8854, 'Piscataway', '23 Geneva Blvd', 'NJ');
INSERT INTO `location` VALUES (106, 9776, 'Deep River', '2 Waverly Rd', 'CT');
INSERT INTO `location` VALUES (107, 21117, 'Owings Mills', '103 Chadd Rd', 'MD');
INSERT INTO `location` VALUES (108, 84109, 'Salt Lake City', '1502 Valley Stream Lane', 'UT');
INSERT INTO `location` VALUES (109, 7076, 'Scotch Plains', '220 E Main Street', 'NJ');
INSERT INTO `location` VALUES (110, 45459, 'Centerville', '25 Brown Lane', 'OH');
INSERT INTO `location` VALUES (111, 1, '1', '1', '1');
INSERT INTO `location` VALUES (1001, 90001, 'Los Angeles', '59 N. Main Street', 'CA');
INSERT INTO `location` VALUES (1002, 90002, 'Los Angeles', '6001-G Cumberland Ln', 'CA');
INSERT INTO `location` VALUES (1003, 9004, 'Los Angeles', '89 Oceanview Rd', 'CA');

-- ----------------------------
-- Table structure for log_illegal
-- ----------------------------
DROP TABLE IF EXISTS `log_illegal`;
CREATE TABLE `log_illegal`  (
  `tid` int NOT NULL,
  `times` int NULL DEFAULT NULL,
  PRIMARY KEY (`tid`) USING BTREE,
  CONSTRAINT `log_illegal_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `trainer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_illegal
-- ----------------------------
INSERT INTO `log_illegal` VALUES (1001, 0);
INSERT INTO `log_illegal` VALUES (1002, 0);
INSERT INTO `log_illegal` VALUES (1003, 1);

-- ----------------------------
-- Table structure for person
-- ----------------------------
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `first_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1005 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of person
-- ----------------------------
INSERT INTO `person` VALUES (101, 'AED@zoom.net', 'Dickerson', 'Allen', '2062560097');
INSERT INTO `person` VALUES (102, 'Oldie@brandywine.net', 'Faber', 'Dale', '2125493324');
INSERT INTO `person` VALUES (103, 'Ahearn@aol.com', 'Hearn', 'Arthur', '6105437611');
INSERT INTO `person` VALUES (104, 'Shirl121@hotmail.com', 'Lavelle', 'Shirley', '9147365512');
INSERT INTO `person` VALUES (105, 'NelsJ@hotmail.com', 'Nelson', 'Janice', '2104693541');
INSERT INTO `person` VALUES (106, 'BS599@aol.com', 'Schwartz', 'Byron', '2035360954');
INSERT INTO `person` VALUES (107, '55SS@zoom.net', 'Sunzar', 'Sam', '3017621298');
INSERT INTO `person` VALUES (108, 'CT@brandywine.net', 'Turner', 'Cynthia', '8016759812');
INSERT INTO `person` VALUES (109, 'Trapp334@hotmail.com', 'Trapp', 'John', '2017578876');
INSERT INTO `person` VALUES (110, 'BillyW@aol.com', 'Wills', 'Billy', '5134359123');
INSERT INTO `person` VALUES (111, '1', '3', '1', '1');
INSERT INTO `person` VALUES (1001, 'diego@owo.com', 'Gonzalez', 'Diego', '6019980091');
INSERT INTO `person` VALUES (1002, 'patti@owo.com', 'McCall', 'Patti', '5408870912');
INSERT INTO `person` VALUES (1003, 'jon@owo.com', 'Kim', 'Jon', '9012247656');

-- ----------------------------
-- Table structure for trainer
-- ----------------------------
DROP TABLE IF EXISTS `trainer`;
CREATE TABLE `trainer`  (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE,
  CONSTRAINT `trainer_ibfk_1` FOREIGN KEY (`id`) REFERENCES `person` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1004 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of trainer
-- ----------------------------
INSERT INTO `trainer` VALUES (1001);
INSERT INTO `trainer` VALUES (1002);
INSERT INTO `trainer` VALUES (1003);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `salt` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'mike', '34d230409f1d36256234dd8a03267f3e', '301770', 'jkl@jkl.com');

-- ----------------------------
-- Procedure structure for delete_illegal_customer
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_illegal_customer`;
delimiter ;;
CREATE PROCEDURE `delete_illegal_customer`()
BEGIN 
  DECLARE cid INT; #暂存被删除顾客的ID
	DECLARE done TINYINT DEFAULT 0; #创建结束标志变量
	DECLARE cur1 CURSOR FOR select id from `customer` WHERE getAge(birth_date)<18;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1; # 指定右边循环结束的返回值
	OPEN cur1;
	read_loop: LOOP
    FETCH FROM cur1 INTO cid;
		IF done THEN #如果游标走到末尾就退出
		  LEAVE read_loop;
		END IF;
    DELETE FROM `customer` c WHERE c.id = cid;
	  DELETE FROM `person` p WHERE p.id = cid;
	  SELECT cid;
  END LOOP;
  CLOSE cur1;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for fit_gold
-- ----------------------------
DROP PROCEDURE IF EXISTS `fit_gold`;
delimiter ;;
CREATE PROCEDURE `fit_gold`()
BEGIN
  SELECT c.id,p.last_name,p.first_name,p.email
	FROM `customer` c
	JOIN `person` p
	ON c.id = p.id
	WHERE c.level_no in (
	   select `no`
		 FROM `level`
		 WHERE `text`='Gold')
  AND c.fitness_no in (
		 select `no`
		 FROM `fitness`
		 WHERE `text` in ('very fit', 'moderately fit')
		 );
END
;;
delimiter ;

-- ----------------------------
-- Function structure for getAge
-- ----------------------------
DROP FUNCTION IF EXISTS `getAge`;
delimiter ;;
CREATE FUNCTION `getAge`(`birth_date` DATE)
 RETURNS int
  NO SQL 
RETURN TIMESTAMPDIFF(YEAR,birth_date,CURDATE())
;;
delimiter ;

-- ----------------------------
-- Procedure structure for over_age
-- ----------------------------
DROP PROCEDURE IF EXISTS `over_age`;
delimiter ;;
CREATE PROCEDURE `over_age`(IN `age` INT)
BEGIN
  SELECT p.id,p.last_name,p.first_name,p.email,c.`birth_date`
	FROM `customer` c
	JOIN `person` p
	ON c.id = p.id
	WHERE getAge(`customer`.birth_date)>age;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for performance
-- ----------------------------
DROP PROCEDURE IF EXISTS `performance`;
delimiter ;;
CREATE PROCEDURE `performance`()
BEGIN
  SELECT p2.id, p2.last_name,p2.first_name,p1.last_name c_last,p1.first_name c_first ,l.`text`,truncate(l.`fee`,2) as fee
	FROM `customer` c
	JOIN `level` l
	ON c.`level_no` = l.`no`
	RIGHT JOIN `trainer` t
	ON c.`tid` = t.`id`
	JOIN `person` p1
	ON c.id = p1.id
	JOIN person p2
	ON t.id = p2.id
	ORDER BY p2.last_name;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for trainer_customers
-- ----------------------------
DROP PROCEDURE IF EXISTS `trainer_customers`;
delimiter ;;
CREATE PROCEDURE `trainer_customers`()
BEGIN 
  SELECT p.id, p.last_name,p.first_name,count(t.id) cnt
  FROM trainer t
	LEFT JOIN customer c
	ON t.id = c.tid
	LEFT JOIN person p
	ON t.id = p.id
	GROUP BY t.id;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table customer
-- ----------------------------
DROP TRIGGER IF EXISTS `after_assignment`;
delimiter ;;
CREATE TRIGGER `after_assignment` AFTER INSERT ON `customer` FOR EACH ROW BEGIN
  INSERT INTO `assignment` (`cid`,`tid`,`level_no`)
	VALUES (NEW.id,NEW.tid,NEW.level_no);
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table customer
-- ----------------------------
DROP TRIGGER IF EXISTS `before_delete_customer`;
delimiter ;;
CREATE TRIGGER `before_delete_customer` BEFORE DELETE ON `customer` FOR EACH ROW BEGIN
  UPDATE `log_illegal` 
	SET `times` = `times`+1
	WHERE `tid`=OLD.tid and getAge(OLD.birth_date)<18;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table trainer
-- ----------------------------
DROP TRIGGER IF EXISTS `after_insert_trainer`;
delimiter ;;
CREATE TRIGGER `after_insert_trainer` AFTER INSERT ON `trainer` FOR EACH ROW BEGIN
  INSERT INTO `log_illegal`(`tid`,`times`)
	VALUES(NEW.id,0);
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
