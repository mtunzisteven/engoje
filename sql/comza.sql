-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2021 at 06:04 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comza`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `addressId` int(11) UNSIGNED NOT NULL,
  `addressName` varchar(86) NOT NULL,
  `addressEmail` varchar(86) NOT NULL,
  `addressNumber` varchar(10) NOT NULL,
  `addressLineOne` varchar(225) NOT NULL,
  `addressLineTwo` varchar(225) DEFAULT NULL,
  `addressCity` varchar(82) NOT NULL,
  `addressZipCode` varchar(22) NOT NULL,
  `addressType` varchar(18) NOT NULL,
  `userId` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`addressId`, `addressName`, `addressEmail`, `addressNumber`, `addressLineOne`, `addressLineTwo`, `addressCity`, `addressZipCode`, `addressType`, `userId`) VALUES
(26, 'MS Mavuma', 'st.vuma@gmail.com', '814511932', '4 Dazana Street', 'Mbuqe Extension', 'Umtata', '5000', '1', 1),
(27, 'Mtunzi Mavuma', 'mtunzisteven@gmail.com', '0814511932', '40 James Herbert Road', '58 Knightsbridge', 'Pinetown', '3610', '2', 1),
(28, '', '', '0', '40 James Herbert Road', 'Caversham', 'Pinetown', '3610', '1', 2),
(29, '', '', '0', '40 James Herbert Road', 'Caversham', 'Pinetown', '3610', '2', 2),
(30, '', '', '0', '1 Amand Place', '49 Marrian Manor', 'Marianhill Park', '3610', '1', 4),
(31, '', '', '0', '40 James Herbert Road', 'Caversham', 'Pinetown', '3610', '2', 4),
(32, '', '', '0', '3801 White Oryx Street', 'West', 'Boksburg', '1459', '1', 3),
(33, '', '', '0', '3801 White Oryx Street', 'West', 'Boksburg', '1459', '1', 3);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_itemId` int(11) NOT NULL,
  `product_entryId` int(11) NOT NULL,
  `cart_item_qty` int(11) NOT NULL,
  `userId` int(11) UNSIGNED NOT NULL,
  `imagePath_tn` varchar(85) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(100) NOT NULL,
  `categoryName` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryName`) VALUES
(2, 'babies'),
(3, 'kids'),
(4, 'baby boys'),
(5, 'baby girls'),
(6, 'boys'),
(7, 'girls'),
(8, 'shoes'),
(9, 'hats'),
(10, 'dresses'),
(11, 'rompers'),
(12, 'Womens Cardigans'),
(13, 'Womens Hoodies');

-- --------------------------------------------------------

--
-- Table structure for table `colour`
--

CREATE TABLE `colour` (
  `colourId` int(11) NOT NULL,
  `colour` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `colour`
--

INSERT INTO `colour` (`colourId`, `colour`) VALUES
(1, 'black'),
(2, 'red'),
(3, 'white'),
(4, 'blue'),
(5, 'green'),
(6, 'grey'),
(7, 'yellow'),
(8, 'orange'),
(9, 'purple'),
(10, 'pink');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imageId` int(11) NOT NULL,
  `imageName` varchar(85) NOT NULL,
  `imagePath` varchar(225) NOT NULL DEFAULT 'no-image.png',
  `imagePath_tn` varchar(225) NOT NULL DEFAULT 'no-image-tn.png',
  `imagePrimary` int(1) NOT NULL,
  `product_entryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imageId`, `imageName`, `imagePath`, `imagePath_tn`, `imagePrimary`, `product_entryId`) VALUES
