
-- two tables to hold info.


-- --------------------------------------------------------
--
-- Table structure for table `proj2_taken`
--

CREATE TABLE IF NOT EXISTS `proj2_taken` (
  `taken_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` varchar(9) NOT NULL,
  PRIMARY KEY (`taken_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `proj2_taken`
--

INSERT INTO `proj2_taken` (`taken_id`, `student_id`, `class_id`) VALUES
(1, 1, 'CMSC201'),
(2, 1, 'CMSC202'),
(3, 1, 'CMSC203');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`student_id`, `student_cid`, `student_first_name`, `student_last_name`, `student_email`) VALUES
(1, 'AA000000', 'Shawn', 'Lupoli', 'slupoli@umbc.edu');
