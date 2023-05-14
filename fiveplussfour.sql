-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2023 at 05:04 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fiveplussfour`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `ProID` varchar(10) NOT NULL,
  `Count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CatID` varchar(10) NOT NULL,
  `CatName` varchar(50) NOT NULL,
  `CatDesc` varchar(1000) NOT NULL,
  `Cat_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CatID`, `CatName`, `CatDesc`, `Cat_image`) VALUES
('C01', 'BOBSON', 'BOBSON product', 'BOBSON-brand.png'),
('C02', 'Levi\'s', 'Levi\'s product', 'Levis-brand.png'),
('C03', 'EDWIN', 'EDWIN product', 'edwin_brand.png'),
('C04', 'MLB', 'MLB product', 'MLB-brand.png'),
('C05', 'Champion', 'Champion product', 'Champion-brand.png'),
('C06', 'GILDAN', 'GILDAN product', 'GILDAN_brand.png'),
('C07', 'DeLong', 'DeLong product', 'DeLONG-brand.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Username` varchar(30) NOT NULL,
  `Password` varchar(70) NOT NULL,
  `CustName` varchar(50) NOT NULL,
  `CustSex` varchar(6) NOT NULL,
  `CustPhone` varchar(12) NOT NULL,
  `CustMail` varchar(100) NOT NULL,
  `CustAddress` varchar(100) NOT NULL,
  `Birthday` date NOT NULL,
  `State` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Username`, `Password`, `CustName`, `CustSex`, `CustPhone`, `CustMail`, `CustAddress`, `Birthday`, `State`) VALUES
('quangnd', '$2y$10$4p2cailsrS7/qSa3VzjUKuCmzsxL/zg1tDNvcNqcPskvEchQL59C2', 'Quang Nguyen Duy', 'Male', '0916843367', 'quangndgcc200030@fpt.edu.vn', 'No. 160, 30/4 Street, An Phu Ward, Ninh Kieu District, Can Tho City', '2002-08-05', 1),
('trannq', '$2y$10$dsL7o5LFxYQa3ZnQ9r9YBeaDZDvjIpenpMY5P5Krf1MxglR2ERVaa', 'Tran Nguyen Que', 'Female', '0843630939', 'trannqgcc210042@fpt.edu.vn', 'Tan Hanh, Vinh Long', '2003-03-09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedID` int(11) NOT NULL,
  `Content` text NOT NULL,
  `sendDate` datetime NOT NULL,
  `state` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `ProID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `OrderID` int(11) NOT NULL,
  `ProID` varchar(10) NOT NULL,
  `Qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`OrderID`, `ProID`, `Qty`) VALUES
(46, 'P02', 1),
(46, 'P04', 1),
(47, 'P03', 1),
(47, 'P12', 1),
(48, 'P01', 4),
(48, 'P16', 1),
(52, 'P06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL,
  `DeliveryDate` datetime NOT NULL,
  `Deliverylocal` varchar(200) NOT NULL,
  `CustName` varchar(255) NOT NULL,
  `CustPhone` varchar(12) NOT NULL,
  `Total` decimal(12,2) NOT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `Username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `DeliveryDate`, `Deliverylocal`, `CustName`, `CustPhone`, `Total`, `Status`, `Username`) VALUES
(46, '2023-05-13 10:07:19', '2023-05-13 10:07:19', 'Tan Hanh, Vinh Long', 'Tran Nguyen Que', '0843630939', '45.00', 0, 'trannq'),
(47, '2023-05-13 10:08:14', '2023-05-13 10:08:14', 'Tan Hanh, Vinh Long', 'Tran Nguyen Que', '0843630939', '38.00', 0, 'trannq'),
(48, '2023-05-13 10:17:36', '2023-05-13 10:17:36', 'No. 160, 30/4 Street, An Phu Ward, Ninh Kieu District, Can Tho City', 'Tran Nguyen', '0916843367', '82.00', 0, 'trannq'),
(52, '2023-05-13 10:28:53', '2023-05-13 10:28:53', 'Tan Hanh, Vinh Long', 'Tran Nguyen Que', '0843630939', '20.00', 0, 'trannq');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProID` varchar(10) NOT NULL,
  `ProName` varchar(50) NOT NULL,
  `ProPrice` decimal(12,2) NOT NULL,
  `OldPrice` decimal(12,2) NOT NULL,
  `SmallDesc` varchar(1000) NOT NULL,
  `DetailDesc` text NOT NULL,
  `ProDate` datetime NOT NULL,
  `Pro_qty` int(11) NOT NULL,
  `Pro_image` varchar(200) NOT NULL,
  `CatID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProID`, `ProName`, `ProPrice`, `OldPrice`, `SmallDesc`, `DetailDesc`, `ProDate`, `Pro_qty`, `Pro_image`, `CatID`) VALUES