(53, '2_59f598a6-91db-4f25-b342-f58d68b1e791_1024x1024@2x.jpg', '/engoje/images/2_59f598a6-91db-4f25-b342-f58d68b1e791_1024x1024@2x.jpg', '/engoje/images/2_59f598a6-91db-4f25-b342-f58d68b1e791_1024x1024@2x-tn.jpg', 1, 164),
(54, '1_339b4c2b-79e5-4187-b581-1e07bb9d5de9_1024x1024@2x.jpg', '/engoje/images/1_339b4c2b-79e5-4187-b581-1e07bb9d5de9_1024x1024@2x.jpg', '/engoje/images/1_339b4c2b-79e5-4187-b581-1e07bb9d5de9_1024x1024@2x-tn.jpg', 0, 164),
(55, '5_16f257c5-37f7-4564-a82d-076bd8f51920_grande.jpg', '/engoje/images/5_16f257c5-37f7-4564-a82d-076bd8f51920_grande.jpg', '/engoje/images/5_16f257c5-37f7-4564-a82d-076bd8f51920_grande-tn.jpg', 0, 164),
(56, '5f03e522c3754_1024x1024@2x.jpg', '/engoje/images/5f03e522c3754_1024x1024@2x.jpg', '/engoje/images/5f03e522c3754_1024x1024@2x-tn.jpg', 0, 164),
(57, '6_cc556a3b-8116-4011-a045-d4d7669d6dda_grande.jpg', '/engoje/images/6_cc556a3b-8116-4011-a045-d4d7669d6dda_grande.jpg', '/engoje/images/6_cc556a3b-8116-4011-a045-d4d7669d6dda_grande-tn.jpg', 0, 164),
(58, '5eb8dee7ea421_1024x1024@2x.jpg', '/engoje/images/5eb8dee7ea421_1024x1024@2x.jpg', '/engoje/images/5eb8dee7ea421_1024x1024@2x-tn.jpg', 1, 165),
(59, '5ec513eecf4df_1024x1024@2x.jpg', '/engoje/images/5ec513eecf4df_1024x1024@2x.jpg', '/engoje/images/5ec513eecf4df_1024x1024@2x-tn.jpg', 1, 166),
(60, '5ea0294e386ad_1024x1024@2x.jpg', '/engoje/images/5ea0294e386ad_1024x1024@2x.jpg', '/engoje/images/5ea0294e386ad_1024x1024@2x-tn.jpg', 1, 167),
(61, '5d380eb9a0f89_1024x1024@2x.jpg', '/engoje/images/5d380eb9a0f89_1024x1024@2x.jpg', '/engoje/images/5d380eb9a0f89_1024x1024@2x-tn.jpg', 1, 168),
(62, '5e154d7eb087f_1024x1024@2x.jpg', '/engoje/images/5e154d7eb087f_1024x1024@2x.jpg', '/engoje/images/5e154d7eb087f_1024x1024@2x-tn.jpg', 1, 169),
(63, '5da5b876699f0_1024x1024@2x.jpg', '/engoje/images/5da5b876699f0_1024x1024@2x.jpg', '/engoje/images/5da5b876699f0_1024x1024@2x-tn.jpg', 1, 170),
(64, '4_e920eee0-22c2-4699-a2fb-dd6aabea1740_1024x1024@2x.jpg', '/engoje/images/4_e920eee0-22c2-4699-a2fb-dd6aabea1740_1024x1024@2x.jpg', '/engoje/images/4_e920eee0-22c2-4699-a2fb-dd6aabea1740_1024x1024@2x-tn.jpg', 1, 175),
(65, '5bd96ff95b4dd_1024x1024@2x.jpg', '/engoje/images/5bd96ff95b4dd_1024x1024@2x.jpg', '/engoje/images/5bd96ff95b4dd_1024x1024@2x-tn.jpg', 0, 175),
(66, '6_617f0618-2ba8-48fd-b3bd-bd40ba0e6b94_1024x1024@2x.jpg', '/engoje/images/6_617f0618-2ba8-48fd-b3bd-bd40ba0e6b94_1024x1024@2x.jpg', '/engoje/images/6_617f0618-2ba8-48fd-b3bd-bd40ba0e6b94_1024x1024@2x-tn.jpg', 0, 175),
(67, '11_dd077e96-8768-42a3-a2c5-4eab5dec40d2_1024x1024@2x.jpg', '/engoje/images/11_dd077e96-8768-42a3-a2c5-4eab5dec40d2_1024x1024@2x.jpg', '/engoje/images/11_dd077e96-8768-42a3-a2c5-4eab5dec40d2_1024x1024@2x-tn.jpg', 0, 175),
(68, '5_5e64b047-a826-46a6-8106-03593b105d1d_1024x1024@2x.jpg', '/engoje/images/5_5e64b047-a826-46a6-8106-03593b105d1d_1024x1024@2x.jpg', '/engoje/images/5_5e64b047-a826-46a6-8106-03593b105d1d_1024x1024@2x-tn.jpg', 1, 176),
(69, '5bd96ff5258c5_1024x1024@2x.jpg', '/engoje/images/5bd96ff5258c5_1024x1024@2x.jpg', '/engoje/images/5bd96ff5258c5_1024x1024@2x-tn.jpg', 0, 176),
(70, '7_0c6d7868-917e-4ac4-abe4-9f424c914ab7_1024x1024@2x.jpg', '/engoje/images/7_0c6d7868-917e-4ac4-abe4-9f424c914ab7_1024x1024@2x.jpg', '/engoje/images/7_0c6d7868-917e-4ac4-abe4-9f424c914ab7_1024x1024@2x-tn.jpg', 0, 176),
(71, '12_d696c6a2-fb9e-4314-96b9-27ce28a2e0bb_1024x1024@2x.jpg', '/engoje/images/12_d696c6a2-fb9e-4314-96b9-27ce28a2e0bb_1024x1024@2x.jpg', '/engoje/images/12_d696c6a2-fb9e-4314-96b9-27ce28a2e0bb_1024x1024@2x-tn.jpg', 0, 176),
(72, '3_27d5e884-7c31-488b-8e56-066ff0ceddc7_1024x1024@2x.jpg', '/engoje/images/3_27d5e884-7c31-488b-8e56-066ff0ceddc7_1024x1024@2x.jpg', '/engoje/images/3_27d5e884-7c31-488b-8e56-066ff0ceddc7_1024x1024@2x-tn.jpg', 1, 174),
(73, '5bd97027f0d07_1024x1024@2x.jpg', '/engoje/images/5bd97027f0d07_1024x1024@2x.jpg', '/engoje/images/5bd97027f0d07_1024x1024@2x-tn.jpg', 0, 174),
(74, '8_2f0b1dc0-1ab5-46d3-bf40-ef5857befb53_1024x1024@2x.jpg', '/engoje/images/8_2f0b1dc0-1ab5-46d3-bf40-ef5857befb53_1024x1024@2x.jpg', '/engoje/images/8_2f0b1dc0-1ab5-46d3-bf40-ef5857befb53_1024x1024@2x-tn.jpg', 0, 174),
(75, '10_68bf9d47-9835-462d-a100-3923191b53c0_grande.jpg', '/engoje/images/10_68bf9d47-9835-462d-a100-3923191b53c0_grande.jpg', '/engoje/images/10_68bf9d47-9835-462d-a100-3923191b53c0_grande-tn.jpg', 0, 174),
(77, 'casual cardigan2.jpg', '/engoje/images/casual cardigan2.jpg', '/engoje/images/casual cardigan2-tn.jpg', 1, 183),
(78, 'casual cardigan3.jpg', '/engoje/images/casual cardigan3.jpg', '/engoje/images/casual cardigan3-tn.jpg', 1, 182),
(80, 'casual cardigan1.jpg', '/engoje/images/casual cardigan1.jpg', '/engoje/images/casual cardigan1-tn.jpg', 1, 181),
(81, 'leopard print hood2.jpg', '/engoje/images/leopard print hood2.jpg', '/engoje/images/leopard print hood2-tn.jpg', 1, 185),
(82, 'leopard print hood1.jpg', '/engoje/images/leopard print hood1.jpg', '/engoje/images/leopard print hood1-tn.jpg', 1, 186),
(83, 'beanieSet.jfif', '/engoje/images/beanieSet.jfif', '/engoje/images/beanieSet-tn.jfif', 1, 187);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `order_items` varchar(265) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `shippingId` int(11) NOT NULL,
  `orderStatus` varchar(22) NOT NULL DEFAULT 'processing',
  `orderTracking` varchar(86) DEFAULT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(100) NOT NULL,
  `productName` varchar(20) NOT NULL,
  `productShortDescr` varchar(60) NOT NULL,
  `productDescription` varchar(256) NOT NULL,
  `productCreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `productName`, `productShortDescr`, `productDescription`, `productCreationDate`) VALUES
(310, 'Minnie Dress', 'Red, black, and red dress.', 'Red, black, and red dress.', '2021-05-24 11:56:54'),
(311, 'Baby Romper', 'Baby Romper in different colours.', 'Baby Romper in different colours.', '2021-05-24 12:02:02'),
(312, 'Formal Dress', 'Formal dress for babies and toddlers.', 'Formal dress for babies and toddlers.', '2021-05-24 12:16:56'),
(314, 'Rabbit hood', 'Rabbit hood baby jacket', 'Rabbit hood baby jacket', '2021-05-24 13:19:58'),
(316, 'Casual Cardigan', 'Casual Cardigan \r\nCardigan Coat \r\nMultiple colours', 'Casual Cardigan \r\nCardigan Coat \r\nMultiple colours', '2021-06-19 06:23:59'),
(317, 'Casual Hood', 'Leopard Print \r\nMultiple Colours\r\nCasual & Lose Fit', 'Leopard Print \r\nMultiple Colours\r\nCasual & Lose Fit', '2021-06-20 00:22:35'),
(318, 'Beanie Set', 'Mother and Daughter<br />\r\nMatch Colour Design<br />\r\nWInter', 'Mother and Daughter<br />\r\nMatch Colour Design<br />\r\nWInter Warm', '2021-06-22 06:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `product_entry`
--

CREATE TABLE `product_entry` (
  `product_entryId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `sizeId` int(11) NOT NULL,
  `colourId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `sku` varchar(36) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_entry`
