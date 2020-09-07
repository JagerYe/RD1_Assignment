DROP DATABASE IF EXISTS `RD1_Assignment`;
CREATE DATABASE IF NOT EXISTS `RD1_Assignment` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `RD1_Assignment`;

DROP TABLE IF EXISTS `Citys`;
CREATE TABLE `Citys`(
    `cityName` VARCHAR(20) NOT NULL,
    `orderID` INT,
    PRIMARY KEY (`cityName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `Weather`;
CREATE TABLE `Weather` (
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `cityName` VARCHAR(20) NOT NULL,
  `wx` VARCHAR(20),
  `t` INT,
  `minT` INT,
  `maxT` INT,
  `aT` INT,
  `pop` INT,
  `rh` INT,
  `ci` VARCHAR(20),
  `wS` INT,
  `wD` VARCHAR(20),
  `uvi` INT,
  PRIMARY KEY (`startTime`,`cityName`),
  FOREIGN KEY (`cityName`) REFERENCES `Citys`(`cityName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `Rainfall`;
CREATE TABLE `Rainfall` (
  `stationId` VARCHAR(20) NOT NULL,
  `cityName` VARCHAR(20) NOT NULL,
  `locationName` VARCHAR(20) NOT NULL,
  `rain` INT,
  `hour_24` INT,
  PRIMARY KEY (`stationId`),
  FOREIGN KEY (`cityName`) REFERENCES `Citys`(`cityName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Citys`(`cityName`, `orderID`) VALUES
('臺北市',0),
('新北市',1),
('基隆市',2),
('桃園市',3),
('新竹市',4),
('新竹縣',5),
('苗栗縣',6),
('臺中市',7),
('彰化縣',8),
('南投縣',9),
('雲林縣',10),
('嘉義市',11),
('嘉義縣',12),
('臺南市',13),
('高雄市',14),
('屏東縣',15),
('宜蘭縣',16),
('花蓮縣',17),
('臺東縣',18),
('澎湖縣',19),
('連江縣',20),
('金門縣',21);