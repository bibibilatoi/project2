-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 11:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `requirement_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `additional_requirement` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `additional_requirements`
--

INSERT INTO `additional_requirements` (`requirement_id`, `job_id`, `additional_requirement`) VALUES
(1, 4, 'Note that an active clearance may provide the opportunity for you to work on sensitive SpeedX missions; if so, you will be subject to pre-employment drug and random drug and alcohol testing.'),
(2, 4, 'Must be willing to work extended hours and weekends as needed.'),
(3, 10, 'This role requires you to be onsite. Hybrid or remote work will not be considered.'),
(4, 10, 'Must be willing to work extended hours and weekends as needed to support mission timelines.');

-- --------------------------------------------------------

--
-- Table structure for table `basic_qualifications`
--

CREATE TABLE `basic_qualifications` (
  `qualification_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `qualification` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `basic_qualifications`
--

INSERT INTO `basic_qualifications` (`qualification_id`, `job_id`, `qualification`) VALUES
(7, 10, 'Bachelor\'s degree in Computer Science, Cybersecurity, or related technical field; or equivalent practical experience.'),
(8, 10, '2+ years of experience securing networks, IT infrastructure, applications, endpoints, and/or APIs.'),
(9, 10, '5+ years of experience hardening Windows, MacOS, and/or Linux operating systems.'),
(10, 4, 'Bachelor\'s degree in computer science, engineering, math, or scientific discipline; OR 2+ years of professional experience in software development in lieu of a degree.'),
(11, 4, '1+ years of experience in applied machine learning engineering, full-stack development, and data science.'),
(12, 4, '1+ years of development experience in Python, C, or C++.');

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `jobRef` varchar(5) DEFAULT NULL,
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `suburb` varchar(40) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `postcode` varchar(4) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `otherSkills` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `jobRef`, `firstName`, `lastName`, `dob`, `gender`, `street`, `suburb`, `state`, `postcode`, `email`, `phone`, `skills`, `otherSkills`, `status`) VALUES
(1, 'AI01', 'ab', 'adsf', '02/01/1921', 'Male', 'abasd', 'adabs', 'TAS', '1000', 'adsf@gmail.com', '11112222', 'Other Advanced Skills', 'asdfdasd', 'New'),
(2, 'AI01', 'asd', 'asb', '20/11/1922', 'Female', 'absd', 'ads', 'VIC', '1222', 'adsb@gmail.com', '2121212111', 'Other Advanced Skills', 'asdfab', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `reference_no` varchar(10) NOT NULL,
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

INSERT INTO `jobs` (`job_id`, `reference_no`, `job_title`, `department`, `reports_to`, `salary_range`, `brief_description`, `is_hiring`) VALUES
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
  `responsibility_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `responsibility` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `key_responsibilities`
--

INSERT INTO `key_responsibilities` (`responsibility_id`, `job_id`, `responsibility`) VALUES
(17, 10, 'Develop and maintain network security tools, configurations, and firewalls.'),
(18, 10, 'Conduct threat modeling, risk assessments, and apply security best practices.'),
(19, 10, 'Collaborate with other teams to design secure architectures and ensure compliance.'),
(20, 10, 'Document and update security policies and processes.'),
(21, 4, 'Develop novel geospatial data processing models to extract valuable information from raw and partially processed sensor data.'),
(22, 4, 'Create highly reliable software and machine learning systems that task remote sensor payloads on hundreds of satellites in low earth orbit and process the collected information.'),
(23, 4, 'See your modeling work and software through from start-to-finish: from figuring out the core needs to prototyping, developing, and testing; to production rollout and beyond.'),
(24, 4, 'Build tools that enable the team to work more efficiently, and that help build software systems that are secure, reliable, and autonomous.');

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
('SteepMoleCules', 'steepbibilatoi123', 'trinhthaianhtuan@gmail.com'),
('long', '123', 'long@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `preferred_skills`
--

CREATE TABLE `preferred_skills` (
  `skill_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `skill` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preferred_skills`
--

INSERT INTO `preferred_skills` (`skill_id`, `job_id`, `skill`) VALUES
(5, 10, 'Relevant certifications (CISSP, CCNP Security, CEH, OSCP, etc.).'),
(6, 10, 'Strong understanding of network security technologies, their operation and limitations (firewalls, IDS/IPS, VPNs, access control, and SIEM-based monitoring, etc.).'),
(7, 10, 'Python programming and automation ability.'),
(8, 10, 'Experience testing and implementing changes in a production environment.'),
(9, 10, 'Adept at learning new technologies and systems.'),
(10, 4, 'Experience applying modern computer vision or machine learning algorithms at scale.'),
(11, 4, 'Experience with cloud environments (AWS, GCP, or Azure).'),
(12, 4, 'Experience with Linux server environments and scripting.'),
(13, 4, 'Experience with Kubernetes or similar container orchestration frameworks.'),
(14, 4, 'Experience with PostgreSQL or other high-performance databases.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_requirements`
--
ALTER TABLE `additional_requirements`
  ADD PRIMARY KEY (`requirement_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `basic_qualifications`
--
ALTER TABLE `basic_qualifications`
  ADD PRIMARY KEY (`qualification_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`);

--
-- Indexes for table `key_responsibilities`
--
ALTER TABLE `key_responsibilities`
  ADD PRIMARY KEY (`responsibility_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `preferred_skills`
--
ALTER TABLE `preferred_skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `job_id` (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_requirements`
--
ALTER TABLE `additional_requirements`
  MODIFY `requirement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `basic_qualifications`
--
ALTER TABLE `basic_qualifications`
  MODIFY `qualification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `key_responsibilities`
--
ALTER TABLE `key_responsibilities`
  MODIFY `responsibility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `preferred_skills`
--
ALTER TABLE `preferred_skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
-- Constraints for table `key_responsibilities`
--
ALTER TABLE `key_responsibilities`
  ADD CONSTRAINT `key_responsibilities_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;

--
-- Constraints for table `preferred_skills`
--
ALTER TABLE `preferred_skills`
  ADD CONSTRAINT `preferred_skills_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
