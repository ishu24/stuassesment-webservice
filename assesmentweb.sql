-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2018 at 05:56 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assesmentweb`
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
(1, 'f94b6ac0589710e114a1b575140ea0fdb1d693f8.png', '', 5, 'sem-2', 'mid-2'),
(2, '', '2.pdf', 8, 'Sem-1', 'mid-1');

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
(5, 3, 3, '', '013d15dd0722fe8f61d9cdd4fb24ac8d296d131a.png', 'good keep it up', '0'),
(6, 6, 4, '6.pdf', '', '', '0'),
(7, 6, 4, '', '1a7aff4c9ff625782b0736fa6cbede1a6eae90c8.png', '', '2018-03-23'),
(8, 6, 4, '8.pdf', '', '', '2018-03-23');

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
(3, 6, '013d15dd0722fe8f61d9cdd4fb24ac8d296d131a.png', '', 'assignment'),
(4, 7, '', '4.pdf', 'practical');

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
(2, '34', '30', 3, 5, '32'),
(4, '14', '30', 3, 6, '22');

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
(6, 'Mid1', 6, 14, '2018-03-23', 7, 'd/5', '156', '89');

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
(5, 'Sem-1', 'Computer engineering', '2d50f2d23785b6b7ea1744f90696657a711ba69b.png', 4, 'IT'),
(6, 'Sem-1', 'Computer Network', 'f2619f3fd1a458867868c013ca639f3f608295b6.png', 4, ''),
(7, 'Sem-2', 'Data structure', 'a3f11c8fff4c7e08e3885fb444e041454bb18a74.png', 7, ''),
(8, 'Sem-2', 'Communication skill', '', 7, ''),
(9, 'Sem-1', 'DSS', '', 4, 'IT');

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
(4, '', '4.pdf', 4, 'Sem-1', 'mid-1');

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
(3, 'Ishani vora', '1672657636', 'voraishani24@gmail.com', 'ish123', 9834251672, 'DAIICT', 'IT', 'Sem-1', 'student', 0),
(4, 'Saurabh tiwari', 'sau07', 'saurabh07@gmail.com', 'saurabh123', 7894534256, 'DAIICT', 'M.scIT', '', 'faculty', 0),
(6, 'jainy', '201612049', 'jainy@gmail.com', 'jain', 7845636734, 'ADC', 'computer', 'Sem-2', 'student', 0),
(7, 'asim upadhyay', '1', 'asim12@gmail.com', 'asim123', 9867453423, 'ADC', 'M.scIT', '', 'faculty', 0);

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
  MODIFY `Answersheetid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `assignment_ans`
--
ALTER TABLE `assignment_ans`
  MODIFY `AssignmentAnsid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `assignment_que`
--
ALTER TABLE `assignment_que`
  MODIFY `AssignmentQueid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedbackid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `marksheet`
--
ALTER TABLE `marksheet`
  MODIFY `Marksheetid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `seatingarrangement`
--
ALTER TABLE `seatingarrangement`
  MODIFY `Seatingid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `Subjectid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `Suggestionid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `Timetableid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Userid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
