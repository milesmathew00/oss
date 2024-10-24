-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 12:04 PM
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
  `selection_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aggregated_concerns`
--

INSERT INTO `aggregated_concerns` (`concern`, `selection_count`) VALUES
('1.Feeling tired much of the time', 4),
('10.Graduation threatened by lack of funds', 4),
('11.Too little chance to get into sports', 4),
('12.Wanting to be more popular', 4),
('13.Worrying about unimportant things', 4),
('14.Getting low grades', 2),
('15.Doubting wisdom of my vocational choice', 2),
('16.Dull classes', 2),
('17.Being overweight', 2),
('18.Needing money for graduate training', 2),
('19.Too little chance to enjoy art or music', 2),
('2.Going into debt for college expenses', 2),
('20.Being left out of things', 2),
('3.Not enough time for recreation', 2),
('4.Losing friends', 2),
('5.Taking things too seriously', 2),
('6.Forgetting things I’ve learned in school', 2),
('7.Restless at delay in starting life work', 2),
('8.College too indifferent to student needs', 2),
('9.Being underweight', 2);

-- --------------------------------------------------------

--
-- Table structure for table `selections`
--

CREATE TABLE `selections` (
  `user_id` int(11) NOT NULL,
  `top_20` text DEFAULT NULL,
  `top_5` text DEFAULT NULL,
  `concern` varchar(255) NOT NULL,
  `selection_count` int(11) DEFAULT 1,
  `submitted` int(1) DEFAULT 0,
  `year_level` int(11) NOT NULL,
  `course_section` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `selections`
--

INSERT INTO `selections` (`user_id`, `top_20`, `top_5`, `concern`, `selection_count`, `submitted`, `year_level`, `course_section`) VALUES
(22, '1.Feeling tired much of the time,2.Going into debt for college expenses,3.Not enough time for recreation,4.Losing friends,5.Taking things too seriously,6.Forgetting things I’ve learned in school,7.Restless at delay in starting life work,8.College too indifferent to student needs,9.Being underweight,10.Graduation threatened by lack of funds,11.Too little chance to get into sports,12.Wanting to be more popular,13.Worrying about unimportant things,14.Getting low grades,15.Doubting wisdom of my vocational choice,16.Dull classes,17.Being overweight,18.Needing money for graduate training,19.Too little chance to enjoy art or music,20.Being left out of things', '1.Feeling tired much of the time,10.Graduation threatened by lack of funds,11.Too little chance to get into sports,12.Wanting to be more popular,13.Worrying about unimportant things', '', 1, 1, 4, 'BSIT A'),
(23, '1.Feeling tired much of the time,2.Going into debt for college expenses,3.Not enough time for recreation,4.Losing friends,5.Taking things too seriously,6.Forgetting things I’ve learned in school,7.Restless at delay in starting life work,8.College too indifferent to student needs,9.Being underweight,10.Graduation threatened by lack of funds,11.Too little chance to get into sports,12.Wanting to be more popular,13.Worrying about unimportant things,14.Getting low grades,15.Doubting wisdom of my vocational choice,16.Dull classes,17.Being overweight,18.Needing money for graduate training,19.Too little chance to enjoy art or music,20.Being left out of things', '1.Feeling tired much of the time,10.Graduation threatened by lack of funds,11.Too little chance to get into sports,12.Wanting to be more popular,13.Worrying about unimportant things', '', 1, 1, 4, 'BSIT 4D');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `course_section` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testing_service`
--

INSERT INTO `testing_service` (`id`, `user_id`, `name_of_test`, `raw_score`, `percentile`, `description`, `dimension_aspect`, `date`) VALUES
(30, 22, 'TEST1', 1, 1, 'TEST1', 'TETS1', '2024-10-23'),
(31, 23, 'TEST2', 123, 123, '123', 'test2', '2024-10-23');

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
(1, 'Admin', 'User', '', 'admin@example.com', 'admin_hashed_password', 'confirmed', 'photo_66ebdb884784b_445586464_1680353762773390_637964440655407413_n.jpg', 'haha', 'Test', 'Lala', 'admin', NULL, NULL),
(22, 'miles mathew', 'capangpangan', '', 'padoxscapangpangan@gmail.com', '12', 'confirmed', NULL, 'vizal', 'SiCUi', '', 'user', NULL, NULL),
(23, 'xiean', 'tot', '', 'padoxscapangpanganthree@gmail.com', '123', 'confirmed', NULL, 'vizal', 'KxGdU', '', 'user', NULL, NULL);

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
(22, 'padoxscapangpangan@gmail.com', '2024-10-23 16:58:00', '2019201223', 'Capangpangan Miles Mathew C', 'Miles', 'BSIT 4A', '09762323454', 'Boy', 'Male', '2001-11-17', 22, 'valenzuela', 'catholic', 'Single', 'vizal', 'vizal', 'With parents', 'Yes', 'starlooks', 'sales', 'N/A', '09356386192', 'mother', '09762323454', 'First Born', 1, 'Married', 'doxie', '2024-10-23', 34, 'Graduate School Graduate MAPhD', 'driver', 'trucking', 'rosalie cunanan capangpangan', '2024-10-21', 45, 'Graduate School Graduate MAPhD', 'house wife', 'N/A', 'Less Than 11,6990.00PHP', 'Married', 'N/A', '0000-00-00', 'Graduate School Graduate MAPhD', 'N/A', 'N/A', 'N/A', 'aa', 'Private', 'aa', 'aa', 'aa', 'Private', 'aa', 'aa', 'aa', 'Private', 'FHB', 'H', 'hb', 'Private', 'WERT', 'a', 'ss', 'DB', 'DB', 'aa', 'DCJH', 'DHCB', 'AAA', NULL, 22),
(23, 'padoxscapangpanganthree@gmail.com', '2024-10-23 17:07:00', '123', 'xiean', 'x', 'BSIT 4D', '09762323454', 'Boy', 'Male', '2024-10-23', 344, 'KJNBCKAJ', 'CATH', 'Single', 'ASAS', 'ASAS', 'With parents', 'Yes', 'ASA', 'ASA', 'N/A', 'aa', 'aa', 'aa', 'Second Born', 23, 'Married', 'aa', '2024-10-23', 23, 'Graduate School Graduate MAPhD', 'DJHCVS', 'asa', 'CHJB', '2024-10-23', 23, 'Graduate School Graduate MAPhD', 'aa', 'aa', 'Less Than 11,6990.00PHP', 'Married', 'N/A', '0000-00-00', 'Graduate School Graduate MAPhD', 'N/A', 'N/A', 'N/A', 'sa', 'Private', 'UDYG', 'FHSB', 'FJHV', 'Private', 'aa', 'aa', 'CB', 'Private', 'FHB', 'H', 'aa', 'Private', 'WERT', 'RTYU', 'aa', 'aa', 'A', 'A', 'A', 'aa', 'AA', NULL, 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aggregated_concerns`
--
ALTER TABLE `aggregated_concerns`
  ADD PRIMARY KEY (`concern`);

--
-- Indexes for table `selections`
--
ALTER TABLE `selections`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testing_service`
--
ALTER TABLE `testing_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_concerns`
--
ALTER TABLE `user_concerns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