('P01', 'Black T-shirt', '15.00', '0.00', 'Small desc black T-shirt', 'Detail desc black T-shirt\r\n', '2022-05-10 18:28:13', 0, 'pro1.jpg', 'C02'),
('P02', 'Black jeans', '20.00', '0.00', 'Small desc black jeans', 'Detail desc black jeans', '2022-05-10 18:27:39', 0, 'pro2.jpg', 'C01'),
('P03', 'Light blue jeans', '10.00', '0.00', 'Small desc light blue jeans', 'Detail desc light blue jeans\r\n', '2022-05-10 18:26:38', 0, 'pro3.jpg', 'C03'),
('P04', 'Loose jeans', '25.00', '0.00', 'Small desc loose jeans', 'Detail desc loose jeans\r\n', '2022-05-10 18:25:15', 0, 'pro4.jpg', 'C04'),
('P05', 'Green T-shirt', '10.00', '0.00', 'Small desc green T-shirt', 'Detail desc green T-shirt', '2022-05-12 10:29:30', 2, 'download.jpg', 'C06'),
('P06', 'White T-shirt', '20.00', '0.00', 'Small desc white T-shirt', 'Detail desc white T-shirt', '2022-05-10 18:23:46', 0, 'z3398765216804_bbd37e95412ae276b0740ed82e342127.jpg', 'C05'),
('P07', 'Checkered shirt', '15.00', '0.00', 'Small desc checkered shirt', 'Detail desc checkered shirt\r\n', '2022-05-10 18:20:39', 5, 'z3398766422532_ede724b6a5829547fd899e7c185a16c8.jpg', 'C06'),
('P08', 'Shorts', '20.00', '0.00', 'Small descript shorts', 'Detail description shorts', '2022-05-10 18:19:22', 2, 'z3398766617127_271089c387fd75d4a1bcc129e6b7e14e.jpg', 'C02'),
('P09', 'Moss green shirt', '23.00', '0.00', 'Long sleeve', 'Detail desc long sleeve', '2022-05-10 18:35:51', 3, 'download (1).jpg', 'C05'),
('P10', 'Navy swim short', '9.00', '0.00', 'Small desc navy swim shorts', 'Detail desc navy swim shorts', '2022-06-02 04:32:50', 1, 'navyswimshorts.jpg', 'C05'),
('P11', 'Shorts Stock', '11.00', '0.00', 'Small desc shorts stock', 'Detail desc shorts stock', '2022-05-10 20:01:00', 3, 'ShortsStock.jpg', 'C04'),
('P12', 'Plaid shirt', '28.00', '0.00', 'Red and black', 'Detail desc Red and black', '2022-05-10 20:02:11', 1, 'images.jpg', 'C02'),
('P13', 'Blue t-shirt', '8.00', '0.00', 'Small desc blue t-shirt', 'Detail desc blue t-shirt', '2022-05-10 20:03:28', 5, '9088.png', 'C02'),
('P14', 'Leather jacket', '30.00', '0.00', 'Small Desc Leather Jacket', 'Detail Desc Leather Jacket', '2022-05-11 11:28:52', 5, 'LeatherJacket.jpg', 'C01'),
('P15', 'Bomber jacket', '25.00', '0.00', 'Small Desc Bomber Jacket', 'Detail Desc Bomber Jacket', '2022-05-11 11:29:51', 0, 'BomberJacket.jpg', 'C03'),
('P16', 'Plain hoodie', '22.00', '0.00', 'Small Desc Plain Hoodie', 'Detail Desc Plain Hoodie', '2022-05-11 11:30:41', 1, 'PlainHoodie.jpg', 'C04'),
('P17', 'Denim jacket', '30.00', '0.00', 'Small Desc Denim Jacket', 'Detail Desc Denim Jacket', '2022-05-11 11:31:42', 1, 'DenimJacket.jpeg', 'C06'),
('P18', 'Denim jeans', '35.00', '0.00', 'Small Desc large-black', 'Detail Desc large-black', '2022-05-11 11:32:58', 2, 'denim-jeans-large-black.jpg', 'C06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `Username` (`Username`,`ProID`),
  ADD KEY `ProID` (`ProID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CatID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Username`),
  ADD UNIQUE KEY `CustPhone` (`CustPhone`,`CustMail`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedID`),
  ADD KEY `Username` (`Username`,`ProID`),
  ADD KEY `ProID` (`ProID`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`OrderID`,`ProID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProID` (`ProID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProID`),
  ADD KEY `CatID` (`CatID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `customer` (`Username`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ProID`) REFERENCES `product` (`ProID`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `customer` (`Username`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`ProID`) REFERENCES `product` (`ProID`) ON DELETE CASCADE;

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProID`) REFERENCES `product` (`ProID`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `customer` (`Username`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CatID`) REFERENCES `category` (`CatID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
