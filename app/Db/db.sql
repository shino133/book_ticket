-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 26, 2025 at 09:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flightgo`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE `aboutus` (
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `para1` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `para2` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `feat_1` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `feat_1_desc` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `feat_2` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `feat_2_desc` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `additionaltraveler`
--

CREATE TABLE `additionaltraveler` (
  `AdditionalTravelerID` int NOT NULL,
  `CustomerID` int DEFAULT NULL,
  `FirstName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `LastName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Age` int NOT NULL,
  `Nationality` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int NOT NULL,
  `Username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

CREATE TABLE `airlines` (
  `id` int NOT NULL,
  `airline` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `seats` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `City` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `Full Name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Phone Number` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Message` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `UserID` int NOT NULL,
  `FirstName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `LastName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Nationality` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Age` int NOT NULL,
  `Country` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `State` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `City` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PostalCode` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `PROFILE_PIC` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'profile.png'
) ;

-- --------------------------------------------------------

--
-- Table structure for table `discountcoupon`
--

CREATE TABLE `discountcoupon` (
  `CouponID` int NOT NULL,
  `CouponCode` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `DiscountAmount` decimal(5,2) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `UsageLimit` int NOT NULL DEFAULT '1',
  `PointsRequired` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `FlightID` int NOT NULL,
  `Flight Name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Source` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Destination` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `DepartureDate` date NOT NULL,
  `DepartureTime` time NOT NULL,
  `FlightCostPerPerson` decimal(10,2) NOT NULL,
  `Status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Issue` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int NOT NULL,
  `OrderAmount` decimal(10,2) NOT NULL,
  `UserID` int DEFAULT NULL,
  `FlightID` int DEFAULT NULL,
  `PaymentScreenshotFile` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PaymentStatus` enum('Pending','Paid','Cancelled') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewardpoint`
--

CREATE TABLE `rewardpoint` (
  `RewardID` int NOT NULL,
  `UserID` int DEFAULT NULL,
  `PointsEarned` int NOT NULL DEFAULT '0',
  `PointsRedeemed` int NOT NULL DEFAULT '0',
  `PointsBalance` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brief` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `info_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  `Token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OTP` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additionaltraveler`
--
ALTER TABLE `additionaltraveler`
  ADD PRIMARY KEY (`AdditionalTravelerID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `airlines`
--
ALTER TABLE `airlines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `discountcoupon`
--
ALTER TABLE `discountcoupon`
  ADD PRIMARY KEY (`CouponID`),
  ADD UNIQUE KEY `CouponCode` (`CouponCode`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`FlightID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `FlightID` (`FlightID`),
  ADD KEY `UserID` (`UserID`) USING BTREE;

--
-- Indexes for table `rewardpoint`
--
ALTER TABLE `rewardpoint`
  ADD PRIMARY KEY (`RewardID`),
  ADD KEY `CustomerID` (`UserID`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additionaltraveler`
--
ALTER TABLE `additionaltraveler`
  MODIFY `AdditionalTravelerID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `airlines`
--
ALTER TABLE `airlines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discountcoupon`
--
ALTER TABLE `discountcoupon`
  MODIFY `CouponID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `FlightID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewardpoint`
--
ALTER TABLE `rewardpoint`
  MODIFY `RewardID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additionaltraveler`
--
ALTER TABLE `additionaltraveler`
  ADD CONSTRAINT `AdditionalTraveler_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`UserID`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `Customer_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `Order_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `customer` (`UserID`),
  ADD CONSTRAINT `Order_ibfk_2` FOREIGN KEY (`FlightID`) REFERENCES `flight` (`FlightID`);

--
-- Constraints for table `rewardpoint`
--
ALTER TABLE `rewardpoint`
  ADD CONSTRAINT `RewardPoint_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `customer` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
