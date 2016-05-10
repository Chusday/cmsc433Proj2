
--
-- Table structure for table `proj2_taken`
--

CREATE TABLE IF NOT EXISTS `proj2_taken` (
  `taken_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` varchar(9) NOT NULL,
  PRIMARY KEY (`taken_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

----------------------------------------------------------
-- Dumping data for table `proj2_taken`
-- Debugging

--INSERT INTO `proj2_taken` (`taken_id`, `student_id`, `class_id`) VALUES
--(1, 1, 'CMSC201'),
--(2, 1, 'CMSC202'),
--(3, 1, 'CMSC203'),
--(10, 2, 'CMSC201'),
--(11, 2, 'CMSC202'),
--(12, 2, 'CMSC203'),
--(13, 2, 'CMSC304');

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE IF NOT EXISTS `Students` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_cid` varchar(8) NOT NULL,
  `student_first_name` tinytext NOT NULL,
  `student_last_name` tinytext NOT NULL,
  `student_email` tinytext NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

----------------------------------------------------------
-- Dumping data for table `Students`
-- Debugging purposes

--INSERT INTO `Students` (`student_id`, `student_cid`, `student_first_name`, `student_last_name`, `student_email`) VALUES
--(1, 'AA00000', 'Shawn', 'Lupoli', 'slupoli@umbc.edu'),
--(2, 'BB00000', 'guest', 'one', 'guest@umbc.edu'),
--(9, 'CC00000', 'kayoung', 'kim', 'kayoung2@umbc.edu');
-- --------------------------------------------------------

--
-- Constraints for table `proj2_taken`
--
ALTER TABLE `proj2_taken`
  ADD CONSTRAINT `proj2_taken_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
