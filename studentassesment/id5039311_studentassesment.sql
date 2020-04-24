-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 06, 2018 at 05:38 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id5039311_studentassesment`
--

-- --------------------------------------------------------

--
-- Table structure for table `answersheet`
--

CREATE TABLE `answersheet` (
  `Answersheetid` int(100) NOT NULL,
  `Answersheetimage` varchar(255) NOT NULL,
  `Answersheetpdf` varchar(255) NOT NULL,
  `Subjectid` int(100) NOT NULL,
  `Semestername` varchar(255) NOT NULL,
  `Midname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answersheet`
--

INSERT INTO `answersheet` (`Answersheetid`, `Answersheetimage`, `Answersheetpdf`, `Subjectid`, `Semestername`, `Midname`) VALUES
(1, 'f94b6ac0589710e114a1b575140ea0fdb1d693f8.png', '', 7, 'sem-2', 'mid-2'),
(2, '', '2.pdf', 8, 'Sem-2', 'mid-1'),
(5, '', '5.docx', 5, 'sem-1', 'mid-1'),
(6, '', '6.docx', 5, 'sem-1', 'mid-1'),
(7, '', '7.docx', 5, 'sem-1', 'mid-1'),
(8, '', '8.docx', 5, 'sem-1', 'mid-1'),
(9, '', '9.docx', 5, 'sem-1', 'mid-1'),
(11, '', '11.docx', 5, 'sem-1', 'mid-1'),
(12, '', '12.docx', 5, 'sem-1', 'mid-1'),
(13, '', '13.pdf', 5, 'sem-1', 'mid-1'),
(14, '', '14.pdf', 5, 'sem-1', 'mid-1'),
(18, '', '18.docx', 5, 'sem-1', 'mid-1'),
(19, '', '19.pdf', 5, 'sem-1', 'mid-1'),
(20, '', '20.docx', 5, 'sem-1', 'mid-1'),
(21, '', '21.docx', 5, 'sem-1', 'mid-1'),
(22, '', '22.docx', 5, 'sem-1', 'mid-1'),
(23, '', '23.docx', 5, 'sem-1', 'mid-1'),
(24, '', '24.docx', 5, 'sem-1', 'mid-1'),
(25, '', '25.docx', 5, 'sem-1', 'mid-1'),
(26, '', '26.docx', 5, 'sem-1', 'mid-1'),
(29, '', '27datadictonry.pdf', 6, 'sem-2', 'mid-2');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_ans`
--

