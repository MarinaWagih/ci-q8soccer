-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 30, 2015 at 05:51 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `q8soccer`
--

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team1` int(11) DEFAULT NULL,
  `team2` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `team1_score` int(11) DEFAULT NULL,
  `team2_score` int(11) DEFAULT NULL,
  `team1_result` enum('tie','win','lose') DEFAULT NULL,
  `team2_result` enum('tie','win','lose') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_match_team1_idx` (`team1`),
  KEY `fk_match_team2_idx` (`team2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `match`
--

INSERT INTO `match` (`id`, `team1`, `team2`, `date`, `team1_score`, `team2_score`, `team1_result`, `team2_result`) VALUES
(1, 1, 2, '2015-09-29 00:00:00', 2, 3, '', ''),
(2, 1, 2, '2015-09-29 00:00:00', 0, 0, '', ''),
(3, 2, 1, '2015-09-29 00:00:00', 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `prediction`
--

CREATE TABLE IF NOT EXISTS `prediction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL,
  `team1_score` int(11) DEFAULT NULL,
  `team2_score` int(11) DEFAULT NULL,
  `team1_result` enum('tie','win','lose') DEFAULT NULL,
  `team2_result` enum('tie','win','lose') DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prediction_user_idx` (`user_id`),
  KEY `fk_prediction_match_idx` (`match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `prediction`
--

INSERT INTO `prediction` (`id`, `user_id`, `match_id`, `team1_score`, `team2_score`, `team1_result`, `team2_result`, `date`) VALUES
(1, 1, 1, 3, 2, '', '', '2015-09-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text,
  `date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_survey_user_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `survey_answer`
--

CREATE TABLE IF NOT EXISTS `survey_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` text,
  `survey_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_survey_answer_survey_idx` (`survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `flag` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `flag`) VALUES
(1, 'new team', '239719916677114572466465307011.png'),
(2, 'new awsome team', '6377571956754734544067758981692.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `type` enum('normal','admin') DEFAULT NULL,
  `active` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `image`, `type`, `active`) VALUES
(1, 'MarinaWagih', 'ed2c21b61e82b23a033a9b3aa1da150f', 'marina_wagih_cs@yahoo.com', '3146027373307589003390211558901.png', 'normal', '1'),
(2, '2222222', '00000000', 'marina_mm@yahoo.com', NULL, 'normal', '1'),
(3, 'Marina Wagih', '25f9e794323b453885f5181f1b624d0b', 'marina_wagih@yato.com', 'default.jpg', 'normal', '0');

-- --------------------------------------------------------

--
-- Table structure for table `user_survey_answer`
--

CREATE TABLE IF NOT EXISTS `user_survey_answer` (
  `user_id` int(11) NOT NULL,
  `survey_answer_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`survey_answer_id`),
  KEY `fk_user_survey_answer_answer_idx` (`survey_answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `fk_match_team1` FOREIGN KEY (`team1`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_match_team2` FOREIGN KEY (`team2`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prediction`
--
ALTER TABLE `prediction`
  ADD CONSTRAINT `fk_prediction_match` FOREIGN KEY (`match_id`) REFERENCES `match` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_prediction_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `fk_survey_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `survey_answer`
--
ALTER TABLE `survey_answer`
  ADD CONSTRAINT `fk_survey_answer_survey` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_survey_answer`
--
ALTER TABLE `user_survey_answer`
  ADD CONSTRAINT `fk_user_survey_answer_answer` FOREIGN KEY (`survey_answer_id`) REFERENCES `survey_answer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_survey_answer_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
