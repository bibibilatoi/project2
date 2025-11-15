-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 04:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project2_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_requirements`
--

CREATE TABLE `additional_requirements` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `additional_requirement` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `additional_requirements`
--

INSERT INTO `additional_requirements` (`id`, `job_id`, `additional_requirement`) VALUES
(1, 4, 'Active clearance may be required for sensitive missions.'),
(2, 4, 'Must be willing to work extended hours and weekends.'),
(3, 10, 'This role requires onsite presence (no remote option).'),
(4, 10, 'Must be willing to work extended hours to meet mission timelines.');

-- --------------------------------------------------------

--
-- Table structure for table `basic_qualifications`
--

CREATE TABLE `basic_qualifications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `qualification` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `basic_qualifications`
--

INSERT INTO `basic_qualifications` (`id`, `job_id`, `qualification`) VALUES
(1, 4, 'Bachelor\'s degree in computer science, engineering, math, or related discipline.'),
(2, 4, '1+ years in ML engineering, full-stack development, or data science.'),
(3, 4, '1+ years of experience in Python, C, or C++.'),
(4, 10, 'Bachelor\'s degree in Cybersecurity, Computer Science, or related field.'),
(5, 10, '2+ years of network, IT infrastructure, or application security experience.'),
(6, 10, '5+ years hardening Windows, MacOS, or Linux.');

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `eoi_number` int(11) NOT NULL,
  `reference_number` varchar(10) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `suburb` varchar(50) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `other_skills` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`eoi_number`, `reference_number`, `first_name`, `last_name`, `date_of_birth`, `gender`, `street`, `suburb`, `state`, `postcode`, `email`, `phone`, `other_skills`, `status`) VALUES
(1, 'AI01', 'Alice', 'Nguyen', '1998-04-12', 'Female', '123 Space Ave', 'Melbourne', 'VIC', '3000', 'alice@example.com', '0412345678', 'AI hobby projects', 'New'),
(2, 'MO04', 'Bob', 'Tran', '1990-09-05', 'Male', '99 Orbit Rd', 'Sydney', 'NSW', '2000', 'bob@example.com', '0422334455', 'Security research', 'New'),
(3, 'AI01', 'john', 'smith', '2023-11-16', 'Female', 'adsbbasd', 'abdas', 'VIC', '1112', 'a@gmail.com', '11111121', 'None', 'New'),
(4, 'MO04', 'a', 'b', NULL, NULL, NULL, NULL, NULL, NULL, 'aaa@gmail.com', '444444443', NULL, 'New'),
(5, 'MO04', 'a', 'b', NULL, NULL, NULL, NULL, NULL, NULL, 'aaa@gmail.com', '444444443', NULL, 'New'),
(6, 'MO04', 'a', 'b', '2025-11-19', 'Male', NULL, NULL, NULL, NULL, 'aaa@gmail.com', '444444443', 'abcdefg', 'New'),
(7, 'MO04', 'a', 'b', '2025-11-19', 'Male', NULL, NULL, NULL, NULL, 'aaa@gmail.com', '444444443', 'abcdefg', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `reference_number` varchar(10) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `reports_to` varchar(100) DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `brief_description` text DEFAULT NULL,
  `is_hiring` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `reference_number`, `job_title`, `department`, `reports_to`, `salary_range`, `brief_description`, `is_hiring`) VALUES
