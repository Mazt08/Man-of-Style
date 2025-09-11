-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2025 at 01:59 AM
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
-- Database: `manofstyle`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Jacket'),
(2, 'Pants'),
(3, 'Shoes'),
(4, 'Accessories'),
(5, 'Tshirt');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','shipped','completed','cancelled') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `old_price`, `stock`, `category_id`, `image`, `rating`, `badge`, `link`) VALUES
(1, 'Classic Denim Jacket', 'This denim jacket is a stylish and versatile wardrobe staple, featuring a classic design with a contemporary twist. The jacket is predominantly white with gray accents, creating a modern and eye-catching aesthetic. Made from durable denim material, it offers both comfort and timeless appeal.', 200.00, 400.00, 7, 1, 'img/jackets/1.jpg', 4.5, 'Best Seller', 'template.html'),
(2, 'Urban Hoodie Jacket', 'The Urban Hoodie Jacket blends casual comfort with urban style. Crafted from soft yet durable fabric, this hoodie jacket provides warmth without sacrificing breathability. Perfect for layering, it comes in a sleek modern design suitable for everyday wear.', 200.00, NULL, 9, 1, 'img/jackets/2.jpg', 5.0, NULL, 'template.html'),
(3, 'Minimalist Sweater', 'A clean and versatile minimalist sweater designed for effortless styling. Made from soft cotton blend, it offers a lightweight yet cozy feel. Ideal for layering or wearing on its own, this sweater is a must-have for a modern wardrobe.', 200.00, NULL, 6, 1, 'img/jackets/3.jpg', 4.0, 'New', 'template.html'),
(4, 'Graphic Print Hoodie', 'Express yourself with this bold graphic print hoodie. Featuring high-quality prints on premium fabric, this hoodie stands out while keeping you comfortable. Its relaxed fit and adjustable drawstring hood make it perfect for streetwear looks.', 200.00, NULL, 8, 1, 'img/jackets/4.jpg', 5.0, NULL, 'template.html'),
(5, 'White Mixed Red Jacket', 'A modern take on a classic jacket style, combining white and red tones for a striking design. Made from durable yet comfortable materials, this jacket is both stylish and functional. A versatile piece that elevates casual outfits effortlessly.', 250.00, 300.00, 10, 1, 'img/jackets/5.jpg', 4.5, 'Sale', 'template.html'),
(6, 'Premium Sweatpants', 'Designed for comfort and style, these premium sweatpants are crafted from soft, breathable fabric. Perfect for lounging, workouts, or casual streetwear looks.', 150.00, NULL, 6, 2, 'img/pants/6.jpg', 4.5, NULL, 'template.html'),
(7, 'Tailored Slim Pants', 'Smart and modern slim-fit pants tailored for a sleek silhouette. Suitable for both formal and casual outfits, these pants add a refined touch to any look.', 150.00, NULL, 7, 2, 'img/pants/7.jpg', 4.0, 'Trending', 'template.html'),
(8, 'Men Joggers', 'Casual yet stylish joggers designed for everyday comfort. Featuring an adjustable waistband and tapered fit, they are perfect for active lifestyles.', 150.00, NULL, 9, 2, 'img/pants/9.jpg', 5.0, NULL, 'template.html'),
(9, 'BK Jeans', 'Durable denim jeans with a contemporary cut. A versatile staple that pairs well with almost any top, making it ideal for casual wear.', 150.00, NULL, 8, 2, 'img/pants/10.jpg', 4.0, 'Trending', 'template.html'),
(10, 'Classic Black Trouser', 'Elegant black trousers crafted from premium fabric. Perfect for office wear, formal events, or pairing with casual shirts for a smart-casual style.', 150.00, NULL, 10, 2, 'img/pants/8.jpg', 5.0, NULL, 'template.html'),
(11, 'AirFlex Runner', 'Lightweight running shoes engineered for maximum comfort and flexibility. Designed for active individuals who value both style and performance.', 400.00, NULL, 5, 3, 'img/shoes/18.jpg', 4.5, 'Trending', 'template.html'),
(12, 'Urban Street Kicks', 'Trendy sneakers built for everyday streetwear fashion. Features durable soles and breathable uppers, making them ideal for all-day wear.', 250.00, 300.00, 8, 3, 'img/shoes/19.jpg', 5.0, 'Sale', 'template.html'),
(13, 'Retro High-Tops', 'A classic retro-inspired high-top sneaker that combines vintage vibes with modern comfort. Perfect for casual and street style outfits.', 100.00, NULL, 6, 3, 'img/shoes/20.jpg', 4.5, 'New', 'template.html'),
(14, 'Midnight Runners', 'Sleek black running shoes designed for performance and style. Featuring cushioned insoles and lightweight materials for long-lasting comfort.', 250.00, 300.00, 7, 3, 'img/shoes/21.jpg', 5.0, 'Sale', 'template.html'),
(15, 'StreetFlow Sneakers', 'Modern sneakers with a clean, streamlined design. Built with breathable fabric and durable outsoles for all-day wear.', 250.00, NULL, 9, 3, 'img/shoes/22.jpg', 4.5, 'New', 'template.html'),
(16, 'HypeFlex 23', 'Bold and futuristic sneakers designed for trendsetters. Featuring flexible soles and eye-catching details for a standout look.', 250.00, NULL, 10, 3, 'img/shoes/23.jpg', 4.5, 'New', 'template.html'),
(17, 'PrimeCourt Classics', 'Classic court-style sneakers that deliver timeless appeal. Made with durable materials and cushioned support for everyday comfort.', 250.00, 300.00, 8, 3, 'img/shoes/24.jpg', 5.0, 'Sale', 'template.html'),
(18, 'Canvas Low Riders', 'Casual low-top canvas sneakers perfect for laid-back outfits. Lightweight, breathable, and easy to style with jeans or shorts.', 250.00, 300.00, 7, 3, 'img/shoes/25.jpg', 5.0, 'Sale', 'template.html'),
(19, 'Snapback Street Cap', 'A modern snapback cap with a streetwear-inspired design. Adjustable fit ensures comfort while completing any casual look.', 350.00, NULL, 5, 4, 'img/cap/1.jpg', 5.0, 'New', 'template.html'),
(20, 'Classic Baseball Cap', 'Timeless baseball cap crafted for everyday wear. Lightweight and durable, perfect for outdoor activities or casual outfits.', 350.00, NULL, 6, 4, 'img/cap/2.jpg', 5.0, 'New', 'template.html'),
(21, 'Flat Brim Cap', 'Stylish flat brim cap designed for a modern urban look. Built with durable fabric and adjustable closure for a secure fit.', 350.00, NULL, 7, 4, 'img/cap/3.jpg', 5.0, 'Trending', 'template.html'),
(22, 'Vintage Trucker Cap', 'Retro-style trucker cap with breathable mesh back. Offers both comfort and a vintage vibe, perfect for casual wear.', 350.00, NULL, 10, 4, 'img/cap/4.jpg', 5.0, 'Sale', 'template.html'),
(23, 'Street Art Tee', 'A bold street art-inspired graphic tee that adds personality to your outfit. Soft cotton fabric ensures comfort and durability.', 150.00, NULL, 7, 5, 'img/clothes/1.jpg', 4.0, 'Trending', 'template.html'),
(24, 'Classic Black Trouser', 'A simple yet timeless black tee, versatile enough to be styled casually or layered under jackets. A wardrobe essential.', 150.00, NULL, 8, 5, 'img/clothes/2.jpg', 5.0, NULL, 'template.html'),
(25, 'Graphic Street Tee', 'Eye-catching graphic tee with bold prints. Crafted from premium cotton for a comfortable fit and standout streetwear appeal.', 400.00, NULL, 9, 5, 'img/clothes/3.jpg', 4.5, 'Trending', 'template.html'),
(26, 'Black plain Tee', 'Minimalist black plain tee, soft and versatile. A classic essential for effortless styling across different outfits.', 250.00, 300.00, 6, 5, 'img/clothes/4.jpg', 5.0, 'Sale', 'template.html'),
(27, 'Casual Blue Tee', 'A comfortable casual tee in refreshing blue. Made from breathable fabric, perfect for everyday wear in warm weather.', 100.00, NULL, 10, 5, 'img/clothes/11.jpg', 4.5, 'New', 'template.html'),
(28, 'Colorful liner tee', 'Vibrant colorful tee that adds a playful touch to any outfit. Soft fabric ensures comfort while keeping the look fresh.', 250.00, 300.00, 8, 5, 'img/clothes/12.jpg', 5.0, 'Sale', 'template.html'),
(29, 'Discovery Expedition Tee', 'A sporty and stylish tee inspired by outdoor adventures. Lightweight, breathable, and designed for active lifestyles.', 250.00, NULL, 7, 5, 'img/clothes/13.jpg', 4.5, 'New', 'template.html'),
(30, 'Nirvana Tee', 'Rock-inspired Nirvana tee with vintage vibes. Made from high-quality cotton for comfort and authentic band-style fashion.', 250.00, NULL, 5, 5, 'img/clothes/14.jpg', 4.5, 'New', 'template.html'),
(31, 'Cotton Tee', 'A soft cotton tee designed for comfort and everyday wear. Classic cut makes it versatile and easy to pair with any outfit.', 250.00, 300.00, 9, 5, 'img/clothes/15.jpg', 5.0, 'Sale', 'template.html');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