--

INSERT INTO `product_entry` (`product_entryId`, `productId`, `sizeId`, `colourId`, `categoryId`, `price`, `sku`, `amount`) VALUES
(164, 310, 4, 2, 5, 180, 'GHwome52', 0),
(165, 311, 4, 2, 2, 90, 'ergwgw', 1),
(166, 311, 4, 4, 2, 90, 'wfwe', 0),
(167, 311, 4, 7, 2, 90, 'wgweg', 1),
(168, 311, 4, 10, 2, 90, 'wgrw', 0),
(169, 312, 5, 2, 5, 260, 'cdsgvvds', 1),
(170, 312, 5, 6, 5, 260, 'dfsg', 1),
(174, 314, 5, 2, 5, 123, 'jhguyh', 1),
(175, 314, 5, 6, 5, 213, 'kji', 1),
(176, 314, 5, 10, 5, 321, 'kji', 1),
(181, 316, 6, 1, 12, 230, 'PAJ-JKU-J13', 1),
(182, 316, 5, 3, 12, 230, 'PAJ-JKU-J14', 1),
(183, 316, 5, 8, 12, 230, 'PAJ-JKU-J15', 1),
(184, 316, 6, 8, 12, 230, 'PAJ-JKU-J16', 1),
(185, 317, 5, 6, 13, 210, 'JUH2-VX2L-M1', 1),
(186, 317, 5, 8, 13, 210, 'JUH2-VX2L-M2', 1),
(187, 318, 1, 3, 9, 95, 'PAH1-KL44-22L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` int(11) NOT NULL,
  `reviewRating` int(1) DEFAULT NULL,
  `reviewText` varchar(255) DEFAULT NULL,
  `productId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `saleId` int(11) NOT NULL,
  `salePrice` int(11) DEFAULT NULL,
  `salePeriod` int(11) NOT NULL DEFAULT 30,
  `saleStart` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_entryId` int(11) NOT NULL,
  `saleMarkDown` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE `shipping_method` (
  `shippingId` int(11) NOT NULL,
  `name` varchar(86) NOT NULL,
  `shipper` varchar(86) NOT NULL,
  `period` varchar(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`shippingId`, `name`, `shipper`, `period`, `price`) VALUES
(1, 'Paxi Shipping', 'paxi', '7-9 busines', 60);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `sizeId` int(11) NOT NULL,
  `sizeValue` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`sizeId`, `sizeValue`) VALUES
(1, 'one size'),
(2, 'XXS'),
(3, 'XS'),
(4, 'S'),
(5, 'M'),
(6, 'L'),
(7, 'XL'),
(8, 'XXL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) UNSIGNED NOT NULL,
  `userFirstName` varchar(22) NOT NULL,
  `userLastName` varchar(22) NOT NULL,
  `userEmail` varchar(36) NOT NULL,
  `userPhone` int(16) DEFAULT NULL,
  `userPassword` varchar(86) NOT NULL,
  `userRegistrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `userLevel` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userFirstName`, `userLastName`, `userEmail`, `userPhone`, `userPassword`, `userRegistrationDate`, `userLevel`) VALUES
(1, 'Mtunzi', 'Mavuma', 'st.vuma@gmail.com', 814511932, '$2y$10$qYQazHE7Dm4DjgaigTnWfOY7PK77VTF1t/Dd5RZO0UU9UryoPqk2y', '2021-04-14 09:57:14', 2),
(2, 'Lusanda', 'Mavuma', 'luhh1973@gmail.com', 723033515, '$2y$10$tPxQbWL2TL5ch1ptPCJnbOnbvez.KLhTP8qr/A2MdW2hTG955Bgb6', '2021-04-14 10:02:03', 1),
(3, 'Pinky', 'Sotafile', 'pinky@gmail.com', 782124365, '$2y$10$xyijUV6akL8.5gVfuJ5LFOnye5YhRd4cFi//PG6/45Z/UoMiA52l6', '2021-04-14 10:25:29', 1),
(4, 'Luyanda', 'Mavuma', 'luyandamascot@gmail.com', 680156971, '$2y$10$uVd1V1N6BPz8oziobEUkHud.2zQlD8FdjSFbwqwtcgZ5NcwB7D7yC', '2021-04-14 10:39:47', 1),
(6, 'Mpo', 'Frank', 'mpofrank@gmail.com', NULL, '$2y$10$r1cF0twgFrM3VqH1GeGOH.aAtJ47S4ILHwxBQjig3aeQD14LE2wN2', '2021-06-30 21:08:09', 1),
(7, 'Lusanda', 'Magadla', 'lusanda@gmail.com', NULL, '$2y$10$NcG2osBnijI6Ru7pRa7UvupovJNJT4fcBRTnEnmKldfmRjcDBWOj2', '2021-07-01 17:53:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_feedback`
--

CREATE TABLE `user_feedback` (
  `user_feedbackId` int(11) NOT NULL,
  `userId` int(11) UNSIGNED NOT NULL,
  `experience` varchar(255) NOT NULL,
  `feedback` varchar(250) NOT NULL,
  `feedbackDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_feedback`
--

INSERT INTO `user_feedback` (`user_feedbackId`, `userId`, `experience`, `feedback`, `feedbackDate`) VALUES
(1, 1, 'on', 'Experience spelt wrong', '2021-06-21 08:43:41'),
(2, 1, 'on', 'Everything working just fine. Sending properly and saving gracefully.', '2021-06-21 08:44:57'),
(3, 1, 'on', 'The WHole time my experience was recorded as on. I don&#39;t remember what it was now.', '2021-06-21 08:46:58'),
(4, 1, 'Bad', 'Double quoted name attr to get proper value for experience', '2021-06-21 08:56:08'),
(5, 1, 'Good', 'Double quotes worked and I sent proper experience.', '2021-06-21 08:56:56'),
(6, 1, 'Good', 'THe website is pretty clean and easy to navigate.', '2021-06-21 12:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `wishlistId` int(11) NOT NULL,
  `userId` int(11) UNSIGNED NOT NULL,
  `product_entryId` int(11) NOT NULL,
  `imagePath_tn` varchar(85) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`addressId`),
  ADD KEY `FK_address_users` (`userId`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_itemId`),
  ADD KEY `FK_cart_Items_users` (`userId`),
  ADD KEY `FK_cart_Items_product_entry` (`product_entryId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `colour`
--
ALTER TABLE `colour`
  ADD PRIMARY KEY (`colourId`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageId`),
  ADD KEY `FK_images_product_entry` (`product_entryId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `FK_orders_users` (`userId`),
  ADD KEY `FK_orders_shipping_method` (`shippingId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `product_entry`
--
ALTER TABLE `product_entry`
  ADD PRIMARY KEY (`product_entryId`),
  ADD KEY `FK_product_entry_product` (`productId`),
  ADD KEY `FK_product_size` (`sizeId`),
  ADD KEY `FK_product_colour` (`colourId`),
  ADD KEY `FK_product_category` (`categoryId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `FK_reviews_products` (`productId`),
  ADD KEY `FK_reviews_users` (`userId`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`saleId`),
  ADD KEY `FK_sale_product_entry` (`product_entryId`);

--
-- Indexes for table `shipping_method`
--
ALTER TABLE `shipping_method`
  ADD PRIMARY KEY (`shippingId`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`sizeId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `user_feedback`
--
ALTER TABLE `user_feedback`
  ADD PRIMARY KEY (`user_feedbackId`),
  ADD KEY `FK_user_feedback_users` (`userId`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`wishlistId`),
  ADD KEY `FK_wishlist_Items_user` (`userId`),
  ADD KEY `FK_wishlist_Items_product_entry` (`product_entryId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `addressId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `colour`
--
ALTER TABLE `colour`
  MODIFY `colourId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `product_entry`
--
ALTER TABLE `product_entry`
  MODIFY `product_entryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `saleId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_method`
--
ALTER TABLE `shipping_method`
  MODIFY `shippingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `sizeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_feedback`
--
ALTER TABLE `user_feedback`
  MODIFY `user_feedbackId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `wishlistId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `FK_address_users` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `FK_cart_Items_product_entry` FOREIGN KEY (`product_entryId`) REFERENCES `product_entry` (`product_entryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cart_Items_users` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_images_product_entry` FOREIGN KEY (`product_entryId`) REFERENCES `product_entry` (`product_entryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_orders_shipping_method` FOREIGN KEY (`shippingId`) REFERENCES `shipping_method` (`shippingId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_entry`
--
ALTER TABLE `product_entry`
  ADD CONSTRAINT `FK_product_category` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_product_colour` FOREIGN KEY (`colourId`) REFERENCES `colour` (`colourId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_product_entry_product` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_product_size` FOREIGN KEY (`sizeId`) REFERENCES `size` (`sizeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `FK_sale_product_entry` FOREIGN KEY (`product_entryId`) REFERENCES `product_entry` (`product_entryId`);

--
-- Constraints for table `user_feedback`
--
ALTER TABLE `user_feedback`
  ADD CONSTRAINT `FK_user_feedback_users` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `FK_wishlist_Items_product_entry` FOREIGN KEY (`product_entryId`) REFERENCES `product_entry` (`product_entryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_wishlist_Items_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