(1, 'PA01', 'Structural Engineer', 'Propulsion and Aerospace Engineering', 'Head of Propulsion Engineering', NULL, 'Develops lightweight, high-strength rocket components using advanced composites.', 0),
(2, 'PA02', 'Thermal Systems Engineer', 'Propulsion and Aerospace Engineering', 'Senior Thermal Systems Engineer', NULL, 'Creates systems to regulate heat and protect spacecraft during flight.', 0),
(3, 'PA03', 'Test Technician', 'Propulsion and Aerospace Engineering', 'Propulsion Test Manager', NULL, 'Operates test facilities and collects performance data from engine and structural tests.', 0),
(4, 'AI01', 'AI Engineer', 'AI, Automation and Mission Systems', 'Head of AI and Orbital Systems', 'USD 120,000 - 150,000 per year', 'The AI and Data Systems team at SpeedX develops intelligent models that power real-time orbital decision-making, spacecraft autonomy, and earth observation.', 1),
(5, 'AI02', 'Robotics Developer', 'AI, Automation and Mission Systems', 'Robotics Team Lead', NULL, 'Designs robotic arms and systems for satellite assembly and space operations.', 0),
(6, 'AI03', 'Mission Planner', 'AI, Automation and Mission Systems', 'Mission Systems Director', NULL, 'Plans launch trajectories, mission timelines, and payload deployment paths.', 0),
(7, 'MO01', 'Manufacturing Engineer', 'Manufacturing and IT Operations', 'Manufacturing Manager', NULL, 'Oversees production and assembly of rocket and spacecraft components with precision and quality.', 0),
(8, 'MO02', 'Quality Assurance Specialist', 'Manufacturing and IT Operations', 'QA Department Lead', NULL, 'Ensures all aerospace parts and systems meet performance and safety standards.', 0),
(9, 'MO03', 'Supply Chain Coordinator', 'Manufacturing and IT Operations', 'Supply Chain Manager', NULL, 'Manages logistics and procurement for production and testing operations.', 0),
(10, 'MO04', 'Network Security Engineer', 'Manufacturing and IT Operations', 'Chief Information Security Officer (CISO)', 'USD 110,000 - 145,000 per year', 'Network security engineers at SpeedX design, build, and maintain the systems that protect our satellites.', 1),
(11, 'BC01', 'Business Development Manager', 'Business, IT and Communications', 'Director of Business Strategy', NULL, 'Builds partnerships, manages contracts, and drives company growth opportunities.', 0),
(12, 'BC02', 'Marketing and PR Specialist', 'Business, IT and Communications', 'Chief Marketing Officer', NULL, 'Manages public communications, branding campaigns, and launch event promotions.', 0),
(13, 'BC03', 'HR and Recruitment Officer', 'Business, IT and Communications', 'Director of Human Resources', NULL, 'Oversees recruitment and employee development to attract and retain top talent.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `key_responsibilities`
--

CREATE TABLE `key_responsibilities` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `responsibility` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `key_responsibilities`
--

INSERT INTO `key_responsibilities` (`id`, `job_id`, `responsibility`) VALUES
(1, 10, 'Develop and maintain network security tools, configurations, and firewalls.'),
(2, 10, 'Conduct threat modeling, risk assessments, and apply security best practices.'),
(3, 10, 'Collaborate with other teams to design secure architectures and ensure compliance.'),
(4, 10, 'Document and update security policies and processes.'),
(5, 4, 'Develop geospatial data processing models for raw sensor data.'),
(6, 4, 'Create reliable ML systems that task remote sensors and process information.'),
(7, 4, 'Manage projects from prototyping to production rollout.'),
(8, 4, 'Build efficient tools ensuring security and reliability.');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`username`, `password`, `email`) VALUES
('ABC', '$2y$10$HNRFOl69REtervonKj0/nuE.CTzThXlvWOWOFqsx.V51FC41crlju', 'anhtuan@gmail.com'),
('Admin', '$2y$10$e9qIillhDPEiMOUo0nGBC.taIGT/.oEDuReD4Dc9C1CHBs9byVSJW', 'trinhthaianhtuan@gmail.com'),
('NeverGonnaGiveYouUp', '$2y$10$.bmxdXQyEdF457w4WQDKFObBfHWJe14hjEtLbmp7lYEa5cZJv9KTS', 'steepmolecules@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `preferred_skills`
--

CREATE TABLE `preferred_skills` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `skill` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preferred_skills`
--

INSERT INTO `preferred_skills` (`id`, `job_id`, `skill`) VALUES
(1, 10, 'Relevant certifications (CISSP, CCNP Security, CEH, OSCP, etc.).'),
(2, 10, 'Strong understanding of network security technologies (firewalls, IDS/IPS, VPNs, SIEM).'),
(3, 10, 'Python programming and automation ability.'),
(4, 10, 'Experience testing and implementing production changes.'),
(5, 10, 'Adept at learning new technologies and systems.'),
(6, 4, 'Experience applying modern ML algorithms at scale.'),
(7, 4, 'Experience with cloud environments (AWS, GCP, Azure).'),
(8, 4, 'Experience with Linux server environments and scripting.'),
(9, 4, 'Experience with Kubernetes or other container orchestration.'),
(10, 4, 'Experience with PostgreSQL or other databases.');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `skill_name`) VALUES
(3, 'C++'),
(6, 'Cloud Computing'),
(9, 'Cybersecurity'),
(7, 'Data Analysis'),
(2, 'JavaScript'),
(8, 'Kubernetes'),
(4, 'Linux'),
(5, 'Machine Learning'),
(10, 'Networking'),
(1, 'Python');

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE `user_skills` (
  `eoi_number` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`eoi_number`, `skill_id`) VALUES
(1, 1),
(1, 5),
(1, 7),
(2, 9),
(2, 10),
(3, 1),
(3, 6),
(3, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_requirements`
--
ALTER TABLE `additional_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `basic_qualifications`
--
ALTER TABLE `basic_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`eoi_number`),
  ADD KEY `reference_number` (`reference_number`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD UNIQUE KEY `reference_number` (`reference_number`);

--
-- Indexes for table `key_responsibilities`
--
ALTER TABLE `key_responsibilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`username`,`email`);

--
-- Indexes for table `preferred_skills`
--
ALTER TABLE `preferred_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD UNIQUE KEY `skill_name` (`skill_name`);

--
-- Indexes for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`eoi_number`,`skill_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_requirements`
--
ALTER TABLE `additional_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `basic_qualifications`
--
ALTER TABLE `basic_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `eoi_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `key_responsibilities`
--
ALTER TABLE `key_responsibilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `preferred_skills`
--
ALTER TABLE `preferred_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_requirements`
--
ALTER TABLE `additional_requirements`
  ADD CONSTRAINT `additional_requirements_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;

--
-- Constraints for table `basic_qualifications`
--
ALTER TABLE `basic_qualifications`
  ADD CONSTRAINT `basic_qualifications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;

--
-- Constraints for table `eoi`
--
ALTER TABLE `eoi`
  ADD CONSTRAINT `eoi_ibfk_1` FOREIGN KEY (`reference_number`) REFERENCES `jobs` (`reference_number`) ON DELETE CASCADE;

--
-- Constraints for table `key_responsibilities`
--
ALTER TABLE `key_responsibilities`
  ADD CONSTRAINT `key_responsibilities_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;

--
-- Constraints for table `preferred_skills`
--
ALTER TABLE `preferred_skills`
  ADD CONSTRAINT `preferred_skills_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_ibfk_1` FOREIGN KEY (`eoi_number`) REFERENCES `eoi` (`eoi_number`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;