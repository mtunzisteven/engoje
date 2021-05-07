-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2021 at 09:34 PM
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

INSERT INTO `addresses` (`addressId`, `addressLineOne`, `addressLineTwo`, `addressCity`, `addressZipCode`, `addressType`, `userId`) VALUES
(26, '4 Dazana Street', 'Mbuqe Extension', 'Umtata', '5000', '1', 1),
(27, '40 James Herbert Road', 'Caversham', 'Zobe', '3610', '2', 1),
(28, '40 James Herbert Road', 'Caversham', 'Pinetown', '3610', '1', 2),
(29, '40 James Herbert Road', 'Caversham', 'Pinetown', '3610', '2', 2),
(30, '101 Market Street', 'Boksburg East', 'Johannesburg', '1459', '1', 4),
(31, '40 James Herbert Road', 'Caversham', 'Pinetown', '3610', '2', 4),
(32, '3801 White Oryx Street', 'West', 'Boksburg', '1459', '1', 3),
(33, '3801 White Oryx Street', 'West', 'Boksburg', '1459', '1', 3);

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
(11, 'rompers');

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
  `imagePath_tn` varchar(86) NOT NULL DEFAULT 'no-image-tn.png',
  `imagePrimary` int(1) NOT NULL,
  `product_entryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imageId`, `imageName`, `imagePath`, `imagePath_tn`, `imagePrimary`, `product_entryId`) VALUES
(1, 'Red & White Family Matching Set', 'redFamilySet.jfif', 'no-image.png', 1, 1),
(2, 'Mom and daughters Matching Set', 'momDaughtersSet.jfif', 'no-image.png', 1, 2),
(3, 'Mom and Daughter Matching Hats Set', 'hatSet.jfif', 'no-image.png', 1, 3),
(4, 'Mom and Daughter Matching Beanie set', 'beanieSet.jfif', 'no-image.png', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `orderSKU` varchar(22) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) NOT NULL,
  `orderStatus` varchar(22) NOT NULL DEFAULT 'processing',
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
(1, 'Red Family Set', 'Red & White Family Matching Set', 'Family set for Mom, Dad, daughter, and son. Comprises of two dresses and two T-shirts', '2021-04-24 05:09:37'),
(2, 'Mom & Daughter Set', 'Mom and daughters Matching Set', 'Family set for Mom, toddler, and baby. Comprises of two dresses and a romper dress for baby', '2021-04-24 05:11:30'),
(3, 'Hat 2pc Set', 'Mom and Daughter Matching Hats Set', 'Mom and daughter set for out doors and sunny days. Comprises two hats', '2021-04-24 05:11:24'),
(4, 'Beanie 2pc Set', 'Mom and Daughter Matching Beanie set', 'Mom and daughter set for out doors and sunny days. Comprises two hats', '2021-04-24 05:11:14');

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
(1, 1, 1, 1, 2, 0, '0', 30),
(2, 2, 1, 1, 2, 0, '0', 30),
(3, 3, 1, 1, 2, 0, '0', 30),
(4, 4, 1, 1, 2, 0, '0', 30),
(5, 2, 3, 4, 2, 120, 'scd200', 2);

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
(4, 'Luyanda', 'Mavuma', 'luyandamascot@gmail.com', 680156971, '$2y$10$uVd1V1N6BPz8oziobEUkHud.2zQlD8FdjSFbwqwtcgZ5NcwB7D7yC', '2021-04-14 10:39:47', 1);

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
  ADD KEY `FK_orders_products` (`productId`),
  ADD KEY `FK_orders_users` (`userId`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `addressId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `colour`
--
ALTER TABLE `colour`
  MODIFY `colourId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `product_entry`
--
ALTER TABLE `product_entry`
  MODIFY `product_entryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `sizeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `FK_address_users` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_images_product_entry` FOREIGN KEY (`product_entryId`) REFERENCES `product_entry` (`product_entryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_entry`
--
ALTER TABLE `product_entry`
  ADD CONSTRAINT `FK_product_category` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_product_colour` FOREIGN KEY (`colourId`) REFERENCES `colour` (`colourId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_product_entry_product` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_product_size` FOREIGN KEY (`sizeId`) REFERENCES `size` (`sizeId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
