DROP DATABASE IF EXISTS `RD1_Assignment`;
CREATE DATABASE IF NOT EXISTS `RD1_Assignment` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `RD1_Assignment`;

DROP TABLE IF EXISTS `Citys`;
CREATE TABLE `Citys`(
    `cityName` VARCHAR(20) NOT NULL,
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