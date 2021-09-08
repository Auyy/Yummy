-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 08, 2021 at 10:09 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mix yummy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `member_id` mediumint(8) UNSIGNED NOT NULL,
  `product_id` mediumint(8) UNSIGNED NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`member_id`, `product_id`, `quantity`) VALUES
(1, 1, 2),
(1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(20) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(50) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Birthday` date NOT NULL,
  `Allergymix` text NOT NULL,
  `ApplyDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `email`, `password`, `firstname`, `lastname`, `address`, `phone`, `Gender`, `Birthday`, `Allergymix`, `ApplyDate`) VALUES
(1, 'kwa_reborn@hotmail.com', '123', 'à¸­à¸±à¸™à¸•à¹Œà¸“à¸´à¸à¸²', 'à¸§à¸´à¸ˆà¸´à¸•à¸•à¸™à¸±à¸™à¸—à¸²à¸à¸¸à¸¥', '25 à¸—à¸£à¸‡à¸§à¸ªà¸§à¸±à¸ªà¸”à¸´à¹Œ', '9874456', 'à¸«à¸à¸´à¸‡', '0000-00-00', '', '0000-00-00'),
(2, 'kk_gg@hotmail.com', '11', 'kkk', 'll', '22', '9874456', 'à¸Šà¸²à¸¢', '0000-00-00', '', '0000-00-00'),
(3, 'll@gmail.com', '22', 'll', 'll', '133', '9874456', 'à¸Šà¸²à¸¢', '2021-03-08', 'à¹„à¸¡à¹ˆà¸¡à¸µ', '0000-00-00'),
(4, 'ccccccc@gmail.com', 'cc', 'kkk', 'll', '25', '9874456', 'à¸«à¸à¸´à¸‡', '2021-09-24', 'à¸–à¸±à¹ˆà¸§', '2021-09-08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `member_id` mediumint(8) UNSIGNED NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(150) NOT NULL,
  `payment` varchar(250) NOT NULL,
  `pay_status` set('pending','paid') NOT NULL,
  `order_date` date NOT NULL,
  `bank_transfer` varchar(250) NOT NULL,
  `date_transfer` date NOT NULL,
  `time_transfer` time NOT NULL,
  `delivery` set('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders_item`
--

CREATE TABLE `orders_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` mediumint(8) UNSIGNED NOT NULL,
  `product_id` mediumint(8) UNSIGNED NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `detail` text NOT NULL,
  `price` double UNSIGNED NOT NULL,
  `quality` varchar(100) NOT NULL,
  `allergymix` text NOT NULL,
  `remain` smallint(5) UNSIGNED NOT NULL,
  `delivery_cost` mediumint(8) UNSIGNED NOT NULL,
  `img_files` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `detail`, `price`, `quality`, `allergymix`, `remain`, `delivery_cost`, `img_files`) VALUES
(1, 'Banana Cake', '<p>à¸”à¸µà¸ˆà¹‰à¸²</p>', 100, '1 ', '-', 77, 9, '1-1.jpeg,1-2.jpeg'),
(2, 'à¹€à¸„à¹‰à¸à¸ªà¹‰à¸¡', '<p>à¸­à¸£à¹ˆà¸­à¸¢à¸¢à¸¢à¸¢à¸¢</p>', 100, '2', '-', 11, 9, '2-1.jpeg,2-2.jpeg'),
(3, ' Young Coconut Cake', '<p>à¸”à¸µ</p>', 150, '1', '-', 77, 11, '3-1.jpeg,3-2.jpeg'),
(4, 'Brownies', '<p>à¸­à¸£à¹ˆà¸­à¸¢à¸¡à¸²à¸à¸à¸à¸</p>', 100, '1', '-', 20, 10, '4-1.jpeg,4-2.jpg'),
(5, 'à¸„à¸¸à¸à¸à¸µà¹‰à¸Šà¸²à¹€à¸‚à¸µà¸¢à¸§', '<p>à¸„à¸¸à¸à¸à¸µà¹‰à¸Šà¸²à¹€à¸‚à¸µà¸¢<br></p>', 50, '1', '-', 20, 10, '5-1.jpeg,5-2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`member_id`,`product_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_item`
--
ALTER TABLE `orders_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
