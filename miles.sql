-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Oct 09, 2024 at 08:31 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miles`
--

-- --------------------------------------------------------

--
-- Table structure for table `aggregated_concerns`
--

CREATE TABLE `aggregated_concerns` (
  `concern` varchar(255) NOT NULL,
  `selection_count` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `course_section` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aggregated_concerns`
--

INSERT INTO `aggregated_concerns` (`concern`, `selection_count`, `user_id`, `course_section`) VALUES
('1.Feeling tired much of the time', 1, NULL, 'BSIT 4A G2'),
('10.Graduation threatened by lack of funds', 1, NULL, 'BSIT 4A G2'),
('11.Too little chance to get into sports', 2, NULL, 'BSIT 4A G2'),
('12.Wanting to be more popular', 2, NULL, 'BSIT 4A G2'),
('13.Worrying about unimportant things', 2, NULL, 'BSIT 4A G2'),
('14.Getting low grades', 2, NULL, 'BSIT 4A G2'),
('15.Doubting wisdom of my vocational choice', 2, NULL, 'BSIT 4A G2'),
('16.Dull classes', 2, NULL, 'BSIT 4A G2'),
('17.Being overweight', 2, NULL, 'BSIT 4A G2'),
('18.Needing money for graduate training', 2, NULL, 'BSIT 4A G2'),
('19.Too little chance to enjoy art or music', 2, NULL, 'BSIT 4A G2'),
('2.Going into debt for college expenses', 1, NULL, 'BSIT 4A G2'),
('20.Being left out of things', 2, NULL, 'BSIT 4A G2'),
('21.Nervousness', 1, NULL, 'BSIT 4A G1'),
('22.Weak in writing', 1, NULL, 'BSIT 4A G1'),
('23.Purpose in going to college not clear', 1, NULL, 'BSIT 4A G1'),
('24.Too many poor teachers', 1, NULL, 'BSIT 4A G1'),
('25.Not getting enough exercise', 1, NULL, 'BSIT 4A G1'),
('26.Too many financial problems', 1, NULL, 'BSIT 4A G1'),
('27.Too little chance to enjoy radio or television', 1, NULL, 'BSIT 4A G1'),
('28.Having feelings of extreme loneliness', 1, NULL, 'BSIT 4A G1'),
('29.Finding it difficult to relax', 1, NULL, 'BSIT 4A G1'),
('3.Not enough time for recreation', 1, NULL, 'BSIT 4A G2'),
('30.Weak in spelling or grammar', 1, NULL, 'BSIT 4A G1'),
('4.Losing friends', 1, NULL, 'BSIT 4A G2'),
('5.Taking things too seriously', 1, NULL, 'BSIT 4A G2'),
('6.Forgetting things I’ve learned in school', 1, NULL, 'BSIT 4A G2'),
('7.Restless at delay in starting life work', 1, NULL, 'BSIT 4A G2'),
('8.College too indifferent to student needs', 1, NULL, 'BSIT 4A G2'),
('9.Being underweight', 1, NULL, 'BSIT 4A G2');

-- --------------------------------------------------------

--
-- Table structure for table `selections`
--

