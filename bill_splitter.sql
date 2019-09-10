-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2019 at 04:25 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bill_splitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(3) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`) VALUES
(1, 'GAMES'),
(2, 'MOVIES'),
(3, 'DINING OUT'),
(4, 'GROCERIES'),
(5, 'ELECTRONICS'),
(6, 'FURNITURE'),
(7, 'MAINTENANCE'),
(8, 'RENT'),
(9, 'CLOTHING'),
(10, 'GIFTS'),
(11, 'MEDICINE'),
(12, 'HOTEL'),
(13, 'TRANSPORTATION');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_group_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_date` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_group_id`, `comment_author`, `comment_content`, `comment_date`, `updated_at`) VALUES
(1, 1, 'Siddhant Tripathi', 'the movie was not so good but the dinner later was awesome.', '2019-09-09', '2019-09-10'),
(2, 1, 'Harshit Garg', 'yeah u are right but still action sequences were good. :) :) :) :p', '2019-09-09', '2019-09-10'),
(7, 1, 'Harshit Garg', 'yo bro....me rico', '2019-09-10', '2019-09-10'),
(9, 1, 'Rico Mendez', 'hello guys', '2019-09-10', '2019-09-10'),
(20, 1, 'Rico Mendez', 'hi', '2019-09-10', '2019-09-10'),
(21, 1, 'Rico Mendez', 'baba yaga', '2019-09-10', '2019-09-10');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` int(3) NOT NULL,
  `group_id` int(3) NOT NULL,
  `expense_description` varchar(255) NOT NULL,
  `total_expense` int(10) NOT NULL,
  `currency` int(3) NOT NULL,
  `paid_by` varchar(255) NOT NULL,
  `split_type` int(3) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `group_id`, `expense_description`, `total_expense`, `currency`, `paid_by`, `split_type`, `date`, `status`, `tags`) VALUES
(89, 2, 'Party 1', 200, 5, 'Tsid123', 1, '2019-09-03', 'open', 'MEDICINE'),
(93, 2, 'Party 2', 100, 5, 'Tsid123', 2, '2019-09-07', 'open', 'MEDICINE'),
(94, 2, 'Party 3', 100, 5, 'Tsid123', 2, '2019-08-22', 'open', 'CLOTHING'),
(95, 2, 'Party 3', 100, 5, 'Tsid123', 1, '2019-09-12', 'open', 'MEDICINE'),
(96, 2, 'Extra Party', 500, 5, 'Tsid123', 2, '2019-08-06', 'open', 'GIFTS'),
(97, 2, 'Extra Party 2', 500, 5, 'Knand456', 1, '2019-09-07', 'open', 'CLOTHING'),
(98, 2, 'Extra Party 2', 500, 5, 'Knand456', 2, '2019-09-07', 'open', 'CLOTHING'),
(99, 2, 'NEW TAGS', 541, 5, '20188011', 2, '2019-09-09', 'open', 'GIFTS');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friendship_id` int(3) NOT NULL,
  `user1_id` int(3) NOT NULL,
  `user2_id` int(3) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friendship_id`, `user1_id`, `user2_id`, `date`) VALUES
(1, 3, 4, '2019-08-14'),
(2, 4, 5, '2019-09-01'),
(3, 3, 5, '2019-09-01'),
(4, 2, 3, '2019-09-01'),
(5, 2, 4, '2019-09-01'),
(6, 2, 1, '2019-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

CREATE TABLE `friend_request` (
  `request_id` int(3) NOT NULL,
  `user1_id` int(3) NOT NULL,
  `user2_id` int(3) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(3) NOT NULL,
  `admin_id` int(3) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `members` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `admin_id`, `admin_username`, `group_name`, `members`, `status`, `date`) VALUES
(1, 2, 'Tsid123', 'Movie', 'Hgarg123,Knand456,rico123', 'open', '2019-07-17'),
(2, 3, 'Hgarg123', 'Trip to Goa', 'Knand456,20188011,Tsid123', 'open', '2019-08-30'),
(3, 3, 'Hgarg123', 'Himalayan Weekend', '', 'open', '2019-08-21');

-- --------------------------------------------------------

--
-- Table structure for table `liability`
--

CREATE TABLE `liability` (
  `liability_id` int(3) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `group_id` int(3) NOT NULL,
  `pay_to` varchar(255) NOT NULL,
  `amount_due` int(10) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `liability`
--

INSERT INTO `liability` (`liability_id`, `user_name`, `group_id`, `pay_to`, `amount_due`, `date`, `status`) VALUES
(169, 'Knand456', 2, 'Tsid123', 150, '2019-09-05', 'pending'),
(170, '20188011', 2, 'Tsid123', 150, '2019-09-07', 'pending'),
(171, 'Hgarg123', 2, 'Tsid123', 50, '2019-09-05', 'pending'),
(176, 'Knand456', 2, 'Tsid123', 100, '2019-09-07', 'pending'),
(177, 'Hgarg123', 2, 'Tsid123', 100, '2019-09-07', 'pending'),
(178, 'Tsid123', 2, 'Knand456', 225, '2019-09-07', 'pending'),
(180, '20188011', 2, 'Knand456', 250, '2019-09-07', 'pending'),
(181, 'Hgarg123', 2, 'Knand456', 250, '2019-09-07', 'pending'),
(183, 'Tsid123', 2, '20188011', 500, '2019-09-09', 'pending'),
(184, 'Knand456', 2, '20188011', 41, '2019-09-09', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `otp_expiry`
--

CREATE TABLE `otp_expiry` (
  `otp_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `otp` int(10) NOT NULL,
  `expiry_status` int(1) NOT NULL,
  `create_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picsource` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `number`, `email`, `password`, `picsource`) VALUES
(5, '20188011', 'Anshuman', '9140156668', 'tsiddhant456@gmail.com', 'Tsid@123', ''),
(3, 'Hgarg123', 'Harshit Garg', '9140156668', 'tsiddhant456@gmail.com', '12345', 'uploaded_images/6.jpg'),
(4, 'Knand456', 'Krishna Nand', '7376683332', 'tsiddhant456@gmail.com', 'Knand123', ''),
(6, 'Laxmi', 'Laxmi Narayan', '7376683332', 'truthlie999@gmail.com', '123456', ''),
(1, 'rico123', 'Rico Mendez', '9140156668', 'tsiddhant456@gmail.com', 'Tsid@007', 'uploaded_images/4.jpg'),
(2, 'Tsid123', 'Siddhant Tripathi', '7376683332', 'tsiddhant456@gmail.com', '123456', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friendship_id`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `liability`
--
ALTER TABLE `liability`
  ADD PRIMARY KEY (`liability_id`);

--
-- Indexes for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  ADD PRIMARY KEY (`otp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friendship_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `friend_request`
--
ALTER TABLE `friend_request`
  MODIFY `request_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `liability`
--
ALTER TABLE `liability`
  MODIFY `liability_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  MODIFY `otp_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