CREATE TABLE `assignment_ans` (
  `AssignmentAnsid` int(100) NOT NULL,
  `Userid` int(100) NOT NULL,
  `AssignmentQueid` int(100) NOT NULL,
  `Assignmentanspdf` varchar(255) NOT NULL,
  `Assignmentansimage` varchar(255) NOT NULL,
  `Remark` varchar(255) NOT NULL,
  `Dt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_ans`
--

INSERT INTO `assignment_ans` (`AssignmentAnsid`, `Userid`, `AssignmentQueid`, `Assignmentanspdf`, `Assignmentansimage`, `Remark`, `Dt`) VALUES
(6, 6, 4, '6.pdf', '', '', '0'),
(7, 6, 4, '', '1a7aff4c9ff625782b0736fa6cbede1a6eae90c8.png', 'good ', '2018-03-23'),
(8, 6, 4, '8.pdf', '', 'good ans', '2018-03-23'),
(9, 6, 4, '9.docx', '', '', ''),
(11, 6, 4, '11.docx', '', '', ''),
(12, 6, 4, '12.pdf', '', '', ''),
(13, 6, 4, '13.pdf', '', '', ''),
(14, 6, 4, '14.pdf', '', '', ''),
(15, 6, 4, '15.pdf', '', '', ''),
(16, 6, 4, '16.pdf', '', '', ''),
(17, 6, 4, '17.pdf', '', '', ''),
(18, 6, 4, '18.pdf', '', '', ''),
(19, 6, 4, '19.pdf', '', '', ''),
(20, 6, 4, '20.pdf', '', '', '2018-03-23'),
(21, 6, 4, '21.pdf', '', '', '2018-04-03'),
(22, 7, 4, '22.docx', '', '', '2018-04-04'),
(45, 6, 4, '45data.pdf', '', '', '2018-03-23'),
(46, 6, 4, '46DATA DICTIONARY.docx', '', '', '2018-03-23');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_que`
--

CREATE TABLE `assignment_que` (
  `AssignmentQueid` int(100) NOT NULL,
  `Subjectid` int(100) NOT NULL,
  `Assignmentimage` varchar(255) NOT NULL,
  `Assignmentpdf` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_que`
--

INSERT INTO `assignment_que` (`AssignmentQueid`, `Subjectid`, `Assignmentimage`, `Assignmentpdf`, `Type`) VALUES
(4, 7, '', '4.pdf', 'practical'),
(5, 5, '', '5.pdf', 'assignment'),
(6, 5, '', '6.pdf', 'assignment'),
(7, 6, '', '7.pdf', 'assignment'),
(8, 7, '', '8.pdf', 'assignment'),
(16, 8, '', '16.pdf', 'assignment'),
(17, 9, '', '17.docx', 'assignment'),
(29, 9, '', '29.pdf', 'assignment'),
(30, 5, '', '30.pdf', 'assignment'),
(31, 6, '', '31.pdf', 'assignment'),
(32, 8, '', '32.pdf', 'assignment'),
(51, 7, '', '51data.pdf', 'practical');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feedbackid` int(100) NOT NULL,
  `Userid` int(100) NOT NULL,
  `Feedbackdes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Feedbackid`, `Userid`, `Feedbackdes`) VALUES
(1, 3, 'This app is very use full');

-- --------------------------------------------------------

--
-- Table structure for table `marksheet`
--

CREATE TABLE `marksheet` (
  `Marksheetid` int(100) NOT NULL,
  `Mid1` varchar(255) NOT NULL,
  `Mid2` varchar(255) NOT NULL,
  `Userid` int(100) NOT NULL,
  `Subjectid` int(100) NOT NULL,
  `Average` decimal(60,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marksheet`
--

INSERT INTO `marksheet` (`Marksheetid`, `Mid1`, `Mid2`, `Userid`, `Subjectid`, `Average`) VALUES
(2, '34', '30', 7, 5, 32),
(4, '14', '30', 7, 6, 22),
(5, '32', '35', 2147483647, 0, 34),
(6, '32', '35', 2147483647, 0, 34),
(7, '32', '35', 2147483647, 0, 34),
(8, '32', '35', 2147483647, 0, 34),
(9, '14', '30', 3, 7, 22);

-- --------------------------------------------------------

--
-- Table structure for table `seatingarrangement`
--

CREATE TABLE `seatingarrangement` (
  `Seatingid` int(100) NOT NULL,
  `Midname` varchar(255) NOT NULL,
  `Userid` int(100) NOT NULL,
  `SeatNo` int(100) NOT NULL,
  `Dttime` varchar(255) NOT NULL,
  `Subjectid` int(100) NOT NULL,
  `BlockNo` varchar(100) NOT NULL,
  `RoomNo` varchar(100) NOT NULL,
  `BenchNo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seatingarrangement`
--

INSERT INTO `seatingarrangement` (`Seatingid`, `Midname`, `Userid`, `SeatNo`, `Dttime`, `Subjectid`, `BlockNo`, `RoomNo`, `BenchNo`) VALUES
(1, 'Mid1', 3, 49, '', 6, 'D-4', '210', '23'),
(2, 'Mid2', 3, 4, '', 5, 'B-2', '110', '20'),
(6, 'Mid1', 7, 14, '2018-03-23', 7, 'd/5', '156', '89');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `Subjectid` int(100) NOT NULL,
  `Semestername` varchar(255) NOT NULL,
  `Subjectname` varchar(255) NOT NULL,
  `Logo` varchar(255) NOT NULL,
  `Userid` int(100) NOT NULL,
  `Department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`Subjectid`, `Semestername`, `Subjectname`, `Logo`, `Userid`, `Department`) VALUES
(5, 'Sem-1', 'Computer engineering', '', 4, 'IT'),
(6, 'Sem-1', 'Computer Network', '', 4, ''),
(7, 'Sem-2', 'Data structure', '', 7, 'Computer'),
(8, 'Sem-2', 'Communication skill', '', 7, 'Computer'),
(9, 'Sem-2', 'DSS', '', 7, 'Computer');

-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE `suggestion` (
  `Suggestionid` int(100) NOT NULL,
  `Userid` int(100) NOT NULL,
  `Suggestiondes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suggestion`
--

INSERT INTO `suggestion` (`Suggestionid`, `Userid`, `Suggestiondes`) VALUES
(1, 3, 'need to improve teaching');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `Timetableid` int(100) NOT NULL,
  `Timetableimage` varchar(255) NOT NULL,
  `Timetablepdf` varchar(255) NOT NULL,
  `Userid` int(100) NOT NULL,
  `Semestername` varchar(255) NOT NULL,
  `Midname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`Timetableid`, `Timetableimage`, `Timetablepdf`, `Userid`, `Semestername`, `Midname`) VALUES
(1, '1559238cd860807d28422035479190304683de46.png', '', 7, 'sem-2', 'mid-1'),
(3, '264f09b08b29fad91506e8ae5347a95ccd7cce8c.png', '', 7, 'sem-1', 'mid-2'),
(4, '', '4.pdf', 4, 'Sem-1', 'mid-1'),
(5, '', '', 7, 'sem-2', 'mid-2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Userid` int(100) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Eno_Fid` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Contact` bigint(100) NOT NULL,
  `College` varchar(255) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Semester` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Userid`, `Username`, `Eno_Fid`, `Email`, `Password`, `Contact`, `College`, `Department`, `Semester`, `Type`, `Status`) VALUES
(3, 'Ishani vora', '54790187', 'ishani@gmail.com', 'ish', 7897549030, 'DAIICT', 'M-scit', 'Sem-2', 'student', 1),
(4, 'Saurabh tiwari', 'sau07', 'saurabh07@gmail.com', 'saurabh123', 7894534256, 'DAIICT', 'computer', '', 'faculty', 1),
(6, 'jainy', 'sau10', 'jainy@gmail.com', 'jain', 78945334578, 'DA-IICT', 'computer', 'sem-2', 'student', 1),
(7, 'asim upadhyay', '1', 'asim12@gmail.com', 'asim123', 9867453423, 'ADC', 'computer', 'sem-2', 'student', 1),
(8, 'Rushabh', 'rush04', 'rush@gmail.com', 'rush', 9727582281, 'socet', 'Computer', '', 'faculty', 1),
(9, 'Admin', 'Admin04', 'admin04@gmail.com', 'admin', 8141691329, 'SOCET', 'All', 'All', 'Admin', 1),
(10, 'Ishani ', '1672657636', 'voraishani24@gmail.com', 'ish123', 9834251672, 'DAIICT', 'IT', 'Sem-2', 'student', 1),
(11, 'vaishali chaudhary', '140770107012', 'vnc@gmail.com', 'vnc123', 8156032350, 'socet', 'computer', 'Sem-8', 'student', 1),
(12, 'asmita', '147012349701', 'vnchaudhary96@gmail.com', 'vaishu', 9633229849, 'socet', 'computer', 'Sem-2', 'student', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answersheet`
--
ALTER TABLE `answersheet`
  ADD PRIMARY KEY (`Answersheetid`);

--
-- Indexes for table `assignment_ans`
--
ALTER TABLE `assignment_ans`
  ADD PRIMARY KEY (`AssignmentAnsid`);

--
-- Indexes for table `assignment_que`
--
ALTER TABLE `assignment_que`
  ADD PRIMARY KEY (`AssignmentQueid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feedbackid`);

--
-- Indexes for table `marksheet`
--
ALTER TABLE `marksheet`
  ADD PRIMARY KEY (`Marksheetid`);

--
-- Indexes for table `seatingarrangement`
--
ALTER TABLE `seatingarrangement`
  ADD PRIMARY KEY (`Seatingid`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`Subjectid`);

--
-- Indexes for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`Suggestionid`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`Timetableid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answersheet`
--
ALTER TABLE `answersheet`
  MODIFY `Answersheetid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `assignment_ans`
--
ALTER TABLE `assignment_ans`
  MODIFY `AssignmentAnsid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `assignment_que`
--
ALTER TABLE `assignment_que`
  MODIFY `AssignmentQueid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedbackid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marksheet`
--
ALTER TABLE `marksheet`
  MODIFY `Marksheetid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seatingarrangement`
--
ALTER TABLE `seatingarrangement`
  MODIFY `Seatingid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `Subjectid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `Suggestionid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `Timetableid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Userid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