CREATE TABLE `selections` (
  `user_id` int(11) NOT NULL,
  `top_20` text DEFAULT NULL,
  `top_5` text DEFAULT NULL,
  `concern` varchar(255) NOT NULL,
  `selection_count` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `selections`
--

INSERT INTO `selections` (`user_id`, `top_20`, `top_5`, `concern`, `selection_count`) VALUES
(1, '1.Feeling tired much of the time,2.Going into debt for college expenses,3.Not enough time for recreation,4.Losing friends,5.Taking things too seriously,6.Forgetting things I’ve learned in school,7.Restless at delay in starting life work,8.College too indifferent to student needs,9.Being underweight,10.Graduation threatened by lack of funds,11.Too little chance to get into sports,12.Wanting to be more popular,13.Worrying about unimportant things,14.Getting low grades,15.Doubting wisdom of my vocational choice,16.Dull classes,17.Being overweight,18.Needing money for graduate training,19.Too little chance to enjoy art or music,20.Being left out of things', '1.Feeling tired much of the time,2.Going into debt for college expenses,3.Not enough time for recreation,4.Losing friends,5.Taking things too seriously', '', 1),
(5, '11.Too little chance to get into sports,12.Wanting to be more popular,13.Worrying about unimportant things,14.Getting low grades,15.Doubting wisdom of my vocational choice,16.Dull classes,17.Being overweight,18.Needing money for graduate training,19.Too little chance to enjoy art or music,20.Being left out of things,21.Nervousness,22.Weak in writing,23.Purpose in going to college not clear,24.Too many poor teachers,25.Not getting enough exercise,26.Too many financial problems,27.Too little chance to enjoy radio or television,28.Having feelings of extreme loneliness,29.Finding it difficult to relax,30.Weak in spelling or grammar', '11.Too little chance to get into sports,12.Wanting to be more popular,13.Worrying about unimportant things,14.Getting low grades,15.Doubting wisdom of my vocational choice', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testing_service`
--

CREATE TABLE `testing_service` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name_of_test` varchar(255) NOT NULL,
  `raw_score` int(11) NOT NULL,
  `percentile` int(11) NOT NULL,
  `description` text NOT NULL,
  `dimension_aspect` varchar(255) NOT NULL,
  `test_date` date DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testing_service`
--

INSERT INTO `testing_service` (`id`, `user_id`, `name_of_test`, `raw_score`, `percentile`, `description`, `dimension_aspect`, `test_date`, `date`) VALUES
(2, 1, 'jay', 131, 213, 'tryy', 'try', NULL, NULL),
(3, 1, 'jay', 235, 30, 'werty', 'ffg', NULL, NULL),
(4, 1, '', 1233, 123, 'try', 'try', NULL, '2024-10-09'),
(5, 1, 'sam', 1233, 123, 'try', 'try', NULL, '2024-10-09'),
(6, 1, 'samp', 213141, 1412213, 'tqwf', 'try', NULL, '2024-10-09');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_status` enum('not confirmed','confirmed') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `confirmation_code` varchar(50) NOT NULL,
  `forgot_password_code` varchar(40) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `course_section` varchar(255) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `subject`, `email`, `password`, `confirmation_status`, `profile_picture`, `address`, `confirmation_code`, `forgot_password_code`, `role`, `course_section`, `year_level`) VALUES
(1, 'Jay R', 'Santos', '', 'jayrsantos114@gmail.com', 'aa', 'confirmed', 'photo_66ebe3142b007_b5.png', 'BLK-16 LOT-12 Bulacan Heights Catacte', '8UDIJ', '', 'user', 'BSIT 4A G2', 3),
(4, 'Admin', 'User', '', 'admin@example.com', 'admin_hashed_password', 'confirmed', 'photo_66ebdb884784b_445586464_1680353762773390_637964440655407413_n.jpg', 'haha', 'Test', 'Lala', 'admin', NULL, NULL),
(5, 'sample', 'Santos', '', 'jayrs@gmail.com', '123', 'confirmed', 'photo_66ebdb884784b_445586464_1680353762773390_637964440655407413_n.jpg', 'BLK-16 LOT-12 Bulacan Heights Catacte', 'Tph6W', '', 'user', 'BSIT 4A G1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_concerns`
--

CREATE TABLE `user_concerns` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `concern` varchar(255) NOT NULL,
  `selection_count` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `course_section` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(50) DEFAULT NULL,
  `sex_at_birth` varchar(50) DEFAULT NULL,
  `gender_identity` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `living_status` varchar(50) DEFAULT NULL,
  `employed` enum('Yes','No','','') DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `handicapped` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `relation_to_emergency_contact` varchar(50) DEFAULT NULL,
  `emergency_contact_number` varchar(50) DEFAULT NULL,
  `birth_order` varchar(255) DEFAULT NULL,
  `number_of_siblings` int(11) DEFAULT NULL,
  `parents_marital_status` varchar(50) DEFAULT NULL,
  `fathers_name` varchar(255) DEFAULT NULL,
  `fathers_dob` date DEFAULT NULL,
  `fathers_age` int(11) DEFAULT NULL,
  `fathers_education` varchar(255) DEFAULT NULL,
  `fathers_occupation` varchar(255) DEFAULT NULL,
  `fathers_company` varchar(255) DEFAULT NULL,
  `mothers_maiden_name` varchar(255) DEFAULT NULL,
  `mothers_dob` date DEFAULT NULL,
  `mothers_age` int(11) DEFAULT NULL,
  `mothers_education` varchar(255) DEFAULT NULL,
  `mothers_occupation` varchar(255) DEFAULT NULL,
  `mothers_company` varchar(255) DEFAULT NULL,
  `family_income` varchar(255) DEFAULT NULL,
  `marriage_status` varchar(50) DEFAULT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `spouse_dob` date DEFAULT NULL,
  `spouse_education` varchar(255) DEFAULT NULL,
  `spouse_occupation` varchar(255) DEFAULT NULL,
  `spouse_company` varchar(255) DEFAULT NULL,
  `spouse_contact` varchar(50) DEFAULT NULL,
  `elem_school` varchar(255) DEFAULT NULL,
  `elem_type` varchar(50) DEFAULT NULL,
  `elem_years` varchar(50) DEFAULT NULL,
  `elem_awards` text DEFAULT NULL,
  `junior_high_school` varchar(255) DEFAULT NULL,
  `junior_type` varchar(50) DEFAULT NULL,
  `junior_years` varchar(50) DEFAULT NULL,
  `junior_awards` text DEFAULT NULL,
  `senior_high_school` varchar(255) DEFAULT NULL,
  `senior_type` varchar(50) DEFAULT NULL,
  `senior_years` varchar(50) DEFAULT NULL,
  `senior_awards` text DEFAULT NULL,
  `college_course` varchar(255) DEFAULT NULL,
  `college_type` varchar(50) DEFAULT NULL,
  `college_years` varchar(50) DEFAULT NULL,
  `college_awards` text DEFAULT NULL,
  `special_skills` text DEFAULT NULL,
  `hobbies` text DEFAULT NULL,
  `ambition` text DEFAULT NULL,
  `motto` text DEFAULT NULL,
  `characteristics` text DEFAULT NULL,
  `influence` text DEFAULT NULL,
  `concern` text DEFAULT NULL,
  `confidentiality` tinyint(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `email`, `datetime`, `student_number`, `name`, `nickname`, `course_section`, `mobile_number`, `sex_at_birth`, `gender_identity`, `dob`, `age`, `place_of_birth`, `religion`, `civil_status`, `permanent_address`, `present_address`, `living_status`, `employed`, `company_name`, `job_title`, `handicapped`, `emergency_contact`, `relation_to_emergency_contact`, `emergency_contact_number`, `birth_order`, `number_of_siblings`, `parents_marital_status`, `fathers_name`, `fathers_dob`, `fathers_age`, `fathers_education`, `fathers_occupation`, `fathers_company`, `mothers_maiden_name`, `mothers_dob`, `mothers_age`, `mothers_education`, `mothers_occupation`, `mothers_company`, `family_income`, `marriage_status`, `spouse_name`, `spouse_dob`, `spouse_education`, `spouse_occupation`, `spouse_company`, `spouse_contact`, `elem_school`, `elem_type`, `elem_years`, `elem_awards`, `junior_high_school`, `junior_type`, `junior_years`, `junior_awards`, `senior_high_school`, `senior_type`, `senior_years`, `senior_awards`, `college_course`, `college_type`, `college_years`, `college_awards`, `special_skills`, `hobbies`, `ambition`, `motto`, `characteristics`, `influence`, `concern`, `confidentiality`, `user_id`) VALUES
(9, 'jayrsantos114@gmail.com', '2024-10-04 06:18:00', '2019201210', 'Santos, Jay R U.', 'J', 'Educ', '09918866661', 'Boy', 'Male', '2024-10-10', 231, 'BAL', 'Catholic', 'Single', 'a', 'a', 'With parents', 'No', 'a', 'a', 'a', 'a', 'a', 'a', 'Only Child', 2, 'Married', 'a', '2024-10-04', 2, 'Graduate School Graduate MAPhD', 'a', 'a', 'a', '2024-10-17', 2, 'Graduate School Graduate MAPhD', '2', 'f', '81,832-140,284.00PHP', 'Married', 'g', '2024-10-10', 'Graduate School Graduate MAPhD', 's', 's', 's', 's', 'Private', 's', 'a', 's', 'Private', 's', 's', 's', 'Private', 'a', 's', 's', 'Private', 's', 's', 's', 's', 's', 's', 's', 's', '', NULL, 1),
(10, 'jayrsantos144@gmail.com', '2024-10-04 07:46:00', '2019201210', 'Santos, Jay  U.', 'Jayy', 'Business Administration', '0991886666111', 'Boy', 'Male', '2024-10-04', 13, 'BAL', '12', 'Single', 'ha', 'ha', 'With parents', 'Yes', 'a', 'ha', 'ha', 'ha', 'ha', 'ha', 'Youngest', 3, 'Married', 'ha', '2024-10-11', 4, 'Graduate School Graduate MAPhD', 'w', 'w', 'w', '2024-10-25', 2, 'Graduate School Graduate MAPhD', 'a', 's', 'Less Than 11,6990.00PHP', 'Married', 's', '2024-10-11', 'Graduate School Graduate MAPhD', 's', 's', 's', 's', 'Private', 's', 's', 's', 'Private', 's', 's', 's', 'Private', 's', 's', 's', 'Private', 's', 's', 's', 'a', 's', 's', 's', 's', 's', NULL, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aggregated_concerns`
--
ALTER TABLE `aggregated_concerns`
  ADD PRIMARY KEY (`concern`),
  ADD UNIQUE KEY `concern` (`concern`,`course_section`);

--
-- Indexes for table `selections`
--
ALTER TABLE `selections`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `testing_service`
--
ALTER TABLE `testing_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_concerns`
--
ALTER TABLE `user_concerns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `testing_service`
--
ALTER TABLE `testing_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_concerns`
--
ALTER TABLE `user_concerns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `testing_service`
--
ALTER TABLE `testing_service`
  ADD CONSTRAINT `testing_service_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_concerns`
--
ALTER TABLE `user_concerns`
  ADD CONSTRAINT `user_concerns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
